@extends('layouts.app')

@section('title', 'Detail Kategori: ' . $kategori['nama'])

@section('content')
<!-- Breadcrumb Navigation -->
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="{{ route('kategori.index') }}">Kategori Buku</a></li>
        <li class="breadcrumb-item active" aria-current="page">{{ $kategori['nama'] }}</li>
    </ol>
</nav>

<!-- Info Kategori -->
<div class="card border-0 shadow-sm mb-4 bg-white">
    <div class="card-body">
        <h3 class="fw-bold">{{ $kategori['nama'] }}</h3>
        <p class="text-muted mb-0">{{ $kategori['deskripsi'] }}</p>
        <span class="badge bg-info text-dark mt-2">Total: {{ $kategori['jumlah_buku'] }} Buku Terdaftar</span>
    </div>
</div>

<!-- Tabel Buku -->
<h4>Buku dalam kategori ini</h4>
<div class="card shadow-sm border-0">
    <div class="card-body p-0">
        <table class="table table-striped table-hover mb-0">
            <thead class="table-dark">
                <tr>
                    <th>No</th>
                    <th>Kode Buku</th>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Tahun Terbit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($buku_list as $buku)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $buku['kode'] }}</td>
                    <td><strong>{{ $buku['judul'] }}</strong></td>
                    <td>{{ $buku['pengarang'] }}</td>
                    <td>{{ $buku['tahun'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection