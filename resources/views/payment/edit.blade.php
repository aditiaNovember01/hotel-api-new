@extends('adminlte::page')

@section('title', 'Edit Pembayaran')

@section('content_header')
    <h1>Edit Pembayaran</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>Booking ID</label>
                    <input type="number" name="booking_id" class="form-control" value="{{ $payment->booking_id }}" required>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <input type="text" name="payment_method" class="form-control" value="{{ $payment->payment_method }}" required>
                </div>
                <div class="form-group">
                    <label>Status Pembayaran</label>
                    <input type="text" name="payment_status" class="form-control" value="{{ $payment->payment_status }}" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Pembayaran</label>
                    <input type="datetime-local" name="payment_date" class="form-control" value="{{ $payment->payment_date }}" required>
                </div>
                <div class="form-group">
                    <label>Total Dibayar</label>
                    <input type="number" name="total_paid" class="form-control" value="{{ $payment->total_paid }}" required>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection 