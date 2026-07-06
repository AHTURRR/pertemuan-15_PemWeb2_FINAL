@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')
<div class="container-fluid py-4">
    <h2 class="mb-4">Dashboard Perpustakaan</h2>

    {{-- Quick Actions --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-lightning-charge text-primary me-2"></i> Akses Cepat (Quick Actions)</h5>
        </div>
        <div class="card-body">
            <div class="row g-3">
                <div class="col-6 col-md-3">
                    <a href="{{ route('transaksi.create') }}" class="btn btn-outline-primary py-3 w-100 d-flex flex-column align-items-center justify-content-center gap-2">
                        <i class="bi bi-bookmark-plus fs-3"></i>
                        <span class="fw-semibold small">Peminjaman Baru</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('buku.create') }}" class="btn btn-outline-success py-3 w-100 d-flex flex-column align-items-center justify-content-center gap-2">
                        <i class="bi bi-journal-plus fs-3"></i>
                        <span class="fw-semibold small">Tambah Buku</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('anggota.create') }}" class="btn btn-outline-info py-3 w-100 d-flex flex-column align-items-center justify-content-center gap-2">
                        <i class="bi bi-person-plus fs-3"></i>
                        <span class="fw-semibold small">Tambah Anggota</span>
                    </a>
                </div>
                <div class="col-6 col-md-3">
                    <a href="{{ route('laporan.index') }}" class="btn btn-outline-danger py-3 w-100 d-flex flex-column align-items-center justify-content-center gap-2">
                        <i class="bi bi-file-earmark-bar-graph fs-3"></i>
                        <span class="fw-semibold small">Laporan Transaksi</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row g-3 mb-4">
        @foreach([
            ['Total Buku', $stats['total_buku'], 'bi-book', 'primary'],
            ['Anggota Aktif', $stats['total_anggota'], 'bi-people', 'success'],
            ['Sedang Dipinjam', $stats['sedang_dipinjam'], 'bi-journal-arrow-up', 'info'],
            ['Terlambat', $stats['terlambat'], 'bi-exclamation-triangle', 'danger'],
            ['Transaksi Hari Ini', $stats['transaksi_hari_ini'], 'bi-calendar-check', 'warning'],
            ['Buku Tersedia', $stats['buku_tersedia'], 'bi-bookshelf', 'secondary'],
            ['Total Transaksi', $stats['total_transaksi'], 'bi-receipt', 'dark'],
            ['Denda Bulan Ini', 'Rp ' . number_format($stats['denda_bulan_ini'], 0, ',', '.'), 'bi-cash', 'danger'],
        ] as [$label, $value, $icon, $color])
        <div class="col-xl-3 col-md-6">
            <div class="card border-{{ $color }} h-100">
                <div class="card-body d-flex align-items-center">
                    <i class="bi {{ $icon }} fs-1 text-{{ $color }} me-3"></i>
                    <div>
                        <h6 class="text-muted mb-1">{{ $label }}</h6>
                        <h4 class="mb-0">{{ $value }}</h4>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Charts Row 1 --}}
    <div class="row g-4 mb-4">
        {{-- Trend Peminjaman (Line) --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-graph-up text-primary me-2"></i> Trend Peminjaman (6 Bulan Terakhir)</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartTrendPeminjaman" height="180"></canvas>
                </div>
            </div>
        </div>
        {{-- Kategori Buku (Pie) --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-pie-chart text-success me-2"></i> Kategori Buku</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div style="width: 280px; height: 280px;">
                        <canvas id="chartKategoriBuku"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Charts Row 2 --}}
    <div class="row g-4 mb-4">
        {{-- Top 10 Buku Populer (Bar) --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-bar-chart-line text-warning me-2"></i> Top 10 Buku Terpopuler</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartBukuPopuler" height="180"></canvas>
                </div>
            </div>
        </div>
        {{-- Status Transaksi (Donut) --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-donut-chart text-info me-2"></i> Status Transaksi</h5>
                </div>
                <div class="card-body d-flex align-items-center justify-content-center">
                    <div style="width: 250px; height: 250px;">
                        <canvas id="chartStatusTransaksi"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Data & Notifications Row --}}
    <div class="row g-4 mb-4">
        {{-- Recent Transactions --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-dark"><i class="bi bi-clock-history text-primary me-2"></i> Transaksi Terbaru</h5>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead>
                            <tr>
                                <th>Kode</th>
                                <th>Anggota</th>
                                <th>Buku</th>
                                <th>Tgl Pinjam</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($recentTransaksi as $trx)
                            <tr>
                                <td class="fw-bold">{{ $trx->kode_transaksi }}</td>
                                <td>{{ $trx->anggota->nama ?? '-' }}</td>
                                <td class="text-truncate" style="max-width: 200px;">{{ $trx->buku->judul ?? '-' }}</td>
                                <td>{{ $trx->tanggal_pinjam->format('d/m/Y') }}</td>
                                <td>
                                    <span class="badge bg-{{ $trx->status === 'Dipinjam' ? 'warning text-dark' : 'success' }}">
                                        {{ $trx->status }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        {{-- Buku Terlambat Widget --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 fw-bold text-danger"><i class="bi bi-exclamation-triangle text-danger me-2"></i> Buku Terlambat</h5>
                    <span class="badge bg-danger">{{ $jumlahTerlambat }} Transaksi</span>
                </div>
                <div class="card-body py-1" style="max-height: 380px; overflow-y: auto;">
                    @forelse($terlambat as $trx)
                        <div class="d-flex align-items-center gap-3 py-3 border-bottom last-border-none">
                            <span class="rounded-circle bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 40px; height: 40px; min-width: 40px;">
                                <i class="bi bi-person-exclamation fs-5"></i>
                            </span>
                            <div class="flex-grow-1 min-width-0">
                                <h6 class="mb-0 fw-semibold text-truncate">{{ $trx->anggota->nama ?? '-' }}</h6>
                                <p class="mb-0 text-muted small text-truncate">{{ $trx->buku->judul ?? '-' }}</p>
                            </div>
                            <div class="text-end">
                                <span class="badge bg-danger small">Terlambat {{ $trx->terlambat }} hari</span>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-5 text-muted">
                            <i class="bi-check-circle fs-1 text-success mb-2 d-block"></i>
                            <span>Semua peminjaman aman. Tidak ada buku terlambat.</span>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// 1. Line Chart - Trend Peminjaman (6 bulan terakhir)
new Chart(document.getElementById('chartTrendPeminjaman'), {
    type: 'line',
    data: {
        labels: @json($chartData->pluck('bulan')),
        datasets: [
            { 
                label: 'Peminjaman', 
                data: @json($chartData->pluck('pinjam')),
                borderColor: '#0d6efd', 
                backgroundColor: 'rgba(13, 110, 253, 0.1)',
                fill: true,
                tension: 0.3 
            },
            { 
                label: 'Pengembalian', 
                data: @json($chartData->pluck('kembali')),
                borderColor: '#198754', 
                backgroundColor: 'rgba(25, 135, 84, 0.1)',
                fill: true,
                tension: 0.3 
            }
        ]
    },
    options: { 
        responsive: true,
        plugins: {
            legend: { position: 'top' }
        }
    }
});

// 2. Pie Chart - Kategori Buku
new Chart(document.getElementById('chartKategoriBuku'), {
    type: 'pie',
    data: {
        labels: @json($kategoriChart->pluck('kategori')),
        datasets: [{
            data: @json($kategoriChart->pluck('count')),
            backgroundColor: ['#0d6efd', '#198754', '#ffc107', '#dc3545', '#0dcaf0', '#6f42c1', '#fd7e14']
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});

// 3. Bar Chart - Top 10 Buku Terpopuler
new Chart(document.getElementById('chartBukuPopuler'), {
    type: 'bar',
    data: {
        labels: @json($bukuPopuler->pluck('judul')->map(function($j) { return strlen($j) > 18 ? substr($j, 0, 15) . '...' : $j; })),
        datasets: [{
            label: 'Total Peminjaman',
            data: @json($bukuPopuler->pluck('transaksis_count')),
            backgroundColor: 'rgba(255, 193, 7, 0.85)',
            borderColor: '#ffc107',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { stepSize: 1 }
            }
        },
        plugins: {
            legend: { display: false }
        }
    }
});

// 4. Donut Chart - Status Transaksi
new Chart(document.getElementById('chartStatusTransaksi'), {
    type: 'doughnut',
    data: {
        labels: ['Sedang Dipinjam', 'Sudah Dikembalikan'],
        datasets: [{
            data: [
                {{ $statusChart['dipinjam'] }},
                {{ $statusChart['dikembalikan'] }}
            ],
            backgroundColor: ['#ffc107', '#198754'],
            hoverOffset: 4
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { position: 'bottom' }
        }
    }
});
</script>
@endpush
@endsection
