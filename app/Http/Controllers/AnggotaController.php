<?php

namespace App\Http\Controllers;

use App\Models\Anggota;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAnggotaRequest;
use App\Http\Requests\UpdateAnggotaRequest;
use App\Exports\AnggotaExport;
use Maatwebsite\Excel\Facades\Excel;

class AnggotaController extends Controller
{
    /**
 * Export data anggota ke Excel
 */
public function export()
{
    return Excel::download(
        new AnggotaExport,
        'anggota_' . date('Y-m-d_His') . '.xlsx'
    );
}
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $anggotas = Anggota::latest()->get();

        $totalAnggota = Anggota::count();
        $anggotaAktif = Anggota::where('status', 'Aktif')->count();
        $anggotaNonaktif = Anggota::where('status', 'Nonaktif')->count();

        return view('anggota.index', compact(
            'anggotas',
            'totalAnggota',
            'anggotaAktif',
            'anggotaNonaktif'
        ));
    }

/**
 * Search dan Filter Data Anggota
 */
public function search(Request $request)
{
    $query = Anggota::query();

    // Pencarian berdasarkan keyword
    if ($request->keyword) {
        $query->where(function ($q) use ($request) {
            $q->where('nama', 'like', '%' . $request->keyword . '%')
              ->orWhere('email', 'like', '%' . $request->keyword . '%')
              ->orWhere('telepon', 'like', '%' . $request->keyword . '%');
        });
    }

    // Filter jenis kelamin
    if ($request->jenis_kelamin) {
        $query->where('jenis_kelamin', $request->jenis_kelamin);
    }

    // Filter status
    if ($request->status) {
        $query->where('status', $request->status);
    }

    // Filter pekerjaan
    if ($request->pekerjaan) {
        $query->where('pekerjaan', $request->pekerjaan);
    }

    $anggotas = $query->latest()->get();

    // Statistik
    $totalAnggota = $anggotas->count();
    $anggotaAktif = $anggotas->where('status', 'Aktif')->count();
    $anggotaNonaktif = $anggotas->where('status', 'Nonaktif')->count();

    return view('anggota.index', compact(
        'anggotas',
        'totalAnggota',
        'anggotaAktif',
        'anggotaNonaktif'
    ));
}


/**
 * Show the form for creating a new resource.
 */
    public function create()
    {
        $kodeAnggota = $this->generateKodeAnggota();
        return view('anggota.create', compact('kodeAnggota'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAnggotaRequest $request)
    {
        try {
            $data = $request->validated(); 
            $data['kode_anggota'] = $this->generateKodeAnggota(); 
            Anggota::create($data);

            return redirect()
                ->route('anggota.index')
                ->with('success', 'Anggota berhasil ditambahkan!');

        } catch (\Exception $e) {

            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Gagal menambahkan anggota: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('anggota.show', compact('anggota'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $anggota = Anggota::findOrFail($id);

        return view('anggota.edit', compact('anggota'));
    }

/**
 * Update the specified resource in storage.
 */
public function update(UpdateAnggotaRequest $request, string $id)
{
    try {

        $anggota = Anggota::findOrFail($id);

        // Update anggota dengan validated data
        $anggota->update($request->validated());

        // Redirect dengan success message
        return redirect()
            ->route('anggota.show', $anggota->id)
            ->with('success', 'Data anggota berhasil diupdate!');

    } catch (\Exception $e) {

        // Redirect dengan error message jika gagal
        return redirect()
            ->back()
            ->withInput()
            ->with('error', 'Gagal mengupdate anggota: ' . $e->getMessage());
    }
}

/**
 * Generate kode anggota otomatis
 */
private function generateKodeAnggota()
{
    $tahun = date('Y');

    $lastAnggota = Anggota::whereYear('created_at', $tahun)
                          ->orderBy('kode_anggota', 'desc')
                          ->first();

    if ($lastAnggota) {
        $lastNumber = intval(substr($lastAnggota->kode_anggota, -3));
        $newNumber = $lastNumber + 1;
    } else {
        $newNumber = 1;
    }

    return 'AGT-' . $tahun . '-' . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
}

/**
 * Remove the specified resource from storage.
 */
public function destroy(string $id)
{
    try {

        $anggota = Anggota::findOrFail($id);
        $namaAnggota = $anggota->nama;

        // Delete anggota
        $anggota->delete();

        // Redirect dengan success message
        return redirect()
            ->route('anggota.index')
            ->with('success', "Anggota '{$namaAnggota}' berhasil dihapus!");

    } catch (\Exception $e) {

        // Redirect dengan error message jika gagal
        return redirect()
            ->back()
            ->with('error', 'Gagal menghapus anggota: ' . $e->getMessage());
    }
}
}