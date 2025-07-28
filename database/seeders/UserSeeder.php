<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin Hotel',
                'email' => 'admin@hotel.com',
                'password' => Hash::make('admin123'),
                'phone' => '081234567890',
                'role' => 'admin',
            ],
            [
                'name' => 'Manager Hotel',
                'email' => 'manager@hotel.com',
                'password' => Hash::make('manager123'),
                'phone' => '081234567891',
                'role' => 'admin',
            ],
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567892',
                'role' => 'user',
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567893',
                'role' => 'user',
            ],
            [
                'name' => 'Bob Wilson',
                'email' => 'bob@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567894',
                'role' => 'user',
            ],
            [
                'name' => 'Alice Brown',
                'email' => 'alice@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567895',
                'role' => 'user',
            ],
            [
                'name' => 'Charlie Davis',
                'email' => 'charlie@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567896',
                'role' => 'user',
            ],
            [
                'name' => 'Diana Miller',
                'email' => 'diana@example.com',
                'password' => Hash::make('password123'),
                'phone' => '081234567897',
                'role' => 'user',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }

        $this->command->info('Data pengguna berhasil ditambahkan!');
    }
}
