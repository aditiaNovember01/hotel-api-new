<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PaymentController extends Controller
{
    /**
     * Menampilkan daftar semua pembayaran
     */
    public function index()
    {
        $payments = Payment::with('booking')->get();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Daftar pembayaran berhasil diambil',
            'data' => $payments
        ], 200);
    }

    /**
     * Menyimpan pembayaran baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_method' => 'required|string|max:50',
            'payment_status' => ['nullable', Rule::in(['pending', 'paid', 'failed'])],
            'payment_date' => 'nullable|date',
            'total_paid' => 'nullable|numeric|min:0',
        ], [
            'booking_id.required' => 'ID pemesanan wajib diisi',
            'booking_id.exists' => 'Pemesanan tidak ditemukan',
            'payment_method.required' => 'Metode pembayaran wajib diisi',
            'payment_method.string' => 'Metode pembayaran harus berupa teks',
            'payment_method.max' => 'Metode pembayaran maksimal 50 karakter',
            'payment_status.in' => 'Status pembayaran harus pending, paid, atau failed',
            'payment_date.date' => 'Format tanggal pembayaran tidak valid',
            'total_paid.numeric' => 'Total pembayaran harus berupa angka',
            'total_paid.min' => 'Total pembayaran tidak boleh negatif',
        ]);

        // Cek apakah sudah ada pembayaran untuk booking ini
        $existingPayment = Payment::where('booking_id', $request->booking_id)->first();
        if ($existingPayment) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pembayaran untuk pemesanan ini sudah ada'
            ], 400);
        }

        $payment = Payment::create([
            'booking_id' => $request->booking_id,
            'payment_method' => $request->payment_method,
            'payment_status' => $request->payment_status ?? 'pending',
            'payment_date' => $request->payment_date ?? now(),
            'total_paid' => $request->total_paid,
        ]);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pembayaran berhasil dibuat',
            'data' => $payment->load('booking')
        ], 201);
    }

    /**
     * Menampilkan detail pembayaran
     */
    public function show($id)
    {
        $payment = Payment::with('booking')->find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Detail pembayaran berhasil diambil',
            'data' => $payment
        ], 200);
    }

    /**
     * Mengupdate status pembayaran
     */
    public function update(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        $request->validate([
            'payment_status' => ['required', Rule::in(['pending', 'paid', 'failed'])],
            'payment_date' => 'nullable|date',
            'total_paid' => 'nullable|numeric|min:0',
        ], [
            'payment_status.required' => 'Status pembayaran wajib diisi',
            'payment_status.in' => 'Status pembayaran harus pending, paid, atau failed',
            'payment_date.date' => 'Format tanggal pembayaran tidak valid',
            'total_paid.numeric' => 'Total pembayaran harus berupa angka',
            'total_paid.min' => 'Total pembayaran tidak boleh negatif',
        ]);

        $updateData = [
            'payment_status' => $request->payment_status,
        ];

        if ($request->has('payment_date')) {
            $updateData['payment_date'] = $request->payment_date;
        }

        if ($request->has('total_paid')) {
            $updateData['total_paid'] = $request->total_paid;
        }

        // Jika status berubah menjadi paid, update payment_date jika belum diisi
        if ($request->payment_status === 'paid' && !$request->has('payment_date')) {
            $updateData['payment_date'] = now();
        }

        $payment->update($updateData);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Status pembayaran berhasil diupdate',
            'data' => $payment->load('booking')
        ], 200);
    }

    /**
     * Menghapus pembayaran
     */
    public function destroy($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        $payment->delete();

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pembayaran berhasil dihapus'
        ], 200);
    }

    /**
     * Menampilkan pembayaran berdasarkan pemesanan
     */
    public function bookingPayment($bookingId)
    {
        $payment = Payment::with('booking')
            ->where('booking_id', $bookingId)
            ->first();

        if (!$payment) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pembayaran untuk pemesanan ini tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pembayaran pemesanan berhasil diambil',
            'data' => $payment
        ], 200);
    }

    /**
     * Proses pembayaran
     */
    public function processPayment(Request $request, $id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pembayaran tidak ditemukan'
            ], 404);
        }

        if ($payment->payment_status === 'paid') {
            return response()->json([
                'status' => 'gagal',
                'message' => 'Pembayaran sudah diproses sebelumnya'
            ], 400);
        }

        // Simulasi proses pembayaran
        $request->validate([
            'payment_method' => 'sometimes|string|max:50',
            'total_paid' => 'required|numeric|min:0',
        ], [
            'total_paid.required' => 'Total pembayaran wajib diisi',
            'total_paid.numeric' => 'Total pembayaran harus berupa angka',
            'total_paid.min' => 'Total pembayaran tidak boleh negatif',
        ]);

        // Update status pembayaran menjadi paid
        $payment->update([
            'payment_status' => 'paid',
            'payment_date' => now(),
            'total_paid' => $request->total_paid,
        ]);

        // Update status booking menjadi confirmed
        $payment->booking->update(['status' => 'confirmed']);

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Pembayaran berhasil diproses',
            'data' => $payment->load('booking')
        ], 200);
    }

    /**
     * Menampilkan statistik pembayaran
     */
    public function statistics()
    {
        $totalPayments = Payment::count();
        $paidPayments = Payment::where('payment_status', 'paid')->count();
        $pendingPayments = Payment::where('payment_status', 'pending')->count();
        $failedPayments = Payment::where('payment_status', 'failed')->count();
        $totalRevenue = Payment::where('payment_status', 'paid')->sum('total_paid');

        return response()->json([
            'status' => 'berhasil',
            'message' => 'Statistik pembayaran berhasil diambil',
            'data' => [
                'total_payments' => $totalPayments,
                'paid_payments' => $paidPayments,
                'pending_payments' => $pendingPayments,
                'failed_payments' => $failedPayments,
                'total_revenue' => $totalRevenue,
                'success_rate' => $totalPayments > 0 ? round(($paidPayments / $totalPayments) * 100, 2) : 0,
            ]
        ], 200);
    }
}
