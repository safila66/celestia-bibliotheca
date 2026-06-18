<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class LoanSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        
        $adminId    = $this->db->table('users')->where('role','admin')->get()->getRowArray()['id'] ?? 1;
        $memberIds  = $this->db->table('users')->where('role','member')->select('id')->get()->getResultArray();
        $bookIds    = $this->db->table('books')->select('id')->get()->getResultArray();

        // Pastikan ada data user dan buku sebelum memasukkan data loan
        if (!empty($memberIds) && !empty($bookIds)) {
            $loans = [
                [
                    'loan_code'   => 'LN-' . date('Y') . '-0001', // <--- INI KUNCINYA (loan_code)
                    'user_id'     => $memberIds[0]['id'], // Rizki Aulia
                    'book_id'     => $bookIds[0]['id'],   // Buku Pertama
                    'approved_by' => $adminId,
                    'loan_date' => date('Y-m-d', strtotime('-5 days')),
                    'due_date'    => date('Y-m-d', strtotime('+9 days')),
                    'status'      => 'active',
                    'fine_days'   => 0, 'fine_amount' => 0, 'fine_paid' => 0,
                    'created_at'  => $now, 'updated_at' => $now, 'deleted_at' => $now
                ],
                [
                    'loan_code'   => 'LN-' . date('Y') . '-0002',
                    'user_id'     => $memberIds[1]['id'], // Sari Novita
                    'book_id'     => $bookIds[1]['id'],   // Buku Kedua
                    'approved_by' => $adminId,
                    'loan_date' => date('Y-m-d', strtotime('-20 days')),
                    'due_date'    => date('Y-m-d', strtotime('-6 days')),
                    'status'      => 'overdue',
                    'fine_days'   => 6, 'fine_amount' => 6000, 'fine_paid' => 0,
                    'created_at'  => $now, 'updated_at' => $now, 'deleted_at' => $now
                ],
                [
                    'loan_code'   => 'LN-' . date('Y') . '-0003',
                    'user_id'     => $memberIds[2]['id'], // Budi Santoso
                    'book_id'     => $bookIds[2]['id'] ?? 1,   
                    'approved_by' => null,
                    'loan_date' => date('Y-m-d'),
                    'due_date'    => date('Y-m-d', strtotime('+14 days')),
                    'status'      => 'pending',
                    'fine_days'   => 0, 'fine_amount' => 0, 'fine_paid' => 0,
                    'created_at'  => $now, 'updated_at' => $now, 'deleted_at' => $now
                ]
            ];
            
            // Matikan kunci, kosongkan, lalu nyalakan lagi
            $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
            $this->db->table('loans')->truncate();
            $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
            
            // Suntikkan data
            $this->db->table('loans')->insertBatch($loans);
            
            echo "✦ Eksekusi LoanSeeder Selesai! Data loan berhasil masuk tanpa error kembar.\n";
        } else {
            echo "⚠ Gagal: Data User atau Buku belum ada di database. Silakan jalankan UserSeeder dan BookSeeder terlebih dahulu.\n";
        }
    }
}