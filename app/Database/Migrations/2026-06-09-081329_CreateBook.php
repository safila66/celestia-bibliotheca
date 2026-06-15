<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateBooksTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'              => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'title'           => ['type' => 'VARCHAR', 'constraint' => 255],
            'author'          => ['type' => 'VARCHAR', 'constraint' => 255],
            'publisher'       => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'year'            => ['type' => 'YEAR', 'null' => true],
            'isbn'            => ['type' => 'VARCHAR', 'constraint' => 25, 'null' => true],
            'call_number'     => ['type' => 'VARCHAR', 'constraint' => 60, 'null' => true],
            'category_id'     => ['type' => 'INT', 'unsigned' => true],
            'description'     => ['type' => 'TEXT', 'null' => true],
            'cover_image'     => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'language'        => ['type' => 'VARCHAR', 'constraint' => 50, 'default' => 'Indonesia'],
            'pages'           => ['type' => 'INT', 'null' => true],
            'edition'         => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'stock'           => ['type' => 'INT', 'default' => 1],
            'stock_available' => ['type' => 'INT', 'default' => 1],
            'type'            => ['type' => 'ENUM', 'constraint' => ['buku','jurnal','skripsi','tesis','prosiding','majalah'], 'default' => 'buku'],
            'file_pdf'        => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'status'          => ['type' => 'ENUM', 'constraint' => ['active','inactive'], 'default' => 'active'],
            'created_at'      => ['type' => 'DATETIME', 'null' => true],
            'updated_at'      => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'      => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addKey('category_id');
        $this->forge->addForeignKey('category_id', 'categories', 'id', 'RESTRICT', 'RESTRICT');
        $this->forge->createTable('books');
    }

    public function down()
    {
        $this->forge->dropTable('books');
    }
}