<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PaymentViewController extends Controller
{
    public function index()
    {
        $payments = Payment::with('booking')->get();
        return view('payment.index', compact('payments'));
    }

    public function create()
    {
        return view('payment.create');
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        return view('payment.edit', compact('payment'));
    }

    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        if ($request->has('payment_status')) {
            $payment->payment_status = $request->input('payment_status');
            $payment->save();
        }
        return redirect()->route('payment.index')->with('success', 'Status pembayaran berhasil diupdate!');
    }

    public function report(Request $request)
    {
        $period = $request->get('period', 'month'); // default to month
        $date = $request->get('date', now()->format('Y-m')); // default to current month

        $startDate = null;
        $endDate = null;
        $periodLabel = '';

        switch ($period) {
            case 'week':
                $startDate = Carbon::parse($date)->startOfWeek();
                $endDate = Carbon::parse($date)->endOfWeek();
                $periodLabel = 'Minggu ' . $startDate->format('d M Y') . ' - ' . $endDate->format('d M Y');
                break;
            case 'month':
                $startDate = Carbon::parse($date)->startOfMonth();
                $endDate = Carbon::parse($date)->endOfMonth();
                $periodLabel = 'Bulan ' . $startDate->format('F Y');
                break;
            case 'year':
                $startDate = Carbon::parse($date)->startOfYear();
                $endDate = Carbon::parse($date)->endOfYear();
                $periodLabel = 'Tahun ' . $startDate->format('Y');
                break;
        }

        // Get payments for the selected period
        $payments = Payment::with('booking')
            ->whereBetween('payment_date', [$startDate, $endDate])
            ->get();

        // Calculate statistics
        $totalRevenue = $payments->where('payment_status', 'paid')->sum('total_paid');
        $totalPending = $payments->where('payment_status', 'pending')->sum('total_paid');
        $totalFailed = $payments->where('payment_status', 'failed')->sum('total_paid');
        $totalPayments = $payments->count();
        $paidPayments = $payments->where('payment_status', 'paid')->count();
        $pendingPayments = $payments->where('payment_status', 'pending')->count();
        $failedPayments = $payments->where('payment_status', 'failed')->count();

        // Get top payment methods
        $paymentMethods = $payments->groupBy('payment_method')
            ->map(function ($group) {
                return [
                    'method' => $group->first()->payment_method,
                    'count' => $group->count(),
                    'total' => $group->where('payment_status', 'paid')->sum('total_paid')
                ];
            })
            ->sortByDesc('total')
            ->take(5);

        // Get daily revenue for chart (if needed)
        $dailyRevenue = $payments->where('payment_status', 'paid')
            ->groupBy(function ($payment) {
                return Carbon::parse($payment->payment_date)->format('Y-m-d');
            })
            ->map(function ($group) {
                return $group->sum('total_paid');
            });

        // Get recent payments
        $recentPayments = $payments->take(10);

        return view('payment.report', compact(
            'payments',
            'totalRevenue',
            'totalPending',
            'totalFailed',
            'totalPayments',
            'paidPayments',
            'pendingPayments',
            'failedPayments',
            'paymentMethods',
            'dailyRevenue',
            'recentPayments',
            'period',
            'date',
            'periodLabel',
            'startDate',
            'endDate'
        ));
    }
} 