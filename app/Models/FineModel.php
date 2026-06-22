<?php

namespace App\Models;

use CodeIgniter\Model;

class FineModel extends Model
{
    protected $table            = 'fines';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'user_id',
        'loan_id',
        'amount',
        'status',
        'description',
        'paid_at'
    ];

    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    public function getAllFines($status = 'all')
    {
        $builder = $this->select('fines.*, users.name as user_name, loans.loan_code as loan_ref')
                        ->join('users', 'users.id = fines.user_id', 'left')
                        ->join('loans', 'loans.id = fines.loan_id', 'left');
                        
        if ($status !== 'all') {
            $builder = $builder->where('fines.status', $status);
        }
        
        return $builder->orderBy('fines.created_at', 'DESC')->findAll();
    }

    public function getStats()
    {
        $db = \Config\Database::connect();
        $totalUnpaid = $db->table('fines')->where('status', 'unpaid')->selectSum('amount')->get()->getRow()->amount ?? 0;
        $totalPaid = $db->table('fines')->where('status', 'paid')->selectSum('amount')->get()->getRow()->amount ?? 0;
        return [
            'total_unpaid' => $totalUnpaid,
            'total_paid'   => $totalPaid
        ];
    }

    public function getTotalUnpaid()
    {
        return $this->where('status', 'unpaid')->selectSum('amount')->get()->getRow()->amount ?? 0;
    }

    public function getTotalPaid()
    {
        return $this->where('status', 'paid')->selectSum('amount')->get()->getRow()->amount ?? 0;
    }

    public function syncFines()
    {
        $db = \Config\Database::connect();
        // Get all overdue loans that are not returned
        // Status can be active or delivering, and due_date < today
        $today = date('Y-m-d');
        $query = $db->query("SELECT * FROM loans WHERE status IN ('active', 'delivering', 'pending') AND due_date < ?", [$today]);
        $overdueLoans = $query->getResultArray();

        foreach ($overdueLoans as $loan) {
            $dueDateTime = strtotime($loan['due_date']);
            $currentDateTime = strtotime($today);
            $overdueDays = floor(($currentDateTime - $dueDateTime) / (60 * 60 * 24));
            
            if ($overdueDays > 0) {
                $amount = $overdueDays * 1000;
                
                // Check if fine already exists for this loan
                $existingFine = $this->where('loan_id', $loan['id'])->first();
                if ($existingFine) {
                    if ($existingFine['status'] == 'unpaid') {
                        // Update amount and description if it's still unpaid
                        $this->update($existingFine['id'], [
                            'amount' => $amount,
                            'description' => "Terlambat $overdueDays hari."
                        ]);
                    }
                } else {
                    // Create new fine
                    $this->insert([
                        'user_id' => $loan['user_id'],
                        'loan_id' => $loan['id'],
                        'amount' => $amount,
                        'status' => 'unpaid',
                        'description' => "Terlambat $overdueDays hari."
                    ]);
                }
            }
        }
    }
}
