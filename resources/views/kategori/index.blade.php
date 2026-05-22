@extends('layouts.app')

@section('title', 'Daftar Kategori Buku')

@section('content')
<div class="mb-4 d-flex justify-content-between align-items-center">
    <h2>Daftar Kategori Buku</h2>
    
    <!-- Fitur Simulasi Search (Opsional, untuk mempermudah tes route search) -->
    <div class="input-group w-25">
        <input type="text" id="searchInput" class="form-control" placeholder="Cari mis: Programming...">
        <button class="btn btn-primary" onclick="window.location.href='/kategori/search/' + document.getElementById('searchInput').value">Cari</button>
    </div>
</div>

<div class="row">
    @foreach($kategori_list as $kategori)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title text-primary fw-bold">{{ $kategori['nama'] }}</h5>
                <p class="card-text text-muted">{{ $kategori['deskripsi'] }}</p>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <span class="badge bg-secondary">{{ $kategori['jumlah_buku'] }} Buku</span>
                    <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>
@endsection 