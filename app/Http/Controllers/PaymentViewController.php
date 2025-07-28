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
} 