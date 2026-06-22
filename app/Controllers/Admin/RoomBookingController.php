<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\RoomBookingModel;
use App\Models\UserModel;

class RoomBookingController extends BaseController
{
    protected $roomBookingModel;
    protected $userModel;

    public function __construct()
    {
        $this->roomBookingModel = new RoomBookingModel();
        $this->userModel = new UserModel();
    }

    public function index()
    {
        $data = [
            'title'    => 'Room Bookings',
            'bookings' => $this->roomBookingModel->getAllBookings()
        ];
        return view('admin/room_bookings/index', $data);
    }

    public function ajaxCreate()
    {
        $data = [
            'members' => $this->userModel->where('role', 'member')->findAll(),
            'rooms'   => [
                'Ruang Diskusi A', 'Ruang Diskusi B', 'Ruang Diskusi C',
                'Private Room A', 'Private Room B', 'Private Room C',
                'Meeting Room A', 'Meeting Room B',
                'Class Room A', 'Class Room B', 'Ruang Audio Visual',
                'Artwork Room A', 'Bilik Komputer'
            ]
        ];
        return view('admin/room_bookings/modal_create', $data);
    }

    public function store()
    {
        $this->roomBookingModel->save([
            'user_id'      => $this->request->getPost('user_id'),
            'room_name'    => $this->request->getPost('room_name'),
            'booking_date' => $this->request->getPost('booking_date'),
            'start_time'   => $this->request->getPost('start_time'),
            'end_time'     => $this->request->getPost('end_time'),
            'purpose'      => $this->request->getPost('purpose'),
            'status'       => $this->request->getPost('status') ?? 'pending',
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi ruangan berhasil ditambahkan.']);
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi ruangan berhasil ditambahkan.']);
        }
        return redirect()->to('admin/room-bookings')->with('success', 'Reservasi ruangan berhasil ditambahkan.');
    }

    public function ajaxEdit($id)
    {
        $data = [
            'booking' => $this->roomBookingModel->find($id),
            'members' => $this->userModel->where('role', 'member')->findAll(),
            'rooms'   => [
                'Ruang Diskusi A', 'Ruang Diskusi B', 'Ruang Diskusi C',
                'Private Room A', 'Private Room B', 'Private Room C',
                'Meeting Room A', 'Meeting Room B',
                'Class Room A', 'Class Room B', 'Ruang Audio Visual',
                'Artwork Room A', 'Bilik Komputer'
            ]
        ];
        return view('admin/room_bookings/modal_edit', $data);
    }

    public function update($id)
    {
        $this->roomBookingModel->update($id, [
            'user_id'      => $this->request->getPost('user_id'),
            'room_name'    => $this->request->getPost('room_name'),
            'booking_date' => $this->request->getPost('booking_date'),
            'start_time'   => $this->request->getPost('start_time'),
            'end_time'     => $this->request->getPost('end_time'),
            'purpose'      => $this->request->getPost('purpose'),
            'status'       => $this->request->getPost('status'),
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi ruangan berhasil diperbarui.']);
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi ruangan berhasil diperbarui.']);
        }
        return redirect()->to('admin/room-bookings')->with('success', 'Reservasi ruangan berhasil diperbarui.');
    }

    public function delete($id)
    {
        $this->roomBookingModel->delete($id);
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi ruangan berhasil dihapus.']);
        }
        if ($this->request->isAJAX()) {
            return $this->response->setJSON(['success' => true, 'message' => 'Reservasi ruangan berhasil dihapus.']);
        }
        return redirect()->to('admin/room-bookings')->with('success', 'Reservasi ruangan berhasil dihapus.');
    }
}
