<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class KategoriController extends Controller
{
    // Private method penyedia data dummy kategori
    private function getDataKategori()
    {
        return [
            ['id' => 1, 'nama' => 'Programming', 'deskripsi' => 'Buku pemrograman dan coding, termasuk web dan mobile', 'jumlah_buku' => 25],
            ['id' => 2, 'nama' => 'Database', 'deskripsi' => 'Buku perancangan dan manajemen basis data relasional & NoSQL', 'jumlah_buku' => 15],
            ['id' => 3, 'nama' => 'Networking', 'deskripsi' => 'Buku seputar jaringan komputer, router, dan keamanan siber', 'jumlah_buku' => 10],
            ['id' => 4, 'nama' => 'Desain Grafis', 'deskripsi' => 'Buku tentang tipografi, UI/UX, dan aplikasi desain grafis', 'jumlah_buku' => 20],
            ['id' => 5, 'nama' => 'Artificial Intelligence', 'deskripsi' => 'Buku tentang machine learning, neural networks, dan algoritma cerdas', 'jumlah_buku' => 12],
        ];
    }

    public function index()
    {
        $kategori_list = $this->getDataKategori();
        return view('kategori.index', compact('kategori_list'));
    }
    
    public function show($id)
    {
        $kategori_list = collect($this->getDataKategori());
        $kategori = $kategori_list->firstWhere('id', (int)$id);

        if (!$kategori) {
            abort(404, 'Kategori tidak ditemukan');
        }

        // Dummy data buku khusus untuk halaman detail
        $buku_list = [
            ['kode' => 'BK-001', 'judul' => 'Mastering Laravel 10', 'pengarang' => 'Taylor Otwell', 'tahun' => 2023],
            ['kode' => 'BK-002', 'judul' => 'Clean Code with PHP', 'pengarang' => 'Uncle Bob', 'tahun' => 2021],
            ['kode' => 'BK-003', 'judul' => 'Dasar Pemrograman Web', 'pengarang' => 'Sandhika Galih', 'tahun' => 2022],
        ];
        
        return view('kategori.show', compact('kategori', 'buku_list'));
    }
    
    public function search($keyword)
    {
        $kategori_list = collect($this->getDataKategori());
        
        // Filter data berdasarkan nama kategori atau deskripsi
        $hasil_pencarian = $kategori_list->filter(function($item) use ($keyword) {
            return stripos($item['nama'], $keyword) !== false || stripos($item['deskripsi'], $keyword) !== false;
        });

        return view('kategori.search', compact('hasil_pencarian', 'keyword'));
    }
}