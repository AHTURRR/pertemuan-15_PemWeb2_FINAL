<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use App\Models\Buku;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BukuExport;
 
// Controller for Buku resources
 
class BukuController extends Controller
{
    public function export()
{
    return Excel::download(
        new BukuExport,
        'data_buku_' . date('Y-m-d') . '.xlsx'
    );
}
    public function bulkDelete(Request $request)
    {
        
        $request->validate([
            'buku_ids' => 'required|array|min:1',
            'buku_ids.*' => 'integer|exists:buku,id',
        ],[
            'buku_ids.required' => 'Anda harus memilih setidaknya satu buku untuk dihapus.',
            'buku_ids.array' => 'Data buku tidak valid.',
            'buku_ids.*.integer' => 'ID buku harus berupa angka.',
            'buku_ids.*.exists' => 'Salah satu ID buku tidak ditemukan di database.',
        ]);

        $ids = $request->buku_ids;
        Buku::whereIn('id', $ids)->delete();
        return redirect()->route('buku.index')
                        ->with('success', 'Buku berhasil dihapus!');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data buku dari database
        $bukus = Buku::latest()->get();
        
        // Statistik untuk card
        $totalBuku = Buku::count();
        $bukuTersedia = Buku::where('stok', '>', 0)->count();
        $bukuHabis = Buku::where('stok', 0)->count();
        $kategoriList = Buku::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->filter()
            ->values();
        $tahunList = Buku::query()
            ->select('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit')
            ->filter()
            ->values();
        
        // Return view dengan data
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoriList',
            'tahunList'
        ));
    }
 

    
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Akan diimplementasi di pertemuan 12
        return view('buku.create');
    }
 
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBukuRequest $request)
    {
        try {
            // Create buku baru dengan validated data
            Buku::create($request->validated());
            
            // Redirect dengan success message
            return redirect()->route('buku.index')
                             ->with('success', 'Buku berhasil ditambahkan!');
                             
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                             ->withInput()
                             ->with('error', 'Gagal menambahkan buku: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // Find buku by ID, throw 404 if not found
        $buku = Buku::findOrFail($id);
        
        // Return view detail buku
        return view('buku.show', compact('buku'));
    }
 
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Akan diimplementasi di pertemuan 12
        $buku = Buku::findOrFail($id);
        return view('buku.edit', compact('buku'));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBukuRequest $request, string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            
            // Update buku dengan validated data
            $buku->update($request->validated());
            
            // Redirect dengan success message
            return redirect()->route('buku.show', $buku->id)
                            ->with('success', 'Buku berhasil diupdate!');
                            
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                            ->withInput()
                            ->with('error', 'Gagal mengupdate buku: ' . $e->getMessage());
        }
    }
 
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $buku = Buku::findOrFail($id);
            $judulBuku = $buku->judul;
            
            // Delete buku
            $buku->delete();
            
            // Redirect dengan success message
            return redirect()->route('buku.index')
                             ->with('success', "Buku '{$judulBuku}' berhasil dihapus!");
                             
        } catch (\Exception $e) {
            // Redirect dengan error message jika gagal
            return redirect()->back()
                             ->with('error', 'Gagal menghapus buku: ' . $e->getMessage());
        }
        // FIX: dd($id) dihapus — dead code, tidak pernah dieksekusi setelah return
    }

    /**
     * Advanced search dan filter buku.
     */
    public function search(Request $request)
    {
        $query = Buku::query();

        $query->when($request->filled('keyword'), function ($q) use ($request) {
            $keyword = $request->keyword;
            $q->where(function ($subQuery) use ($keyword) {
                $subQuery->where('judul', 'like', "%{$keyword}%")
                    ->orWhere('pengarang', 'like', "%{$keyword}%")
                    ->orWhere('penerbit', 'like', "%{$keyword}%");
            });
        });

        $query->when($request->filled('kategori'), function ($q) use ($request) {
            $q->where('kategori', $request->kategori);
        });

        $query->when($request->filled('tahun'), function ($q) use ($request) {
            $q->where('tahun_terbit', $request->tahun);
        });

        $query->when($request->filled('ketersediaan'), function ($q) use ($request) {
            if ($request->ketersediaan === 'tersedia') {
                $q->where('stok', '>', 0);
            }

            if ($request->ketersediaan === 'habis') {
                $q->where('stok', '=', 0);
            }
        });

        $bukus = $query->latest()->get();

        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();

        $kategoriList = Buku::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->filter()
            ->values();
        $tahunList = Buku::query()
            ->select('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit')
            ->filter()
            ->values();

        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategoriList',
            'tahunList'
        ));
    }
    
    /**
     * Filter buku berdasarkan kategori.
     */
    public function filterKategori($kategori)
    {
        $bukus = Buku::where('kategori', $kategori)->latest()->get();
        
        $totalBuku = $bukus->count();
        $bukuTersedia = $bukus->where('stok', '>', 0)->count();
        $bukuHabis = $bukus->where('stok', 0)->count();
        $kategoriList = Buku::query()
            ->select('kategori')
            ->distinct()
            ->orderBy('kategori')
            ->pluck('kategori')
            ->filter()
            ->values();
        $tahunList = Buku::query()
            ->select('tahun_terbit')
            ->distinct()
            ->orderByDesc('tahun_terbit')
            ->pluck('tahun_terbit')
            ->filter()
            ->values();
        
        return view('buku.index', compact(
            'bukus',
            'totalBuku',
            'bukuTersedia',
            'bukuHabis',
            'kategori',
            'kategoriList',
            'tahunList'
        ));
    }
}
