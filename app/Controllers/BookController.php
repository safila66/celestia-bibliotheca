<?php
namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\BookModel; 

class BookController extends BaseController
{
    protected $bookModel;

    public function __construct()
    {
        // Inisialisasi model
        $this->bookModel = new BookModel();
    }

    // 1. UBAH NAMA FUNGSI MENJADI 'detail' (bukan index)
    public function detail($id = null)
    {
        // Ambil data buku berdasarkan ID
        $data['book'] = $this->bookModel->find($id);
        
        // Jika buku tidak ada di database, munculkan error 404 bawaan CodeIgniter
        if (!$data['book']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Buku tidak ditemukan di arsip.");
        }
        
        // 2. MUNCULKAN HALAMAN FLIPBOOK (Bukan JSON)
        return view('user/bookdetail', $data);
    }
}