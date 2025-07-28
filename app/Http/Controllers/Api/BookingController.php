<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class BookingController extends Controller
{
    /**
     * Menampilkan daftar semua pemesanan
     */
    public function index()
    {
        $bookings = Booking::with(['user', 'room', 'payment'])->get();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Daftar pemesanan berhasil diambil',
            'data' => $bookings
        ], 200);
    }

    /**
     * Menyimpan pemesanan baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
            'total_price' => 'required|numeric|min:0',
            'status' => ['nullable', Rule::in(['pending', 'confirmed', 'cancelled'])],
        ], [
            'user_id.required' => 'ID pengguna wajib diisi',
            'user_id.exists' => 'Pengguna tidak ditemukan',
            'room_id.required' => 'ID kamar wajib diisi',
            'room_id.exists' => 'Kamar tidak ditemukan',
            'check_in_date.required' => 'Tanggal check-in wajib diisi',
            'check_in_date.date' => 'Format tanggal check-in tidak valid',
            'check_in_date.after' => 'Tanggal check-in harus setelah hari ini',
            'check_out_date.required' => 'Tanggal check-out wajib diisi',
            'check_out_date.date' => 'Format tanggal check-out tidak valid',
            'check_out_date.after' => 'Tanggal check-out harus setelah tanggal check-in',
            'total_price.required' => 'Total harga wajib diisi',
            'total_price.numeric' => 'Total harga harus berupa angka',
            'total_price.min' => 'Total harga tidak boleh negatif',
            'status.in' => 'Status harus pending, confirmed, atau cancelled',
        ]);



        // Cek ketersediaan kamar
        $conflictingBookings = Booking::where('room_id', $request->room_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in_date', '<=', $request->check_in_date)
                            ->where('check_out_date', '>=', $request->check_out_date);
                    });
            })->exists();

        if ($conflictingBookings) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Kamar tidak tersedia untuk tanggal yang dipilih'
            ], 400);
        }

        $booking = Booking::create([
            'user_id' => $request->user_id,
            'room_id' => $request->room_id,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'total_price' => $request->total_price,
            'status' => $request->status ?? 'pending',
        ]);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pemesanan berhasil dibuat',
            'data' => $booking->load(['user', 'room'])
        ], 201);
    }

    /**
     * Menampilkan detail pemesanan
     */
    public function show($id)
    {
        $booking = Booking::with(['user', 'room', 'payment'])->find($id);

        if (!$booking) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pemesanan tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Detail pemesanan berhasil diambil',
            'data' => $booking
        ], 200);
    }

    /**
     * Mengupdate status pemesanan
     */
    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pemesanan tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'status' => ['required', Rule::in(['pending', 'confirmed', 'cancelled'])],
        ], [
            'status.required' => 'Status wajib diisi',
            'status.in' => 'Status harus pending, confirmed, atau cancelled',
        ]);

        $booking->update(['status' => $request->status]);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Status pemesanan berhasil diupdate',
            'data' => $booking->load(['user', 'room'])
        ], 200);
    }

    /**
     * Menghapus pemesanan
     */
    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pemesanan tidak ditemukan'
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pemesanan berhasil dihapus'
        ], 200);
    }

    /**
     * Menampilkan pemesanan berdasarkan pengguna
     */
    public function userBookings($userId)
    {
        $bookings = Booking::with(['room', 'payment'])
            ->where('user_id', $userId)
            ->get();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Daftar pemesanan pengguna berhasil diambil',
            'data' => $bookings
        ], 200);
    }

    /**
     * Cek ketersediaan kamar
     */
    public function checkAvailability(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'check_in_date' => 'required|date|after:today',
            'check_out_date' => 'required|date|after:check_in_date',
        ], [
            'room_id.required' => 'ID kamar wajib diisi',
            'room_id.exists' => 'Kamar tidak ditemukan',
            'check_in_date.required' => 'Tanggal check-in wajib diisi',
            'check_in_date.after' => 'Tanggal check-in harus setelah hari ini',
            'check_out_date.required' => 'Tanggal check-out wajib diisi',
            'check_out_date.after' => 'Tanggal check-out harus setelah tanggal check-in',
        ]);

        $conflictingBookings = Booking::where('room_id', $request->room_id)
            ->where('status', '!=', 'cancelled')
            ->where(function ($query) use ($request) {
                $query->whereBetween('check_in_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhereBetween('check_out_date', [$request->check_in_date, $request->check_out_date])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('check_in_date', '<=', $request->check_in_date)
                            ->where('check_out_date', '>=', $request->check_out_date);
                    });
            })->exists();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Cek ketersediaan berhasil',
            'data' => [
                'available' => !$conflictingBookings,
                'room_id' => $request->room_id,
                'check_in_date' => $request->check_in_date,
                'check_out_date' => $request->check_out_date,
            ]
        ], 200);
    }
}
