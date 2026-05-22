@extends('layouts.app')

@section('title', 'Hasil Pencarian: ' . $keyword)

@section('content')
<div class="mb-4">
    <a href="{{ route('kategori.index') }}" class="btn btn-sm btn-secondary mb-3">&laquo; Kembali ke Daftar Kategori</a>
    <h4>Hasil Pencarian untuk: <span class="text-primary">"{{ $keyword }}"</span></h4>
</div>

@if($hasil_pencarian->isEmpty())
    <div class="alert alert-warning">
        Maaf, tidak ada kategori yang cocok dengan kata kunci <strong>{{ $keyword }}</strong>.
    </div>
@else
    <div class="row">
        @foreach($hasil_pencarian as $kategori)
        <div class="col-md-4 mb-4">
            <div class="card h-100 shadow-sm border-0 border-start border-primary border-4">
                <div class="card-body">
                    <!-- Highlighting Keyword menggunakan str_ireplace -->
                    <h5 class="card-title fw-bold">
                        {!! str_ireplace($keyword, "<mark class='bg-warning p-0'>$keyword</mark>", $kategori['nama']) !!}
                    </h5>
                    <p class="card-text text-muted">
                        {!! str_ireplace($keyword, "<mark class='bg-warning p-0'>$keyword</mark>", $kategori['deskripsi']) !!}
                    </p>
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="badge bg-secondary">{{ $kategori['jumlah_buku'] }} Buku</span>
                        <a href="{{ route('kategori.show', $kategori['id']) }}" class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif
@endsection