<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class MemberController extends BaseController
{
    protected $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ══════════════════════════════════════════════════════════
    // 1. TAMPILAN TABEL UTAMA
    // ══════════════════════════════════════════════════════════
    public function index()
    {
        $keyword = $this->request->getGet('q');

        // Hanya tampilkan role 'member', bukan admin
        $query = $this->userModel->where('role', 'member');

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

    // ══════════════════════════════════════════════════════════
    // 2. FUNGSI TAMBAH ANGGOTA (CREATE)
    // ══════════════════════════════════════════════════════════
    public function ajaxCreate()
    {
        return view('admin/members/modal_create');
    }

    public function store()
    {
        $photo = $this->handlePhotoUpload();

        $this->userModel->save([
            'name'     => $this->request->getPost('name'),
            'email'    => $this->request->getPost('email'),
            'password' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'phone'    => $this->request->getPost('phone'),
            'address'  => $this->request->getPost('address'),
            'role'     => 'member',
            'status'   => 'active',
            'photo'    => $photo,
        ]);

        return redirect()->to('admin/list/members')->with('success', 'Anggota baru berhasil ditambahkan!');
    }

    // ══════════════════════════════════════════════════════════
    // 3. FUNGSI EDIT ANGGOTA (UPDATE)
    // ══════════════════════════════════════════════════════════
    public function ajaxEdit($id)
    {
        $member = $this->userModel->find($id);
        return view('admin/members/modal_edit', ['member' => $member]);
    }

    public function update($id)
    {
        $member = $this->userModel->find($id);
        if (!$member) return redirect()->to('admin/list/members')->with('error', 'Anggota tidak ditemukan.');

        $photo = $this->handlePhotoUpload() ?? $member['photo'];

        $this->userModel->update($id, [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'phone'   => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status'  => $this->request->getPost('status'),
            'photo'   => $photo,
        ]);

        return redirect()->to('admin/list/members')->with('success', 'Data anggota berhasil diperbarui!');
    }

    // ══════════════════════════════════════════════════════════
    // 4. FUNGSI HAPUS ANGGOTA (DELETE)
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        $member = $this->userModel->find($id);
        if (!$member) return redirect()->to('admin/list/members')->with('error', 'Anggota tidak ditemukan.');

        $this->userModel->delete($id);

        return redirect()->to('admin/list/members')->with('success', 'Anggota berhasil dipindahkan ke tong sampah.');
    }

    // ══════════════════════════════════════════════════════════
    // 5. TONG SAMPAH ANGGOTA (TRASH, RESTORE, PURGE)
    // ══════════════════════════════════════════════════════════
    public function trash()
    {
        $data = [
            'title'   => 'Tong Sampah Anggota',
            'members' => $this->userModel->onlyDeleted()->where('role', 'member')->findAll(),
        ];

        return view('admin/members/trash', $data);
    }

    public function restore($id)
    {
        $this->userModel->update($id, ['deleted_at' => null]);
        return redirect()->to('admin/list/members/trash')->with('success', 'Anggota berhasil di-restore.');
    }

    public function deletePermanent($id)
    {
        $this->userModel->delete($id, true);
        return redirect()->to('admin/list/members/trash')->with('success', 'Anggota berhasil dihapus permanen.');
    }

    // ══════════════════════════════════════════════════════════
    // HELPER: FUNGSI UPLOAD FOTO PROFIL
    // ══════════════════════════════════════════════════════════
    private function handlePhotoUpload(): ?string
    {
        $file = $this->request->getFile('photo');

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/profiles', $newName);
            return $newName;
        }

        return null;
    }
}