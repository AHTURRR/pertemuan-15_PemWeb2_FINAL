@extends('layouts.app')

@section('title', 'Detail Transaksi')

@section('content')
    @php
        $terlambat = $transaksi->terlambat;
        $isDipinjam = $transaksi->status === 'Dipinjam';
    @endphp

    <x-page-header
        title="Detail Transaksi"
        subtitle="Ringkasan lengkap peminjaman, pengembalian, keterlambatan, dan denda."
        icon="bi-receipt"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Transaksi', 'url' => route('transaksi.index')],
            ['label' => $transaksi->kode_transaksi],
        ]"
    >
        <x-slot name="actions">
           {{-- Status Pengembalian --}}
@if($transaksi->status === 'Dipinjam')

    <button type="button" class="btn btn-success" id="btn-kembalikan">
        <i class="bi bi-arrow-return-left"></i> Kembalikan Buku
    </button>

    <form id="form-kembalikan"
          action="{{ route('transaksi.kembalikan', $transaksi->id) }}"
          method="POST"
          class="d-none">
        @csrf
        @method('PUT')
    </form>
@else
    {{-- Status setelah berhasil dikembalikan --}}
    @if($transaksi->tanggal_dikembalikan <= $transaksi->tanggal_kembali)
        <div class="alert alert-success d-flex align-items-start gap-3 shadow-sm border-0">
            <i class="bi bi-check-circle-fill fs-2"></i>
            <div>
                <h5 class="mb-1">
                    Buku Berhasil Dikembalikan
                </h5>

                <p class="mb-1">
                    Buku dikembalikan <strong>tepat waktu</strong>.
                </p>

                <p class="mb-0">
                    Tanggal dikembalikan:
                    <strong>
                        {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                    </strong>
                </p>
            </div>

        </div>

    @else

        <div class="alert alert-warning d-flex align-items-start gap-3 shadow-sm border-0">

            <i class="bi bi-exclamation-triangle-fill fs-2"></i>

            <div>
                <h5 class="mb-1">
                    Buku Berhasil Dikembalikan
                </h5>

                <p class="mb-1">
                    Buku dikembalikan terlambat
                    <strong>{{ $transaksi->terlambat }} hari</strong>.
                </p>

                <p class="mb-1">
                    Tanggal dikembalikan:
                    <strong>
                        {{ $transaksi->tanggal_dikembalikan->format('d M Y') }}
                    </strong>
                </p>

                <p class="mb-0">
                    Denda:
                    <strong>
                        Rp {{ number_format($transaksi->denda, 0, ',', '.') }}
                    </strong>
                </p>
            </div>

        </div>

    @endif

@endif

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.getElementById('btn-kembalikan')?.addEventListener('click', function () {

    Swal.fire({
        title: 'Konfirmasi Pengembalian',
        text: 'Apakah Anda yakin buku ini sudah dikembalikan?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#198754',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Ya, Kembalikan',
        cancelButtonText: 'Batal'
    }).then((result) => {

        if (result.isConfirmed) {
            document.getElementById('form-kembalikan').submit();
        }

    });

});
</script>
@endpush
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </x-slot>
    </x-page-header>
    {{-- Alert jika sudah melewati batas pengembalian --}}
    @if($transaksi->terlambat > 0)
        <div class="alert alert-danger d-flex align-items-start gap-3 shadow-sm border-0 mt-4">
            <i class="bi bi-exclamation-triangle-fill fs-2"></i>
            <div>
                <h5 class="mb-1">
                    Buku Terlambat Dikembalikan
                </h5>
                <p class="mb-1">
                    Buku ini telah melewati batas pengembalian selama
                    <strong>{{ $transaksi->terlambat }} hari</strong>.
                </p>
                <p class="mb-0">
                    Denda saat ini:
                    <strong>
                        Rp {{ number_format($transaksi->nominal_denda, 0, ',', '.') }}
                    </strong>
                </p>
            </div>
        </div>
    @endif

    <div class="stat-grid">
        <x-stat-card label="Status" :value="$terlambat && $isDipinjam ? 'Terlambat' : $transaksi->status" icon="bi-info-circle" :variant="$terlambat && $isDipinjam ? 'danger' : ($isDipinjam ? 'warning' : 'success')" />
        <x-stat-card label="Lama Pinjam" :value="$transaksi->durasi_peminjaman . ' hari'" icon="bi-hourglass-split" variant="info" />
        <x-stat-card label="Keterlambatan" :value="$terlambat . ' hari'" icon="bi-exclamation-triangle" :variant="$terlambat > 0 ? 'danger' : 'success'" />
        <x-stat-card label="Denda" :value="'Rp ' . number_format($transaksi->nominal_denda, 0, ',', '.')" icon="bi-cash-coin" variant="warning" />
    </div>

    <div class="row g-4">
        <div class="col-lg-6">
            <div class="app-card h-100">
                <h3 class="h5 fw-bold mb-3">Informasi Anggota</h3>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="page-icon"><i class="bi bi-person"></i></span>
                    <div>
                        <div class="fw-bold fs-5">{{ $transaksi->anggota->nama }}</div>
                        <div class="text-muted">{{ $transaksi->anggota->kode_anggota }}</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><span class="text-muted small">Email</span><div class="fw-bold">{{ $transaksi->anggota->email }}</div></div></div>
                    <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><span class="text-muted small">Telepon</span><div class="fw-bold">{{ $transaksi->anggota->telepon }}</div></div></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6">
            <div class="app-card h-100">
                <h3 class="h5 fw-bold mb-3">Informasi Buku</h3>
                <div class="d-flex align-items-center gap-3 mb-4">
                    <span class="page-icon"><i class="bi bi-book"></i></span>
                    <div>
                        <div class="fw-bold fs-5">{{ $transaksi->buku->judul }}</div>
                        <div class="text-muted">{{ $transaksi->buku->kode_buku }}</div>
                    </div>
                </div>
                <div class="row g-3">
                    <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><span class="text-muted small">Pengarang</span><div class="fw-bold">{{ $transaksi->buku->pengarang }}</div></div></div>
                    <div class="col-md-6"><div class="p-3 rounded-4 bg-light"><span class="text-muted small">Kategori</span><div class="fw-bold">{{ $transaksi->buku->kategori }}</div></div></div>
                </div>
            </div>
        </div>
    </div>

    <div class="app-card">
        <h3 class="h5 fw-bold mb-3">Timeline Transaksi</h3>
        <div class="row g-3">
            <div class="col-md-3">
                <div class="p-3 rounded-4 bg-light h-100">
                    <div class="text-muted small">Kode Transaksi</div>
                    <div class="fw-bold">{{ $transaksi->kode_transaksi }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-4 bg-light h-100">
                    <div class="text-muted small">Tanggal Pinjam</div>
                    <div class="fw-bold">{{ $transaksi->tanggal_pinjam->format('d M Y') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-4 bg-light h-100">
                    <div class="text-muted small">Batas Kembali</div>
                    <div class="fw-bold">{{ $transaksi->tanggal_kembali->format('d M Y') }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="p-3 rounded-4 bg-light h-100">
                    <div class="text-muted small">Tanggal Dikembalikan</div>
                    <div class="fw-bold">{{ $transaksi->tanggal_dikembalikan?->format('d M Y') ?? '-' }}</div>
                </div>
            </div>
            @if ($transaksi->keterangan)
                <div class="col-12">
                    <div class="p-3 rounded-4 bg-light">
                        <div class="text-muted small">Keterangan</div>
                        <div class="fw-bold">{{ $transaksi->keterangan }}</div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
