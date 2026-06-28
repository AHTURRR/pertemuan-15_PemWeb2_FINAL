@extends('layouts.app')

@section('title', 'Daftar Kategori Buku')

@section('content')
    <x-page-header
        title="Daftar Kategori Buku"
        subtitle="Kelompokkan koleksi agar pencarian dan pengelolaan buku lebih mudah."
        icon="bi-tags"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Kategori'],
        ]"
    />

    <div class="app-card">
        <div class="table-toolbar">
            <div>
                <h3 class="h5 fw-bold mb-1">Kategori Koleksi</h3>
                <p class="text-muted mb-0">Menampilkan {{ count($kategori_list) }} kategori buku.</p>
            </div>
            <div class="input-group search-box">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" placeholder="Cari kategori..." data-table-search="#kategoriTable">
            </div>
        </div>

        @if (count($kategori_list))
            <div class="row g-4" id="kategoriTable">
                @foreach ($kategori_list as $kategori)
                    <div class="col-md-6 col-xl-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-start gap-3 mb-3">
                                    <span class="page-icon"><i class="bi bi-tag"></i></span>
                                    <span class="badge bg-primary-subtle text-primary">{{ $kategori['jumlah_buku'] }} Buku</span>
                                </div>
                                <h3 class="h5 fw-bold">{{ $kategori['nama'] }}</h3>
                                <p class="text-muted">{{ $kategori['deskripsi'] }}</p>
                                <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-eye"></i> Lihat Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <x-empty-state title="Belum ada kategori" message="Kategori akan membantu pengelompokan koleksi buku." icon="bi-tags" />
        @endif
    </div>
@endsection
