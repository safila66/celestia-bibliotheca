<?php

namespace App\Models;

use CodeIgniter\Model;

class LoanModel extends Model
{
    protected $table            = 'loans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = false;
    protected $dateFormat    = 'datetime';
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
    protected $deletedField  = 'deleted_at';

    // Validation
    protected $validationRules      = [];
    protected $validationMessages   = [];
    protected $skipValidation       = false;
    protected $cleanValidationRules = true;

    // Callbacks
    protected $allowCallbacks = true;
    protected $beforeInsert   = [];
    protected $afterInsert    = [];
    protected $beforeUpdate   = [];
    protected $afterUpdate    = [];
    protected $beforeFind     = [];
    protected $afterFind      = [];
    protected $beforeDelete   = [];
    protected $afterDelete    = [];

    // ════════════════════════════════════════════
    //   FUNGSI STATISTIK UNTUK DASHBOARD ADMIN
    // ════════════════════════════════════════════

    public function getRecentLoans($limit = 8)
    {
        // Mengambil data peminjaman yang paling baru
        return $this->orderBy('id', 'DESC')->findAll($limit);
    }

    public function getOverdueLoans()
    {
        // Mengambil data yang tenggat waktunya (due_date) sudah lewat hari ini
        // dan statusnya belum dikembalikan (returned)
        return $this->where('due_date <', date('Y-m-d'))
                    ->where('status !=', 'returned')
                    ->findAll();
    }

    public function getLoansByMonth()
    {
        // Untuk sementara kita kembalikan array kosong agar halaman bisa terbuka
        // Nanti bisa diisi dengan query (GROUP BY MONTH) jika ingin membuat grafik
        return [];
    }
}
