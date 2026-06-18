<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Menjalankan seeder kecil satu per satu secara otomatis
        $this->call('MemberSeeder');
        $this->call('CategorySeeder');
        $this->call('BookSeeder');
        $this->call('LoanSeeder');
        
        echo "Semua data berhasil disuntikkan secara terpisah!\n";
    }
}