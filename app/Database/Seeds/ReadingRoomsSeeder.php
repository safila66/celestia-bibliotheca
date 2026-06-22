<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ReadingRoomsSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title'         => 'Moonlit Reading Session',
                'description'   => 'Sesi baca bersama buku-buku sastra klasik atau misteri di bawah cahaya bulan. Cocok bagi Anda yang menikmati ketenangan malam sambil berimajinasi.',
                'schedule_time' => 'Setiap malam pkl 20:00 & 22:00 WIB',
                'zoom_link'     => 'https://zoom.us/j/1234567890',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'title'         => 'Sci-Fi & Technology Club',
                'description'   => 'Diskusi intens tentang masa depan teknologi, kecerdasan buatan, dan fiksi ilmiah. Mari bedah buku-buku karya Isaac Asimov hingga buku teknologi modern.',
                'schedule_time' => 'Setiap Sabtu pkl 15:00 WIB',
                'zoom_link'     => 'https://zoom.us/j/0987654321',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ],
            [
                'title'         => 'Philosophical Debates',
                'description'   => 'Ruang baca dan debat filsafat. Mengupas tuntas pikiran-pikiran besar dari Plato, Nietzsche, hingga filsuf kontemporer.',
                'schedule_time' => 'Setiap Minggu pkl 10:00 WIB',
                'zoom_link'     => 'https://zoom.us/j/1122334455',
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ]
        ];

        // Simple check to avoid duplicates
        if ($this->db->table('online_reading_rooms')->countAllResults() == 0) {
            $this->db->table('online_reading_rooms')->insertBatch($data);
        }
    }
}
