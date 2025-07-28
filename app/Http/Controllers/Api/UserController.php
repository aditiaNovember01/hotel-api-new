<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan daftar semua pengguna
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Daftar pengguna berhasil diambil',
            'data' => $users
        ], 200);
    }

    /**
     * Menyimpan pengguna baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'role' => ['nullable', Rule::in(['admin', 'user'])],
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'role.in' => 'Role harus admin atau user',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role ?? 'user',
        ]);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pengguna berhasil dibuat',
            'data' => $user
        ], 201);
    }

    /**
     * Menampilkan detail pengguna
     */
    public function show($id)
    {
        $user = User::with('bookings')->find($id);

        if (!$user) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Detail pengguna berhasil diambil',
            'data' => $user
        ], 200);
    }

    /**
     * Mengupdate data pengguna
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($id)],
            'phone' => 'nullable|string|max:20',
            'role' => ['sometimes', Rule::in(['admin', 'user'])],
        ], [
            'name.string' => 'Nama harus berupa teks',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'role.in' => 'Role harus admin atau user',
        ]);

        $user->update($request->only(['name', 'email', 'phone', 'role']));

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Data pengguna berhasil diupdate',
            'data' => $user
        ], 200);
    }

    /**
     * Menghapus pengguna
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pengguna tidak ditemukan'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pengguna berhasil dihapus'
        ], 200);
    }
}
