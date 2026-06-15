<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;
    protected $helpers = ['form'];

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
        $this->userModel = new UserModel();
    }

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    // ── Tampilkan form login ──
    public function login()
    {
        if (session()->get('user_id')) {
            return $this->redirectByRole();
        }
        return view('auth/login', ['title' => 'Masuk']);
    }

   // ── Proses login ──
public function processLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required|min_length[6]',
        ];
        $messages = [
            'email'    => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.'],
            'password' => ['required' => 'Kata sandi wajib diisi.', 'min_length' => 'Kata sandi minimal 6 karakter.'],
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $user = $this->userModel->where('email', $this->request->getPost('email'))->first();

        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
            return redirect()->back()->withInput()->with('error', 'Email atau kata sandi salah.');
        }

        if ($user['status'] !== 'active') {
            return redirect()->back()->withInput()->with('error', 'Akun Anda tidak aktif. Hubungi administrator.');
        }

        // Set session
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
            'logged_in'  => true,
        ]);

        // Redirect ke URL sebelumnya jika ada
        $redirectUrl = session()->get('redirect_url') ?? null;
        session()->remove('redirect_url');

        if ($redirectUrl) {
            return redirect()->to($redirectUrl)->with('success', 'Selamat datang, ' . $user['full_name'] . '!');
        }
        
        return $this->redirectByRole()->with('success', 'Login berhasil! Selamat datang kembali di Bibliotheca Stellarum.');
    }

    // ── Tampilkan form register ──
    public function register()
    {
        if (session()->get('user_id')) return redirect()->to('/');
        return view('auth/register', ['title' => 'Daftar Anggota']);
    }

    // ── Proses register ──
    public function processRegister()
    {
        $rules = [
            'name'                  => 'required|max_length[255]',
            'email'                 => 'required|valid_email|is_unique[users.email]',
            'address'               => 'required|max_length[255]',
            'phone'                 => 'required|max_length[15]',
            'password'              => 'required|min_length[6]',
            'password_confirmation' => 'required|matches[password]',
            'role'                  => 'required|in_list[member,admin]' // Validasi Pilihan Role
        ];
        
        $messages = [
            'name'                  => ['required' => 'Nama wajib diisi.'],
            'email'                 => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.', 'is_unique' => 'Email sudah terdaftar.'],
            'password'              => ['required' => 'Kata sandi wajib diisi.', 'min_length' => 'Kata sandi minimal 6 karakter.'],
            'password_confirmation' => ['required' => 'Konfirmasi kata sandi wajib diisi.', 'matches' => 'Konfirmasi kata sandi tidak cocok.'],
            'address'               => ['required' => 'Alamat wajib diisi.', 'max_length' => 'Alamat maksimal 255 karakter.'],
            'phone'                 => ['required' => 'Nomor telepon wajib diisi.', 'max_length' => 'Nomor telepon maksimal 15 karakter.'],
            'role'                  => ['required' => 'Peran (Role) wajib dipilih.', 'in_list' => 'Pilihan peran tidak valid.']
        ];

        if (!$this->validate($rules, $messages)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

       // Menyimpan data termasuk Role yang dipilih ke phpMyAdmin
        $this->userModel->insert([
            // UBAH 'name' MENJADI 'full_name' AGAR COCOK DENGAN DATABASE
            'full_name' => $this->request->getPost('name'), 
            'email'     => $this->request->getPost('email'),
            'address'   => $this->request->getPost('address'),
            'phone'     => $this->request->getPost('phone'),
            'password'  => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'role'      => $this->request->getPost('role'), 
            'status'    => 'active',
        ]);

        // Ambil data user yang baru saja dibuat
        $user = $this->userModel->findByEmail($this->request->getPost('email'));
        
        // Langsung buatkan sesi login
        session()->set([
            'user_id'    => $user['id'],
            // UBAH JUGA DI SINI: $user['name'] MENJADI $user['full_name']
            'user_name'  => $user['name'], 
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
            'logged_in'  => true,
        ]);
        return $this->redirectByRole()->with('success', 'Registrasi berhasil! Kunci arsip telah ditempa. Selamat datang di Bibliotheca Stellarum.');
    }

    // ── Logout ──
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar dari Bibliotheca Stellarum.');
    }

    // ── Helper Redirect ──
    private function redirectByRole()
    {
        return session()->get('user_role') === 'admin'
            ? redirect()->to('/admin')
            : redirect()->to('/');
    }
}