<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call all seeders in the correct order
        $this->call([
            AdminSeeder::class,
            UserSeeder::class,
            RoomSeeder::class,
            BookingSeeder::class,
            PaymentSeeder::class,
        ]);

        $this->command->info('Semua data sample berhasil ditambahkan!');
        $this->command->info('Admin login: admin@hotel.com / password');
        $this->command->info('Manager login: manager@hotel.com / password');
        $this->command->info('User login: john@example.com / password');
    }
}
