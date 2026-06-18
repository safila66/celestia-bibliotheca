<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateLoanTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id'          => ['type' => 'INT', 'unsigned' => true, 'auto_increment' => true],
            'loan_code'   => ['type' => 'VARCHAR', 'constraint' => 30],
            'user_id'     => ['type' => 'INT', 'unsigned' => true],
            'book_id'     => ['type' => 'INT', 'unsigned' => true],
            'approved_by' => ['type' => 'INT', 'unsigned' => true, 'null' => true],
            'loan_date' => ['type' => 'DATE'],
            'due_date'    => ['type' => 'DATE'],
            'return_date' => ['type' => 'DATE', 'null' => true],
            'status'      => ['type' => 'ENUM', 'constraint' => ['pending','active','returned','overdue','rejected'], 'default' => 'pending'],
            'fine_days'   => ['type' => 'INT', 'default' => 0],
            'fine_amount' => ['type' => 'DECIMAL', 'constraint' => '10,2', 'default' => 0.00],
            'fine_paid'   => ['type' => 'TINYINT', 'constraint' => 1, 'default' => 0],
            'notes'       => ['type' => 'TEXT', 'null' => true],
            'created_at'  => ['type' => 'DATETIME', 'null' => true],
            'updated_at'  => ['type' => 'DATETIME', 'null' => true],
            'deleted_at'  => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addPrimaryKey('id');
        $this->forge->addUniqueKey('loan_code');
        $this->forge->addKey('user_id');
        $this->forge->addKey('book_id');
        $this->forge->addForeignKey('user_id', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('book_id', 'books', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('loans');
    }

    public function down()
    {
        $this->forge->dropTable('loans');
    }
}