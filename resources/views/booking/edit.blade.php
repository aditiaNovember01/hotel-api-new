@extends('adminlte::page')

@section('title', 'Edit Booking')

@section('content_header')
    <h1>Edit Booking</h1>
@endsection

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="#" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label>User ID</label>
                    <input type="number" name="user_id" class="form-control" value="{{ $booking->user_id }}" required>
                </div>
                <div class="form-group">
                    <label>Room ID</label>
                    <input type="number" name="room_id" class="form-control" value="{{ $booking->room_id }}" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Check In</label>
                    <input type="date" name="check_in_date" class="form-control" value="{{ $booking->check_in_date }}" required>
                </div>
                <div class="form-group">
                    <label>Tanggal Check Out</label>
                    <input type="date" name="check_out_date" class="form-control" value="{{ $booking->check_out_date }}" required>
                </div>
                <div class="form-group">
                    <label>Total Harga</label>
                    <input type="number" name="total_price" class="form-control" value="{{ $booking->total_price }}" required>
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <input type="text" name="status" class="form-control" value="{{ $booking->status }}">
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection 