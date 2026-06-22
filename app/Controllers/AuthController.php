<?php

namespace App\Controllers;

use App\Models\UserModel;

class AuthController extends BaseController
{
    protected UserModel $userModel;
    protected $helpers = ['form'];

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
    {
        parent::initController($request, $response, $logger);
    }

    // ══════════════════════════════════════════════════════════
    // 1. BAGIAN LOGIN
    // ══════════════════════════════════════════════════════════
    public function login()
    {
        if (session()->get('user_id')) {
            return $this->redirectByRole();
        }
        return view('auth/login', ['title' => 'Masuk ke Arsip']);
    }

    public function processLogin()
    {
        $rules = [
            'email'    => 'required|valid_email',
            'password' => 'required',
        ];
        
        $messages = [
            'email'    => ['required' => 'Email wajib diisi.', 'valid_email' => 'Format email tidak valid.'],
            'password' => ['required' => 'Kata sandi / NIM wajib diisi.'],
        ];

        if (!$this->validate($rules, $messages)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        // Cari user berdasarkan email di database
        $user = $this->userModel->where('email', $this->request->getPost('email'))->first();

        // Verifikasi Email dan Password (Atau NIM khusus Admin)
        if (!$user || !password_verify($this->request->getPost('password'), $user['password'])) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'error' => 'Akses ditolak! Email atau Sandi salah.']);
            }
            return redirect()->back()->withInput()->with('error', 'Akses ditolak! Email atau Sandi salah.');
        }

        // Cek status aktif
        if ($user['status'] !== 'active') {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'error' => 'Kunci arsipmu tidak aktif. Hubungi Head Librarian.']);
            }
            return redirect()->back()->withInput()->with('error', 'Kunci arsipmu tidak aktif. Hubungi Head Librarian.');
        }

        // Buat Sesi Login
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'],
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
            'logged_in'  => true,
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'redirect' => base_url($user['role'] === 'admin' ? 'admin' : ''),
                'message' => 'Selamat datang kembali di Bibliotheca Stellarum, ' . $user['name'] . '!'
            ]);
        }
        return $this->redirectByRole()->with('success', 'Selamat datang kembali di Bibliotheca Stellarum, ' . $user['name'] . '!');
    }

    // ══════════════════════════════════════════════════════════
    // 2. BAGIAN REGISTER
    // ══════════════════════════════════════════════════════════
    public function register()
    {
        if (session()->get('user_id')) {
            return $this->redirectByRole();
        }
        return view('auth/register', ['title' => 'Daftar Arsip']);
    }

    public function processRegister()
    {
        $rules = [
            'name'                  => 'required|max_length[255]',
            'email'                 => 'required|valid_email|is_unique[users.email]',
            'address'               => 'required|max_length[255]',
            'phone'                 => 'required|max_length[15]',
            'password'              => 'required|min_length[6]',
            'password_confirmation' => 'required|matches[password]',
            'role'                  => 'required|in_list[member,admin]' 
        ];
        
        if (!$this->validate($rules)) {
            if ($this->request->isAJAX()) {
                return $this->response->setJSON(['success' => false, 'errors' => $this->validator->getErrors()]);
            }
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }

        $role     = $this->request->getPost('role');
        $email    = $this->request->getPost('email');
        $password = $this->request->getPost('password');

        // 🛡️ MANTRA PELINDUNG ADMIN: WHITELIST EMAIL & NIM 🛡️
        if ($role === 'admin') {
            
            // ⬇️ UBAH DENGAN EMAIL & NIM KELOMPOKMU ⬇️
            $allowedAdmins = [
                'safila.mutiara.fani-2024@fisip.unair.ac.id'    => '177241065',
                'eileen.calya.ifthara-2024@fisip.unair.ac.id' => '177241041',
                'sallendra.aldina.adjie-2024@fisip.unair.ac.id' => '177241060'
            ];

            if (!array_key_exists($email, $allowedAdmins)) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['success' => false, 'error' => 'Akses ditolak! Email tidak dikenali sebagai Librarian kelompok.']);
                }
                return redirect()->back()->withInput()->with('error', 'Akses ditolak! Email tidak dikenali sebagai Librarian kelompok.');
            }

            if ($password !== $allowedAdmins[$email]) {
                if ($this->request->isAJAX()) {
                    return $this->response->setJSON(['success' => false, 'error' => 'Akses ditolak! Sandi Librarian harus berupa NIM yang sesuai.']);
                }
                return redirect()->back()->withInput()->with('error', 'Akses ditolak! Sandi Librarian harus berupa NIM yang sesuai.');
            }
        }

        // Simpan Data
        $this->userModel->insert([
            'name'      => $this->request->getPost('name'), 
            'email'     => $email,
            'address'   => $this->request->getPost('address'),
            'phone'     => $this->request->getPost('phone'),
            'password'  => password_hash($password, PASSWORD_DEFAULT),
            'role'      => $role, 
            'status'    => 'active',
        ]);

        $user = $this->userModel->where('email', $email)->first();
        
        session()->set([
            'user_id'    => $user['id'],
            'user_name'  => $user['name'], 
            'user_email' => $user['email'],
            'user_role'  => $user['role'],
            'logged_in'  => true,
        ]);

        if ($this->request->isAJAX()) {
            return $this->response->setJSON([
                'success' => true,
                'redirect' => base_url($user['role'] === 'admin' ? 'admin' : ''),
                'message' => 'Registrasi berhasil! Kunci arsip telah ditempa.'
            ]);
        }

        return $this->redirectByRole()->with('success', 'Registrasi berhasil! Kunci arsip telah ditempa.');
    }

    // ══════════════════════════════════════════════════════════
    // 3. LOGOUT & HELPER
    // ══════════════════════════════════════════════════════════
    public function logout()
    {
        session()->destroy();
        return redirect()->to('/login')->with('success', 'Anda telah berhasil keluar dari Bibliotheca Stellarum.');
    }

    private function redirectByRole()
    {
        return session()->get('user_role') === 'admin' ? redirect()->to('/admin') : redirect()->to('/');
    }
}