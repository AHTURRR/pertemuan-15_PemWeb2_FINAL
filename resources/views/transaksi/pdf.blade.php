<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <title>Laporan Transaksi</title>

    <style>

        body{
            font-family: DejaVu Sans;
            font-size:12px;
            color:#333;
        }

        h2{
            text-align:center;
            margin-bottom:5px;
        }

        .subtitle{
            text-align:center;
            margin-bottom:20px;
            color:#666;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table th{

            background:#0d6efd;
            color:white;

            border:1px solid #444;

            padding:8px;

        }

        table td{

            border:1px solid #444;

            padding:7px;

        }

        .summary{

            margin-top:20px;

            width:40%;

            float:right;

        }

        .summary td{

            border:1px solid #444;

            padding:8px;

        }

        .footer{

            position:fixed;

            bottom:0;

            left:0;

            right:0;

            text-align:center;

            color:#888;

            font-size:11px;

        }

    </style>

</head>

<body>

<h2>

LAPORAN TRANSAKSI PERPUSTAKAAN

</h2>

<div class="subtitle">

Tanggal Cetak :

{{ now()->format('d F Y') }}

</div>

<table>

<thead>

<tr>

<th>No</th>

<th>Kode</th>

<th>Anggota</th>

<th>Buku</th>

<th>Pinjam</th>

<th>Kembali</th>

<th>Status</th>

<th>Denda</th>

</tr>

</thead>

<tbody>

@foreach($transaksis as $transaksi)

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

{{ $transaksi->status }}

</td>

<td>

Rp {{ number_format($transaksi->nominal_denda,0,',','.') }}

</td>

</tr>

@endforeach

</tbody>

</table>

<table class="summary">

<tr>

<td>

<strong>Total Transaksi</strong>

</td>

<td>

{{ $totalTransaksi }}

</td>

</tr>

<tr>

<td>

<strong>Total Denda</strong>

</td>

<td>

Rp {{ number_format($totalDenda,0,',','.') }}

</td>

</tr>

</table>

<div class="footer">

Dicetak oleh Sistem Informasi Perpustakaan

</div>

</body>

</html>
