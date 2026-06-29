@extends('layouts.app')

@section('title', 'Laporan Transaksi')

@section('content')
<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2 class="fw-bold">Laporan Transaksi</h2>
            <p class="text-muted mb-0">
                Laporan seluruh transaksi perpustakaan
            </p>
        </div>
    </div>

    {{-- Card Filter --}}
    <div class="card shadow-sm border-0 mb-4">
    <div class="card-header bg-primary text-white">
        <strong>Filter Laporan</strong>
    </div>
    <div class="card-body">
        <form method="GET"
              action="{{ route('transaksi.laporan') }}">
            <div class="row">
                <div class="col-md-3">
                    <label>Dari</label>
                    <input
                        type="date"
                        name="dari"
                        value="{{ request('dari') }}"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Sampai</label>
                    <input
                        type="date"
                        name="sampai"
                        value="{{ request('sampai') }}"
                        class="form-control">
                </div>
                <div class="col-md-3">
                    <label>Status</label>
                    <select
                        name="status"
                        class="form-select">
                        <option value="Semua">
                            Semua
                        </option>
                        <option
                            value="Dipinjam"
                            {{ request('status')=='Dipinjam' ? 'selected':'' }}>
                            Dipinjam
                        </option>
                        <option
                            value="Dikembalikan"
                            {{ request('status')=='Dikembalikan' ? 'selected':'' }}>
                            Dikembalikan
                        </option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label>Anggota</label>
                    <select
                        name="anggota"
                        class="form-select">
                        <option value="">
                            Semua Anggota
                        </option>
                        @foreach($anggotas as $anggota)
                            <option
                                value="{{ $anggota->id }}"
                                {{ request('anggota')==$anggota->id ? 'selected':'' }}>
                                {{ $anggota->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mt-4 d-flex gap-2">
                <button
                    class="btn btn-primary">
                    Filter
                </button>
                <a
                    href="{{ route('transaksi.laporan') }}"
                    class="btn btn-secondary">
                    Reset
                </a>
                <a
                    href="{{ route('transaksi.laporan.pdf', request()->query()) }}"
                    class="btn btn-danger">
                    Export PDF
                </a>
            </div>
        </form>
    </div>
</div>
{{-- Card Statistik --}}
    <div class="row mb-4">

    <div class="col-md-6">

        <div class="card border-0 shadow">

            <div class="card-body">

                <h6>Total Transaksi</h6>

                <h2>

                    {{ $totalTransaksi }}

                </h2>

            </div>

        </div>

    </div>

    <div class="col-md-6">

        <div class="card border-0 shadow">

            <div class="card-body">

                <h6>Total Denda</h6>

                <h2>

                    Rp {{ number_format($totalDenda,0,',','.') }}

                </h2>

            </div>

        </div>

    </div>

</div>

{{-- Tabel --}}
<div class="card shadow border-0">

    <div class="card-header">

        <strong>

            Data Transaksi

        </strong>

    </div>

    <div class="card-body">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                    <tr>

                        <th>No</th>

                        <th>Kode</th>

                        <th>Anggota</th>

                        <th>Buku</th>

                        <th>Tgl Pinjam</th>

                        <th>Tgl Kembali</th>

                        <th>Status</th>

                        <th>Denda</th>

                    </tr>

                </thead>

                <tbody>

                @forelse($transaksis as $transaksi)

                    <tr>

                        <td>

                            {{ $loop->iteration }}

                        </td>

                        <td>

                            {{ $transaksi->kode_transaksi }}

                        </td>

                        <td>

                            {{ optional($transaksi->anggota)->nama ?? '-' }}

                        </td>

                        <td>

                            {{ optional($transaksi->buku)->judul ?? '-' }}

                        </td>

                        <td>

                            {{ optional($transaksi->tanggal_pinjam)->format('d-m-Y') ?? '-' }}

                        </td>

                        <td>

                            {{ optional($transaksi->tanggal_kembali)->format('d-m-Y') ?? '-' }}

                        </td>

                        <td>

                            {!! $transaksi->status_badge !!}

                        </td>

                        <td>

                            Rp {{ number_format($transaksi->nominal_denda,0,',','.') }}

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center text-muted">

                            Tidak ada data.

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
</div>

@endsection
