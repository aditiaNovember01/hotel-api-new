<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;

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
} 