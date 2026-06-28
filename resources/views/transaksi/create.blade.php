@extends('layouts.app')

@section('title', 'Peminjaman Baru')

@section('content')
    <x-page-header
        title="Peminjaman Baru"
        subtitle="Ikuti alur sederhana: pilih anggota, pilih buku, lalu konfirmasi peminjaman."
        icon="bi-bookmark-plus"
        :breadcrumbs="[
            ['label' => 'Dashboard', 'url' => route('dashboard')],
            ['label' => 'Transaksi', 'url' => route('transaksi.index')],
            ['label' => 'Peminjaman Baru'],
        ]"
    />

    <div class="wizard-steps">
        <div class="wizard-step active"><span>1</span> Pilih Anggota</div>
        <div class="wizard-step active"><span>2</span> Pilih Buku</div>
        <div class="wizard-step active"><span>3</span> Konfirmasi</div>
    </div>

    <form action="{{ route('transaksi.store') }}" method="POST" data-loading="true">
        @csrf

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="app-card">
                    <h3 class="h5 fw-bold mb-1">Data Peminjaman</h3>
                    <p class="text-muted mb-4">Hanya anggota aktif dan buku yang masih tersedia yang dapat dipilih.</p>

                    <div class="row g-4">
                        <div class="col-12">
                            <label for="anggota_id" class="form-label required">Pilih Anggota</label>
                            <select name="anggota_id" id="anggota_id" required class="form-select @error('anggota_id') is-invalid @enderror">
                                <option value="">Pilih anggota aktif</option>
                                @foreach ($anggotas as $anggota)
                                    <option value="{{ $anggota->id }}" @selected(old('anggota_id') == $anggota->id)>
                                        {{ $anggota->kode_anggota }} — {{ $anggota->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Jika anggota tidak muncul, pastikan statusnya aktif.</div>
                            @error('anggota_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-12">
                            <label for="buku_id" class="form-label required">Pilih Buku</label>
                            <select name="buku_id" id="buku_id" required class="form-select @error('buku_id') is-invalid @enderror">
                                <option value="">Pilih buku tersedia</option>
                                @foreach ($bukus as $buku)
                                    <option value="{{ $buku->id }}" @selected(old('buku_id') == $buku->id)>
                                        {{ $buku->judul }} — Stok: {{ $buku->stok }}
                                    </option>
                                @endforeach
                            </select>
                            <div class="form-text">Buku dengan stok 0 tidak dapat dipinjam.</div>
                            @error('buku_id') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label for="tanggal_pinjam" class="form-label required">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" required max="{{ date('Y-m-d') }}"
                                class="form-control @error('tanggal_pinjam') is-invalid @enderror"
                                value="{{ old('tanggal_pinjam', date('Y-m-d')) }}">
                            <div class="form-text">Tanggal kembali otomatis 7 hari dari tanggal pinjam.</div>
                            @error('tanggal_pinjam') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Estimasi Tanggal Kembali</label>
                            <input type="text" class="form-control" value="{{ now()->addDays(7)->format('d M Y') }}" readonly>
                            <div class="form-text">Denda keterlambatan Rp 5.000/hari.</div>
                        </div>

                        <div class="col-12">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea name="keterangan" id="keterangan" rows="3" class="form-control @error('keterangan') is-invalid @enderror" placeholder="Catatan tambahan, kondisi buku, atau informasi lain...">{{ old('keterangan') }}</textarea>
                            @error('keterangan') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="app-card">
                    <h3 class="h5 fw-bold mb-3">Ringkasan Aturan</h3>
                    <div class="timeline-item mb-3">
                        <span class="timeline-dot"><i class="bi bi-calendar-week"></i></span>
                        <div>
                            <div class="fw-bold">Durasi 7 hari</div>
                            <div class="text-muted small">Tanggal kembali dihitung otomatis.</div>
                        </div>
                    </div>
                    <div class="timeline-item mb-3">
                        <span class="timeline-dot"><i class="bi bi-cash-coin"></i></span>
                        <div>
                            <div class="fw-bold">Denda Rp 5.000/hari</div>
                            <div class="text-muted small">Dihitung saat pengembalian.</div>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-dot"><i class="bi bi-box-seam"></i></span>
                        <div>
                            <div class="fw-bold">Stok otomatis berkurang</div>
                            <div class="text-muted small">Setelah peminjaman berhasil.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex flex-column flex-sm-row justify-content-between gap-2">
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-check-circle"></i> Konfirmasi Peminjaman
            </button>
        </div>
    </form>
@endsection
