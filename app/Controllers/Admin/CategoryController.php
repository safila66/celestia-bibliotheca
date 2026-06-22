<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CategoryModel;

class CategoryController extends BaseController
{
    public function table()
{
    $categoryModel = new \App\Models\CategoryModel();
    $data = [
        'categories' => $categoryModel->withBookCount() // Pakai fungsi yang baru kita perbaiki tadi
    ];
    return view('admin/categories/table', $data); // Memanggil file table.php
}

public function index()
    {
        $categoryModel = new CategoryModel();
        $data = [
            'title'      => 'Manajemen Kategori',
            'categories' => $categoryModel->withBookCount(),
        ];
        return view('admin/categories/index', $data);
    }

    public function store()
    {
        $rules = [
            'name' => 'required|min_length[2]|is_unique[categories.name]',
            'icon' => 'permit_empty|max_length[10]',
        ];

        if (! $this->validate($rules)) {
            if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
        }
        return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $categoryModel = new CategoryModel();
        $categoryModel->save([
            'name'        => $this->request->getPost('name'),
            'icon'        => $this->request->getPost('icon') ?? '📚',
            'description' => $this->request->getPost('description'),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Kategori berhasil ditambahkan.']);
        }
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function delete($id)
    {
        $categoryModel = new CategoryModel();
        $categoryModel->delete($id);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
        }
        return redirect()->to('/admin/kategori')->with('success', 'Kategori berhasil dihapus.');
    }
}