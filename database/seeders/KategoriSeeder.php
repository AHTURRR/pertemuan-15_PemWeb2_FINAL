<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Kategori;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama_kategori' => 'Programming',
                'deskripsi'     => 'Buku tentang bahasa pemrograman dan rekayasa perangkat lunak.',
                'icon'          => 'code-slash',
                'warna'         => 'primary',
            ],
            [
                'nama_kategori' => 'Database',
                'deskripsi'     => 'Buku tentang perancangan dan manajemen basis data.',
                'icon'          => 'database',
                'warna'         => 'success',
            ],
            [
                'nama_kategori' => 'Web Design',
                'deskripsi'     => 'Buku tentang desain UI/UX dan antarmuka web.',
                'icon'          => 'palette',
                'warna'         => 'info',
            ],
            [
                'nama_kategori' => 'Networking',
                'deskripsi'     => 'Buku tentang jaringan komputer dan infrastruktur IT.',
                'icon'          => 'wifi',
                'warna'         => 'warning',
            ],
            [
                'nama_kategori' => 'Data Science',
                'deskripsi'     => 'Buku tentang analisis data, machine learning, dan statistik.',
                'icon'          => 'graph-up',
                'warna'         => 'danger',
            ]
        ];

        // Menyimpan data ke dalam tabel
        foreach ($data as $item) {
            Kategori::create($item);
        }
    }
}