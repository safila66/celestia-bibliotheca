<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAdvancedReviewFields extends Migration
{
    public function up()
    {
        $this->forge->modifyColumn('reviews', [
            'rating' => [
                'type' => 'DECIMAL',
                'constraint' => '3,2',
                'null' => false,
                'default' => 0.00
            ]
        ]);

        $this->forge->addColumn('reviews', [
            'flaws_focus' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true
            ],
            'themes' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true
            ],
            'content_warnings' => [
                'type' => 'TEXT',
                'null' => true
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('reviews', ['flaws_focus', 'themes', 'content_warnings']);
        $this->forge->modifyColumn('reviews', [
            'rating' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => false,
                'default' => 0
            ]
        ]);
    }
}
