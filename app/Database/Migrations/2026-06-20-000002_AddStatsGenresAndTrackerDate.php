<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddStatsGenresAndTrackerDate extends Migration
{
    public function up()
    {
        // Add columns to reviews
        $this->forge->addColumn('reviews', [
            'pace' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'plot_or_character' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'strong_dev' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'loveable' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'diverse' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
        ]);

        // Add genres to books
        $this->forge->addColumn('books', [
            'genres' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        // Add started_at to reading_trackers
        $this->forge->addColumn('reading_trackers', [
            'started_at' => [
                'type' => 'DATE',
                'null' => true,
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('reviews', ['pace', 'plot_or_character', 'strong_dev', 'loveable', 'diverse']);
        $this->forge->dropColumn('books', 'genres');
        $this->forge->dropColumn('reading_trackers', 'started_at');
    }
}
