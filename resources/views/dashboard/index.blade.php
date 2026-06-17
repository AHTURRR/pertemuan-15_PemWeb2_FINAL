@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="d-flex flex-column flex-md-row align-items-start align-items-md-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Dashboard Perpustakaan</h1>
            <p class="text-muted mb-0">Ringkasan aktivitas dan data terbaru perpustakaan.</p>
        </div>
        <div class="mt-3 mt-md-0 d-flex flex-wrap gap-2">
            <a href="{{ route('buku.index') }}" class="btn btn-primary btn-sm">
                <i class="bi bi-book"></i> Kelola Buku
            </a>
            <a href="{{ route('anggota.index') }}" class="btn btn-success btn-sm">
                <i class="bi bi-people"></i> Kelola Anggota
            </a>
            <a href="{{ url('/kategori') }}" class="btn btn-outline-secondary btn-sm">
                <i class="bi bi-tags"></i> Kategori
            </a>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-primary text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-white-50">Total Buku</p>
                            <h3 class="mb-0">{{ $statistikBuku['total_buku'] }}</h3>
                        </div>
                        <i class="bi bi-collection fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-white-50">Buku Tersedia</p>
                            <h3 class="mb-0">{{ $statistikBuku['buku_tersedia'] }}</h3>
                        </div>
                        <i class="bi bi-check2-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-white-50">Buku Habis</p>
                            <h3 class="mb-0">{{ $statistikBuku['buku_habis'] }}</h3>
                        </div>
                        <i class="bi bi-x-circle fs-2"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Total Anggota</p>
                            <h3 class="mb-0">{{ $statistikAnggota['total_anggota'] }}</h3>
                        </div>
                        <i class="bi bi-people fs-2 text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Anggota Aktif</p>
                            <h3 class="mb-0">{{ $statistikAnggota['anggota_aktif'] }}</h3>
                        </div>
                        <i class="bi bi-person-check fs-2 text-success"></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="mb-1 text-muted">Anggota Nonaktif</p>
                            <h3 class="mb-0">{{ $statistikAnggota['anggota_nonaktif'] }}</h3>
                        </div>
                        <i class="bi bi-person-x fs-2 text-danger"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">5 Buku Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th class="text-end">Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bukuTerbaru as $buku)
                                    <tr>
                                        <td>{{ $buku['judul'] }}</td>
                                        <td>{{ $buku['pengarang'] }}</td>
                                        <td class="text-end">{{ $buku['tahun'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white">
                    <h5 class="mb-0">5 Anggota Terbaru</h5>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-striped mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggotaTerbaru as $anggota)
                                    <tr>
                                        <td>{{ $anggota['kode'] }}</td>
                                        <td>{{ $anggota['nama'] }}</td>
                                        <td class="text-end">
                                            <span class="badge {{ $anggota['status'] === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $anggota['status'] }}
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
    </div>
@endsection
