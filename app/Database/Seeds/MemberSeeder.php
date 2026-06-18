<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        
        $rawUsers = [
            ['name' => 'Administrator', 'email' => 'admin@bibliotheca.ac.id', 'role' => 'admin', 'phone' => '081234567890'],
            ['name' => 'Rizki Aulia',   'email' => 'rizkudar@gmail.com',      'role' => 'member', 'phone' => '081234567891'],
            ['name' => 'Sari Novita',   'email' => 'sarimms@gmail.com',       'role' => 'member', 'phone' => '081234567892'],
            ['name' => 'Budi Santoso',  'email' => 'budiadi@gmail.com',       'role' => 'member', 'phone' => '081234567893'],
            ['name' => 'Dewi Putri',    'email' => 'dwip009@gmail.com',       'role' => 'member', 'phone' => '081234567894'],
            ['name' => 'Ahmad Fauzi',   'email' => 'amadjkks@gmail.com',      'role' => 'member', 'phone' => '081234567895'],
            ['name' => 'Maya Indah',    'email' => 'mayawho@gmail.com',       'role' => 'member', 'phone' => '081234567896'],
            ['name' => 'Fajar Nugroho', 'email' => 'seranganfajar@gmail.com', 'role' => 'member', 'phone' => '081234567897'],
            ['name' => 'Lestari Wulan', 'email' => 'lestarindah@gmail.com',   'role' => 'member', 'phone' => '081234567898'],
            ['name' => 'Rian Pratama',  'email' => 'riangosling@gmail.com',   'role' => 'member', 'phone' => '081234567899'],
        ];

        $users = [];
        foreach ($rawUsers as $u) {
            $users[] = [
                'name'       => $u['name'],
                'email'      => $u['email'],
                'password'   => password_hash($u['role'] === 'admin' ? 'admin123' : 'member123', PASSWORD_DEFAULT),
                'role'       => $u['role'],
                'address'    => 'Alamat ' . $u['name'],
                'phone'      => $u['phone'],
                'status'     => 'active',
                'created_at' => $now, 
                'updated_at' => null, 
                'deleted_at' => null, // <--- INI KUNCI PERBAIKANNYA (NULL)
            ];
        }

        // Matikan FK, Truncate, lalu nyalakan lagi
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('users')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');
        
        // Suntikkan data
        $this->db->table('users')->insertBatch($users);
        
        echo "✦ Eksekusi MemberSeeder Selesai! Data anggota berhasil dibangkitkan.\n";
    }
}