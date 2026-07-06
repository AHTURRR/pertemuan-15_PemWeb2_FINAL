<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Transaksi;
use App\Models\Anggota;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
 
class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $transaksis = $this->buildQuery($request)->get();
 
        // Statistik ringkasan
        $summary = [
            'total'          => $transaksis->count(),
            'dipinjam'       => $transaksis->where('status', 'Dipinjam')->count(),
            'dikembalikan'   => $transaksis->where('status', 'Dikembalikan')->count(),
            'total_denda'    => $transaksis->sum(fn ($trx) => $trx->nominal_denda),
        ];
 
        $anggotas = Anggota::orderBy('nama')->get();
 
        return view('laporan.index', compact('transaksis', 'summary', 'anggotas'));
    }

    public function exportPdf(Request $request)
    {
        $transaksis = $this->buildQuery($request)->get();

        $totalTransaksi = $transaksis->count();
        $totalDenda = $transaksis->sum(fn ($trx) => $trx->nominal_denda);

        $pdf = Pdf::loadView(
            'transaksi.pdf',
            compact('transaksis', 'totalTransaksi', 'totalDenda')
        );

        return $pdf->stream('laporan-transaksi.pdf');
    }

    /**
     * Build query transaksi dengan filter.
     */
    private function buildQuery(Request $request)
    {
        $query = Transaksi::with(['anggota', 'buku']);

        // Filter berdasarkan tanggal
        if ($request->filled('dari')) {
            $query->whereDate('tanggal_pinjam', '>=', $request->dari);
        }
        if ($request->filled('sampai')) {
            $query->whereDate('tanggal_pinjam', '<=', $request->sampai);
        }

        // Filter berdasarkan status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan anggota
        if ($request->filled('anggota_id')) {
            $query->where('anggota_id', $request->anggota_id);
        }

        return $query->latest();
    }
}