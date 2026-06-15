<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;
use App\Models\LoanModel;

class UserController extends BaseController
{
    public function index()
    {
        $userModel = new UserModel();
        $keyword   = $this->request->getGet('q');

        $query = $userModel->where('role', 'user');
        if ($keyword) {
            $query->groupStart()
                  ->like('name', $keyword)
                  ->orLike('email', $keyword)
                  ->groupEnd();
        }

        $data = [
            'title'   => 'Manajemen Anggota',
            'members' => $query->findAll(),
            'keyword' => $keyword,
        ];
        return view('admin/members/index', $data);
    }

    public function detail($id)
    {
        $userModel = new UserModel();
        $loanModel = new LoanModel();

        $user = $userModel->find($id);
        if (! $user) return redirect()->to('/admin/anggota')->with('error', 'Anggota tidak ditemukan.');

        $data = [
            'title'  => 'Detail Anggota: ' . $user['name'],
            'member' => $user,
            'loans'  => $loanModel->getUserLoans($id),
            'stats'  => $loanModel->getUserStats($id),
        ];
        return view('admin/members/detail', $data);
    }

    public function toggleStatus($id)
    {
        $userModel = new UserModel();
        $user = $userModel->find($id);
        if (! $user) return redirect()->to('/admin/anggota')->with('error', 'Anggota tidak ditemukan.');

        $newStatus = $user['status'] === 'active' ? 'inactive' : 'active';
        $userModel->update($id, ['status' => $newStatus]);

        $label = $newStatus === 'active' ? 'diaktifkan' : 'dinonaktifkan';
        return redirect()->to('/admin/anggota')->with('success', "Akun {$user['name']} berhasil {$label}.");
    }
}