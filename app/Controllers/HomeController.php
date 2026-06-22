<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\CategoryModel;
use App\Models\LoanModel;
use App\Models\WishlistModel;
use App\Models\UserModel;

class HomeController extends BaseController
{
    protected $bookModel;
    protected $categoriesModel;
    protected $loanModel;
    protected $userModel;

    public function __construct()
    {
        $this->bookModel       = new BookModel();
        $this->categoriesModel = new CategoryModel();
        $this->loanModel       = new LoanModel();
        $this->userModel       = new UserModel();
    }

    // ─── Beranda & Dashboard ─────────────────────────────────
    public function index()
    {
        // GABUNGKAN SEMUA DATA MENJADI SATU WADAH
        $data = [
            'title'         => 'Celestia Bibliotheca',
            
            // 1. Hitung Angka Statistik Asli (Bukan Dummy)
            'total_buku'    => $this->bookModel->countAllResults(), 
            'total_anggota' => $this->userModel->where('role', 'member')->countAllResults(),
            'total_layanan' => 8, // Tetap 8 karena layout UI grid layananmu ada 8
            
            // 2. Ambil Kategori DDC 000-900 Asli untuk Carousel Bintang
            'categories'    => $this->categoriesModel->findAll(),
            
            // 2. New Arrivals (Koleksi yang baru di-add hari ini)
            'newArrivals'   => $this->bookModel->where('DATE(created_at)', date('Y-m-d'))->orderBy('created_at', 'DESC')->findAll(4),

            // 4. Koleksi Unggulan (Rating > 4.5)
            'featured'      => $this->bookModel
                                    ->select('books.*, AVG(reviews.rating) as avg_rating')
                                    ->join('reviews', 'reviews.book_id = books.id', 'inner')
                                    ->groupBy('books.id')
                                    ->having('AVG(reviews.rating) >', 4.5)
                                    ->orderBy('avg_rating', 'DESC')
                                    ->findAll(4),

            // 5. Featured Volumes (Jurnal)
            'journals'      => (new \App\Models\JournalModel())->orderBy('created_at', 'DESC')->findAll(4)
        ];

        // ── LOGIKA PERCABANGAN HALAMAN ──
        if (session()->get('user_id')) {
            // Jika User Sudah Login -> Tampilkan Dashboard
            return view('user/dashboard', $data);
        } else {
            // Jika User Belum Login -> Tampilkan Landing Page (Halaman Luar)
            // Catatan: Pastikan file landing page-mu bernama 'home.php' atau 'index.php' di dalam folder Views/user/
            return view('user/home', $data); 
        }
    }

    // ─── Catalog ─────────────────────────────────────────────
    public function catalog()
    {
        $keyword  = $this->request->getGet('q');
        $category = $this->request->getGet('kategori');
        $page     = $this->request->getGet('page') ?? 1;

        $books = $this->bookModel->search($keyword, $category, 12);

        $data = [
            'title'      => 'Catalog Koleksi',
            'books'      => $books,
            'categories' => $this->categoriesModel->findAll(),
            'keyword'    => $keyword,
            'category'   => $category,
        ];
        return view('user/catalog/index', $data);
    }

    // ─── Detail Buku ─────────────────────────────────────────
    public function bookDetail($id)
    {
        $book = $this->bookModel->find($id);
        if (! $book) return redirect()->to('/catalog')->with('error', 'Buku tidak ditemukan.');

        $userId       = session()->get('user_id');
        $isWishlisted = false;
        $activeLoan   = null;

        if ($userId) {
            $wishlistModel = new WishlistModel();
            $isWishlisted  = $wishlistModel->isWishlisted($userId, $id);
            $activeLoan    = $this->loanModel->getActiveLoan($userId, $id);
        }

        $data = [
            'title'        => $book['title'],
            'book'         => $book,
            'isWishlisted' => $isWishlisted,
            'activeLoan'   => $activeLoan,
            'related'      => $this->bookModel->getByCategory($book['category_id'], 4, $id),
        ];
        return view('user/catalog/detail', $data);
    }

    // ─── Pinjam Buku ─────────────────────────────────────────
    public function LoanBook($id)
    {
        $userId = session()->get('user_id');
        
        $book = $this->bookModel->find($id);

        if (! $book) return redirect()->back()->with('error', 'Buku tidak ditemukan.');
        if ($book['stock'] < 1) return redirect()->back()->with('error', 'Stok buku habis.');

        $existing = $this->loanModel->getActiveLoan($userId, $id);
        if ($existing) return redirect()->back()->with('error', 'Kamu sudah meminjam buku ini.');

        $this->loanModel->save([
            'loan_code'   => 'LN-' . date('Ymd') . '-' . rand(1000, 9999),
            'user_id'     => $userId,
            'book_id'     => $id,
            'status'      => 'pending',
            'borrow_date' => date('Y-m-d'),
            'due_date'    => date('Y-m-d', strtotime('+14 days')),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Permintaan loan dikirim. Tunggu persetujuan pustakawan.'
            ]);
        }
        return redirect()->to('/loan-saya')->with('success', 'Permintaan loan dikirim. Tunggu persetujuan pustakawan.');
    }

    // ─── Borrow Form & Processing ────────────────────────────
    public function loanForm($id)
    {
        $book = $this->bookModel->find($id);
        if (!$book) return redirect()->to('/catalog')->with('error', 'Buku tidak ditemukan.');
        
        $data = [
            'title' => 'Formulir Peminjaman',
            'book' => $book,
            'user' => $this->userModel->find(session()->get('user_id'))
        ];
        return view('user/borrow_form', $data);
    }

    public function processLoan($id)
    {
        $userId = session()->get('user_id');
        $format = $this->request->getPost('format'); // ebook / physical
        $method = $this->request->getPost('method'); // pickup / delivery
        $address = $this->request->getPost('address');

        // Untuk demo delivery, generate random tracking code
        $trackingCode = strtoupper(substr(md5(uniqid()), 0, 10));
        
        // Generate Unique Loan Code
        $loanCode = 'LN-' . date('Ymd') . '-' . rand(1000, 9999);

        $this->loanModel->save([
            'loan_code'   => $loanCode,
            'user_id'     => $userId,
            'book_id'     => $id,
            'status'      => ($method === 'delivery') ? 'delivering' : 'pending',
            'borrow_date' => date('Y-m-d'),
            'due_date'    => date('Y-m-d', strtotime('+14 days')),
        ]);

        return redirect()->to('/loan-saya')->with('success', 'Buku berhasil dipinjam/diajukan. Silakan tunggu persetujuan Pustakawan.');
    }

    public function deliveryTracking($trackingCode)
    {
        $data = [
            'title' => 'Live Tracking Delivery',
            'trackingCode' => $trackingCode
        ];
        return view('user/delivery_tracking', $data);
    }

    // ─── Wishlist ─────────────────────────────────────────────
    public function toggleWishlist($id)
    {
        $userId        = session()->get('user_id');
        $wishlistModel = new WishlistModel();

        $wishlistModel->toggle($userId, $id);
        
        if ($this->request->isAJAX()) {
            $isWishlisted = $wishlistModel->where(['user_id' => $userId, 'book_id' => $id])->countAllResults() > 0;
            return $this->response->setJSON([
                'success' => true, 
                'message' => 'Daftar bacaan diperbarui.',
                'isWishlisted' => $isWishlisted
            ]);
        }
        return redirect()->back()->with('success', 'Daftar bacaan diperbarui.');
    }

    public function wishlist()
    {
        $userId        = session()->get('user_id');
        $wishlistModel = new WishlistModel();

        $data = [
            'title' => 'Daftar Bacaan',
            'books' => $wishlistModel->getUserWishlist($userId),
        ];
        return view('user/wishlist', $data);
    }

    // ─── Peminjaman Saya ─────────────────────────────────────
    public function myLoans()
    {
        $userId = session()->get('user_id');
        $fineModel = new \App\Models\FineModel();
        $fineModel->syncFines();
        
        $data   = [
            'title' => 'Peminjaman Saya',
            'loans' => $this->loanModel->getUserLoans($userId),
        ];
        return view('user/loans', $data);
    }

    // ─── Profil ──────────────────────────────────────────────
    public function profile()
    {
        $userId    = session()->get('user_id');
        $wishlistModel = new WishlistModel();
        
        $db = \Config\Database::connect();
        
        // Ambil data follower/following asli dari DB
        $followersCount = $db->table('user_follows')->where('following_id', $userId)->countAllResults();
        $followingCount = $db->table('user_follows')->where('follower_id', $userId)->countAllResults();
        
        // Ambil buku favorit dari DB
        $favoriteBooks = $db->table('favorite_books')
                            ->select('books.*')
                            ->join('books', 'books.id = favorite_books.book_id')
                            ->where('favorite_books.user_id', $userId)
                            ->limit(4)
                            ->get()->getResultArray();
        
        // Ambil denda user yang belum dibayar
        $fineModel = new \App\Models\FineModel();
        $unpaidFines = $fineModel->where('user_id', $userId)->where('status', 'unpaid')->findAll();

        // Layanan Tambahan User
        $refModel = new \App\Models\ReferenceLoanModel();
        $citModel = new \App\Models\CitationCheckModel();
        $consModel = new \App\Models\ConsultationModel();
        $mendeleyModel = new \App\Models\MendeleyClassModel();
        $langModel = new \App\Models\LanguageClassModel();
        $roomModel = new \App\Models\RoomBookingModel();

        $myServices = [
            'referensi' => $refModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'sitasi'    => $citModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'konsultasi'=> $consModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'mendeley'  => $mendeleyModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'language'  => $langModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll(),
            'room'      => $roomModel->where('user_id', $userId)->orderBy('created_at', 'DESC')->findAll()
        ];

        // Hitung Books Read dari Reading Trackers
        $trackerModel = new \App\Models\ReadingTrackerModel();
        $booksReadCount = $trackerModel->where('user_id', $userId)->where('status', 'read')->countAllResults();

        $data = [
            'title' => 'Profil Saya',
            'user'  => $this->userModel->find($userId),
            'stats' => $this->loanModel->getUserStats($userId),
            'booksReadCount' => $booksReadCount,
            'favoriteBooks'  => $favoriteBooks,
            'followersCount' => $followersCount,
            'followingCount' => $followingCount,
            'wishlistCount'  => $wishlistModel->where('user_id', $userId)->countAllResults(),
            'unpaidFines'    => $unpaidFines,
            'myServices'     => $myServices
        ];
        return view('user/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
            'photo' => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'
        ];

        if (! $this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON([
                    'success' => false, 
                    'errors' => $this->validator->getErrors()
                ]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];
        
        if ($this->request->getPost('bio') !== null) {
            $data['bio'] = $this->request->getPost('bio');
        }

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $photo = $this->request->getFile('photo');
        if ($photo && $photo->isValid() && ! $photo->hasMoved()) {
            $newName = $photo->getRandomName();
            $photo->move('uploads/users', $newName);
            $data['photo'] = $newName;
        }

        $this->userModel->update($userId, $data);
        session()->set('user_name', $data['name']);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'message' => 'Profil berhasil diperbarui.',
                'user'    => $data
            ]);
        }

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    public function submitJournal()
    {
        $userId = session()->get('user_id');
        if (!$userId) return redirect()->to('/login');

        $journalModel = new \App\Models\JournalModel();
        $userModel = new \App\Models\UserModel();
        $user = $userModel->find($userId);

        $rules = [
            'title'   => 'required|min_length[3]|max_length[255]',
            'excerpt' => 'required',
            'content' => 'required'
        ];

        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $coverImage = 'placeholder.jpg';
        $file = $this->request->getFile('cover_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(FCPATH . 'uploads/journals', $newName);
            $coverImage = $newName;
        }

        $data = [
            'user_id'     => $userId,
            'title'       => $this->request->getPost('title'),
            'type'        => 'User Journal', // Approved by user
            'excerpt'     => $this->request->getPost('excerpt'),
            'content'     => $this->request->getPost('content'),
            'cover_image' => $coverImage,
            'author'      => $user['name'] ?? 'Anonymous Member'
        ];

        $journalModel->insert($data);

        return redirect()->to('/profil#my-journal')->with('success', 'Artikel berhasil diterbitkan!');
    }

    // ─── Halaman Statis ──────────────────────────────────────
    public function collections()
    {
        return view('user/collections', ['title' => 'Koleksi Kami']);
    }

    public function readingRooms()
    {
        return view('user/reading_rooms', ['title' => 'Ruang Baca']);
    }

    public function archiveDownload($id)
    {
        return redirect()->to('/archives')->with('success', 'File arsip sedang diunduh.');
    }

    public function payFine($id)
    {
        $userId = session()->get('user_id');
        $fineModel = new \App\Models\FineModel();
        
        $fine = $fineModel->find($id);
        if ($fine && $fine['user_id'] == $userId && $fine['status'] == 'unpaid') {
            $fineModel->update($id, [
                'status'  => 'paid',
                'paid_at' => date('Y-m-d H:i:s')
            ]);
            
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Denda berhasil dibayar melalui sistem otomatis.']);
            }
            return redirect()->back()->with('success', 'Denda berhasil dibayar melalui sistem otomatis.');
        }
        
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'error' => 'Gagal membayar denda.']);
        }
        return redirect()->back()->with('error', 'Gagal membayar denda.');
    }

    public function archives()
    {
        return view('user/archives', ['title' => 'Arsip Digital']);
    }

    public function about()
    {
        return view('user/about', ['title' => 'Tentang Kami']);
    }

    public function journal()
    {
        $journalModel = new \App\Models\JournalModel();
        // Get all journals ordered by newest
        $journals = $journalModel->orderBy('created_at', 'DESC')->findAll();
        
        return view('user/journal', [
            'title'    => 'Mini Journalism of the Week',
            'journals' => $journals
        ]);
    }

    public function journalDetail($id)
    {
        $journalModel = new \App\Models\JournalModel();
        $journal = $journalModel->find($id);

        if (!$journal) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Jurnal tidak ditemukan.');
        }

        $book = null;
        if (!empty($journal['book_id'])) {
            $bookModel = new \App\Models\BookModel();
            $book = $bookModel->select('books.*, categories.name as category_name')
                              ->join('categories', 'categories.id = books.category_id', 'left')
                              ->find($journal['book_id']);
        }

        return view('user/journal_detail', [
            'title'   => $journal['title'],
            'journal' => $journal,
            'book'    => $book
        ]);
    }

    public function latestOdoc()
    {
        $journalModel = new \App\Models\JournalModel();
        // Cari jurnal bertipe ODOC (atau judul mengandung ODOC, tapi idealnya type)
        // Kita asumsikan typenya "ODOC" atau "Classic" atau kita ambil yang terbaru
        $latest = $journalModel->where('type', 'ODOC')
                               ->orWhere('type', 'Classic')
                               ->orderBy('created_at', 'DESC')
                               ->first();
        if ($latest) {
            return redirect()->to('mini-journalism/' . $latest['id']);
        } else {
            // Fallback ke daftar jurnal
            return redirect()->to('mini-journalism');
        }
    }
}