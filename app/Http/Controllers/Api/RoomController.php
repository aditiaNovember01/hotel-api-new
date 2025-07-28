<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    /**
     * Menampilkan daftar semua kamar
     */
    public function index()
    {
        $rooms = Room::with('bookings')->get();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Daftar kamar berhasil diambil',
            'data' => $rooms
        ], 200);
    }

    /**
     * Menyimpan kamar baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'required|numeric|min:0',
            'max_guest' => 'required|integer|min:1',
            'image_url' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Nama kamar wajib diisi',
            'price_per_night.required' => 'Harga per malam wajib diisi',
            'price_per_night.numeric' => 'Harga harus berupa angka',
            'price_per_night.min' => 'Harga tidak boleh negatif',
            'max_guest.required' => 'Maksimal tamu wajib diisi',
            'max_guest.integer' => 'Maksimal tamu harus berupa angka',
            'max_guest.min' => 'Maksimal tamu minimal 1',
        ]);

        $room = Room::create($request->all());

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Kamar berhasil dibuat',
            'data' => $room
        ], 201);
    }

    /**
     * Menampilkan detail kamar
     */
    public function show($id)
    {
        $room = Room::with('bookings')->find($id);

        if (!$room) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Kamar tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Detail kamar berhasil diambil',
            'data' => $room
        ], 200);
    }

    /**
     * Mengupdate data kamar
     */
    public function update(Request $request, $id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Kamar tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'price_per_night' => 'sometimes|numeric|min:0',
            'max_guest' => 'sometimes|integer|min:1',
            'image_url' => 'nullable|string|max:255',
        ], [
            'name.string' => 'Nama kamar harus berupa teks',
            'price_per_night.numeric' => 'Harga harus berupa angka',
            'price_per_night.min' => 'Harga tidak boleh negatif',
            'max_guest.integer' => 'Maksimal tamu harus berupa angka',
            'max_guest.min' => 'Maksimal tamu minimal 1',
        ]);

        $room->update($request->all());

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Data kamar berhasil diupdate',
            'data' => $room
        ], 200);
    }

    /**
     * Menghapus kamar
     */
    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Kamar tidak ditemukan'
            ], 404);
        }

        $room->delete();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Kamar berhasil dihapus'
        ], 200);
    }

    /**
     * Mencari kamar berdasarkan kriteria
     */
    public function search(Request $request)
    {
        $query = Room::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('min_price')) {
            $query->where('price_per_night', '>=', $request->min_price);
        }

        if ($request->has('max_price')) {
            $query->where('price_per_night', '<=', $request->max_price);
        }

        if ($request->has('max_guest')) {
            $query->where('max_guest', '>=', $request->max_guest);
        }

        $rooms = $query->get();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pencarian kamar berhasil',
            'data' => $rooms
        ], 200);
    }
}
