<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanModel;
use App\Models\BookModel;

class LoanController extends BaseController
{
    protected $loanModel;
    protected $bookModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->bookModel = new BookModel();
    }

    public function index()
    {
        $data = [
            'title' => 'Sirkulasi Peminjaman',
            // Ini akan memanggil fungsi getAllLoans() yang baru kita buat di Model
            'loans' => $this->loanModel->getAllLoans() 
        ];

        return view('admin/loans/index', $data);
    }
    public function getData()
{
    // Panggil koneksi database
    $db = \Config\Database::connect();
    
    // Asumsi tabel kamu bernama 'loans', 'users' (untuk anggota), dan 'books'
    // Silakan sesuaikan nama tabel dan kolom dengan yang ada di phpMyAdmin kamu!
    $builder = $db->table('loans');
    $builder->select('loans.id, users.name as peminjam, books.title as judul_buku, loans.tanggal_pinjam, loans.status');
    $builder->join('users', 'users.id = loans.user_id');
    $builder->join('books', 'books.id = loans.book_id');
    $builder->orderBy('loans.tanggal_pinjam', 'DESC');
    $query = $builder->get();

    // Kembalikan data dalam bentuk JSON
    return $this->response->setJSON([
        'status' => 'success',
        'data' => $query->getResult()
    ]);
}
    // Fungsi untuk Pustakawan Menyetujui Peminjaman
    public function approve($id)
    {
        $this->loanModel->update($id, [
            'status'      => 'active',
            'approved_by' => session()->get('user_id'),
            'borrow_date' => date('Y-m-d'),
            'due_date'    => date('Y-m-d', strtotime('+14 days')) // Durasi pinjam 14 hari
        ]);

        return redirect()->back()->with('success', 'Buku berhasil dipinjamkan ke Scholar.');
    }

    // Fungsi untuk Menyelesaikan Peminjaman (Buku Dikembalikan)
    public function complete($id)
    {
        $loan = $this->loanModel->find($id);
        
        if ($loan) {
            // Menambah kembali stok buku yang dikembalikan
            $book = $this->bookModel->find($loan['book_id']);
            if ($book) {
                $this->bookModel->update($loan['book_id'], [
                    'stock_available' => $book['stock_available'] + 1
                ]);
            }
            
            // Ubah status menjadi returned
            $this->loanModel->update($id, ['status' => 'returned']);
        }

        return redirect()->back()->with('success', 'Buku telah kembali ke rak.');
    }

    public function ajaxCreate()
    {
        $userModel = new \App\Models\UserModel();
        $data = [
            'members' => $userModel->where('role', 'member')->findAll(),
            'books'   => $this->bookModel->where('stock_available >', 0)->findAll()
        ];
        return view('admin/loans/modal_create', $data);
    }

    public function store()
    {
        $this->loanModel->save([
            'user_id'     => $this->request->getPost('user_id'),
            'book_id'     => $this->request->getPost('book_id'),
            'borrow_date' => $this->request->getPost('borrow_date'),
            'due_date'    => $this->request->getPost('due_date'),
            'status'      => $this->request->getPost('status') ?? 'pending',
            'notes'       => $this->request->getPost('notes'),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan peminjaman berhasil ditambahkan.']);
        }
        return redirect()->to('admin/loan')->with('success', 'Catatan peminjaman berhasil ditambahkan.');
    }

    public function ajaxEdit($id)
    {
        $userModel = new \App\Models\UserModel();
        $data = [
            'loan'    => $this->loanModel->find($id),
            'members' => $userModel->where('role', 'member')->findAll(),
            'books'   => $this->bookModel->findAll()
        ];
        return view('admin/loans/modal_edit', $data);
    }

    public function update($id)
    {
        $this->loanModel->update($id, [
            'user_id'     => $this->request->getPost('user_id'),
            'book_id'     => $this->request->getPost('book_id'),
            'borrow_date' => $this->request->getPost('borrow_date'),
            'due_date'    => $this->request->getPost('due_date'),
            'status'      => $this->request->getPost('status'),
            'notes'       => $this->request->getPost('notes'),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan peminjaman berhasil diperbarui.']);
        }
        return redirect()->to('admin/loan')->with('success', 'Catatan peminjaman berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->loanModel->delete($id);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan peminjaman berhasil dihapus.']);
        }
        return redirect()->to('admin/loan')->with('success', 'Catatan peminjaman berhasil dihapus.');
    }
}