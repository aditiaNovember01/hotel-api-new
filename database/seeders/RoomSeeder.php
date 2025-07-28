<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Standard Room',
                'description' => 'Kamar standar nyaman dengan tempat tidur queen size, AC, TV LED, dan kamar mandi dalam. Cocok untuk perjalanan bisnis atau liburan singkat.',
                'price_per_night' => 350000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Deluxe Room',
                'description' => 'Kamar mewah dengan pemandangan kota, tempat tidur king size, AC, TV LED 55", mini bar, dan kamar mandi mewah dengan shower. Dilengkapi dengan balkon pribadi.',
                'price_per_night' => 550000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Superior Room',
                'description' => 'Kamar superior dengan desain modern, tempat tidur king size, AC, TV LED 65", sofa bed, dan kamar mandi dalam dengan bathtub. Pemandangan taman hotel.',
                'price_per_night' => 450000,
                'max_guest' => 3,
                'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Executive Suite',
                'description' => 'Suite eksekutif dengan ruang tamu terpisah, tempat tidur king size, AC, TV LED 75", ruang kerja, mini bar, dan kamar mandi mewah dengan jacuzzi. Pemandangan kota terbaik.',
                'price_per_night' => 850000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Family Room',
                'description' => 'Kamar keluarga luas dengan 2 tempat tidur queen size, AC, TV LED 65", sofa bed, dan kamar mandi dalam. Cocok untuk keluarga dengan anak-anak.',
                'price_per_night' => 650000,
                'max_guest' => 4,
                'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Presidential Suite',
                'description' => 'Suite presidensial mewah dengan 2 kamar tidur, ruang tamu besar, ruang makan, dapur mini, AC, TV LED 85", dan kamar mandi mewah dengan sauna pribadi. Pemandangan kota 360 derajat.',
                'price_per_night' => 2500000,
                'max_guest' => 4,
                'image_url' => 'https://images.unsplash.com/photo-1578683010236-d716f9a3f461?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Honeymoon Suite',
                'description' => 'Suite romantis untuk pasangan pengantin baru dengan tempat tidur king size, dekorasi romantis, AC, TV LED 65", balkon pribadi, dan kamar mandi mewah dengan shower rain.',
                'price_per_night' => 1200000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1566665797739-1674de7a421a?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Business Suite',
                'description' => 'Suite bisnis dengan ruang kerja lengkap, tempat tidur king size, AC, TV LED 65", meja kerja besar, dan kamar mandi dalam. Dilengkapi dengan printer dan scanner.',
                'price_per_night' => 750000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1582719478250-c89cae4dc85b?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Garden View Room',
                'description' => 'Kamar dengan pemandangan taman hotel yang indah, tempat tidur queen size, AC, TV LED, dan kamar mandi dalam. Suasana tenang dan nyaman.',
                'price_per_night' => 400000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Pool View Room',
                'description' => 'Kamar dengan pemandangan kolam renang, tempat tidur queen size, AC, TV LED, dan kamar mandi dalam. Akses langsung ke area kolam renang.',
                'price_per_night' => 500000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1571896349842-33c89424de2d?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Accessible Room',
                'description' => 'Kamar yang dirancang khusus untuk tamu dengan kebutuhan khusus, tempat tidur queen size, AC, TV LED, dan kamar mandi yang mudah diakses dengan pegangan tangan.',
                'price_per_night' => 350000,
                'max_guest' => 2,
                'image_url' => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=800&h=600&fit=crop',
            ],
            [
                'name' => 'Connecting Rooms',
                'description' => 'Dua kamar yang terhubung dengan pintu dalam, masing-masing dengan tempat tidur queen size, AC, TV LED, dan kamar mandi dalam. Ideal untuk keluarga besar.',
                'price_per_night' => 800000,
                'max_guest' => 4,
                'image_url' => 'https://images.unsplash.com/photo-1590490360182-c33d57733427?w=800&h=600&fit=crop',
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }

        $this->command->info('Data kamar berhasil ditambahkan!');
    }
}
