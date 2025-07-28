@extends('adminlte::page')

@section('title', 'Tambah Pembayaran')

@section('content_header')
    <h1>Tambah Pembayaran</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label>Booking ID</label>
                    <input type="number" name="booking_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Metode Pembayaran</label>
                    <input type="text" name="payment_method" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status Pembayaran</label>
                    <input type="text" name="payment_status" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Pembayaran</label>
                    <input type="datetime-local" name="payment_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Total Dibayar</label>
                    <input type="number" name="total_paid" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection 