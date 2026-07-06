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
            </div> {{-- Menutup app-card Profil Anggota --}}

            {{-- Statistik Peminjaman --}}
            <div class="row g-3 mb-4 mt-1">
                <div class="col-md-6">
                    <div class="stat-card stat-primary h-100 mb-0 shadow-sm">
                        <div>
                            <p>Total Peminjaman</p>
                            <h3>{{ $totalPinjam }} Kali</h3>
                        </div>
                        <span class="stat-icon"><i class="bi bi-journal-check"></i></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="stat-card stat-danger h-100 mb-0 shadow-sm">
                        <div>
                            <p>Akumulasi Denda</p>
                            <h3>Rp {{ number_format($totalDenda, 0, ',', '.') }}</h3>
                        </div>
                        <span class="stat-icon"><i class="bi bi-cash-coin"></i></span>
                    </div>
                </div>
            </div>

            {{-- Riwayat Transaksi --}}
            <div class="app-card mb-4">
                <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-4">
                    <h4 class="h5 fw-bold mb-0 text-dark"><i class="bi bi-clock-history text-primary me-2"></i> Riwayat Transaksi</h4>
                    
                    {{-- Filter Status --}}
                    <div class="btn-group btn-group-sm" role="group" aria-label="Filter Status">
                        <a href="{{ route('anggota.show', [$anggota->id]) }}" class="btn {{ !request('status') ? 'btn-primary' : 'btn-outline-primary' }}">Semua</a>
                        <a href="{{ route('anggota.show', [$anggota->id, 'status' => 'Dipinjam']) }}" class="btn {{ request('status') == 'Dipinjam' ? 'btn-primary' : 'btn-outline-primary' }}">Dipinjam</a>
                        <a href="{{ route('anggota.show', [$anggota->id, 'status' => 'Dikembalikan']) }}" class="btn {{ request('status') == 'Dikembalikan' ? 'btn-primary' : 'btn-outline-primary' }}">Dikembalikan</a>
                    </div>
                </div>

                @forelse($transaksis as $trx)
                    <div class="p-3 rounded-4 bg-light mb-3">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-2 pb-2 border-bottom">
                            <div>
                                <span class="fw-bold text-primary">{{ $trx->kode_transaksi }}</span>
                                <span class="text-muted small ms-2">{{ $trx->created_at->format('d M Y H:i') }}</span>
                            </div>
                            <div>
                                <span class="badge bg-{{ $trx->status === 'Dipinjam' ? 'warning text-dark' : 'success' }}">
                                    {{ $trx->status }}
                                </span>
                            </div>
                        </div>
                        
                        <div class="row g-2 small">
                            <div class="col-md-8">
                                <div class="text-muted">Buku</div>
                                <div class="fw-bold text-dark">{{ $trx->buku->judul ?? '-' }}</div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="text-muted">Tgl Pinjam</div>
                                <div class="fw-semibold">{{ $trx->tanggal_pinjam->format('d/m/Y') }}</div>
                            </div>
                            <div class="col-6 col-md-2">
                                <div class="text-muted">Batas Kembali</div>
                                <div class="fw-semibold">{{ $trx->tanggal_kembali->format('d/m/Y') }}</div>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-between align-items-center mt-3 pt-2 border-top small">
                            <div>
                                @if($trx->status === 'Dikembalikan')
                                    <span class="text-success"><i class="bi bi-calendar-check me-1"></i> Dikembalikan: {{ $trx->tanggal_dikembalikan?->format('d/m/Y') }}</span>
                                @else
                                    @if($trx->terlambat > 0)
                                        <span class="text-danger fw-bold"><i class="bi bi-exclamation-circle me-1"></i> Terlambat {{ $trx->terlambat }} hari</span>
                                    @else
                                        @php
                                            $sisaHari = (int) today()->diffInDays($trx->tanggal_kembali, false);
                                        @endphp
                                        <span class="text-info"><i class="bi bi-clock me-1"></i> Sisa waktu: {{ $sisaHari >= 0 ? $sisaHari . ' hari lagi' : 'Hari ini batasnya' }}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="d-flex align-items-center gap-3">
                                @if($trx->nominal_denda > 0)
                                    <span class="text-danger fw-bold">Denda: Rp {{ number_format($trx->nominal_denda, 0, ',', '.') }}</span>
                                @endif
                                <a href="{{ route('transaksi.show', $trx->id) }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-5 text-muted">
                        <i class="bi bi-folder2-open fs-2 mb-2 d-block"></i>
                        <span>Tidak ada riwayat peminjaman dengan status ini.</span>
                    </div>
                @endforelse
            </div>
        </div> {{-- Menutup col-lg-8 --}}

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
    </div> {{-- Menutup row g-4 --}}
@endsection
