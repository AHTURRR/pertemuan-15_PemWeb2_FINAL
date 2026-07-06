<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LaporanController;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/hello', function () {
    return 'Hello dari Laravel!';
});

Route::middleware(['auth'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    /*
    |--------------------------------------------------------------------------
    | Laporan
    |--------------------------------------------------------------------------
    */

    Route::get('/laporan', [LaporanController::class, 'index'])
        ->name('laporan.index');

    Route::get('/laporan/pdf', [LaporanController::class, 'exportPdf'])
        ->name('laporan.pdf');

    /*
    |--------------------------------------------------------------------------
    | Buku
    |--------------------------------------------------------------------------
    */


    Route::get('/buku/search', [BukuController::class, 'search'])
        ->name('buku.search');

    Route::post('/buku/bulk-delete', [BukuController::class, 'bulkDelete'])
        ->name('buku.bulk-delete');

    Route::get('/buku/kategori/{kategori}', [BukuController::class, 'filterKategori'])
        ->name('buku.kategori');

    Route::get('/buku/export', [BukuController::class, 'export'])
    ->name('buku.export');
    
    Route::resource('buku', BukuController::class);

    /*
    |--------------------------------------------------------------------------
    | Anggota
    |--------------------------------------------------------------------------
    */

    Route::get('/anggota/export', [AnggotaController::class, 'export'])
        ->name('anggota.export');

    Route::get('/anggota/search', [AnggotaController::class, 'search'])
        ->name('anggota.search');

    Route::resource('anggota', AnggotaController::class);

    /*
    |--------------------------------------------------------------------------
    | Kategori
    |--------------------------------------------------------------------------
    */

    Route::resource('kategori', KategoriController::class)
        ->only(['index', 'show']);

    /*
    |--------------------------------------------------------------------------
    | Transaksi
    |--------------------------------------------------------------------------
    */

    Route::resource('transaksi', TransaksiController::class)
        ->only(['index', 'create', 'store', 'show']);

    Route::put('/transaksi/{id}/kembalikan', [TransaksiController::class, 'kembalikan'])
        ->name('transaksi.kembalikan');


    /*
    |--------------------------------------------------------------------------
    | Profile (Laravel Breeze)
    |--------------------------------------------------------------------------
    */

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
