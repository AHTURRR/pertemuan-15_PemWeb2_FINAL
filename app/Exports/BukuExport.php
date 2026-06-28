<?php

namespace App\Exports;

use App\Models\Buku;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BukuExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Buku::select(
            'kode_buku',
            'judul',
            'pengarang',
            'penerbit',
            'tahun_terbit',
            'stok'
        )->get();
    }

    public function headings(): array
    {
        return [
            'Kode Buku',
            'Judul',
            'Pengarang',
            'Penerbit',
            'Tahun Terbit',
            'Stok',
        ];
    }
}