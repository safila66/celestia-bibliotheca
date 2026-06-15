<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\FineModel;

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
        $status = $this->request->getGet('status') ?? 'all';

        $data = [
            'title'  => 'Manajemen Peminjaman',
            'loans'  => $this->loanModel->getAllLoans($status),
            'status' => $status,
            'counts' => [
                'all'      => $this->loanModel->countAll(),
                'pending'  => $this->loanModel->where('status','pending')->countAllResults(),
                'approved' => $this->loanModel->where('status','approved')->countAllResults(),
                'returned' => $this->loanModel->where('status','returned')->countAllResults(),
                'overdue'  => $this->loanModel->getOverdueLoans(true),
            ],
        ];
        return view('admin/loans/index', $data);
    }

    public function approve($id)
    {
        $loan = $this->loanModel->find($id);
        if (! $loan || $loan['status'] !== 'pending') {
            return redirect()->to('/admin/peminjaman')->with('error', 'Permintaan tidak valid.');
        }

        // Kurangi stok
        $this->bookModel->decrementStock($loan['book_id']);

        $this->loanModel->update($id, [
            'status'        => 'approved',
            'approved_date' => date('Y-m-d'),
        ]);

        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman disetujui.');
    }

    public function reject($id)
    {
        $loan = $this->loanModel->find($id);
        if (! $loan || $loan['status'] !== 'pending') {
            return redirect()->to('/admin/peminjaman')->with('error', 'Permintaan tidak valid.');
        }

        $this->loanModel->update($id, ['status' => 'rejected']);
        return redirect()->to('/admin/peminjaman')->with('success', 'Peminjaman ditolak.');
    }

    public function returnBook($id)
    {
        $loan = $this->loanModel->find($id);
        if (! $loan || $loan['status'] !== 'approved') {
            return redirect()->to('/admin/peminjaman')->with('error', 'Data peminjaman tidak valid.');
        }

        $returnDate = date('Y-m-d');
        $dueDate    = $loan['due_date'];
        $fine       = 0;

        // Hitung denda jika terlambat (Rp 2.000/hari)
        if ($returnDate > $dueDate) {
            $days  = (int) ceil((strtotime($returnDate) - strtotime($dueDate)) / 86400);
            $fine  = $days * 2000;

            $fineModel = new FineModel();
            $fineModel->save([
                'loan_id'  => $id,
                'user_id'  => $loan['user_id'],
                'amount'   => $fine,
                'status'   => 'unpaid',
            ]);
        }

        // Kembalikan stok
        $this->bookModel->incrementStock($loan['book_id']);

        $this->loanModel->update($id, [
            'status'      => 'returned',
            'return_date' => $returnDate,
        ]);

        $msg = 'Buku berhasil dikembalikan.';
        if ($fine > 0) $msg .= " Denda: Rp " . number_format($fine, 0, ',', '.');

        return redirect()->to('/admin/peminjaman')->with('success', $msg);
    }

    public function deliveryQueue()
    {
        $data = [
            'title'    => 'Antrian Book Delivery',
            'deliveries' => $this->loanModel->getDeliveryQueue(),
        ];
        return view('admin/loans/delivery', $data);
    }
}