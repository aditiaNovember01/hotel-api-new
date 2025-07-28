@extends('adminlte::page')

@section('title', 'Daftar Booking')

@section('content_header')
    <h1>Daftar Booking</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('booking.create') }}" class="btn btn-primary mb-3">Tambah Booking</a>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Kamar</th>
                        <th>Check In</th>
                        <th>Check Out</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($bookings as $booking)
                        <tr>
                            <td>{{ $booking->id }}</td>
                            <td>{{ $booking->user->name ?? '-' }}</td>
                            <td>{{ $booking->room->name ?? '-' }}</td>
                            <td>{{ $booking->check_in_date }}</td>
                            <td>{{ $booking->check_out_date }}</td>
                            <td>{{ $booking->total_price }}</td>
                            <td>
                                <form action="{{ route('booking.update', $booking->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" onchange="this.form.submit()" class="form-control form-control-sm">
                                        <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="confirmed" {{ $booking->status == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                                        <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <a href="{{ route('booking.edit', $booking->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection 