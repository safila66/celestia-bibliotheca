<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LoanModel;
use App\Models\BookModel;
use App\Models\UserModel;
use App\Models\FineModel;

class ReportController extends BaseController
{
    public function index()
    {
        $loanModel = new LoanModel();
        $bookModel = new BookModel();
        $userModel = new UserModel();
        $fineModel = new FineModel();

        $data = [
            'title'        => 'report',
            'loansByMonth' => $loanModel->getLoansByMonth(12),
            'topBooks'     => $bookModel->getMostBorrowed(10),
            'topMembers'   => $userModel->getMostActive(10),
            'fineStats'    => $fineModel->getStats(),
        ];
        return view('admin/reports/index', $data);
    }
}