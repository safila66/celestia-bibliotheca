<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // ── USERS ──
        $users = [
            [
                'name'     => 'Administrator',
                'email'    => 'admin@bibliotheca.ac.id',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role'     => 'admin',
                'address'  => 'address of admin',
                'phone'    => '081234567890',
                'status'   => 'active',
                'created_at' => date('D-M-Y H:i:s'),
                'updated_at' => date('D-M-Y H:i:s'),
                'deleted_at' => date('D-M-Y H:i:s'),
            ],
            ['id'=>1, 'name'=>'Rizki Aulia',   'email'=>'rizkudar@gmail.com', 'phone'=>'081234567891', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>2, 'name'=>'Sari Novita',   'email'=>'sarimms@gmail.com', 'phone'=>'081234567892', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>3, 'name'=>'Budi Santoso',  'email'=>'budiadi@gmail.com', 'phone'=>'081234567893', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>4, 'name'=>'Dewi Putri',    'email'=>'dwip009@gmail.com', 'phone'=>'081234567894', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>5, 'name'=>'Ahmad Fauzi',   'email'=>'amadjkks@gmail.com', 'phone'=>'081234567895', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>6, 'name'=>'Maya Indah',    'email'=>'mayawho@gmail.com', 'phone'=>'081234567896', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>7, 'name'=>'Fajar Nugroho', 'email'=>'seranganfajar@gmail.com', 'phone'=>'081234567897', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>8, 'name'=>'Lestari Wulan', 'email'=>'lestarindah@gmail.com', 'phone'=>'081234567898', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
            ['id'=>9, 'name'=>'Rian Pratama',  'email'=>'riangosling@gmail.com', 'phone'=>'081234567899', 'updated_at' => date('D-M-Y H:i:s'), 'deleted_at' => date('D-M-Y H:i:s')],
        ];

        foreach ($users as &$u) {
            if (!isset($u['role'])) {
                $u['password']   = password_hash('member123', PASSWORD_DEFAULT);
                $u['role']       = 'member';
                $u['status']     = 'active';
                $u['created_at'] = date('D-M-Y H:i:s');
                $u['updated_at'] = date('D-M-Y H:i:s');
                $u['deleted_at'] = date('D-M-Y H:i:s');
            }
        }
        $this->db->table('users')->insertBatch($users);

        // ── CATEGORIES ──
        $categories = [
            ['name'=>'Ilmu Perpustakaan',     'slug'=>'ilmu-perpustakaan',  'constellation'=>'Orion',      'symbol'=>'⊕', 'color_class'=>'bc-orion',      'sort_order'=>1],
            ['name'=>'Seni & Sastra',          'slug'=>'seni-sastra',        'constellation'=>'Lyra',       'symbol'=>'✦', 'color_class'=>'bc-lyra',       'sort_order'=>2],
            ['name'=>'Teknologi & Sains',      'slug'=>'teknologi-sains',    'constellation'=>'Aquila',     'symbol'=>'☉', 'color_class'=>'bc-aquila',     'sort_order'=>3],
            ['name'=>'Sejarah & Sosial',       'slug'=>'sejarah-sosial',     'constellation'=>'Perseus',    'symbol'=>'◈', 'color_class'=>'bc-perseus',    'sort_order'=>4],
            ['name'=>'Filsafat & Agama',       'slug'=>'filsafat-agama',     'constellation'=>'Cassiopeia', 'symbol'=>'⊛', 'color_class'=>'bc-cassiopeia', 'sort_order'=>5],
            ['name'=>'Hukum & Politik',        'slug'=>'hukum-politik',      'constellation'=>'Scorpius',   'symbol'=>'♦', 'color_class'=>'bc-scorpius',   'sort_order'=>6],
            ['name'=>'Ekonomi & Bisnis',       'slug'=>'ekonomi-bisnis',     'constellation'=>'Taurus',     'symbol'=>'♆', 'color_class'=>'bc-taurus',     'sort_order'=>7],
            ['name'=>'Kesehatan & Kedokteran', 'slug'=>'kesehatan',          'constellation'=>'Virgo',      'symbol'=>'☿', 'color_class'=>'bc-virgo',      'sort_order'=>8],
        ];

        $now = date('Y-m-d H:i:s');
        foreach ($categories as &$c) {
            $c['created_at'] = $now;
            $c['updated_at'] = $now;
            $c['deleted_at'] = $now;
        }
        $this->db->table('categories')->insertBatch($categories);

        $cats = [];
        $rows = $this->db->table('categories')->orderBy('sort_order')->get()->getResultArray();
        foreach ($rows as $r) $cats[$r['slug']] = $r['id'];

        // ── BOOKS ──
        $books = [
            ['title'=>'Manajemen Perpustakaan Digital',           'author'=>'Sulistyo Basuki',  'publisher'=>'Gramedia',       'year'=>2023,'isbn'=>'978-602-0001-01-1','call_number'=>'020.5 SUS m','category_id'=>$cats['ilmu-perpustakaan'], 'stock'=>3,'type'=>'buku','description'=>'Buku komprehensif manajemen perpustakaan di era digital.'],
            ['title'=>'catalogisasi & Klasifikasi RDA',           'author'=>'Maryono',          'publisher'=>'UNS Press',      'year'=>2022,'isbn'=>'978-602-0001-02-2','call_number'=>'025.3 MAR k','category_id'=>$cats['ilmu-perpustakaan'], 'stock'=>2,'type'=>'buku','description'=>'Panduan praktis catalogisasi standar RDA.'],
            ['title'=>'Perilaku Pencarian Informasi',             'author'=>'T.D. Wilson',      'publisher'=>'Erlangga',       'year'=>2021,'isbn'=>'978-602-0001-03-3','call_number'=>'020.19 WIL p','category_id'=>$cats['ilmu-perpustakaan'],'stock'=>4,'type'=>'buku','description'=>'Model perilaku pencarian informasi Wilson 1996.'],
            ['title'=>'Literasi Informasi di Era Digital',        'author'=>'Tri Septiyantono', 'publisher'=>'UT Press',       'year'=>2023,'isbn'=>'978-602-0001-04-4','call_number'=>'028.7 TRI l','category_id'=>$cats['ilmu-perpustakaan'], 'stock'=>3,'type'=>'buku','description'=>'Konsep dan praktik literasi informasi.'],
            ['title'=>'Metadata & Dublin Core',                   'author'=>'Zulfikar Zen',     'publisher'=>'Sagung Seto',    'year'=>2022,'isbn'=>'978-602-0001-05-5','call_number'=>'025.4 ZUL m','category_id'=>$cats['ilmu-perpustakaan'], 'stock'=>2,'type'=>'buku','description'=>'Penerapan metadata Dublin Core.'],
            ['title'=>'Ontologi dan Epistemologi Ilmu Perpustakaan','author'=>'Dian Sinaga',    'publisher'=>'Bejana',         'year'=>2024,'isbn'=>'978-602-0001-06-6','call_number'=>'020.1 DIA o','category_id'=>$cats['ilmu-perpustakaan'], 'stock'=>2,'type'=>'buku','description'=>'Kajian filosofis ilmu perpustakaan.'],
            ['title'=>'Sistem Informasi Manajemen',               'author'=>'Raymond McLeod',  'publisher'=>'Salemba Empat',  'year'=>2022,'isbn'=>'978-602-0002-01-7','call_number'=>'004.6 MAC s','category_id'=>$cats['teknologi-sains'],   'stock'=>3,'type'=>'buku','description'=>'Konsep sistem informasi manajemen modern.'],
            ['title'=>'Jaringan Komputer & Internet',             'author'=>'Forouzan',         'publisher'=>'McGraw-Hill',    'year'=>2021,'isbn'=>'978-602-0002-02-8','call_number'=>'004.6 FOR j','category_id'=>$cats['teknologi-sains'],   'stock'=>2,'type'=>'buku','description'=>'Dasar-dasar jaringan komputer.'],
            ['title'=>'Kecerdasan Buatan & Machine Learning',     'author'=>'Andrew Ng',        'publisher'=>"O'Reilly",       'year'=>2023,'isbn'=>'978-602-0002-03-9','call_number'=>'006.3 ANG k','category_id'=>$cats['teknologi-sains'],   'stock'=>2,'type'=>'buku','description'=>'Machine learning dan deep learning.'],
            ['title'=>'Sejarah Nusantara',                        'author'=>'Slamet Muljana',   'publisher'=>'LKIS',           'year'=>2020,'isbn'=>'978-602-0003-01-5','call_number'=>'959.8 SLA s','category_id'=>$cats['sejarah-sosial'],    'stock'=>3,'type'=>'buku','description'=>'Sejarah kepulauan Indonesia.'],
            ['title'=>'Filsafat Ilmu',                            'author'=>'Jujun S. Suriasumantri','publisher'=>'Sinar Harapan','year'=>2019,'isbn'=>'978-602-0004-01-3','call_number'=>'121 JUJ f','category_id'=>$cats['filsafat-agama'], 'stock'=>4,'type'=>'buku','description'=>'Pengantar filsafat ilmu pengetahuan.'],
            ['title'=>'Sastra Indonesia Modern',                  'author'=>'H.B. Jassin',      'publisher'=>'Gramedia',       'year'=>2021,'isbn'=>'978-602-0005-01-2','call_number'=>'899.221 JAS s','category_id'=>$cats['seni-sastra'],    'stock'=>3,'type'=>'buku','description'=>'Perkembangan sastra Indonesia modern.'],
            ['title'=>'Pengantar Ilmu Ekonomi',                   'author'=>'Sadono Sukirno',   'publisher'=>'Rajawali Pers',  'year'=>2022,'isbn'=>'978-602-0006-01-4','call_number'=>'330 SAD p','category_id'=>$cats['ekonomi-bisnis'],     'stock'=>5,'type'=>'buku','description'=>'Buku teks ekonomi mikro dan makro.'],
        ];

        foreach ($books as &$b) {
            $b['stock_available'] = $b['stock'];
            $b['status']          = 'active';
            $b['language']        = ['Indonesia', 'English', 'Other'][array_rand(['Indonesia', 'English', 'Other'])];
            $b['created_at']      = $now;
            $b['updated_at']      = $now;
            $b['deleted_at']      = $now;
            $b['pages']           = rand(150, 500);
            $b['cover_image']     = 'https://source.unsplash.com/400x600/?book,library&' . rand(1000,9999);
            $b['description']     = $b['description'] . ' Buku ini membahas ' . strtolower($b['title']) . ' secara mendalam dan komprehensif.';
            $b['type']            = 'buku';
        }
        $this->db->table('books')->insertBatch($books);

        // ── LOAN ──
        $adminId    = $this->db->table('users')->where('role','admin')->get()->getRowArray()['id'];
        $bookIds    = $this->db->table('books')->select('id')->get()->getResultArray();
        $memberIds  = $this->db->table('users')->where('role','member')->select('id')->get()->getResultArray();

        $loan = [
            [
                'borrow_code' => 'BS-' . date('Y') . '-0001',
                'user_id'     => $memberIds[0]['id'],
                'book_id'     => $bookIds[0]['id'],
                'approved_by' => $adminId,
                'borrow_date' => date('Y-m-d', strtotime('-5 days')),
                'due_date'    => date('Y-m-d', strtotime('+9 days')),
                'status'      => 'active',
                'fine_days'   => 0, 'fine_amount' => 0, 'fine_paid' => 0,
            ],
            [
                'borrow_code' => 'BS-' . date('Y') . '-0002',
                'user_id'     => $memberIds[1]['id'],
                'book_id'     => $bookIds[1]['id'],
                'approved_by' => $adminId,
                'borrow_date' => date('Y-m-d', strtotime('-20 days')),
                'due_date'    => date('Y-m-d', strtotime('-6 days')),
                'status'      => 'overdue',
                'fine_days'   => 6, 'fine_amount' => 6000, 'fine_paid' => 0,
            ],
            [
                'borrow_code' => 'BS-' . date('Y') . '-0003',
                'user_id'     => $memberIds[2]['id'],
                'book_id'     => $bookIds[4]['id'],
                'approved_by' => null,
                'borrow_date' => date('Y-m-d'),
                'due_date'    => date('Y-m-d', strtotime('+14 days')),
                'status'      => 'pending',
                'fine_days'   => 0, 'fine_amount' => 0, 'fine_paid' => 0,
            ],
        ];

        foreach ($loan as &$br) {
            $br['created_at'] = $now;
            $br['updated_at'] = $now;
            $br['deleted_at'] = $now;
        }
        $this->db->table('loan')->insertBatch($loan);

        echo "✦ Seeder selesai! Database Celestia Bibliothe berhasil diisi.\n";
    }
}