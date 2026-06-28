@extends('layouts.app')

@section('title', 'Edit Anggota')

@section('content')
    <x-page-header
        title="Edit Anggota"
        subtitle="Perbarui data anggota agar informasi kontak dan status tetap akurat."
        icon="bi-pencil-square"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Anggota', 'url' => route('anggota.index')],
            ['label' => $anggota->nama, 'url' => route('anggota.show', $anggota->id)],
            ['label' => 'Edit'],
        ]"
    />

    <form action="{{ route('anggota.update', $anggota->id) }}" method="POST" data-loading="true">
        @csrf
        @method('PUT')

        <div class="app-card">
            <h3 class="h5 fw-bold mb-1">Identitas Anggota</h3>
            <p class="text-muted mb-4">Pastikan data kontak masih bisa digunakan.</p>

            <div class="row g-4">
                <div class="col-md-4">
                    <label for="kode_anggota" class="form-label required">Kode Anggota</label>
                    <input type="text" name="kode_anggota" id="kode_anggota" required class="form-control @error('kode_anggota') is-invalid @enderror" value="{{ old('kode_anggota', $anggota->kode_anggota) }}">
                    @error('kode_anggota') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-8">
                    <label for="nama" class="form-label required">Nama Lengkap</label>
                    <input type="text" name="nama" id="nama" required class="form-control @error('nama') is-invalid @enderror" value="{{ old('nama', $anggota->nama) }}">
                    @error('nama') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="email" class="form-label required">Email</label>
                    <input type="email" name="email" id="email" required class="form-control @error('email') is-invalid @enderror" value="{{ old('email', $anggota->email) }}">
                    @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="telepon" class="form-label required">Nomor Telepon</label>
                    <input type="text" name="telepon" id="telepon" required class="form-control @error('telepon') is-invalid @enderror" value="{{ old('telepon', $anggota->telepon) }}">
                    @error('telepon') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-12">
                    <label for="alamat" class="form-label required">Alamat Lengkap</label>
                    <textarea name="alamat" id="alamat" rows="3" required class="form-control @error('alamat') is-invalid @enderror">{{ old('alamat', $anggota->alamat) }}</textarea>
                    @error('alamat') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="app-card">
            <h3 class="h5 fw-bold mb-1">Profil Keanggotaan</h3>
            <p class="text-muted mb-4">Status aktif menentukan apakah anggota bisa meminjam buku.</p>

            <div class="row g-4">
                <div class="col-md-4">
                    <label for="tanggal_lahir" class="form-label required">Tanggal Lahir</label>
                    <input type="date" name="tanggal_lahir" id="tanggal_lahir" required max="{{ date('Y-m-d') }}" class="form-control @error('tanggal_lahir') is-invalid @enderror" value="{{ old('tanggal_lahir', $anggota->tanggal_lahir?->format('Y-m-d')) }}">
                    @error('tanggal_lahir') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="jenis_kelamin" class="form-label required">Jenis Kelamin</label>
                    <select name="jenis_kelamin" id="jenis_kelamin" required class="form-select @error('jenis_kelamin') is-invalid @enderror">
                        @foreach (['Laki-laki', 'Perempuan'] as $jk)
                            <option value="{{ $jk }}" @selected(old('jenis_kelamin', $anggota->jenis_kelamin) == $jk)>{{ $jk }}</option>
                        @endforeach
                    </select>
                    @error('jenis_kelamin') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-4">
                    <label for="pekerjaan" class="form-label">Pekerjaan</label>
                    <input type="text" name="pekerjaan" id="pekerjaan" class="form-control @error('pekerjaan') is-invalid @enderror" value="{{ old('pekerjaan', $anggota->pekerjaan) }}">
                    @error('pekerjaan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="tanggal_daftar" class="form-label required">Tanggal Pendaftaran</label>
                    <input type="date" name="tanggal_daftar" id="tanggal_daftar" required max="{{ date('Y-m-d') }}" class="form-control @error('tanggal_daftar') is-invalid @enderror" value="{{ old('tanggal_daftar', $anggota->tanggal_daftar?->format('Y-m-d')) }}">
                    @error('tanggal_daftar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
                <div class="col-md-6">
                    <label for="status" class="form-label required">Status</label>
                    <select name="status" id="status" required class="form-select @error('status') is-invalid @enderror">
                        @foreach (['Aktif', 'Nonaktif'] as $status)
                            <option value="{{ $status }}" @selected(old('status', $anggota->status) == $status)>{{ $status }}</option>
                        @endforeach
                    </select>
                    @error('status') <div class="invalid-feedback">{{ $message }}</div> @enderror
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
            <a href="{{ route('anggota.show', $anggota->id) }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-warning">
                <i class="bi bi-save"></i> Update Anggota
            </button>
        </div>
    </form>
@endsection
