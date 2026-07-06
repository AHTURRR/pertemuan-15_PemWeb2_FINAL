@extends('layouts.app')

@section('title', 'Daftar Transaksi')

@section('content')
    <x-page-header
        title="Daftar Transaksi"
        subtitle="Pantau peminjaman, pengembalian, keterlambatan, dan denda dalam satu tempat."
        icon="bi-arrow-left-right"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Transaksi'],
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('laporan.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-file-earmark-bar-graph"></i> Laporan Transaksi
            </a>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary">
                <i class="bi bi-bookmark-plus"></i> Peminjaman Baru
            </a>
        </x-slot>
    </x-page-header>

    <div class="stat-grid">
        <x-stat-card label="Total Transaksi" :value="$transaksis->count()" icon="bi-receipt" variant="primary" />
        <x-stat-card label="Sedang Dipinjam" :value="$transaksis->where('status', 'Dipinjam')->count()" icon="bi-bookmark-check" variant="warning" />
        <x-stat-card label="Dikembalikan" :value="$transaksis->where('status', 'Dikembalikan')->count()" icon="bi-arrow-return-left" variant="success" />
        <x-stat-card label="Terlambat" :value="$transaksis->filter(fn ($item) => $item->status === 'Dipinjam' && now()->gt($item->tanggal_kembali))->count()" icon="bi-exclamation-triangle" variant="danger" />
    </div>

    <div class="app-card table-card">
        <div class="table-toolbar">
            <div>
                <h3 class="h5 fw-bold mb-1">Riwayat Transaksi</h3>
                <p class="text-muted mb-0">Menampilkan {{ $transaksis->count() }} transaksi terbaru.</p>
            </div>
            <div class="input-group search-box">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" placeholder="Cari transaksi..." data-table-search="#transaksiTable">
            </div>
        </div>

        @if ($transaksis->count())
            <div class="table-responsive">
                <table class="table align-middle" id="transaksiTable">
                    <thead>
                        <tr>
                            <th>Transaksi</th>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Batas Kembali</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksis as $transaksi)
                            @php
                                $terlambat = $transaksi->status === 'Dipinjam' && now()->gt($transaksi->tanggal_kembali);
                            @endphp
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $transaksi->kode_transaksi }}</div>
                                    <div class="text-muted small">{{ $transaksi->created_at->format('d M Y H:i') }}</div>
                                </td>
                                <td>{{ $transaksi->anggota->nama ?? '-' }}</td>
                                <td>{{ $transaksi->buku->judul ?? '-' }}</td>
                                <td>{{ $transaksi->tanggal_pinjam->format('d M Y') }}</td>
                                <td>{{ $transaksi->tanggal_kembali->format('d M Y') }}</td>
                                <td>
                                    @if($transaksi->status=='Dipinjam' && $transaksi->terlambat>0)
                                        <span class="badge bg-danger">
                                            Terlambat
                                        {{ $transaksi->terlambat }}
                                            Hari
                                        </span>
                                    @else
                                        {!! $transaksi->status_badge !!}
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="Aksi transaksi">
                                        <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        @if ($transaksi->status === 'Dipinjam')
                                            <form action="{{ route('transaksi.kembalikan', $transaksi->id) }}" method="POST"
                                                data-confirm
                                                data-confirm-title="Kembalikan Buku"
                                                data-confirm-text="Konfirmasi buku '{{ $transaksi->buku->judul ?? '-' }}' sudah dikembalikan?"
                                                data-confirm-button="Ya, Kembalikan">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-sm btn-outline-success" data-bs-toggle="tooltip" title="Kembalikan">
                                                    <i class="bi bi-arrow-return-left"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state
                title="Belum ada transaksi"
                message="Mulai proses peminjaman pertama melalui tombol di bawah."
                icon="bi-bookmark-plus"
                :actionUrl="route('transaksi.create')"
                actionLabel="Peminjaman Baru"
            />
        @endif
    </div>
@endsection
