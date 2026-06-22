<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\JournalModel;

class JournalController extends BaseController
{
    protected $journalModel;

    public function __construct()
    {
        $this->journalModel = new JournalModel();
    }

    public function index()
    {
        $keyword = $this->request->getGet('q');
        
        if ($keyword) {
            $this->journalModel->like('title', $keyword)->orLike('author', $keyword);
        }

        $data = [
            'title'    => 'Manajemen Jurnal',
            'journals' => $this->journalModel->findAll(),
            'keyword'  => $keyword
        ];

        return view('admin/journals/index', $data);
    }

    public function ajaxCreate()
    {
        $bookModel = new \App\Models\BookModel();
        return view('admin/journals/modal_create', [
            'books' => $bookModel->select('id, title')->findAll()
        ]);
    }

    public function ajaxEdit($id)
    {
        $journal = $this->journalModel->find($id);
        if (!$journal) {
            return "Jurnal tidak ditemukan.";
        }
        $bookModel = new \App\Models\BookModel();
        return view('admin/journals/modal_edit', [
            'journal' => $journal,
            'books'   => $bookModel->select('id, title')->findAll()
        ]);
    }

    public function store()
    {
        $book_id = $this->request->getPost('book_id');
        $data = [
            'book_id' => empty($book_id) ? null : $book_id,
            'title'   => $this->request->getPost('title'),
            'type'    => $this->request->getPost('type'),
            'author'  => $this->request->getPost('author'),
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
        ];

        $cover = $this->handleCoverUpload();
        if ($cover) {
            $data['cover_image'] = $cover;
        }

        if ($this->journalModel->insert($data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Jurnal berhasil ditambahkan.']);
            }
            session()->setFlashdata('success', 'Jurnal berhasil ditambahkan.');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'error' => 'Gagal menambahkan jurnal.']);
            }
            session()->setFlashdata('error', 'Gagal menambahkan jurnal. Periksa data kembali.');
        }

        return redirect()->to('admin/list/journals');
    }

    public function update($id)
    {
        $book_id = $this->request->getPost('book_id');
        $data = [
            'book_id' => empty($book_id) ? null : $book_id,
            'title'   => $this->request->getPost('title'),
            'type'    => $this->request->getPost('type'),
            'author'  => $this->request->getPost('author'),
            'excerpt' => $this->request->getPost('excerpt'),
            'content' => $this->request->getPost('content'),
        ];

        $cover = $this->handleCoverUpload();
        if ($cover) {
            $data['cover_image'] = $cover;
        }

        if ($this->journalModel->update($id, $data)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => true, 'message' => 'Jurnal berhasil diperbarui.']);
            }
            session()->setFlashdata('success', 'Jurnal berhasil diperbarui.');
        } else {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'error' => 'Gagal memperbarui jurnal.']);
            }
            session()->setFlashdata('error', 'Gagal memperbarui jurnal. Periksa data kembali.');
        }

        return redirect()->to('admin/list/journals');
    }

    public function delete($id)
    {
        $this->journalModel->delete($id);
        session()->setFlashdata('success', 'Jurnal dipindahkan ke tong sampah.');
        return redirect()->to('admin/list/journals');
    }

    public function trash()
    {
        $data = [
            'title'    => 'Tong Sampah Jurnal',
            'journals' => $this->journalModel->onlyDeleted()->findAll()
        ];
        return view('admin/journals/trash', $data);
    }

    public function restore($id)
    {
        $this->journalModel->update($id, ['deleted_at' => null]);
        session()->setFlashdata('success', 'Jurnal berhasil dipulihkan.');
        return redirect()->to('admin/list/journals/trash');
    }

    public function purge($id)
    {
        // Option to delete file here too, skipping for now
        $this->journalModel->delete($id, true);
        session()->setFlashdata('success', 'Jurnal dihapus permanen.');
        return redirect()->to('admin/list/journals/trash');
    }

    private function handleCoverUpload()
    {
        $file = $this->request->getFile('cover_image');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/assets/images', $newName);
            return $newName;
        }
        return null;
    }
}
