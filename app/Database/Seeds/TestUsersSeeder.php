<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class TestUsersSeeder extends Seeder
{
    public function run()
    {
        // Create test users with different roles
        $data = [
            [
                'name' => 'Admin User',
                'email' => 'admin@test.com',
                'password_hash' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Teacher User',
                'email' => 'teacher@test.com',
                'password_hash' => password_hash('teacher123', PASSWORD_DEFAULT),
                'role' => 'teacher',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Student User',
                'email' => 'student@test.com',
                'password_hash' => password_hash('student123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@test.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@test.com',
                'password_hash' => password_hash('password123', PASSWORD_DEFAULT),
                'role' => 'student',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ];

        // Insert test users
        foreach ($data as $user) {
            $this->db->table('users')->insert($user);
        }
        
        echo "Test users created successfully!\n";
        echo "Admin: admin@test.com / admin123\n";
        echo "Teacher: teacher@test.com / teacher123\n";
        echo "Student: student@test.com / student123\n";
    }
}
