@extends('adminlte::page')

@section('title', 'Daftar Pembayaran')

@section('content_header')
    <h1>Daftar Pembayaran</h1>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <a href="{{ route('payment.create') }}" class="btn btn-primary mb-3">Tambah Pembayaran</a>
    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Booking</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Total Dibayar</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $payment)
                        <tr>
                            <td>{{ $payment->id }}</td>
                            <td>{{ $payment->booking->id ?? '-' }}</td>
                            <td>{{ $payment->payment_method }}</td>
                            <td>
                                <form action="{{ route('payment.update', $payment->id) }}" method="POST" style="display:inline-block;">
                                    @csrf
                                    @method('PUT')
                                    <span class="badge 
                                        {{ $payment->payment_status == 'pending' ? 'badge-warning' : '' }}
                                        {{ $payment->payment_status == 'paid' ? 'badge-success' : '' }}
                                        {{ $payment->payment_status == 'failed' ? 'badge-danger' : '' }}
                                    ">
                                        {{ ucfirst($payment->payment_status) }}
                                    </span>
                                    <select name="payment_status" onchange="this.form.submit()" class="form-control form-control-sm mt-1">
                                        <option value="pending" {{ $payment->payment_status == 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="paid" {{ $payment->payment_status == 'paid' ? 'selected' : '' }}>Paid</option>
                                        <option value="failed" {{ $payment->payment_status == 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </form>
                            </td>
                            <td>{{ $payment->payment_date }}</td>
                            <td>{{ $payment->total_paid }}</td>
                            <td>
                                <a href="{{ route('payment.edit', $payment->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection 