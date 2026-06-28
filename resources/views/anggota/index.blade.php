@extends('layouts.app')

@section('title', 'Daftar Anggota')

@section('content')
    <x-page-header
        title="Daftar Anggota"
        subtitle="Kelola data anggota aktif dan nonaktif untuk proses peminjaman."
        icon="bi-people"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Anggota'],
        ]"
    >
        <x-slot name="actions">
            <a href="{{ route('anggota.export') }}" class="btn btn-success" data-loading-link>
                <i class="bi bi-file-earmark-excel"></i> Export
            </a>
            <a href="{{ route('anggota.create') }}" class="btn btn-primary">
                <i class="bi bi-person-plus"></i> Tambah Anggota
            </a>
        </x-slot>
    </x-page-header>

    <div class="stat-grid">
        <x-stat-card label="Total Anggota" :value="$totalAnggota" icon="bi-people" variant="primary" />
        <x-stat-card label="Anggota Aktif" :value="$anggotaAktif" icon="bi-person-check" variant="success" />
        <x-stat-card label="Anggota Nonaktif" :value="$anggotaNonaktif" icon="bi-person-x" variant="warning" />
        <x-stat-card label="Data Ditampilkan" :value="$anggotas->count()" icon="bi-table" variant="info" />
    </div>

    <div class="app-card">
        <form action="{{ route('anggota.search') }}" method="GET" class="row g-3 align-items-end" data-no-loading>
            <div class="col-lg-4">
                <label for="keyword" class="form-label">Cari Anggota</label>
                <input type="text" id="keyword" name="keyword" class="form-control"
                    placeholder="Cari nama, email, atau telepon..." value="{{ request('keyword') }}">
                <div class="form-text">Gunakan nama, email, atau nomor telepon.</div>
            </div>
            <div class="col-md-4 col-lg-2">
                <label for="jenis_kelamin" class="form-label">Gender</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                    <option value="">Semua</option>
                    <option value="Laki-laki" @selected(request('jenis_kelamin') == 'Laki-laki')>Laki-laki</option>
                    <option value="Perempuan" @selected(request('jenis_kelamin') == 'Perempuan')>Perempuan</option>
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label for="status" class="form-label">Status</label>
                <select name="status" id="status" class="form-select">
                    <option value="">Semua</option>
                    <option value="Aktif" @selected(request('status') == 'Aktif')>Aktif</option>
                    <option value="Nonaktif" @selected(request('status') == 'Nonaktif')>Nonaktif</option>
                </select>
            </div>
            <div class="col-md-4 col-lg-2">
                <label for="pekerjaan" class="form-label">Pekerjaan</label>
                <input type="text" id="pekerjaan" name="pekerjaan" class="form-control" placeholder="Opsional" value="{{ request('pekerjaan') }}">
            </div>
            <div class="col-lg-2 d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-fill">
                    <i class="bi bi-search"></i> Cari
                </button>
                <a href="{{ route('anggota.index') }}" class="btn btn-outline-secondary" data-bs-toggle="tooltip" title="Reset filter">
                    <i class="bi bi-arrow-counterclockwise"></i>
                </a>
            </div>
        </form>
    </div>

    <div class="app-card table-card">
        <div class="table-toolbar">
            <div>
                <h3 class="h5 fw-bold mb-1">Data Anggota</h3>
                <p class="text-muted mb-0">Menampilkan {{ $anggotas->count() }} data anggota.</p>
            </div>
            <div class="input-group search-box">
                <span class="input-group-text bg-white"><i class="bi bi-search"></i></span>
                <input type="search" class="form-control" placeholder="Cari cepat di tabel..." data-table-search="#anggotaTable">
            </div>
        </div>

        @if ($anggotas->count())
            <div class="table-responsive">
                <table class="table align-middle" id="anggotaTable">
                    <thead>
                        <tr>
                            <th>Anggota</th>
                            <th>Email</th>
                            <th>Telepon</th>
                            <th>Gender</th>
                            <th>Status</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($anggotas as $anggota)
                            <tr>
                                <td>
                                    <div class="fw-bold">{{ $anggota->nama }}</div>
                                    <div class="text-muted small"><code>{{ $anggota->kode_anggota }}</code></div>
                                </td>
                                <td>{{ $anggota->email }}</td>
                                <td>{{ $anggota->telepon }}</td>
                                <td>
                                    <i class="bi {{ $anggota->jenis_kelamin === 'Laki-laki' ? 'bi-gender-male text-primary' : 'bi-gender-female text-danger' }}"></i>
                                    {{ $anggota->jenis_kelamin }}
                                </td>
                                <td>{!! $anggota->status_badge !!}</td>
                                <td class="text-end">
                                    <div class="btn-group" role="group" aria-label="Aksi anggota">
                                        <a href="{{ route('anggota.show', $anggota->id) }}" class="btn btn-sm btn-outline-primary" data-bs-toggle="tooltip" title="Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('anggota.edit', $anggota->id) }}" class="btn btn-sm btn-outline-warning" data-bs-toggle="tooltip" title="Edit">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <x-empty-state
                title="Belum ada data anggota"
                message="Tambahkan anggota agar proses peminjaman dapat dilakukan."
                icon="bi-person-plus"
                :actionUrl="route('anggota.create')"
                actionLabel="Tambah Anggota"
            />
        @endif
    </div>
@endsection
