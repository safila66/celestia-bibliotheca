<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class BookSeeder extends Seeder
{
    public function run()
    {
        // ⬇️ MASUKKAN DATA BUKU ASLIMU DI BAWAH INI ⬇️
        $books = [
            [
                'title'       => 'The Song of Achilles',
                'author'      => 'Madeline Miller',
                'publisher'   => 'Ecco Press',
                'year'        => 2011,
                'isbn'        => '9780062060624',
                'call_number' => 'FIC MIL',
                'category_id' => 9, 
                'description' => 'Achilles, "the best of all the Greeks," son of the cruel sea goddess Thetis and the legendary king Peleus, is strong, swift, and beautiful, irresistible to all who meet him. Patroclus is an awkward young prince, exiled from his homeland after an act of shocking violence. Brought together by chance, they forge an inseparable bond, despite risking the gods wrath. They are trained by the centaur Chiron in the arts of war and medicine, but when word comes that Helen of Sparta has been kidnapped, all the heroes of Greece are called upon to lay siege to Troy in her name. Seduced by the promise of a glorious destiny, Achilles joins their cause, and torn between love and fear for his friend, Patroclus follows. Little do they know that the cruel Fates will test them both as never before and demand a terrible sacrifice.',
                'cover_image' => 'tsoa_book_cover.jpg',
                'language'    => 'English',
                'pages'       => 384,
                'edition'     => '1st Edition',
                'stock'       => 5,
                'stock_available' => 3,
                'type'        => 'ebook, print',
                'file_pdf'    => 'the_song_of_achilles_preview.pdf',
                'status'      => 'available'
            ],
            [
                'title'       => 'Babel: Or the Necessity of Violence',
                'author'      => 'R.F. Kuang',
                'publisher'   => 'Harper Voyager',
                'year'        => 2018,
                'isbn'        => '9780063021443',
                'call_number' => 'FIC KUA',
                'category_id' => 9, 
                'description' => 'Language is not just communication, but a foundational tool that shapes reality and enforces colonial hierarchies.',
                'cover_image' => 'babel_cover.jpg', 
                'language'    => 'English',
                'pages'       => 544,
                'edition'     => '1st Edition',
                'stock'       => 7,
                'stock_available' => 2,
                'type'        => 'ebook, print',
                'file_pdf'    => 'babel_rf_kuang.pdf',
                'status'      => 'available'
            ],
            [
                'title'       => 'Capital: A Critique of Political Economy',
                'author'      => 'Karl Marx',
                'publisher'   => 'Penguin Classics Publishers',
                'year'        => 1867,
                'isbn'        => '9780140445688',
                'call_number' => 'HIS MAR',
                'category_id' => 10, 
                'description' => 'A critical analysis of the political economy of capitalism.',
                'cover_image' => 'future read.jpg', 
                'language'    => 'English',
                'pages'       => 1200,
                'edition'     => '2nd Edition',
                'stock'       => 6,
                'stock_available' => 3,
                'type'        => 'ebook, print',
                'file_pdf'    => 'capital-marx.pdf',
                'status'      => 'available'
            ],
            [
                'title'       => 'White Nights',
                'author'      => 'Fyodor Dostoevsky',
                'publisher'   => 'Penguin Classics Publishers',
                'year'        => 1848,
                'isbn'        => '9780241252086',
                'call_number' => 'LIT DOS',
                'category_id' => 9, 
                'description' => 'White Nights is a short story by Fyodor Dostoevsky that was published in 1848. Set in St. Petersburg, it is the story of a young man fighting his inner restlessness. A light and tender narrative, it delves into the torment and guilt of unrequited love. Both protagonists suffer from a deep sense of alienation that initially brings them together. A blend of romanticism and realism, the story appeals gently to the senses and feelings.',
                'cover_image' => 'White Nights.jpg', 
                'language'    => 'English',
                'pages'       => 82,
                'edition'     => '2nd Edition',
                'stock'       => 5,
                'stock_available' => 1,
                'type'        => 'ebook, print',
                'file_pdf'    => 'white-nights.pdf',
                'status'      => 'available'
            ],
            [
                'title'       => 'Stars of Chaos',
                'author'      => 'Priest',
                'publisher'   => 'Seven Seas Publishers',
                'year'        => 2023,
                'isbn'        => '9781638589310',
                'call_number' => 'FIC PRI',
                'category_id' => 9, 
                'description' => 'The discovery of violet gold, a vital fuel for steam-powered machines, propelled Great Liang into an age of prosperity. But for Chang Geng, a young man raised on the impoverished northern frontier, the concerns of the empire are as distant as the stars above. When raiders from the north attack Chang Geng’s small village, he discovers that the life he knows is a lie. His mother, his teacher...even his beloved godfather, the man he trusted most in the world, are not who they seem. As enemies of the empire circle ever closer, Chang Geng must travel to the heart of the capital—with his godfather as his guide—to meet his destiny.',
                'cover_image' => '62145799.jpg',
                'language'    => 'English',
                'pages'       => 82,
                'edition'     => '2nd Edition',
                'stock'       => 5,
                'stock_available' => 1,
                'type'        => 'ebook, print',
                'file_pdf'    => 'Stars of Chaos_Sha Po Lang Vol. 1.pdf',
                'status'      => 'available'
            ],
        ];

        // Memperbaiki settingan waktu agar tidak "Soft Delete"
        $now = date('Y-m-d H:i:s');
        foreach ($books as &$b) {
            $b['created_at'] = $now;
            $b['updated_at'] = null;
            $b['deleted_at'] = null; // <--- SUDAH DIPERBAIKI MENJADI NULL
        }

        $this->db->query('SET FOREIGN_KEY_CHECKS = 0');
        $this->db->table('books')->truncate();
        $this->db->query('SET FOREIGN_KEY_CHECKS = 1');

        if (!empty($books)) {
            $this->db->table('books')->insertBatch($books);
            echo "✦ Eksekusi BookSeeder Selesai! Buku telah kembali dari alam bayangan (Tidak terhapus lagi).\n";
        }
    }
}