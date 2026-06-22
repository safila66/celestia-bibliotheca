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
        // Redirect to buku if index view does not exist
        return redirect()->to('admin/report/buku');
    }

    public function buku()
    {
        $bookModel = new BookModel();
        $data = [
            'title' => 'Laporan Koleksi Buku',
            'books' => $bookModel->findAll()
        ];
        return view('admin/report/buku', $data);
    }

    public function cetakBuku()
    {
        $bookModel = new BookModel();
        $data = [
            'title' => 'Cetak Laporan Buku',
            'books' => $bookModel->findAll()
        ];
        return view('admin/report/cetak_buku', $data);
    }

    public function labelBuku()
    {
        $bookModel = new BookModel();
        $data = [
            'title' => 'Cetak Label Buku',
            'books' => $bookModel->findAll()
        ];
        return view('admin/report/label_buku', $data);
    }

    public function cetakLabelBuku()
    {
        $bookModel = new BookModel();
        $data = [
            'title' => 'Cetak Label Buku (Semua)',
            'books' => $bookModel->findAll()
        ];
        return view('admin/report/cetak_label_buku', $data);
    }

    public function cetakLabelSatu($id)
    {
        $bookModel = new BookModel();
        $data = [
            'title' => 'Cetak Label Buku (Satuan)',
            'book'  => $bookModel->find($id)
        ];
        return view('admin/report/cetak_label_satu', $data);
    }

    public function member()
    {
        $userModel = new UserModel();
        $data = [
            'title'   => 'Laporan Anggota',
            'members' => $userModel->where('role', 'member')->findAll()
        ];
        return view('admin/report/member', $data);
    }

    public function cetakKartuMemberSemua()
    {
        $userModel = new UserModel();
        $data = [
            'title'   => 'Cetak Kartu Member (Semua)',
            'members' => $userModel->where('role', 'member')->findAll()
        ];
        return view('admin/report/cetak_kartu_member', $data);
    }

    public function cetakKartuMemberSatu($id)
    {
        $userModel = new UserModel();
        $data = [
            'title'   => 'Cetak Kartu Member (Satuan)',
            'members' => [$userModel->find($id)] // dibungkus array agar view bisa meloop atau menangani satu item
        ];
        return view('admin/report/cetak_kartu_member', $data);
    }
}