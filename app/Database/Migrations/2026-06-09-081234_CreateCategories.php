<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateCategoriesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'            => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'name'          => ['type' => 'VARCHAR', 'constraint' => 100],
            'slug'          => ['type' => 'VARCHAR', 'constraint' => 120],
            'constellation' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'symbol'        => ['type' => 'VARCHAR', 'constraint' => 10, 'null' => true],
            'color_class'   => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'description'   => ['type' => 'TEXT', 'null' => true],
            'sort_order'    => ['type' => 'INT', 'default' => 0],
            'created_at'    => ['type' => 'DATETIME', 'null' => true],
            'updated_at'    => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'    => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('slug');
        $this->forge->createTable('categories');
    }

    public function down()
    {
        $this->forge->dropTable('categories');
    }
}