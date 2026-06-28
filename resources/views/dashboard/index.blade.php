@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-page-header
        title="Dashboard Perpustakaan"
        subtitle="Selamat datang, berikut ringkasan aktivitas perpustakaan hari ini."
        icon="bi-speedometer2"
        :breadcrumbs="[
            ['label' => 'Dashboard'],
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('buku.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Buku
            </a>
            <a href="{{ route('anggota.create') }}" class="btn btn-outline-primary">
                <i class="bi bi-person-plus"></i> Tambah Anggota
            </a>
            <a href="{{ route('transaksi.create') }}" class="btn btn-success">
                <i class="bi bi-bookmark-plus"></i> Peminjaman Baru
            </a>
        </x-slot>
    </x-page-header>

    <div class="stat-grid">
        <x-stat-card label="Jumlah Buku" :value="$statistikBuku['total_buku']" icon="bi-journal-bookmark" variant="primary" hint="Total koleksi terdaftar" />
        <x-stat-card label="Jumlah Anggota" :value="$statistikAnggota['total_anggota']" icon="bi-people" variant="success" hint="Anggota perpustakaan" />
        <x-stat-card label="Buku Dipinjam" :value="$statistikTransaksi['dipinjam']" icon="bi-bookmark-check" variant="warning" hint="Belum dikembalikan" />
        <x-stat-card label="Buku Terlambat" :value="$statistikTransaksi['terlambat']" icon="bi-exclamation-triangle" variant="danger" hint="Melewati tanggal kembali" />
    </div>

    <div class="row g-4">
        <div class="col-xl-8">
            <div class="app-card h-100">
                <div class="d-flex justify-content-between align-items-start mb-4">
                    <div>
                        <h3 class="h5 fw-bold mb-1">Ringkasan Koleksi</h3>
                        <p class="text-muted mb-0">Visual cepat kondisi stok dan transaksi.</p>
                    </div>
                    <span class="badge bg-primary-subtle text-primary">Hari ini: {{ $statistikTransaksi['hari_ini'] }} transaksi</span>
                </div>

                @php
                    $totalBuku = max($statistikBuku['total_buku'], 1);
                    $tersediaPercent = round(($statistikBuku['buku_tersedia'] / $totalBuku) * 100);
                    $habisPercent = round(($statistikBuku['buku_habis'] / $totalBuku) * 100);
                @endphp

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Buku tersedia</span>
                        <span class="text-muted">{{ $tersediaPercent }}%</span>
                    </div>
                    <div class="progress progress-slim">
                        <div class="progress-bar bg-success" style="width: {{ $tersediaPercent }}%"></div>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span class="fw-bold">Buku habis</span>
                        <span class="text-muted">{{ $habisPercent }}%</span>
                    </div>
                    <div class="progress progress-slim">
                        <div class="progress-bar bg-danger" style="width: {{ $habisPercent }}%"></div>
                    </div>
                </div>

                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 bg-light">
                            <p class="text-muted mb-1">Anggota Aktif</p>
                            <h4 class="fw-bold mb-0">{{ $statistikAnggota['anggota_aktif'] }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 bg-light">
                            <p class="text-muted mb-1">Dikembalikan</p>
                            <h4 class="fw-bold mb-0">{{ $statistikTransaksi['dikembalikan'] }}</h4>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3 rounded-4 bg-light">
                            <p class="text-muted mb-1">Stok Menipis/Habis</p>
                            <h4 class="fw-bold mb-0">{{ $statistikBuku['buku_habis'] }}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-4">
            <div class="app-card h-100">
                <h3 class="h5 fw-bold mb-1">Aktivitas Terbaru</h3>
                <p class="text-muted mb-4">Transaksi terakhir yang perlu dipantau.</p>

                @forelse ($aktivitasTerbaru as $transaksi)
                    <div class="timeline-item mb-3">
                        <span class="timeline-dot">
                            <i class="bi {{ $transaksi->status === 'Dipinjam' ? 'bi-bookmark-check' : 'bi-arrow-return-left' }}"></i>
                        </span>
                        <div>
                            <div class="fw-bold">{{ $transaksi->kode_transaksi }}</div>
                            <div class="text-muted small">
                                {{ $transaksi->anggota->nama ?? '-' }} meminjam {{ Str::limit($transaksi->buku->judul ?? '-', 28) }}
                            </div>
                            <div class="mt-1">{!! $transaksi->status_badge !!}</div>
                        </div>
                    </div>
                @empty
                    <x-empty-state
                        title="Belum ada aktivitas"
                        message="Transaksi peminjaman dan pengembalian akan tampil di sini."
                        icon="bi-activity"
                        :actionUrl="route('transaksi.create')"
                        actionLabel="Buat Peminjaman"
                    />
                @endforelse
            </div>
        </div>
    </div>

    <div class="row g-4 mt-1">
        <div class="col-lg-6">
            <div class="app-card">
                <h3 class="h5 fw-bold mb-3">5 Buku Terbaru</h3>
                @if ($bukuTerbaru->count())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th class="text-end">Tahun</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($bukuTerbaru as $buku)
                                    <tr>
                                        <td class="fw-bold">{{ $buku['judul'] }}</td>
                                        <td>{{ $buku['pengarang'] }}</td>
                                        <td class="text-end">{{ $buku['tahun'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-empty-state title="Belum ada buku" message="Tambahkan buku pertama untuk mulai mengelola koleksi." :actionUrl="route('buku.create')" actionLabel="Tambah Buku" />
                @endif
            </div>
        </div>

        <div class="col-lg-6">
            <div class="app-card">
                <h3 class="h5 fw-bold mb-3">5 Anggota Terbaru</h3>
                @if ($anggotaTerbaru->count())
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th class="text-end">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($anggotaTerbaru as $anggota)
                                    <tr>
                                        <td><code>{{ $anggota['kode'] }}</code></td>
                                        <td class="fw-bold">{{ $anggota['nama'] }}</td>
                                        <td class="text-end">
                                            <span class="badge {{ $anggota['status'] === 'Aktif' ? 'bg-success' : 'bg-secondary' }}">
                                                {{ $anggota['status'] }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <x-empty-state title="Belum ada anggota" message="Daftarkan anggota pertama agar proses peminjaman bisa dimulai." :actionUrl="route('anggota.create')" actionLabel="Tambah Anggota" icon="bi-people" />
                @endif
            </div>
        </div>
    </div>
@endsection
