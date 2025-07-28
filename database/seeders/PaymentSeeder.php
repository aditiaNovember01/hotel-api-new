<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Payment;
use App\Models\Booking;
use Carbon\Carbon;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $confirmedBookings = Booking::where('status', 'confirmed')->get();

        if ($confirmedBookings->isEmpty()) {
            $this->command->warn('Tidak ada booking yang confirmed. Jalankan BookingSeeder terlebih dahulu.');
            return;
        }

        $payments = [
            [
                'booking_id' => $confirmedBookings->first()->id,
                'payment_method' => 'bank_transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(1),
                'total_paid' => 700000,
            ],
            [
                'booking_id' => $confirmedBookings->skip(1)->first()->id,
                'payment_method' => 'credit_card',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(2),
                'total_paid' => 900000,
            ],
            [
                'booking_id' => $confirmedBookings->skip(2)->first()->id,
                'payment_method' => 'e_wallet',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(3),
                'total_paid' => 1700000,
            ],
            [
                'booking_id' => $confirmedBookings->skip(3)->first()->id,
                'payment_method' => 'bank_transfer',
                'payment_status' => 'paid',
                'payment_date' => Carbon::now()->subDays(4),
                'total_paid' => 1500000,
            ],
        ];

        foreach ($payments as $payment) {
            Payment::create($payment);
        }

        // Buat beberapa payment untuk booking yang pending
        $pendingBookings = Booking::where('status', 'pending')->take(3)->get();

        foreach ($pendingBookings as $booking) {
            Payment::create([
                'booking_id' => $booking->id,
                'payment_method' => 'bank_transfer',
                'payment_status' => 'pending',
                'payment_date' => null,
                'total_paid' => null,
            ]);
        }

        // Buat satu payment yang failed
        $failedBooking = Booking::where('status', 'cancelled')->first();
        if ($failedBooking) {
            Payment::create([
                'booking_id' => $failedBooking->id,
                'payment_method' => 'credit_card',
                'payment_status' => 'failed',
                'payment_date' => Carbon::now()->subDays(5),
                'total_paid' => 1000000,
            ]);
        }

        $this->command->info('Data pembayaran berhasil ditambahkan!');
    }
}
