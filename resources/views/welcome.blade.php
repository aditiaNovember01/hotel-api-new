@extends('adminlte::page')

@section('title', 'Dashboard - Hotel Management System')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-hotel text-primary"></i> Dashboard</h1>
            <p class="text-muted mb-0">Selamat datang di Hotel Management System</p>
        </div>
        <div class="text-right">
            <p class="mb-0 text-muted">Tanggal: {{ date('d F Y') }}</p>
            <p class="mb-0 text-muted">Waktu: {{ date('H:i') }}</p>
        </div>
    </div>
@endsection

@section('content')
    <style>
        .welcome-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }
        .stats-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: none;
            border-radius: 15px;
            overflow: hidden;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(0,0,0,0.1);
        }
        .feature-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
        }
        .feature-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }
        .quick-actions {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }
        .system-info {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
            border-radius: 15px;
            padding: 25px;
            margin-bottom: 20px;
        }
    </style>

    <!-- Welcome Section -->
    <div class="welcome-section">
        <div class="row align-items-center">
            <div class="col-md-8">
                <h2 class="mb-3">
                    <i class="fas fa-sun text-warning"></i> 
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>
                <p class="mb-0">
                    Selamat datang di Hotel Management System. Kelola hotel Anda dengan mudah dan efisien.
                    Semua fitur tersedia di sidebar menu.
                </p>
            </div>
            <div class="col-md-4 text-center">
                <i class="fas fa-hotel" style="font-size: 4rem; opacity: 0.8;"></i>
            </div>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box bg-info stats-card">
                <div class="inner">
                    <h3>{{ \App\Models\User::count() }}</h3>
                    <p>Total Users</p>
                </div>
                <div class="icon">
                    <i class="fas fa-users"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-success stats-card">
                <div class="inner">
                    <h3>{{ \App\Models\Room::count() }}</h3>
                    <p>Total Rooms</p>
                </div>
                <div class="icon">
                    <i class="fas fa-bed"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-warning stats-card">
                <div class="inner">
                    <h3>{{ \App\Models\Booking::count() }}</h3>
                    <p>Total Bookings</p>
                </div>
                <div class="icon">
                    <i class="fas fa-calendar-check"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box bg-danger stats-card">
                <div class="inner">
                    <h3>{{ \App\Models\Payment::count() }}</h3>
                    <p>Total Payments</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Quick Actions -->
        <div class="col-md-6">
            <div class="quick-actions">
                <h4><i class="fas fa-bolt"></i> Quick Actions</h4>
                <div class="row">
                    <div class="col-6 mb-3">
                        <a href="{{ route('user.create') }}" class="btn btn-light btn-block">
                            <i class="fas fa-user-plus"></i> Add User
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('room.create') }}" class="btn btn-light btn-block">
                            <i class="fas fa-plus"></i> Add Room
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('booking.create') }}" class="btn btn-light btn-block">
                            <i class="fas fa-calendar-plus"></i> New Booking
                        </a>
                    </div>
                    <div class="col-6 mb-3">
                        <a href="{{ route('payment.create') }}" class="btn btn-light btn-block">
                            <i class="fas fa-credit-card"></i> New Payment
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Information -->
        <div class="col-md-6">
            <div class="system-info">
                <h4><i class="fas fa-info-circle"></i> System Information</h4>
                <div class="row">
                    <div class="col-6">
                        <p class="mb-1"><strong>PHP Version:</strong></p>
                        <p class="mb-1"><strong>Laravel Version:</strong></p>
                        <p class="mb-1"><strong>Database:</strong></p>
                        <p class="mb-1"><strong>Server Time:</strong></p>
                    </div>
                    <div class="col-6">
                        <p class="mb-1">{{ phpversion() }}</p>
                        <p class="mb-1">{{ app()->version() }}</p>
                        <p class="mb-1">MySQL</p>
                        <p class="mb-1">{{ date('H:i:s') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Feature Cards -->
    <div class="row">
        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center mb-3">
                    <i class="fas fa-users text-primary" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-center mb-3">User Management</h5>
                <p class="text-muted text-center">
                    Kelola user, admin, dan akses. Lihat laporan user dan statistik.
                </p>
                <div class="text-center">
                    <a href="{{ route('user.index') }}" class="btn btn-primary btn-sm">
                        <i class="fas fa-arrow-right"></i> Manage Users
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center mb-3">
                    <i class="fas fa-bed text-success" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-center mb-3">Room Management</h5>
                <p class="text-muted text-center">
                    Kelola kamar hotel, harga, dan ketersediaan. Upload gambar kamar.
                </p>
                <div class="text-center">
                    <a href="{{ route('room.index') }}" class="btn btn-success btn-sm">
                        <i class="fas fa-arrow-right"></i> Manage Rooms
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="feature-card">
                <div class="text-center mb-3">
                    <i class="fas fa-calendar-check text-warning" style="font-size: 3rem;"></i>
                </div>
                <h5 class="text-center mb-3">Booking System</h5>
                <p class="text-muted text-center">
                    Kelola reservasi, status booking, dan konfirmasi pembayaran.
                </p>
                <div class="text-center">
                    <a href="{{ route('booking.index') }}" class="btn btn-warning btn-sm">
                        <i class="fas fa-arrow-right"></i> Manage Bookings
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock text-info"></i> Recent Activity
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6><i class="fas fa-user text-primary"></i> Recent Users</h6>
                            <ul class="list-group list-group-flush">
                                @foreach(\App\Models\User::latest()->take(3)->get() as $user)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-user-circle text-primary"></i>
                                            {{ $user->name }}
                                        </div>
                                        <span class="badge badge-primary badge-pill">{{ $user->role }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6><i class="fas fa-calendar text-success"></i> Recent Bookings</h6>
                            <ul class="list-group list-group-flush">
                                @foreach(\App\Models\Booking::latest()->take(3)->get() as $booking)
                                    <li class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-calendar-check text-success"></i>
                                            Booking #{{ $booking->id }}
                                        </div>
                                        <span class="badge badge-{{ $booking->status == 'confirmed' ? 'success' : ($booking->status == 'pending' ? 'warning' : 'danger') }} badge-pill">
                                            {{ ucfirst($booking->status) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden logout form -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
@endsection
