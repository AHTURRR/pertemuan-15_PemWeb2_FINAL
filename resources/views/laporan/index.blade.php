@extends('layouts.app')
@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Laporan Transaksi</h2>
            <p class="text-muted mb-0">
                Laporan seluruh transaksi perpustakaan
            </p>
        </div>
    </div>

    {{-- Card Filter --}}
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-header bg-primary text-white">
            <strong><i class="bi bi-funnel"></i> Filter Laporan</strong>
        </div>
        <div class="card-body">
            <form method="GET" action="{{ route('laporan.index') }}">
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="dari" class="form-control"
                               value="{{ request('dari') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="sampai" class="form-control"
                               value="{{ request('sampai') }}">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="">Semua</option>
                            <option value="Dipinjam" {{ request('status') == 'Dipinjam' ? 'selected' : '' }}>Dipinjam</option>
                            <option value="Dikembalikan" {{ request('status') == 'Dikembalikan' ? 'selected' : '' }}>Dikembalikan</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label">Anggota</label>
                        <select name="anggota_id" class="form-select">
                            <option value="">Semua Anggota</option>
                            @foreach($anggotas as $anggota)
                                <option value="{{ $anggota->id }}" {{ request('anggota_id') == $anggota->id ? 'selected' : '' }}>
                                    {{ $anggota->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="mt-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-filter"></i> Filter
                    </button>
                    <a href="{{ route('laporan.index') }}" class="btn btn-secondary">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </a>
                    <a href="{{ route('laporan.pdf', request()->query()) }}" class="btn btn-danger">
                        <i class="bi bi-file-earmark-pdf"></i> Export PDF
                    </a>
                    <button type="button" class="btn btn-success" onclick="window.print()">
                        <i class="bi bi-printer"></i> Cetak
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body text-center">
                    <h6 class="mb-1">Total Transaksi</h6>
                    <h3 class="mb-0 fw-bold">{{ $summary['total'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-warning text-dark">
                <div class="card-body text-center">
                    <h6 class="mb-1">Dipinjam</h6>
                    <h3 class="mb-0 fw-bold">{{ $summary['dipinjam'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body text-center">
                    <h6 class="mb-1">Dikembalikan</h6>
                    <h3 class="mb-0 fw-bold">{{ $summary['dikembalikan'] }}</h3>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body text-center">
                    <h6 class="mb-1">Total Denda</h6>
                    <h3 class="mb-0 fw-bold">Rp {{ number_format($summary['total_denda'], 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    {{-- Tabel Laporan --}}
    <div class="card shadow-sm border-0">
        <div class="card-header">
            <strong><i class="bi bi-table"></i> Data Transaksi</strong>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>No</th>
                            <th>Kode</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                            <th>Denda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksis as $trx)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trx->kode_transaksi }}</td>
                            <td>{{ optional($trx->anggota)->nama ?? '-' }}</td>
                            <td>{{ optional($trx->buku)->judul ?? '-' }}</td>
                            <td>{{ optional($trx->tanggal_pinjam)->format('d/m/Y') ?? '-' }}</td>
                            <td>{{ $trx->tanggal_dikembalikan?->format('d/m/Y') ?? '-' }}</td>
                            <td>{!! $trx->status_badge !!}</td>
                            <td>Rp {{ number_format($trx->nominal_denda, 0, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted">Tidak ada data transaksi.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

{{-- Print CSS --}}
<style>
@media print {
    .card-body form, .btn, nav, footer, .sidebar, .topbar { display: none !important; }
    .card { border: none !important; box-shadow: none !important; }
    .app-main { margin-left: 0 !important; }
}
</style>
@endsection