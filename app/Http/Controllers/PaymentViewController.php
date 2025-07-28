<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

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
} 