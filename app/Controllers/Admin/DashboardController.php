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
            'title'          => 'Dashboard',
            'totalBooks'     => $bookModel->countAll(),
            'totalMembers'   => $userModel->where('role', 'user')->countAllResults(),
            'activeLoans'    => $loanModel->where('status', 'approved')->countAllResults(),
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