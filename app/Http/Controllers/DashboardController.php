<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use App\Models\Buku;
use App\Models\Transaksi;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_buku' => Buku::count(),
            'buku_tersedia' => Buku::where('stok', '>', 0)->count(),
            'buku_habis' => Buku::where('stok', 0)->count(),
            'total_anggota' => Anggota::count(),
            'anggota_aktif' => Anggota::where('status', 'Aktif')->count(),
            'anggota_nonaktif' => Anggota::where('status', 'Nonaktif')->count(),
            'total_transaksi' => Transaksi::count(),
            'sedang_dipinjam' => Transaksi::where('status', 'Dipinjam')->count(),
            'sudah_dikembalikan' => Transaksi::where('status', 'Dikembalikan')->count(),
            'terlambat' => Transaksi::where('status', 'Dipinjam')
                ->whereDate('tanggal_kembali', '<', today())
                ->count(),
            'transaksi_hari_ini' => Transaksi::whereDate('tanggal_pinjam', today())->count(),
            'denda_bulan_ini' => Transaksi::whereMonth('tanggal_dikembalikan', now()->month)
                ->whereYear('tanggal_dikembalikan', now()->year)
                ->sum('denda'),
        ];

        $chartData = collect(range(5, 0))->map(function ($i) {
            $bulan = now()->subMonths($i);
            return [
                'bulan' => $bulan->translatedFormat('M Y'),
                'pinjam' => Transaksi::whereMonth('tanggal_pinjam', $bulan->month)
                    ->whereYear('tanggal_pinjam', $bulan->year)
                    ->count(),
                'kembali' => Transaksi::whereMonth('tanggal_dikembalikan', $bulan->month)
                    ->whereYear('tanggal_dikembalikan', $bulan->year)
                    ->count(),
            ];
        });

        $bukuPopuler = Buku::withCount('transaksis')
            ->orderByDesc('transaksis_count')
            ->take(10)
            ->get();

        $anggotaAktif = Anggota::withCount('transaksis')
            ->orderByDesc('transaksis_count')
            ->take(5)
            ->get();

        $bukuTerbaru = Buku::latest()
            ->take(5)
            ->get();

        $anggotaTerbaru = Anggota::latest()
            ->take(5)
            ->get();

        $recentTransaksi = Transaksi::with(['anggota', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        $terlambat = Transaksi::with(['anggota', 'buku'])
            ->where('status', 'Dipinjam')
            ->whereDate('tanggal_kembali', '<', Carbon::today())
            ->orderBy('tanggal_kembali')
            ->get();

        $jumlahTerlambat = $terlambat->count();

        // 1. Pie Chart Kategori Buku
        $kategoriChart = Buku::selectRaw('kategori, count(*) as count')
            ->groupBy('kategori')
            ->get();

        // 2. Donut Chart Status Transaksi
        $statusChart = [
            'dipinjam' => Transaksi::where('status', 'Dipinjam')->count(),
            'dikembalikan' => Transaksi::where('status', 'Dikembalikan')->count(),
        ];

        return view('dashboard', compact(
            'stats',
            'chartData',
            'bukuPopuler',
            'anggotaAktif',
            'bukuTerbaru',
            'anggotaTerbaru',
            'recentTransaksi',
            'terlambat',
            'jumlahTerlambat',
            'kategoriChart',
            'statusChart'
        ));
    }
}