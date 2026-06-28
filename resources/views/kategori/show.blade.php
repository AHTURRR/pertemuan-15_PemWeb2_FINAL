@extends('layouts.app')

@section('title', 'Detail Kategori')

@section('content')
    <x-page-header
        :title="$kategori['nama']"
        :subtitle="$kategori['deskripsi']"
        icon="bi-tag"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Kategori', 'url' => route('kategori.index')],
            ['label' => $kategori['nama']],
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('kategori.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="stat-grid">
        <x-stat-card label="Total Buku" :value="$kategori['jumlah_buku']" icon="bi-journal-bookmark" variant="primary" />
        <x-stat-card label="Data Contoh" :value="count($buku_list)" icon="bi-table" variant="info" />
        <x-stat-card label="Kategori" value="Aktif" icon="bi-check-circle" variant="success" />
        <x-stat-card label="Tipe Data" value="Master" icon="bi-database" variant="warning" />
    </div>

    <div class="app-card table-card">
        <div class="table-toolbar">
            <div>
                <h3 class="h5 fw-bold mb-1">Buku dalam Kategori Ini</h3>
                <p class="text-muted mb-0">Daftar buku contoh untuk kategori {{ $kategori['nama'] }}.</p>
            </div>
            <div class="input-group search-box">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" placeholder="Cari buku..." data-table-search="#kategoriDetailTable">
            </div>
        </div>

        @if (count($buku_list))
            <div class="table-responsive">
                <table class="table align-middle" id="kategoriDetailTable">
                    <thead>
                        <tr>
                            <th>Kode Buku</th>
                            <th>Judul Buku</th>
                            <th>Pengarang</th>
                            <th class="text-end">Tahun</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($buku_list as $buku)
                            <tr>
                                <td><code>{{ $buku['kode'] }}</code></td>
                                <td class="fw-bold">{{ $buku['judul'] }}</td>
                                <td>{{ $buku['pengarang'] }}</td>
                                <td class="text-end">{{ $buku['tahun'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state title="Belum ada buku" message="Belum ada buku pada kategori ini." icon="bi-journal" />
        @endif
    </div>
@endsection
