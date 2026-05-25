<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    // Mendefinisikan nama tabel secara manual
    protected $table = 'kategori';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'nama_kategori',
        'deskripsi',
        'icon',
        'warna'
    ];
}