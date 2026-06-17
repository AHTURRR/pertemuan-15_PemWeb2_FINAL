<?php
 
use App\Http\Controllers\PerpustakaanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;
use Illuminate\Support\Facades\DB;
use App\Models\Buku;
use App\Models\Anggota;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\DashboardController;
 
Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

// ✅ Semua route SPESIFIK harus di atas Route::resource
Route::get('/buku/search', [BukuController::class, 'search'])->name('buku.search');
Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])->name('buku.bulk-delete');
Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])->name('buku.kategori');

// ✅ Route::resource PALING BAWAH — karena ia mendaftarkan /buku/{buku}
Route::resource('buku', BukuController::class);

Route::get('/anggota/export', [AnggotaController::class, 'export'])
    ->name('anggota.export');

Route::get('/anggota/search', [AnggotaController::class, 'search'])
    ->name('anggota.search');

Route::resource('anggota', AnggotaController::class);

// Route untuk testing
Route::get('/test-accessor-scope', function () {
    return view('test-accessor-scope', [
        'bukus' => Buku::all(),
        'bukuTerbaru' => Buku::terbaru()->get(),
        'bukuMenipis' => Buku::stokMenipis()->get(),
        'anggotas' => Anggota::all(),
        'anggotaBaru' => Anggota::terdaftarBulanIni()->get(),
    ]);
});
 
// Testing Scope & Query
Route::get('/test-query', function () {
    $html = '<h1>Testing Query Eloquent</h1>';
    
    // Buku tersedia
    $tersedia = Buku::tersedia()->get();
    $html .= '<h3>Buku Tersedia (Stok > 0): ' . $tersedia->count() . '</h3>';
    $html .= '<ul>';
    foreach ($tersedia as $buku) {
        $html .= '<li>' . $buku->judul . ' (Stok: ' . $buku->stok . ')</li>';
    }
    $html .= '</ul>';
    
    // Buku Programming
    $programming = Buku::kategori('Programming')->get();
    $html .= '<h3>Buku Programming: ' . $programming->count() . '</h3>';
    $html .= '<ul>';
    foreach ($programming as $buku) {
        $html .= '<li>' . $buku->judul . '</li>';
    }
    $html .= '</ul>';
    
    // Anggota Aktif
    $aktif = Anggota::aktif()->get();
    $html .= '<h3>Anggota Aktif: ' . $aktif->count() . '</h3>';
    $html .= '<ul>';
    foreach ($aktif as $anggota) {
        $html .= '<li>' . $anggota->nama . ' (' . $anggota->email . ')</li>';
    }
    $html .= '</ul>';
    
    return $html;
});