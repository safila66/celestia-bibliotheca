<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel; 

class CatalogController extends BaseController
{
    protected $bookModel;

    public function __construct()
    {
        // Inisialisasi model saat controller dipanggil
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        // 1. Menangkap filter kategori dari URL (contoh: ?category=computer)
        $category = $this->request->getGet('category');
        
        // 2. Menangkap kata kunci dari kotak pencarian (contoh: ?q=harry+potter)
        $keyword = $this->request->getGet('q');

        // Mulai menyusun query pencarian ke database
        $query = $this->bookModel;
        $judulLayar = "Semua Koleksi Archive";

        // Jika user mengklik salah satu rasi bintang (kategori)
        if ($category) {
            // Asumsi nama kolom di databasemu adalah 'category'
            $query = $query->like('category', $category);
            $judulLayar = "Katalog: " . ucfirst($category);
        }

        // Jika user mengetik di kotak pencarian "Search the Stars"
        if ($keyword) {
            $query = $query->groupStart()
                           ->like('title', $keyword)
                           ->orLike('author', $keyword)
                           ->orLike('isbn', $keyword)
                           ->orLike('description', $keyword)
                           ->orLike('Genre', $keyword)
                           ->orLike('Publisher', $keyword)
                           ->orLike('Year', $keyword)
                           ->orLike('category', $keyword)
                           ->orLike('tags', $keyword)
                           ->groupEnd();
            $judulLayar = "Hasil Pencarian: " . $keyword;
        }

        // Eksekusi pencarian dan ambil semua hasilnya
        $daftarBuku = $query->findAll();

        // Siapkan data untuk dikirim ke file View (katalog.php)
        $data = [
            'title'          => $judulLayar . ' | Celestia Bibliotheca',
            'buku'           => $daftarBuku,
            'kategori_aktif' => $category,
            'keyword'        => $keyword
        ];

        return view('user/catalog', $data);
    }
}