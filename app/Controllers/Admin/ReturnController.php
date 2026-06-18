<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanModel;
use App\Models\BookModel;

class ReturnController extends BaseController
{
    protected $loanModel;
    protected $bookModel;

    public function __construct()
    {
        $this->loanModel = new LoanModel();
        $this->bookModel = new BookModel();
    }

    // ══════════════════════════════════════════════════════════
    // 1. TAMPILAN HALAMAN UTAMA (INDEX)
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        // Mengambil semua data peminjaman beserta nama user dan judul bukunya
        // Filter khusus untuk yang statusnya sudah 'returned' (dikembalikan)
        $returnedLoans = $this->loanModel->select('loans.*, users.name as user_name, books.title as book_title')
            ->join('users', 'users.id = loans.user_id', 'left')
            ->join('books', 'books.id = loans.book_id', 'left')
            ->where('loans.status', 'returned')
            ->orderBy('loans.updated_at', 'DESC')
            ->findAll();

        $data = [
            'title'        => 'Data Pengembalian',
            'pengembalian' => $returnedLoans
        ];

        return view('admin/pengembalian/index', $data);
    }

    // ══════════════════════════════════════════════════════════
    // 2. PROSES SIMPAN PENGEMBALIAN BUKU
    // ══════════════════════════════════════════════════════════
    public function simpanPengembalian()
    {
        // Mengambil ID Peminjaman (Loan ID) dari form input
        $loanId = $this->request->getPost('loan_id');
        
        if (!$loanId) {
            return redirect()->back()->with('error', 'Pilih ID Transaksi yang ingin dikembalikan.');
        }

        $loan = $this->loanModel->find($loanId);

        // Pastikan datanya ada dan statusnya masih dipinjam (active/overdue)
        if ($loan && in_array($loan['status'], ['active', 'overdue'])) {
            
            // 1. Kembalikan / Tambah Stok Buku (+1)
            $book = $this->bookModel->find($loan['book_id']);
            if ($book) {
                $this->bookModel->update($loan['book_id'], [
                    'stock_available' => $book['stock_available'] + 1
                ]);
            }

            // 2. Ubah Status Peminjaman menjadi Selesai ('returned')
            $this->loanModel->update($loanId, [
                'status' => 'returned'
            ]);

            return redirect()->to('admin/pengembalian')->with('success', 'Buku berhasil dikembalikan dan stok telah diperbarui!');
        }

        return redirect()->back()->with('error', 'Data tidak valid atau buku sudah dikembalikan sebelumnya.');
    }

    // ══════════════════════════════════════════════════════════
    // 3. FUNGSI HAPUS RIWAYAT PENGEMBALIAN
    // ══════════════════════════════════════════════════════════
    public function hapus($id)
    {
        $loan = $this->loanModel->find($id);

        if ($loan) {
            // Hapus riwayat dari database
            $this->loanModel->delete($id);
            return redirect()->to('admin/pengembalian')->with('success', 'Riwayat pengembalian berhasil dihapus.');
        }

        return redirect()->to('admin/pengembalian')->with('error', 'Data tidak ditemukan.');
    }
    
    // (Fungsi alias untuk mencocokkan route 'delete/pengembalian/(:num)')
    public function delete($id)
    {
        return $this->hapus($id);
    }

    // ══════════════════════════════════════════════════════════
    // 4. FUNGSI AJAX (Untuk Modal Pop-up / DataTables jika pakai)
    // ══════════════════════════════════════════════════════════
    public function ajaxCreate()
    {
        // Mengambil daftar peminjaman yang SEDANG AKTIF untuk ditampilkan di form kembalikan buku
        $data['active_loans'] = $this->loanModel->select('loans.id, users.name as user_name, books.title as book_title')
            ->join('users', 'users.id = loans.user_id')
            ->join('books', 'books.id = loans.book_id')
            ->whereIn('loans.status', ['active', 'overdue'])
            ->findAll();

        return view('admin/pengembalian/_form_create', $data); // Asumsi kamu memakai partial view untuk modal
    }

    public function ajaxEdit($id)
    {
        $data['pengembalian'] = $this->loanModel->find($id);
        return view('admin/pengembalian/_form_edit', $data);
    }
}