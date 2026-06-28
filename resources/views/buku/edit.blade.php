@extends('layouts.app')

@section('title', 'Edit Buku')

@section('content')
    <x-page-header
        title="Edit Buku"
        subtitle="Perbarui informasi buku dengan hati-hati agar data koleksi tetap akurat."
        icon="bi-pencil-square"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Buku', 'url' => route('buku.index')],
            ['label' => $buku->judul, 'url' => route('buku.show', $buku->id)],
            ['label' => 'Edit'],
        ]"
    />

    <form action="{{ route('buku.update', $buku->id) }}" method="POST" data-loading="true">
        @csrf
        @method('PUT')

        <div class="app-card">
            <h3 class="h5 fw-bold mb-1">Informasi Utama</h3>
            <p class="text-muted mb-4">Pastikan kode, judul, dan identitas buku sudah benar.</p>

            <div class="row g-4">
                <div class="col-md-4">
                    <label for="kode_buku" class="form-label required">Kode Buku</label>
                    <input type="text" name="kode_buku" id="kode_buku" required class="form-control @error('kode_buku') is-invalid @enderror" value="{{ old('kode_buku', $buku->kode_buku) }}">
                    @error('kode_buku') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8">
                    <label for="judul" class="form-label required">Judul Buku</label>
                    <input type="text" name="judul" id="judul" required class="form-control @error('judul') is-invalid @enderror" value="{{ old('judul', $buku->judul) }}">
                    @error('judul') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="kategori" class="form-label required">Kategori</label>
                    <select name="kategori" id="kategori" required class="form-select @error('kategori') is-invalid @enderror">
                        @foreach (['Programming', 'Database', 'Web Design', 'Networking', 'Data Science'] as $kategori)
                            <option value="{{ $kategori }}" @selected(old('kategori', $buku->kategori) == $kategori)>{{ $kategori }}</option>
                        @endforeach
                    </select>
                    @error('kategori') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="pengarang" class="form-label required">Pengarang</label>
                    <input type="text" name="pengarang" id="pengarang" required class="form-control @error('pengarang') is-invalid @enderror" value="{{ old('pengarang', $buku->pengarang) }}">
                    @error('pengarang') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="penerbit" class="form-label required">Penerbit</label>
                    <input type="text" name="penerbit" id="penerbit" required class="form-control @error('penerbit') is-invalid @enderror" value="{{ old('penerbit', $buku->penerbit) }}">
                    @error('penerbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="app-card">
            <h3 class="h5 fw-bold mb-1">Detail Koleksi</h3>
            <p class="text-muted mb-4">Perubahan stok akan memengaruhi status ketersediaan buku.</p>

            <div class="row g-4">
                <div class="col-md-3">
                    <label for="tahun_terbit" class="form-label required">Tahun Terbit</label>
                    <input type="number" name="tahun_terbit" id="tahun_terbit" required min="1900" max="{{ date('Y') }}" class="form-control @error('tahun_terbit') is-invalid @enderror" value="{{ old('tahun_terbit', $buku->tahun_terbit) }}">
                    @error('tahun_terbit') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-3">
                    <label for="isbn" class="form-label">ISBN</label>
                    <input type="text" name="isbn" id="isbn" class="form-control @error('isbn') is-invalid @enderror" value="{{ old('isbn', $buku->isbn) }}" placeholder="Opsional">
                    @error('isbn') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label for="bahasa" class="form-label required">Bahasa</label>
                    <select name="bahasa" id="bahasa" required class="form-select @error('bahasa') is-invalid @enderror">
                        <option value="Indonesia" @selected(old('bahasa', $buku->bahasa) == 'Indonesia')>Indonesia</option>
                        <option value="Inggris" @selected(old('bahasa', $buku->bahasa) == 'Inggris')>Inggris</option>
                    </select>
                    @error('bahasa') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label for="harga" class="form-label required">Harga</label>
                    <input type="number" name="harga" id="harga" required min="0" step="1000" class="form-control @error('harga') is-invalid @enderror" value="{{ old('harga', $buku->harga) }}">
                    @error('harga') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-2">
                    <label for="stok" class="form-label required">Stok</label>
                    <input type="number" name="stok" id="stok" required min="0" class="form-control @error('stok') is-invalid @enderror" value="{{ old('stok', $buku->stok) }}">
                    @error('stok') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea name="deskripsi" id="deskripsi" rows="4" class="form-control @error('deskripsi') is-invalid @enderror">{{ old('deskripsi', $buku->deskripsi) }}</textarea>
                    @error('deskripsi') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="app-card">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-info-circle text-primary fs-4"></i>
                <div class="text-muted small">
                    <strong class="text-dark">Informasi Audit</strong><br>
                    Ditambahkan: {{ $buku->created_at->format('d M Y H:i') }} · Terakhir diperbarui: {{ $buku->updated_at->format('d M Y H:i') }}
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
            <a href="{{ route('buku.show', $buku->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save"></i> Update Buku
            </button>
        </div>
    </form>
@endsection
