<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FineModel;

class FineController extends BaseController
{
    public function index()
    {
        $fineModel = new FineModel();
        $fineModel->syncFines(); // Sync fines before loading view
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
        $fineModel->update($id, ['status' => 'paid', 'paid_at' => date('Y-m-d H:i:s')]);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Denda ditandai sudah dibayar.']);
        }
        return redirect()->to('/admin/fines')->with('success', 'Denda ditandai sudah dibayar.');
    }

    public function delete($id)
    {
        $fineModel = new FineModel();
        $fineModel->delete($id);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Data denda berhasil dihapus.']);
        }
        return redirect()->to('/admin/fines')->with('success', 'Data denda berhasil dihapus.');
    }
}