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
            
            // 3. Ambil Koleksi Buku Asli
            'newArrivals'   => $this->bookModel->orderBy('created_at', 'DESC')->findAll(4),
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
            'user_id'   => $userId,
            'book_id'   => $id,
            'status'    => 'pending',
            'loan_date' => date('Y-m-d'),
            'due_date'  => date('Y-m-d', strtotime('+14 days')),
        ]);

        return redirect()->to('/loan-saya')->with('success', 'Permintaan loan dikirim. Tunggu persetujuan pustakawan.');
    }

    // ─── Wishlist ─────────────────────────────────────────────
    public function toggleWishlist($id)
    {
        $userId        = session()->get('user_id');
        $wishlistModel = new WishlistModel();

        $wishlistModel->toggle($userId, $id);
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
        $data = [
            'title' => 'Profil Saya',
            'user'  => $this->userModel->find($userId),
            'stats' => $this->loanModel->getUserStats($userId),
        ];
        return view('user/profile', $data);
    }

    public function updateProfile()
    {
        $userId = session()->get('user_id');

        $rules = [
            'name'  => 'required|min_length[3]',
            'email' => "required|valid_email|is_unique[users.email,id,{$userId}]",
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $data = [
            'name'  => $this->request->getPost('name'),
            'email' => $this->request->getPost('email'),
        ];

        if ($this->request->getPost('password')) {
            $data['password'] = password_hash($this->request->getPost('password'), PASSWORD_DEFAULT);
        }

        $this->userModel->update($userId, $data);
        session()->set('user_name', $data['name']);

        return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
    }

    // ─── Halaman Statis ──────────────────────────────────────
    public function collections()
    {
        return view('user/static/collections', ['title' => 'Koleksi Kami']);
    }

    public function readingRooms()
    {
        return view('user/static/reading_rooms', ['title' => 'Ruang Baca']);
    }

    public function archives()
    {
        return view('user/static/archives', ['title' => 'Arsip Digital']);
    }

    public function about()
    {
        return view('user/static/about', ['title' => 'Tentang Kami']);
    }
}