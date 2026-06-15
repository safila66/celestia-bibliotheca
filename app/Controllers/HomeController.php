<?php

namespace App\Controllers;

use App\Models\BookModel;
use App\Models\CategoriesModel;
use App\Models\LoanModel;
use App\Models\WishlistModel;
use App\Models\UserModel;

class HomeController extends BaseController
{
    // Gunakan huruf kecil di awal (camelCase) agar standar dan seragam
    protected $bookModel;
    protected $categoriesModel;
    protected $loanModel;

    public function __construct()
    {
        $this->bookModel       = new BookModel();
        $this->categoriesModel = new CategoriesModel();
        $this->loanModel       = new LoanModel();
    }

    // ─── Beranda & Dashboard ─────────────────────────────────
    public function index()
    {
        $data = [
            'title'        => 'Bibliotheca Stellarum',
            'featured'     => $this->bookModel->getFeatured(8),
            'categories'   => $this->categoriesModel->findAll(),
            'newArrivals'  => $this->bookModel->getNewArrivals(4),
        ];

        // ── LOGIKA PERCABANGAN HALAMAN ──
        // Mengecek apakah ada data 'user_id' di dalam sesi (tanda user sudah login)
        if (session()->get('user_id')) {
            // Tampilkan Dashboard khusus Anggota
            return view('user/dashboard', $data);
        } else {
            // Tampilkan Landing Page animasi Goddess (Halaman Public)
            return view('user/home', $data);
        }
    }

    // ─── Katalog ─────────────────────────────────────────────
    public function catalog()
    {
        $keyword  = $this->request->getGet('q');
        $category = $this->request->getGet('kategori');
        $page     = $this->request->getGet('page') ?? 1;

        $books = $this->bookModel->search($keyword, $category, 12);

        $data = [
            'title'      => 'Katalog Koleksi',
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
        if (! $book) return redirect()->to('/katalog')->with('error', 'Buku tidak ditemukan.');

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
        
        // PERBAIKAN: Gunakan bookModel untuk mencari buku, bukan loanModel
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

        return redirect()->to('/peminjaman-saya')->with('success', 'Permintaan peminjaman dikirim. Tunggu persetujuan pustakawan.');
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
        $userModel = new UserModel();
        $data = [
            'title' => 'Profil Saya',
            'user'  => $userModel->find($userId),
            'stats' => $this->loanModel->getUserStats($userId),
        ];
        return view('user/profile', $data);
    }

    public function updateProfile()
    {
        $userId    = session()->get('user_id');
        $userModel = new UserModel();

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

        $userModel->update($userId, $data);
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