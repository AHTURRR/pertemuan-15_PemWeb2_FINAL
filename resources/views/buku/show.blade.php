@extends('layouts.app')

@section('title', $buku->judul)

@section('content')
    <x-page-header
        :title="$buku->judul"
        subtitle="Ringkasan detail buku, status stok, dan aksi pengelolaan koleksi."
        icon="bi-book"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Buku', 'url' => route('buku.index')],
            ['label' => $buku->judul],
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="app-card">
                <div class="d-flex flex-wrap align-items-center gap-2 mb-4">
                    <span class="badge bg-primary-subtle text-primary">{{ $buku->kategori }}</span>
                    @if ($buku->stok > 0)
                        <span class="badge bg-success">Tersedia</span>
                    @else
                        <span class="badge bg-danger">Habis</span>
                    @endif
                    <span class="badge bg-info text-dark">{{ $buku->bahasa }}</span>
                </div>

                <h3 class="h5 fw-bold mb-3">Informasi Buku</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Kode Buku</div>
                            <div class="fw-bold">{{ $buku->kode_buku }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Pengarang</div>
                            <div class="fw-bold">{{ $buku->pengarang }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Penerbit</div>
                            <div class="fw-bold">{{ $buku->penerbit }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Tahun Terbit</div>
                            <div class="fw-bold">{{ $buku->tahun_terbit }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">ISBN</div>
                            <div class="fw-bold">{{ $buku->isbn ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Harga</div>
                            <div class="fw-bold text-success">{{ $buku->harga_format }}</div>
                        </div>
                    </div>
                </div>

                <hr class="my-4">

                <h3 class="h5 fw-bold mb-2">Deskripsi</h3>
                <p class="text-muted mb-0">{{ $buku->deskripsi ?: 'Belum ada deskripsi untuk buku ini.' }}</p>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="app-card">
                <h3 class="h5 fw-bold mb-3">Status Stok</h3>
                <div class="d-flex align-items-center gap-3 mb-3">
                    <span class="page-icon {{ $buku->stok > 0 ? 'text-success bg-success-subtle' : 'text-danger bg-danger-subtle' }}">
                        <i class="bi {{ $buku->stok > 0 ? 'bi-check-circle' : 'bi-x-circle' }}"></i>
                    </span>
                    <div>
                        <div class="display-6 fw-bold">{{ $buku->stok }}</div>
                        <div class="text-muted">eksemplar tersedia</div>
                    </div>
                </div>

                @if ($buku->stok == 0)
                    <div class="alert alert-danger mb-0">
                        <i class="bi bi-exclamation-triangle"></i> Buku sedang tidak tersedia.
                    </div>
                @elseif ($buku->stok <= 5)
                    <div class="alert alert-warning mb-0">
                        <i class="bi bi-exclamation-circle"></i> Stok menipis, pertimbangkan penambahan koleksi.
                    </div>
                @else
                    <div class="alert alert-success mb-0">
                        <i class="bi bi-check-circle"></i> Stok aman untuk peminjaman.
                    </div>
                @endif
            </div>

            <div class="app-card">
                <h3 class="h5 fw-bold mb-3">Aksi</h3>
                <div class="d-grid gap-2">
                    <a href="{{ route('buku.edit', $buku->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Buku
                    </a>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-success {{ $buku->stok <= 0 ? 'disabled' : '' }}">
                        <i class="bi bi-bookmark-plus"></i> Pinjam Buku
                    </a>
                    <form action="{{ route('buku.destroy', $buku->id) }}" method="POST"
                        data-confirm
                        data-confirm-title="Hapus Buku"
                        data-confirm-text="Apakah Anda yakin ingin menghapus buku '{{ $buku->judul }}'?"
                        data-confirm-button="Ya, Hapus">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Hapus Buku
                        </button>
                    </form>
                </div>
            </div>

            <div class="app-card">
                <h3 class="h5 fw-bold mb-3">Buku Serupa</h3>
                @php
                    $bukuSerupa = App\Models\Buku::where('kategori', $buku->kategori)
                        ->where('id', '!=', $buku->id)
                        ->take(3)
                        ->get();
                @endphp

                @forelse ($bukuSerupa as $item)
                    <a href="{{ route('buku.show', $item->id) }}" class="d-block text-decoration-none mb-3">
                        <div class="fw-bold text-dark">{{ Str::limit($item->judul, 42) }}</div>
                        <small class="text-muted">{{ $item->pengarang }}</small>
                    </a>
                @empty
                    <p class="text-muted mb-0">Tidak ada buku serupa.</p>
                @endforelse
            </div>
        </div>
    </div>
@endsection
