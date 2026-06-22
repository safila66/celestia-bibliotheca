<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBookshelfAdvanced extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'book_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'tbr', // read, tbr, dnf
            ],
            'format' => [
                'type'       => 'VARCHAR',
                'constraint' => 50,
                'default'    => 'Ebook', // Ebook, Physical
            ],
            'read_start_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'read_end_date' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'moods' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true, // JSON string e.g. ["nostalgic", "inspired"]
            ],
            'notes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'favorite_quotes' => [
                'type' => 'TEXT',
                'null' => true,
            ],
            'rating_romance' => [
                'type'       => 'DECIMAL',
                'constraint' => '2,1',
                'default'    => 0.0,
            ],
            'rating_spice' => [
                'type'       => 'DECIMAL',
                'constraint' => '2,1',
                'default'    => 0.0,
            ],
            'rating_sadness' => [
                'type'       => 'DECIMAL',
                'constraint' => '2,1',
                'default'    => 0.0,
            ],
            'rating_writing' => [
                'type'       => 'DECIMAL',
                'constraint' => '2,1',
                'default'    => 0.0,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('id', true);
        // We'll call this table `user_bookshelf_details` to distinguish it from any existing tables.
        $this->forge->createTable('user_bookshelf_details', true);
    }

    public function down()
    {
        $this->forge->dropTable('user_bookshelf_details', true);
    }
}
