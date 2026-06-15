<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table            = 'users';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = true; 
    protected $protectFields    = true;
    protected $allowedFields    = [
        'name', 'email', 'password', 'role', 'phone', 'address', 'photo', 'status'
    ];

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    protected $useTimestamps = true;
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
    //   ADDED FUNCTIONS (CUSTOM METHODS)
    // ════════════════════════════════════════════

    /**
     * counting total celesthica active members for stats bar
     * this function is called in HomeController to get total active members for stats bar
     */
    public function countActiveMembers()
    {
        return $this->where('status', 'active')->countAllResults();
    }

    /**
     * Mencari user berdasarkan email
     */
    public function findByEmail($email)
    {
        return $this->where('email', $email)->first();
    }
}