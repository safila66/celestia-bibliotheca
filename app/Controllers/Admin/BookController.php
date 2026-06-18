<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\CategoryModel;

class BookController extends BaseController
{
    protected $bookModel;
    protected $categoryModel;

    public function __construct()
    {
        $this->bookModel     = new BookModel();
        $this->categoryModel = new CategoryModel();
    }

    // ══════════════════════════════════════════════════════════
    // 1. TAMPILAN TABEL UTAMA
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $keyword  = $this->request->getGet('q');
        $category = $this->request->getGet('kategori');

        $data = [
            'title'      => 'Manajemen Koleksi',
            'books'      => $this->bookModel->search($keyword, $category),
            'categories' => $this->categoryModel->findAll(),
            'keyword'    => $keyword,
            'category'   => $category,
        ];
        
        return view('admin/books/index', $data);
    }

    // ══════════════════════════════════════════════════════════
    // 2. FUNGSI TAMBAH BUKU (CREATE)
    // ══════════════════════════════════════════════════════════
    public function ajaxCreate()
    {
        // Mengambil semua data kategori untuk dropdown pilihan di pop-up
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/books/modal_create', $data);
    }
    
    public function store()
    {
        // JARING PENGAMAN: Cek apakah kategori dipilih!
        $categoryId = $this->request->getPost('category_id');
        if (empty($categoryId)) {
            return redirect()->to('admin/books')->with('error', 'Gagal menyimpan: Kategori Buku wajib dipilih!');
        }

        $cover = $this->handleCoverUpload();

        // Jika aman, simpan ke database
        $this->bookModel->save([
            'call_number'     => $this->request->getPost('call_number'),
            'isbn'            => $this->request->getPost('isbn'),
            'title'           => $this->request->getPost('title'),
            'author'          => $this->request->getPost('author'),
            'publisher'       => $this->request->getPost('publisher'),
            'year'            => $this->request->getPost('year'),
            'stock_available' => $this->request->getPost('stock_available'),
            'category_id'     => $categoryId, // Masukkan kategori yang sudah dicek
            'description'     => $this->request->getPost('description'),
            'cover_image'     => $cover,
        ]);
        
        return redirect()->to('admin/books')->with('success', 'Volume baru berhasil ditambahkan ke arsip!');
    }
    // ══════════════════════════════════════════════════════════
    // 3. FUNGSI EDIT BUKU (UPDATE)
    // ══════════════════════════════════════════════════════════
    public function ajaxEdit($id)
    {
        $data['book'] = $this->bookModel->find($id);
        return view('admin/books/modal_edit', $data);
    }

    public function update($id)
    {
        $book = $this->bookModel->find($id);
        if (! $book) return redirect()->to('admin/books')->with('error', 'Volume tidak ditemukan.');

        $cover = $this->handleCoverUpload() ?? $book['cover_image'];

        $this->bookModel->update($id, [
            'call_number'     => $this->request->getPost('call_number'),
            'isbn'            => $this->request->getPost('isbn'),
            'title'           => $this->request->getPost('title'),
            'author'          => $this->request->getPost('author'),
            'publisher'       => $this->request->getPost('publisher'),
            'year'            => $this->request->getPost('year'),
            'stock_available' => $this->request->getPost('stock_available'),
            'description'     => $this->request->getPost('description'),
            'cover_image'     => $cover,
        ]);

        return redirect()->to('admin/books')->with('success', 'Catatan volume berhasil diperbarui.');
    }

    // ══════════════════════════════════════════════════════════
    // 4. FUNGSI HAPUS BUKU (DELETE)
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        $book = $this->bookModel->find($id);
        if (! $book) return redirect()->to('admin/books')->with('error', 'Volume tidak ditemukan.');

        $this->bookModel->delete($id);
        
        return redirect()->to('admin/books')->with('success', 'Volume berhasil dibuang ke tong sampah.');
    }

    // ══════════════════════════════════════════════════════════
    // 5. TONG SAMPAH BUKU (TRASH, RESTORE, PURGE)
    // ══════════════════════════════════════════════════════════
    public function trash()
    {
        $data = [
            'title' => 'Tong Sampah Volume',
            'books' => $this->bookModel->onlyDeleted()->findAll() 
        ];
        
        return view('admin/books/trash', $data);
    }

    public function restore($id)
    {
        $this->bookModel->update($id, ['deleted_at' => null]);
        return redirect()->to('admin/book/trash')->with('success', 'Volume berhasil dikembalikan ke arsip utama.');
    }

    public function purge($id)
    {
        $this->bookModel->delete($id, true);
        return redirect()->to('admin/book/trash')->with('success', 'Volume telah dibumihanguskan selamanya.');
    }

    // ══════════════════════════════════════════════════════════
    // HELPER: FUNGSI UPLOAD GAMBAR SAMPUL
    // ══════════════════════════════════════════════════════════
    private function handleCoverUpload(): ?string
    {
        $file = $this->request->getFile('cover_image');
        
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/covers', $newName);
            return $newName;
        }
        
        return null;
    }
}