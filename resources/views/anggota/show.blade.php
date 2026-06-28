@extends('layouts.app')

@section('title', $anggota->nama)

@section('content')
    <x-page-header
        :title="$anggota->nama"
        subtitle="Ringkasan profil anggota, status keanggotaan, dan aksi pengelolaan."
        icon="bi-person-circle"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Anggota', 'url' => route('anggota.index')],
            ['label' => $anggota->nama],
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-warning">
                <i class="bi bi-pencil"></i> Edit
            </a>
            <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="app-card">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4">
                    <span class="page-icon {{ $anggota->jenis_kelamin === 'Laki-laki' ? 'text-primary bg-primary-subtle' : 'text-danger bg-danger-subtle' }}">
                        <i class="bi bi-person"></i>
                    </span>
                    <div>
                        <h3 class="h4 fw-bold mb-1">{{ $anggota->nama }}</h3>
                        <div class="d-flex flex-wrap gap-2">
                            {!! $anggota->status_badge !!}
                            <span class="badge bg-info text-dark">{{ $anggota->kategori_usia }}</span>
                        </div>
                    </div>
                </div>

                <h3 class="h5 fw-bold mb-3">Informasi Anggota</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Kode Anggota</div>
                            <div class="fw-bold"><code>{{ $anggota->kode_anggota }}</code></div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Email</div>
                            <div class="fw-bold">{{ $anggota->email }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Telepon</div>
                            <div class="fw-bold">{{ $anggota->telepon }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Jenis Kelamin</div>
                            <div class="fw-bold">{{ $anggota->jenis_kelamin }}</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Tanggal Lahir</div>
                            <div class="fw-bold">{{ $anggota->tanggal_lahir->format('d F Y') }} · {{ $anggota->umur }} tahun</div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Pekerjaan</div>
                            <div class="fw-bold">{{ $anggota->pekerjaan ?: '-' }}</div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="p-3 rounded-4 bg-light">
                            <div class="text-muted small">Alamat</div>
                            <div class="fw-bold">{{ $anggota->alamat }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="app-card">
                <h3 class="h5 fw-bold mb-3">Status Keanggotaan</h3>
                <div class="timeline-item">
                    <span class="timeline-dot"><i class="bi bi-calendar-check"></i></span>
                    <div>
                        <div class="fw-bold">Terdaftar</div>
                        <div class="text-muted small">{{ $anggota->tanggal_daftar->format('d F Y') }}</div>
                    </div>
                </div>
                <div class="timeline-item mt-3">
                    <span class="timeline-dot"><i class="bi bi-hourglass-split"></i></span>
                    <div>
                        <div class="fw-bold">{{ $anggota->lama_anggota }} hari</div>
                        <div class="text-muted small">Lama menjadi anggota</div>
                    </div>
                </div>
            </div>

            <div class="app-card">
                <h3 class="h5 fw-bold mb-3">Aksi</h3>
                <div class="d-grid gap-2">
                    <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-warning">
                        <i class="bi bi-pencil"></i> Edit Anggota
                    </a>
                    <a href="{{ route('transaksi.create') }}" class="btn btn-success {{ $anggota->status !== 'Aktif' ? 'disabled' : '' }}">
                        <i class="bi bi-bookmark-plus"></i> Buat Peminjaman
                    </a>
                    <form action="{{ route('anggota.destroy', $anggota->id) }}" method="POST"
                        data-confirm
                        data-confirm-title="Hapus Anggota"
                        data-confirm-text="Apakah Anda yakin ingin menghapus anggota '{{ $anggota->nama }}'?"
                        data-confirm-button="Ya, Hapus">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="bi bi-trash"></i> Hapus Anggota
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
