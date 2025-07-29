@extends('adminlte::page')

@section('title', 'Laporan User')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-chart-bar text-primary"></i> Laporan User</h1>
            <p class="text-muted mb-0">Tanggal: {{ date('d F Y') }}</p>
        </div>
        <div>
            <button onclick="window.print()" class="btn btn-primary">
                <i class="fas fa-print"></i> Cetak Laporan
            </button>
        </div>
    </div>
@endsection

@section('content')
    <style>
        @media print {
            .btn, .sidebar, .navbar, .main-header {
                display: none !important;
            }
            .content-wrapper {
                margin: 0 !important;
                padding: 0 !important;
            }
            .card {
                border: 1px solid #000 !important;
                page-break-inside: avoid;
            }
            .report-header {
                text-align: center;
                margin-bottom: 20px;
            }
            .report-summary, .stats-card, .ringkasan-section {
                display: none !important;
            }
            .print-only {
                display: block !important;
            }
            .print-header {
                text-align: center;
                margin-bottom: 30px;
                border-bottom: 2px solid #000;
                padding-bottom: 20px;
            }
            .print-header h1 {
                font-size: 24px;
                margin-bottom: 10px;
            }
            .print-header p {
                font-size: 14px;
                margin: 5px 0;
            }
        }
        .print-only {
            display: none;
        }
        .stats-card {
            transition: transform 0.2s;
        }
        .stats-card:hover {
            transform: translateY(-5px);
        }
        .table-responsive {
            border-radius: 8px;
            overflow: hidden;
        }
        .card-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
        }
        .report-summary {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 30px;
        }
    </style>

    <!-- Print Header -->
    <div class="print-only print-header">
        <h1>LAPORAN DATA PENGGUNA APLIKASI</h1>
        <p><strong>Hotel Management System</strong></p>
        <p>Tanggal: {{ date('d F Y') }}</p>
        <p>Dibuat oleh: Administrator</p>
    </div>

    <div class="report-summary">
        <div class="row text-center">
            <div class="col-md-3">
                <h4><i class="fas fa-users"></i></h4>
                <h2>{{ $totalUsers }}</h2>
                <p>Total User</p>
            </div>
            <div class="col-md-3">
                <h4><i class="fas fa-user-check"></i></h4>
                <h2>{{ $activeUsers }}</h2>
                <p>User Aktif</p>
            </div>
            <div class="col-md-3">
                <h4><i class="fas fa-user-shield"></i></h4>
                <h2>{{ $adminUsers }}</h2>
                <p>Admin</p>
            </div>
            <div class="col-md-3">
                <h4><i class="fas fa-calendar-check"></i></h4>
                <h2>{{ $usersWithBookings }}</h2>
                <p>User dengan Booking</p>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card stats-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-clock"></i> User Terbaru
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentUsers as $user)
                                    <tr>
                                        <td>
                                            <i class="fas fa-user-circle text-primary"></i>
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge badge-{{ $user->role == 'admin' ? 'danger' : 'info' }}">
                                                {{ $user->role ?? 'user' }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card stats-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-trophy"></i> Top User (Berdasarkan Booking)
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Ranking</th>
                                    <th>Nama</th>
                                    <th>Email</th>
                                    <th>Jumlah Booking</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($topUsers as $index => $user)
                                    <tr>
                                        <td>
                                            @if($index == 0)
                                                <i class="fas fa-medal text-warning"></i> 1st
                                            @elseif($index == 1)
                                                <i class="fas fa-medal text-secondary"></i> 2nd
                                            @elseif($index == 2)
                                                <i class="fas fa-medal text-danger"></i> 3rd
                                            @else
                                                {{ $index + 1 }}
                                            @endif
                                        </td>
                                        <td>
                                            <i class="fas fa-user-circle text-primary"></i>
                                            {{ $user->name }}
                                        </td>
                                        <td>{{ $user->email }}</td>
                                        <td>
                                            <span class="badge badge-success">{{ $user->bookings_count }}</span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Tables -->
    <div class="print-only">
        <div style="margin-bottom: 30px;">
            <h3>Daftar User Terbaru</h3>
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #000; padding: 8px;">No</th>
                        <th style="border: 1px solid #000; padding: 8px;">Nama</th>
                        <th style="border: 1px solid #000; padding: 8px;">Email</th>
                        <th style="border: 1px solid #000; padding: 8px;">Role</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($recentUsers as $index => $user)
                        <tr>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $user->name }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $user->email }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $user->role ?? 'user' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-bottom: 30px;">
            <h3>Daftar Top User (Berdasarkan Booking)</h3>
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #000; padding: 8px;">Ranking</th>
                        <th style="border: 1px solid #000; padding: 8px;">Nama</th>
                        <th style="border: 1px solid #000; padding: 8px;">Email</th>
                        <th style="border: 1px solid #000; padding: 8px;">Jumlah Booking</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($topUsers as $index => $user)
                        <tr>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $user->name }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $user->email }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $user->bookings_count }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div style="margin-top: 50px;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 50%;"></td>
                    <td style="text-align: center;">
                        <p>Jakarta, {{ date('d F Y') }}</p>
                        <p>Administrator</p>
                        <br><br><br>
                        <p>_________________</p>
                    </td>
                </tr>
            </table>
        </div>
    </div>

    <div class="row mt-4 ringkasan-section">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Ringkasan Laporan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-chart-pie text-primary"></i> Statistik User</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total User
                                    <span class="badge badge-primary badge-pill">{{ $totalUsers }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    User Aktif
                                    <span class="badge badge-success badge-pill">{{ $activeUsers }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Admin
                                    <span class="badge badge-warning badge-pill">{{ $adminUsers }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    User dengan Booking
                                    <span class="badge badge-info badge-pill">{{ $usersWithBookings }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-percentage text-success"></i> Persentase</h5>
                            <div class="progress-group">
                                <span class="progress-text">User Aktif</span>
                                <span class="float-right"><b>{{ $activeUsers }}</b>/{{ $totalUsers }}</span>
                                <div class="progress sm">
                                    <div class="progress-bar bg-success" style="width: {{ $totalUsers > 0 ? ($activeUsers/$totalUsers)*100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">Admin</span>
                                <span class="float-right"><b>{{ $adminUsers }}</b>/{{ $totalUsers }}</span>
                                <div class="progress sm">
                                    <div class="progress-bar bg-warning" style="width: {{ $totalUsers > 0 ? ($adminUsers/$totalUsers)*100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">User dengan Booking</span>
                                <span class="float-right"><b>{{ $usersWithBookings }}</b>/{{ $totalUsers }}</span>
                                <div class="progress sm">
                                    <div class="progress-bar bg-info" style="width: {{ $totalUsers > 0 ? ($usersWithBookings/$totalUsers)*100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 