@extends('layouts.app')

@section('title', 'Home')

@section('content')
    <section class="page-title-card">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow mb-2">Sistem Informasi Perpustakaan</p>
                <h2 class="page-title display-5">Kelola buku, anggota, dan transaksi perpustakaan dengan lebih mudah.</h2>
                <p class="page-subtitle mt-3">
                    Pustaka membantu petugas memantau koleksi, peminjaman, pengembalian, dan status anggota dalam alur kerja yang jelas.
                </p>
                <div class="d-flex flex-wrap gap-2 mt-4">
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        <i class="bi bi-box-arrow-in-right"></i> Masuk Aplikasi
                    </a>
                    <a href="{{ route('register') }}" class="btn btn-outline-primary">
                        <i class="bi bi-person-plus"></i> Daftar
                    </a>
                </div>
            </div>
            <div class="col-lg-5">
                <div class="app-card mb-0">
                    <div class="timeline-item mb-3">
                        <span class="timeline-dot"><i class="bi bi-journal-bookmark"></i></span>
                        <div>
                            <div class="fw-bold">Master Data</div>
                            <div class="text-muted small">Buku, anggota, dan kategori rapi dalam satu sistem.</div>
                        </div>
                    </div>
                    <div class="timeline-item mb-3">
                        <span class="timeline-dot"><i class="bi bi-arrow-left-right"></i></span>
                        <div>
                            <div class="fw-bold">Transaksi</div>
                            <div class="text-muted small">Peminjaman dan pengembalian lebih mudah dipantau.</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-dot"><i class="bi bi-bar-chart"></i></span>
                        <div>
                            <div class="fw-bold">Dashboard</div>
                            <div class="text-muted small">Statistik dan aktivitas terbaru tersedia cepat.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="row g-4">
        <div class="col-md-4">
            <div class="app-card h-100">
                <span class="page-icon mb-3"><i class="bi bi-book"></i></span>
                <h3 class="h5 fw-bold">Kelola Buku</h3>
                <p class="text-muted">Pantau koleksi, stok, kategori, harga, dan informasi detail buku.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="app-card h-100">
                <span class="page-icon mb-3"><i class="bi bi-people"></i></span>
                <h3 class="h5 fw-bold">Kelola Anggota</h3>
                <p class="text-muted">Data anggota aktif dan nonaktif tersusun jelas untuk proses peminjaman.</p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="app-card h-100">
                <span class="page-icon mb-3"><i class="bi bi-arrow-left-right"></i></span>
                <h3 class="h5 fw-bold">Transaksi</h3>
                <p class="text-muted">Alur peminjaman dan pengembalian dibuat lebih jelas dan mudah dipahami.</p>
            </div>
        </div>
    </div>
@endsection
