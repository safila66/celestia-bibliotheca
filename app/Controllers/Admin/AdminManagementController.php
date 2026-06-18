<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\UserModel;

class AdminManagementController extends BaseController
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

        $query = $this->userModel->where('role', 'admin');

        if ($keyword) {
            $query->groupStart()
                  ->like('name', $keyword)
                  ->orLike('email', $keyword)
                  ->groupEnd();
        }

        $data = [
            'title'   => 'Manajemen Admin',
            'admins'  => $query->findAll(),
            'keyword' => $keyword,
        ];

        return view('admin/superadmin/index', $data);
    }

    // ══════════════════════════════════════════════════════════
    // 2. FUNGSI TAMBAH ADMIN (CREATE)
    // ══════════════════════════════════════════════════════════
    public function ajaxCreate()
    {
        return view('admin/superadmin/modal_create');
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
            'role'     => 'admin',
            'status'   => 'active',
            'photo'    => $photo,
        ]);

        return redirect()->to('admin/list/superadmin')->with('success', 'Admin baru berhasil ditambahkan!');
    }

    // ══════════════════════════════════════════════════════════
    // 3. FUNGSI EDIT ADMIN (UPDATE)
    // ══════════════════════════════════════════════════════════
    public function ajaxEdit($id)
    {
        $data['admin'] = $this->userModel->find($id);
        return view('admin/superadmin/modal_edit', $data);
    }

    public function update($id)
    {
        $admin = $this->userModel->find($id);
        if (! $admin) return redirect()->to('admin/list/superadmin')->with('error', 'Admin tidak ditemukan.');

        $photo = $this->handlePhotoUpload() ?? $admin['photo'];

        $this->userModel->update($id, [
            'name'    => $this->request->getPost('name'),
            'email'   => $this->request->getPost('email'),
            'phone'   => $this->request->getPost('phone'),
            'address' => $this->request->getPost('address'),
            'status'  => $this->request->getPost('status'),
            'photo'   => $photo,
        ]);

        return redirect()->to('admin/list/superadmin')->with('success', 'Data admin berhasil diperbarui.');
    }

    // ══════════════════════════════════════════════════════════
    // 4. FUNGSI HAPUS ADMIN (DELETE)
    // ══════════════════════════════════════════════════════════
    public function delete($id)
    {
        $admin = $this->userModel->find($id);
        if (! $admin) return redirect()->to('admin/list/superadmin')->with('error', 'Admin tidak ditemukan.');

        $this->userModel->delete($id);

        return redirect()->to('admin/list/superadmin')->with('success', 'Admin berhasil dibuang ke tong sampah.');
    }

    // ══════════════════════════════════════════════════════════
    // 5. TONG SAMPAH ADMIN (TRASH, RESTORE, PURGE)
    // ══════════════════════════════════════════════════════════
    public function trash()
    {
        $data = [
            'title'  => 'Tong Sampah Admin',
            'admins' => $this->userModel->onlyDeleted()->where('role', 'admin')->findAll(),
        ];

        return view('admin/superadmin/trash', $data);
    }

    public function restore($id)
    {
        $this->userModel->update($id, ['deleted_at' => null]);
        return redirect()->to('admin/list/superadmin/trash')->with('success', 'Admin berhasil dikembalikan.');
    }

    public function purge($id)
    {
        $this->userModel->delete($id, true);
        return redirect()->to('admin/list/superadmin/trash')->with('success', 'Admin telah dihapus permanen.');
    }

    // ══════════════════════════════════════════════════════════
    // HELPER: FUNGSI UPLOAD FOTO PROFIL
    // ══════════════════════════════════════════════════════════
    private function handlePhotoUpload(): ?string
    {
        $file = $this->request->getFile('photo');

        if ($file && $file->isValid() && ! $file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/profiles', $newName);
            return $newName;
        }

        return null;
    }
}
