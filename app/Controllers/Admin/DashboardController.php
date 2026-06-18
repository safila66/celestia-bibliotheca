<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BookModel;
use App\Models\LoanModel;
use App\Models\UserModel;
use App\Models\FineModel;

class DashboardController extends BaseController
{
    public function index()
    {
        $bookModel = new BookModel();
        $loanModel = new LoanModel();
        $userModel = new UserModel();
        $fineModel = new FineModel();

        $data = [
            'title'          => 'Dashboard | Celestia Bibliotheca',
            
            // Menggunakan countAllResults() agar lebih akurat jika menggunakan Soft Deletes
            'totalBooks'     => $bookModel->countAllResults(),
            
            // ⬇️ PERBAIKAN 1: Ganti 'user' menjadi 'member'
            'totalMembers'   => $userModel->where('role', 'member')->countAllResults(),
            
            // ⬇️ PERBAIKAN 2: Ganti 'approved' menjadi 'active' sesuai database-mu
            'activeLoans'    => $loanModel->where('status', 'active')->countAllResults(),
            
            'pendingLoans'   => $loanModel->where('status', 'pending')->countAllResults(),
            'unpaidFines'    => $fineModel->where('status', 'unpaid')->countAllResults(),
            'recentLoans'    => $loanModel->getRecentLoans(8),
            'overdueLoans'   => $loanModel->getOverdueLoans(),
            'loansByMonth'   => $loanModel->getLoansByMonth(),
            'topBooks'       => $bookModel->getMostBorrowed(5),
        ];

        return view('admin/dashboard', $data);
    }
}