<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MemberServices extends Migration
{
    public function up()
    {
        // 1. Reference Loans
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'book_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'type' => ['type' => 'ENUM', 'constraint' => ['ebook', 'offline'], 'default' => 'offline'],
            'status' => ['type' => 'ENUM', 'constraint' => ['active', 'returned'], 'default' => 'active'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('reference_loans');

        // 2. Citation Checks
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'title' => ['type' => 'VARCHAR', 'constraint' => 255],
            'file_path' => ['type' => 'VARCHAR', 'constraint' => 255],
            'ai_percentage' => ['type' => 'INT', 'constraint' => 3, 'null' => true],
            'status' => ['type' => 'ENUM', 'constraint' => ['Checking', 'Approved', 'Rejected'], 'default' => 'Checking'],
            'librarian_notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('citation_checks');

        // 3. Mendeley Classes
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'schedule_date' => ['type' => 'DATE'],
            'session' => ['type' => 'ENUM', 'constraint' => ['Pagi', 'Sore']],
            'format' => ['type' => 'ENUM', 'constraint' => ['Online', 'Offline']],
            'qr_code' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'zoom_link' => ['type' => 'VARCHAR', 'constraint' => 255, 'null' => true],
            'zoom_passcode' => ['type' => 'VARCHAR', 'constraint' => 50, 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('mendeley_classes');

        // 4. Consultations
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'topic' => ['type' => 'VARCHAR', 'constraint' => 255],
            'consultation_date' => ['type' => 'DATE'],
            'consultation_time' => ['type' => 'TIME'],
            'status' => ['type' => 'ENUM', 'constraint' => ['Pending', 'Confirmed', 'Completed', 'Cancelled'], 'default' => 'Pending'],
            'notes' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('consultations');

        // 5. Language Classes
        $this->forge->addField([
            'id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true, 'auto_increment' => true],
            'user_id' => ['type' => 'INT', 'constraint' => 11, 'unsigned' => true],
            'language' => ['type' => 'VARCHAR', 'constraint' => 100],
            'schedule_date' => ['type' => 'DATE'],
            'session_time' => ['type' => 'VARCHAR', 'constraint' => 50],
            'room' => ['type' => 'VARCHAR', 'constraint' => 100],
            'status' => ['type' => 'ENUM', 'constraint' => ['Registered', 'Completed', 'Cancelled'], 'default' => 'Registered'],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('language_classes');
    }

    public function down()
    {
        $this->forge->dropTable('reference_loans');
        $this->forge->dropTable('citation_checks');
        $this->forge->dropTable('mendeley_classes');
        $this->forge->dropTable('consultations');
        $this->forge->dropTable('language_classes');
    }
}
