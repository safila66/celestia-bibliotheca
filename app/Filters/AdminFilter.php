<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AdminFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // 1. Cek apakah sudah login
        if (!session()->get('logged_in')) {
            return redirect()->to('/login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // 2. Cek apakah role-nya admin
        if (session()->get('user_role') !== 'admin') {
            // Jika user biasa mencoba masuk admin, kembalikan ke beranda
            return redirect()->to('/')->with('error', 'Pelanggaran akses! Ruang arsip ini hanya untuk Pustakawan.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Tidak ada aksi khusus
    }
}