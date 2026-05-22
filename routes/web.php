<?php
 
use App\Http\Controllers\PerpustakaanController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KategoriController;


// Gunakan named routes (->name) sesuai syarat bonus
Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/search/{keyword}', [KategoriController::class, 'search'])->name('kategori.search');
Route::get('/kategori/{id}', [KategoriController::class, 'show'])->name('kategori.show');

 
// Halaman utama
Route::get('/', [KategoriController::class, 'index'])->name('home');

// Halaman kategori
Route::prefix('kategori')->name('kategori.')->controller(KategoriController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/search/{keyword}', 'search')->name('search');
    Route::get('/{id}', 'show')->whereNumber('id')->name('show');
});

// Halaman perpustakaan
Route::prefix('perpustakaan')->name('perpustakaan.')->controller(PerpustakaanController::class)->group(function () {
    Route::get('/', 'index')->name('index');
    Route::get('/{id}', 'show')->name('show');
});

// Route baru - return text
Route::get('/hello', function () {
    return 'Hello dari Laravel!';
});
 
// Route dengan HTML
Route::get('/info', function () {
    return '<h1>Sistem Perpustakaan</h1><p>Selamat datang!</p>';
});
 
// Route dengan JSON
Route::get('/buku', function () {
    return [
        'judul' => 'Laravel Programming',
        'pengarang' => 'John Doe',
        'harga' => 150000
    ];
});

// Data dummy minimal 5 anggota
$anggota_list = [
    [
        'id' => 1,
        'kode' => 'AGT-001',
        'nama' => 'Budi Santoso',
        'email' => 'budi@email.com',
        'telepon' => '081234567890',
        'alamat' => 'Jakarta',
        'status' => 'Aktif'
    ],
    [
        'id' => 2,
        'kode' => 'AGT-002',
        'nama' => 'Siti Aminah',
        'email' => 'siti@email.com',
        'telepon' => '082345678901',
        'alamat' => 'Pekalongan',
        'status' => 'Aktif'
    ],
    [
        'id' => 3,
        'kode' => 'AGT-003',
        'nama' => 'Agus Hariyanto',
        'email' => 'agus@email.com',
        'telepon' => '083456789012',
        'alamat' => 'Bandung',
        'status' => 'Tidak Aktif'
    ],
    [
        'id' => 4,
        'kode' => 'AGT-004',
        'nama' => 'Dewi Lestari',
        'email' => 'dewi@email.com',
        'telepon' => '084567890123',
        'alamat' => 'Yogyakarta',
        'status' => 'Aktif'
    ],
    [
        'id' => 5,
        'kode' => 'AGT-005',
        'nama' => 'Fajar Pratama',
        'email' => 'fajar@email.com',
        'telepon' => '085678901234',
        'alamat' => 'Semarang',
        'status' => 'Dibekukan'
    ],
];

// Route untuk menampilkan daftar anggota
Route::get('/anggota', function () use ($anggota_list) {
    return view('anggota.index', ['anggota_list' => $anggota_list]);
});

// Route untuk menampilkan detail anggota berdasarkan ID
Route::get('/anggota/{id}', function ($id) use ($anggota_list) {
    // Mencari anggota berdasarkan ID menggunakan Collection
    $anggota = collect($anggota_list)->firstWhere('id', (int)$id);

    // Jika data tidak ditemukan, tampilkan error 404
    if (!$anggota) {
        abort(404, 'Data anggota tidak ditemukan');
    }

    return view('anggota.show', ['anggota' => $anggota]);
});