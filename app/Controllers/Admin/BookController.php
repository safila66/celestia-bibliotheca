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

    public function create()
    {
        $data = [
            'title'      => 'Tambah Koleksi',
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('admin/books/form', $data);
    }

    public function store()
    {
        $rules = [
            'title'       => 'required|min_length[3]',
            'author'      => 'required',
            'isbn'        => 'permit_empty|is_unique[books.isbn]',
            'category_id' => 'required|integer',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
            'year'        => 'permit_empty|integer',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $cover = $this->handleCoverUpload();

        $this->bookModel->save([
            'title'       => $this->request->getPost('title'),
            'author'      => $this->request->getPost('author'),
            'isbn'        => $this->request->getPost('isbn'),
            'publisher'   => $this->request->getPost('publisher'),
            'year'        => $this->request->getPost('year'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'stock'       => $this->request->getPost('stock'),
            'cover'       => $cover,
        ]);

        return redirect()->to('/admin/koleksi')->with('success', 'Buku berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $book = $this->bookModel->find($id);
        if (! $book) return redirect()->to('/admin/koleksi')->with('error', 'Buku tidak ditemukan.');

        $data = [
            'title'      => 'Edit Koleksi',
            'book'       => $book,
            'categories' => $this->categoryModel->findAll(),
        ];
        return view('admin/books/form', $data);
    }

    public function update($id)
    {
        $book = $this->bookModel->find($id);
        if (! $book) return redirect()->to('/admin/koleksi')->with('error', 'Buku tidak ditemukan.');

        $rules = [
            'title'       => 'required|min_length[3]',
            'author'      => 'required',
            'isbn'        => "permit_empty|is_unique[books.isbn,id,{$id}]",
            'category_id' => 'required|integer',
            'stock'       => 'required|integer|greater_than_equal_to[0]',
        ];

        if (! $this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $cover = $this->handleCoverUpload() ?? $book['cover'];

        $this->bookModel->update($id, [
            'title'       => $this->request->getPost('title'),
            'author'      => $this->request->getPost('author'),
            'isbn'        => $this->request->getPost('isbn'),
            'publisher'   => $this->request->getPost('publisher'),
            'year'        => $this->request->getPost('year'),
            'category_id' => $this->request->getPost('category_id'),
            'description' => $this->request->getPost('description'),
            'stock'       => $this->request->getPost('stock'),
            'cover'       => $cover,
        ]);

        return redirect()->to('/admin/koleksi')->with('success', 'Buku berhasil diperbarui.');
    }

    public function delete($id)
    {
        $book = $this->bookModel->find($id);
        if (! $book) return redirect()->to('/admin/koleksi')->with('error', 'Buku tidak ditemukan.');

        $this->bookModel->delete($id);
        return redirect()->to('/admin/koleksi')->with('success', 'Buku berhasil dihapus.');
    }

    private function handleCoverUpload(): ?string
    {
        $file = $this->request->getFile('cover');
        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/covers', $newName);
            return $newName;
        }
        return null;
    }
}