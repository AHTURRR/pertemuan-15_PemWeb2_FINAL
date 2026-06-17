<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;

class DashboardController extends Controller
{
    public function index()
    {
        $statistikBuku = [
            'total_buku' => Buku::count(),
            'buku_tersedia' => Buku::where('stok', '>', 0)->count(),
            'buku_habis' => Buku::where('stok', 0)->count(),
        ];

        $statistikAnggota = [
            'total_anggota' => Anggota::count(),
            'anggota_aktif' => Anggota::where('status', 'Aktif')->count(),
            'anggota_nonaktif' => Anggota::where('status', 'Nonaktif')->count(),
        ];

        $bukuTerbaru = Buku::latest()
            ->take(5)
            ->get(['judul', 'pengarang', 'tahun_terbit'])
            ->map(function ($buku) {
                return [
                    'judul' => $buku->judul,
                    'pengarang' => $buku->pengarang,
                    'tahun' => $buku->tahun_terbit,
                ];
            });

        $anggotaTerbaru = Anggota::latest()
            ->take(5)
            ->get(['kode_anggota', 'nama', 'status'])
            ->map(function ($anggota) {
                return [
                    'kode' => $anggota->kode_anggota,
                    'nama' => $anggota->nama,
                    'status' => $anggota->status,
                ];
            });

        return view('dashboard.index', compact(
            'statistikBuku',
            'statistikAnggota',
            'bukuTerbaru',
            'anggotaTerbaru'
        ));
    }
}
