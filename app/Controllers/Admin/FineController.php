<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FineModel;

class FineController extends BaseController
{
    public function index()
    {
        $fineModel = new FineModel();
        $status    = $this->request->getGet('status') ?? 'all';

        $data = [
            'title'  => 'Manajemen Denda',
            'fines'  => $fineModel->getAllFines($status),
            'status' => $status,
            'totals' => [
                'unpaid' => $fineModel->getTotalUnpaid(),
                'paid'   => $fineModel->getTotalPaid(),
            ],
        ];
        return view('admin/fines/index', $data);
    }

    public function markPaid($id)
    {
        $fineModel = new FineModel();
        $fineModel->update($id, ['status' => 'paid', 'paid_date' => date('Y-m-d')]);
        return redirect()->to('/admin/fines')->with('success', 'Denda ditandai sudah dibayar.');
    }
}