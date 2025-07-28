@extends('adminlte::page')

@section('title', 'Tambah Booking')

@section('content_header')
    <h1>Tambah Booking</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                <div class="form-group">
                    <label>User ID</label>
                    <input type="number" name="user_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Room ID</label>
                    <input type="number" name="room_id" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Check In</label>
                    <input type="date" name="check_in_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Check Out</label>
                    <input type="date" name="check_out_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="number" name="total_price" class="form-control" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control">
                </div>
                <button type="submit" class="btn btn-primary">Simpan</button>
            </form>
        </div>
    </div>
@endsection 