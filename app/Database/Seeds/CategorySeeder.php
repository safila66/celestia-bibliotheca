<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // 10 Kelas Utama DDC (Dewey Decimal Classification) 000-900
        $categories = [
            [
                'id'            => 1,
                'name'          => 'Computer, Information, & General Works', // 000
                'slug'          => 'general-knowledge',
                'constellation' => 'The Prime Nebula',
                'symbol'        => '🧭',
                'color_class'   => 'theme-silver',
                'description'   => 'Fondasi ilmu komputer, sistem informasi, dan karya pengetahuan universal.',
                'sort_order'    => 1
            ],
            [
                'id'            => 2,
                'name'          => 'Philosophy & Psychology', // 100
                'slug'          => 'philosophy-psychology',
                'constellation' => 'The Thinker\'s Void',
                'symbol'        => '🦉',
                'color_class'   => 'theme-amethyst',
                'description'   => 'Kajian mendalam tentang eksistensi, logika, dan misteri pikiran manusia.',
                'sort_order'    => 2
            ],
            [
                'id'            => 3,
                'name'          => 'Religion', // 200
                'slug'          => 'religion',
                'constellation' => 'The Divine Pantheon',
                'symbol'        => '🕊️',
                'color_class'   => 'theme-gold',
                'description'   => 'Sistem kepercayaan, teologi, dan warisan spiritual dari berbagai peradaban.',
                'sort_order'    => 3
            ],
            [
                'id'            => 4,
                'name'          => 'Social Sciences', // 300
                'slug'          => 'social-sciences',
                'constellation' => 'The Civic Cluster',
                'symbol'        => '⚖️',
                'color_class'   => 'theme-sapphire',
                'description'   => 'Arsitektur peradaban, ekonomi, hukum, dan interaksi sosial budaya masyarakat.',
                'sort_order'    => 4
            ],
            [
                'id'            => 5,
                'name'          => 'Language', // 400
                'slug'          => 'language',
                'constellation' => 'The Rosetta Stars',
                'symbol'        => '🗣️',
                'color_class'   => 'theme-emerald',
                'description'   => 'Linguistik, tata bahasa, dan akar dari segala bentuk komunikasi manusia.',
                'sort_order'    => 5
            ],
            [
                'id'            => 6,
                'name'          => 'Science', // 500
                'slug'          => 'science',
                'constellation' => 'The Empirical Orbit',
                'symbol'        => '🔭',
                'color_class'   => 'theme-ruby',
                'description'   => 'Matematika, astronomi, fisika, dan eksplorasi terhadap hukum alam semesta.',
                'sort_order'    => 6
            ],
            [
                'id'            => 7,
                'name'          => 'Technology', // 600
                'slug'          => 'technology',
                'constellation' => 'The Innovator\'s Belt',
                'symbol'        => '⚙️',
                'color_class'   => 'theme-bronze',
                'description'   => 'Ilmu terapan, kedokteran, teknik, dan penemuan yang memajukan peradaban.',
                'sort_order'    => 7
            ],
            [
                'id'            => 8,
                'name'          => 'Arts & Recreation', // 700
                'slug'          => 'arts-recreation',
                'constellation' => 'The Muse\'s Galaxy',
                'symbol'        => '🎨',
                'color_class'   => 'theme-rose',
                'description'   => 'Seni rupa, arsitektur, musik, rekreasi, dan ekspresi kreatif manusia.',
                'sort_order'    => 8
            ],
            [
                'id'            => 9,
                'name'          => 'Literature', // 800
                'slug'          => 'literature',
                'constellation' => 'The Bard\'s Constellation',
                'symbol'        => '📖',
                'color_class'   => 'theme-pearl',
                'description'   => 'Puisi, prosa, retorika, dan karya tulis terbaik sepanjang masa.',
                'sort_order'    => 9
            ],
            [
                'id'            => 10,
                'name'          => 'History & Geography', // 900
                'slug'          => 'history-geography',
                'constellation' => 'The Chronos System',
                'symbol'        => '⏳',
                'color_class'   => 'theme-obsidian',
                'description'   => 'Catatan peristiwa masa lampau, biografi tokoh, dan eksplorasi geografi bumi.',
                'sort_order'    => 10
            ]
        ];

        // 1. Matikan pengecekan Foreign Key agar tidak error saat dihapus
        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        
        // 2. Kosongkan tabel kategori secara total
        $this->db->table('categories')->truncate();
        
        // 3. Nyalakan kembali keamanan Foreign Key
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        // 4. Masukkan ke-10 kelas DDC secara serentak
        $this->db->table('categories')->insertBatch($categories);
    }
}