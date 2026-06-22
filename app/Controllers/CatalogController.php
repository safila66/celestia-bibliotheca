<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;

class CatalogController extends BaseController
{
    protected $bookModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->bookModel = new BookModel();
        $this->categoryModel = new CategoryModel();
    }

    public function categories()
    {
        return redirect()->to('/#categories');
    }

    public function index()
    {
        // 1. Menangkap filter kategori dari URL (contoh: ?category=3)
        $category = $this->request->getGet('category');
        
        // 2. Menangkap kata kunci dari kotak pencarian (contoh: ?q=harry+potter)
        $keyword = $this->request->getGet('q');

        // Mulai menyusun query pencarian ke database
        $query = $this->bookModel
                      ->select('books.*, categories.name as category_name')
                      ->join('categories', 'categories.id = books.category_id', 'left');
        
        $judulLayar = "Semua Koleksi Archive";
        $categoryName = null;

        // Jika user mengklik salah satu rasi bintang (kategori)
        if ($category) {
            if (is_numeric($category)) {
                // Filter berdasarkan ID kategori
                $query = $query->where('books.category_id', $category);
                // Ambil nama kategori untuk tampilan judul
                $cat = $this->categoryModel->find($category);
                $categoryName = $cat ? $cat['name'] : 'Unknown';
            } else {
                // Filter berdasarkan nama kategori (LIKE)
                $query = $query->like('categories.name', $category);
                $categoryName = ucfirst($category);
            }
            $judulLayar = "Koleksi: " . ($categoryName ?? $category);
        }

        // Jika user mengetik di kotak pencarian "Search the Stars"
        if ($keyword) {
            $query = $query->groupStart()
                           ->like('books.title', $keyword)
                           ->orLike('books.author', $keyword)
                           ->orLike('books.isbn', $keyword)
                           ->orLike('books.description', $keyword)
                           ->orLike('books.publisher', $keyword)
                           ->orLike('categories.name', $keyword)
                           ->orLike('books.genres', $keyword)
                           ->groupEnd();
            $judulLayar = "Hasil Pencarian: " . $keyword;
        }

        // Eksekusi pencarian dan ambil semua hasilnya
        $daftarBuku = $query->orderBy('books.created_at', 'DESC')->findAll();

        $rekomendasi = [];
        if (empty($daftarBuku) && !empty($keyword)) {
            // Pecah keyword menjadi kata-kata
            $words = explode(' ', $keyword);
            $recQuery = $this->bookModel
                             ->select('books.*, categories.name as category_name')
                             ->join('categories', 'categories.id = books.category_id', 'left')
                             ->groupStart();
            
            foreach ($words as $word) {
                if (strlen($word) > 2) {
                    $recQuery = $recQuery->orLike('books.genres', $word)
                                         ->orLike('books.description', $word);
                }
            }
            $recQuery = $recQuery->groupEnd();
            $rekomendasi = $recQuery->limit(5)->findAll();
        }

        // Ambil semua kategori untuk filter sidebar/dropdown
        $allCategories = $this->categoryModel->findAll();

        // Siapkan data untuk dikirim ke file View (catalog.php)
        $data = [
            'title'          => $judulLayar . ' | Celestia Bibliotheca',
            'buku'           => $daftarBuku,
            'kategori_aktif' => $category,
            'keyword'        => $keyword,
            'categories'     => $allCategories,
            'rekomendasi'    => $rekomendasi,
        ];

        return view('user/catalog', $data);
    }
}