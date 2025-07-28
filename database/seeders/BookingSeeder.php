<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Booking;
use App\Models\User;
use App\Models\Room;
use Carbon\Carbon;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'user')->get();
        $rooms = Room::all();

        if ($users->isEmpty() || $rooms->isEmpty()) {
            $this->command->warn('Users atau Rooms belum ada. Jalankan UserSeeder dan RoomSeeder terlebih dahulu.');
            return;
        }

        $bookings = [
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Standard Room')->first()->id,
                'check_in_date' => Carbon::now()->addDays(2),
                'check_out_date' => Carbon::now()->addDays(4),
                'total_price' => 700000, // 2 malam x 350000
                'status' => 'confirmed',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Deluxe Room')->first()->id,
                'check_in_date' => Carbon::now()->addDays(5),
                'check_out_date' => Carbon::now()->addDays(7),
                'total_price' => 1100000, // 2 malam x 550000
                'status' => 'pending',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Superior Room')->first()->id,
                'check_in_date' => Carbon::now()->addDays(1),
                'check_out_date' => Carbon::now()->addDays(3),
                'total_price' => 900000, // 2 malam x 450000
                'status' => 'confirmed',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Family Room')->first()->id,
                'check_in_date' => Carbon::now()->addDays(10),
                'check_out_date' => Carbon::now()->addDays(13),
                'total_price' => 1950000, // 3 malam x 650000
                'status' => 'pending',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Executive Suite')->first()->id,
                'check_in_date' => Carbon::now()->addDays(15),
                'check_out_date' => Carbon::now()->addDays(17),
                'total_price' => 1700000, // 2 malam x 850000
                'status' => 'confirmed',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Honeymoon Suite')->first()->id,
                'check_in_date' => Carbon::now()->addDays(20),
                'check_out_date' => Carbon::now()->addDays(22),
                'total_price' => 2400000, // 2 malam x 1200000
                'status' => 'pending',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Business Suite')->first()->id,
                'check_in_date' => Carbon::now()->addDays(8),
                'check_out_date' => Carbon::now()->addDays(10),
                'total_price' => 1500000, // 2 malam x 750000
                'status' => 'confirmed',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Garden View Room')->first()->id,
                'check_in_date' => Carbon::now()->addDays(25),
                'check_out_date' => Carbon::now()->addDays(28),
                'total_price' => 1200000, // 3 malam x 400000
                'status' => 'pending',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Pool View Room')->first()->id,
                'check_in_date' => Carbon::now()->addDays(30),
                'check_out_date' => Carbon::now()->addDays(32),
                'total_price' => 1000000, // 2 malam x 500000
                'status' => 'cancelled',
            ],
            [
                'user_id' => $users->random()->id,
                'room_id' => $rooms->where('name', 'Connecting Rooms')->first()->id,
                'check_in_date' => Carbon::now()->addDays(35),
                'check_out_date' => Carbon::now()->addDays(38),
                'total_price' => 2400000, // 3 malam x 800000
                'status' => 'pending',
            ],
        ];

        foreach ($bookings as $booking) {
            Booking::create($booking);
        }

        $this->command->info('Data pemesanan berhasil ditambahkan!');
    }
}
