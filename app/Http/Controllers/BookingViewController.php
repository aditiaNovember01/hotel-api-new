<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use App\Models\Payment;

class BookingViewController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['user', 'room', 'payment'])->get();
        return view('booking.index', compact('bookings'));
    }

    public function create()
    {
        return view('booking.create');
    }

    public function edit($id)
    {
        $booking = Booking::findOrFail($id);
        return view('booking.edit', compact('booking'));
    }

    public function update(Request $request, $id)
    {
        $booking = Booking::findOrFail($id);
        if ($request->has('status')) {
            $booking->status = $request->input('status');
            $booking->save();

            // Jika status menjadi confirmed, buat payment jika belum ada
            if ($booking->status === 'confirmed' && !$booking->payment) {
                Payment::create([
                    'booking_id' => $booking->id,
                    'payment_method' => 'manual', // default, bisa diubah
                    'payment_status' => 'pending',
                    'payment_date' => now(),
                    'total_paid' => $booking->total_price,
                ]);
            }
        }
        return redirect()->route('booking.index')->with('success', 'Status booking berhasil diupdate!');
    }
} 