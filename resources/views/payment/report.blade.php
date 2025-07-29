@extends('adminlte::page')

@section('title', 'Laporan Keuangan')

@section('content_header')
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h1><i class="fas fa-chart-line text-success"></i> Laporan Keuangan</h1>
            <p class="text-muted mb-0">{{ $periodLabel }}</p>
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
            .filter-section {
                display: none !important;
            }
            .print-only {
                display: block !important;
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
        .revenue-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .pending-card {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            color: white;
        }
        .success-card {
            background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            color: white;
        }
        .danger-card {
            background: linear-gradient(135deg, #fa709a 0%, #fee140 100%);
            color: white;
        }
    </style>

    <!-- Print Header -->
    <div class="print-only" style="text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 20px;">
        <h1>LAPORAN KEUANGAN</h1>
        <p><strong>Hotel Management System</strong></p>
        <p>Periode: {{ $periodLabel }}</p>
        <p>Tanggal: {{ date('d F Y') }}</p>
    </div>

    <!-- Filter Section -->
    <div class="card filter-section">
        <div class="card-header">
            <h3 class="card-title">
                <i class="fas fa-filter"></i> Filter Periode
            </h3>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('payment.report') }}" class="row">
                <div class="col-md-4">
                    <label>Periode:</label>
                    <select name="period" class="form-control" onchange="this.form.submit()">
                        <option value="week" {{ $period == 'week' ? 'selected' : '' }}>Per Minggu</option>
                        <option value="month" {{ $period == 'month' ? 'selected' : '' }}>Per Bulan</option>
                        <option value="year" {{ $period == 'year' ? 'selected' : '' }}>Per Tahun</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label>Tanggal:</label>
                    @if($period == 'week')
                        <input type="week" name="date" value="{{ $date }}" class="form-control" onchange="this.form.submit()">
                    @elseif($period == 'month')
                        <input type="month" name="date" value="{{ $date }}" class="form-control" onchange="this.form.submit()">
                    @else
                        <input type="number" name="date" value="{{ $date }}" class="form-control" placeholder="Tahun" onchange="this.form.submit()">
                    @endif
                </div>
                <div class="col-md-4">
                    <label>&nbsp;</label>
                    <button type="submit" class="btn btn-primary btn-block">
                        <i class="fas fa-search"></i> Tampilkan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row">
        <div class="col-lg-3 col-6">
            <div class="small-box revenue-card">
                <div class="inner">
                    <h3>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                    <p>Total Pendapatan</p>
                </div>
                <div class="icon">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box pending-card">
                <div class="inner">
                    <h3>Rp {{ number_format($totalPending, 0, ',', '.') }}</h3>
                    <p>Pendapatan Pending</p>
                </div>
                <div class="icon">
                    <i class="fas fa-clock"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box success-card">
                <div class="inner">
                    <h3>{{ $paidPayments }}</h3>
                    <p>Pembayaran Sukses</p>
                </div>
                <div class="icon">
                    <i class="fas fa-check-circle"></i>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-6">
            <div class="small-box danger-card">
                <div class="inner">
                    <h3>{{ $failedPayments }}</h3>
                    <p>Pembayaran Gagal</p>
                </div>
                <div class="icon">
                    <i class="fas fa-times-circle"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Print Tables -->
    <div class="print-only">
        <div style="margin-bottom: 30px;">
            <h3>Ringkasan Keuangan</h3>
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #000; padding: 8px;">Kategori</th>
                        <th style="border: 1px solid #000; padding: 8px;">Jumlah</th>
                        <th style="border: 1px solid #000; padding: 8px;">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px;">Pembayaran Sukses</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $paidPayments }}</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ number_format($totalRevenue, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px;">Pembayaran Pending</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $pendingPayments }}</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ number_format($totalPending, 0, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td style="border: 1px solid #000; padding: 8px;">Pembayaran Gagal</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ $failedPayments }}</td>
                        <td style="border: 1px solid #000; padding: 8px;">{{ number_format($totalFailed, 0, ',', '.') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div style="margin-bottom: 30px;">
            <h3>Daftar Pembayaran</h3>
            <table class="table table-bordered" style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background-color: #f8f9fa;">
                        <th style="border: 1px solid #000; padding: 8px;">No</th>
                        <th style="border: 1px solid #000; padding: 8px;">Tanggal</th>
                        <th style="border: 1px solid #000; padding: 8px;">Booking ID</th>
                        <th style="border: 1px solid #000; padding: 8px;">Metode</th>
                        <th style="border: 1px solid #000; padding: 8px;">Status</th>
                        <th style="border: 1px solid #000; padding: 8px;">Total (Rp)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($payments as $index => $payment)
                        <tr>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $index + 1 }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $payment->payment_date }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $payment->booking_id }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $payment->payment_method }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ $payment->payment_status }}</td>
                            <td style="border: 1px solid #000; padding: 8px;">{{ number_format($payment->total_paid, 0, ',', '.') }}</td>
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

    <!-- Detailed Reports -->
    <div class="row">
        <div class="col-md-6">
            <div class="card stats-card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie"></i> Metode Pembayaran Terpopuler
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Metode</th>
                                    <th>Jumlah</th>
                                    <th>Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($paymentMethods as $method)
                                    <tr>
                                        <td>
                                            <i class="fas fa-credit-card text-primary"></i>
                                            {{ ucfirst($method['method']) }}
                                        </td>
                                        <td>
                                            <span class="badge badge-info">{{ $method['count'] }}</span>
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($method['total'], 0, ',', '.') }}</strong>
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
                        <i class="fas fa-list"></i> Pembayaran Terbaru
                    </h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Booking ID</th>
                                    <th>Status</th>
                                    <th>Total (Rp)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentPayments as $payment)
                                    <tr>
                                        <td>{{ Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                                        <td>{{ $payment->booking_id }}</td>
                                        <td>
                                            <span class="badge badge-{{ $payment->payment_status == 'paid' ? 'success' : ($payment->payment_status == 'pending' ? 'warning' : 'danger') }}">
                                                {{ ucfirst($payment->payment_status) }}
                                            </span>
                                        </td>
                                        <td>
                                            <strong>Rp {{ number_format($payment->total_paid, 0, ',', '.') }}</strong>
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

    <!-- Summary Section -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-info-circle"></i> Ringkasan Laporan Keuangan
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h5><i class="fas fa-chart-bar text-primary"></i> Statistik Pembayaran</h5>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Total Pembayaran
                                    <span class="badge badge-primary badge-pill">{{ $totalPayments }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Pembayaran Sukses
                                    <span class="badge badge-success badge-pill">{{ $paidPayments }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Pembayaran Pending
                                    <span class="badge badge-warning badge-pill">{{ $pendingPayments }}</span>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Pembayaran Gagal
                                    <span class="badge badge-danger badge-pill">{{ $failedPayments }}</span>
                                </li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h5><i class="fas fa-percentage text-success"></i> Persentase Keberhasilan</h5>
                            <div class="progress-group">
                                <span class="progress-text">Pembayaran Sukses</span>
                                <span class="float-right"><b>{{ $paidPayments }}</b>/{{ $totalPayments }}</span>
                                <div class="progress sm">
                                    <div class="progress-bar bg-success" style="width: {{ $totalPayments > 0 ? ($paidPayments/$totalPayments)*100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">Pembayaran Pending</span>
                                <span class="float-right"><b>{{ $pendingPayments }}</b>/{{ $totalPayments }}</span>
                                <div class="progress sm">
                                    <div class="progress-bar bg-warning" style="width: {{ $totalPayments > 0 ? ($pendingPayments/$totalPayments)*100 : 0 }}%"></div>
                                </div>
                            </div>
                            <div class="progress-group">
                                <span class="progress-text">Pembayaran Gagal</span>
                                <span class="float-right"><b>{{ $failedPayments }}</b>/{{ $totalPayments }}</span>
                                <div class="progress sm">
                                    <div class="progress-bar bg-danger" style="width: {{ $totalPayments > 0 ? ($failedPayments/$totalPayments)*100 : 0 }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection 