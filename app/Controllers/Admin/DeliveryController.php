<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\DeliveryModel;
use App\Models\BookModel;
use App\Models\UserModel;

class DeliveryController extends BaseController
{
    protected $deliveryModel;
    protected $bookModel;
    protected $userModel;

    public function __construct()
    {
        $this->deliveryModel = new DeliveryModel();
        $this->bookModel = new BookModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'      => 'Book Delivery',
            'deliveries' => $this->deliveryModel->getAllDeliveries()
        ];
        return view('admin/deliveries/index', $data);
    }

    public function ajaxCreate()
    {
        $data = [
            'members' => $this->userModel->where('role', 'member')->findAll(),
            'books'   => $this->bookModel->findAll()
        ];
        return view('admin/deliveries/modal_create', $data);
    }

    public function store()
    {
        $this->deliveryModel->save([
            'user_id'          => $this->request->getPost('user_id'),
            'book_id'          => $this->request->getPost('book_id'),
            'delivery_address' => $this->request->getPost('delivery_address'),
            'status'           => $this->request->getPost('status') ?? 'pending',
            'shipping_date'    => $this->request->getPost('shipping_date') ?: null,
            'tracking_number'  => $this->request->getPost('tracking_number') ?: null,
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan delivery berhasil ditambahkan.']);
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan delivery berhasil ditambahkan.']);
        }
        return redirect()->to('admin/delivery')->with('success', 'Catatan delivery berhasil ditambahkan.');
    }

    public function ajaxEdit($id)
    {
        $data = [
            'delivery' => $this->deliveryModel->find($id),
            'members'  => $this->userModel->where('role', 'member')->findAll(),
            'books'    => $this->bookModel->findAll()
        ];
        return view('admin/deliveries/modal_edit', $data);
    }

    public function update($id)
    {
        $status = $this->request->getPost('status');
        $userId = $this->request->getPost('user_id');
        $bookId = $this->request->getPost('book_id');

        $this->deliveryModel->update($id, [
            'user_id'          => $userId,
            'book_id'          => $bookId,
            'delivery_address' => $this->request->getPost('delivery_address'),
            'status'           => $status,
            'shipping_date'    => $this->request->getPost('shipping_date') ?: null,
            'tracking_number'  => $this->request->getPost('tracking_number') ?: null,
        ]);

        // Real-time integration with Sirkulasi Peminjaman (Loans)
        $loanModel = new \App\Models\LoanModel();
        $loan = $loanModel->where('user_id', $userId)
                          ->where('book_id', $bookId)
                          ->whereIn('status', ['pending', 'active'])
                          ->first();

        if ($loan) {
            if ($status === 'shipping' && $loan['status'] === 'pending') {
                // Buku sudah dikirim, maka status pinjaman jadi aktif
                $loanModel->update($loan['id'], [
                    'status'      => 'active',
                    'borrow_date' => date('Y-m-d'),
                    'due_date'    => date('Y-m-d', strtotime('+14 days')),
                    'approved_by' => session()->get('user_id')
                ]);
            } elseif ($status === 'cancelled') {
                // Jika delivery dibatalkan, batalkan juga pinjaman
                $loanModel->delete($loan['id']);
            }
        }

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan delivery berhasil diperbarui dan disinkronkan dengan sirkulasi.']);
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan delivery berhasil diperbarui.']);
        }
        return redirect()->to('admin/delivery')->with('success', 'Catatan delivery berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->deliveryModel->delete($id);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan delivery berhasil dihapus.']);
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Catatan delivery berhasil dihapus.']);
        }
        return redirect()->to('admin/delivery')->with('success', 'Catatan delivery berhasil dihapus.');
    }
}
