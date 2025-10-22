<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AlterUsersTableRoleColumn extends Migration
{
    public function up()
    {
        // Modify the role column to include 'teacher' instead of 'instructor'
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['student', 'teacher', 'admin'],
                'default' => 'student',
            ],
        ]);
    }

    public function down()
    {
        // Revert back to original role values
        $this->forge->modifyColumn('users', [
            'role' => [
                'type' => 'ENUM',
                'constraint' => ['student', 'instructor', 'admin'],
                'default' => 'student',
            ],
        ]);
    }
}
