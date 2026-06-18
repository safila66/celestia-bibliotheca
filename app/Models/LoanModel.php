<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; // Agar riwayat tidak benar-benar terhapus

    // Kolom-kolom yang diizinkan untuk diisi/diubah
    protected $allowedFields    = [
        'loan_code',
        'user_id',
        'book_id',
        'approved_by',
        'borrow_date',
        'due_date',
        'status', // Isinya: pending, active, returned, overdue
        'fine_days',
        'fine_amount',
        'fine_paid'
    ];

    // Format Tanggal Otomatis CodeIgniter
    protected $useTimestamps = true;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // ══════════════════════════════════════════════════════════
    // 1. FUNGSI UNTUK MENU "PEMINJAMAN" DI ADMIN
    // ══════════════════════════════════════════════════════════
    
    // Ini fungsi yang dicari-cari oleh sistem sehingga menyebabkan error merah
    public function getAllLoans()
    {
        return $this->select('loans.*, users.name as user_name, books.title as book_title')
                    ->join('users', 'users.id = loans.user_id', 'left')
                    ->join('books', 'books.id = loans.book_id', 'left')
                    ->orderBy('loans.created_at', 'DESC')
                    ->findAll();
    }


    // ══════════════════════════════════════════════════════════
    // 2. FUNGSI UNTUK DASHBOARD ADMIN
    // ══════════════════════════════════════════════════════════
    
    public function getRecentLoans($limit = 5)
    {
        return $this->select('loans.*, users.name as user_name, books.title as book_title')
                    ->join('users', 'users.id = loans.user_id', 'left')
                    ->join('books', 'books.id = loans.book_id', 'left')
                    ->orderBy('loans.created_at', 'DESC')
                    ->findAll($limit);
    }

    public function getOverdueLoans()
    {
        return $this->select('loans.*, users.name as user_name, books.title as book_title')
                    ->join('users', 'users.id = loans.user_id', 'left')
                    ->join('books', 'books.id = loans.book_id', 'left')
                    ->where('loans.status', 'overdue')
                    ->orderBy('loans.due_date', 'ASC')
                    ->findAll();
    }

    public function getLoansByMonth()
    {
        // Berfungsi untuk menampilkan grafik di dashboard admin
        $db = \Config\Database::connect();
        $query = $db->query("SELECT MONTH(borrow_date) as month, COUNT(id) as total FROM loans WHERE YEAR(borrow_date) = YEAR(CURRENT_DATE()) GROUP BY MONTH(borrow_date)");
        $results = $query->getResultArray();
        
        $data = array_fill(1, 12, 0); // Siapkan wadah bulan 1-12 (Jan-Des) dengan nilai 0
        foreach($results as $row) {
            if($row['month']) {
                $data[$row['month']] = $row['total'];
            }
        }
        return array_values($data);
    }


    // ══════════════════════════════════════════════════════════
    // 3. FUNGSI UNTUK USER / MEMBER BIASA
    // ══════════════════════════════════════════════════════════
    
    public function getActiveLoan($userId, $bookId)
    {
        // Mengecek apakah user sedang meminjam buku ini agar tidak pinjam ganda
        return $this->where('user_id', $userId)
                    ->where('book_id', $bookId)
                    ->whereIn('status', ['pending', 'active'])
                    ->first();
    }

    public function getUserLoans($userId)
    {
        // Menampilkan riwayat loan khusus untuk satu user
        return $this->select('loans.*, books.title as book_title, books.cover_image, books.author')
                    ->join('books', 'books.id = loans.book_id', 'left')
                    ->where('loans.user_id', $userId)
                    ->orderBy('loans.created_at', 'DESC')
                    ->findAll();
    }

    public function getUserStats($userId)
    {
        // Menghitung statistik profil user
        return [
            'active'   => $this->where('user_id', $userId)->where('status', 'active')->countAllResults(),
            'returned' => $this->where('user_id', $userId)->where('status', 'returned')->countAllResults(),
            'fines'    => $this->where('user_id', $userId)->selectSum('fine_amount')->first()['fine_amount'] ?? 0,
        ];
    }
}