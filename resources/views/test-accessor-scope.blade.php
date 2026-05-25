@extends('layouts.app')

@section('title', 'Testing Accessor & Scope')

@section('content')
<div class="mb-5">
    <h1 class="display-5 fw-bold mb-4">
        <i class="bi bi-tools"></i> Testing Accessor & Scope
    </h1>
    <p class="text-muted">Demonstrasi penggunaan Accessor dan Scope pada Model Eloquent</p>
</div>

<!-- ===== SECTION 1: ACCESSOR BUKU ===== -->
<section class="mb-5">
    <div class="section-header mb-4">
        <h2 class="h3 border-bottom pb-3">
            <span class="badge bg-primary">1</span> Accessor: Daftar Buku
        </h2>
    </div>
    
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Judul</th>
                    <th>Stok</th>
                    <th>Status Stok</th>
                    <th>Tahun Terbit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($bukus as $b)
                <tr class="align-middle">
                    <td class="fw-500">{{ $b->judul }}</td>
                    <td>
                        <span class="badge bg-info">{{ $b->stok }}</span>
                    </td>
                    <td>
                        {!! $b->status_stok_badge !!}
                    </td>
                    <td>
                        <small class="text-muted">{{ $b->tahun_label }}</small>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</section>

<!-- ===== SECTION 2: SCOPE BUKU TERBARU ===== -->
<section class="mb-5">
    <div class="section-header mb-4">
        <h2 class="h3 border-bottom pb-3">
            <span class="badge bg-success">2</span> Scope: Buku Terbaru (Tahun >= 2024)
        </h2>
    </div>
    
    <div class="row">
        @forelse($bukuTerbaru as $b)
        <div class="col-md-6 col-lg-4 mb-3">
            <div class="card h-100 border-0 shadow-sm card-hover">
                <div class="card-body">
                    <h5 class="card-title">{{ $b->judul }}</h5>
                    <p class="card-text text-muted small">
                        Tahun: <strong>{{ $b->tahun_terbit }}</strong>
                    </p>
                    <p class="card-text text-muted small">
                        Pengarang: {{ $b->pengarang }}
                    </p>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">Tidak ada buku terbaru ditemukan.</div>
        </div>
        @endforelse
    </div>
</section>

<!-- ===== SECTION 3: SCOPE STOK MENIPIS ===== -->
<section class="mb-5">
    <div class="section-header mb-4">
        <h2 class="h3 border-bottom pb-3">
            <span class="badge bg-warning">3</span> Scope: Buku Stok Menipis (< 5)
        </h2>
    </div>
    
    <div class="alert alert-warning" role="alert">
        <strong>⚠️ Perhatian:</strong> Stok buku-buku berikut menipis dan perlu segera dipesok ulang.
    </div>
    
    @forelse($bukuMenipis as $b)
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ $b->judul }}</strong>
        <br>
        <small>Stok sisa: <strong class="text-danger">{{ $b->stok }}</strong> unit</small>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @empty
    <div class="alert alert-success">
        ✅ Semua stok buku dalam kondisi baik, tidak ada yang menipis.
    </div>
    @endforelse
</section>

<hr class="my-5">

<!-- ===== SECTION 4: ACCESSOR ANGGOTA ===== -->
<section class="mb-5">
    <div class="section-header mb-4">
        <h2 class="h3 border-bottom pb-3">
            <span class="badge bg-info">4</span> Accessor: Daftar Anggota
        </h2>
    </div>
    
    <div class="row">
        @foreach($anggotas as $a)
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="card h-100 border-0 shadow-sm card-anggota">
                <div class="card-header bg-light border-bottom">
                    <h5 class="card-title mb-0">{{ $a->nama }}</h5>
                </div>
                <div class="card-body">
                    <p class="card-text">
                        <strong>Status:</strong><br>
                        {!! $a->status_badge !!}
                    </p>
                    <p class="card-text mt-3">
                        <strong>Kategori Usia:</strong><br>
                        <span class="badge bg-secondary">{{ $a->kategori_usia }}</span>
                    </p>
                    <hr>
                    <p class="card-text small text-muted">
                        <strong>Kontak:</strong><br>
                        📧 {{ $a->email }}<br>
                        📞 {{ $a->telepon }}
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- ===== SECTION 5: SCOPE ANGGOTA BARU ===== -->
<section class="mb-5">
    <div class="section-header mb-4">
        <h2 class="h3 border-bottom pb-3">
            <span class="badge bg-secondary">5</span> Scope: Anggota Terdaftar Bulan Ini
        </h2>
    </div>
    
    @if($anggotaBaru->count() > 0)
    <div class="timeline">
        @foreach($anggotaBaru as $a)
        <div class="timeline-item mb-4">
            <div class="timeline-marker">
                <span class="badge bg-success">✓</span>
            </div>
            <div class="timeline-content">
                <h5>{{ $a->nama }}</h5>
                <p class="text-muted">
                    Terdaftar: <strong>{{ $a->tanggal_daftar->format('d M Y') }}</strong>
                </p>
            </div>
        </div>
        @endforeach
    </div>
    @else
    <div class="alert alert-info">
        Tidak ada anggota baru yang terdaftar bulan ini.
    </div>
    @endif
</section>

<div class="mb-5 pb-5">
    <hr>
    <p class="text-center text-muted small">
        <em>Testing Accessor & Scope - Laravel Eloquent ORM</em>
    </p>
</div>

@endsection
