<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserIdToJournals extends Migration
{
    public function up()
    {
        $this->forge->addColumn('journals', [
            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'id' // Put it after ID
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('journals', 'user_id');
    }
}
