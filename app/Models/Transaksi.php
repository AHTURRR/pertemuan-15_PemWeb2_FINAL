<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
 
class Transaksi extends Model
{
    use HasFactory;

    public const DENDA_PER_HARI = 5000;
 
    protected $fillable = [
        'kode_transaksi',
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
        'keterangan',
    ];
 
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'tanggal_kembali' => 'date',
        'tanggal_dikembalikan' => 'date',
        'denda' => 'integer',
    ];
 
    // Relationship ke Anggota (belongsTo)
    public function anggota()
    {
        return $this->belongsTo(Anggota::class);
    }
 
    // Relationship ke Buku (belongsTo)
    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }
 
    // Accessor untuk durasi peminjaman (hari)
    public function getDurasiPeminjamanAttribute()
    {
        if ($this->tanggal_dikembalikan) {
            return $this->tanggal_pinjam->diffInDays($this->tanggal_dikembalikan);
        }
        return (int) $this->tanggal_pinjam->diffInDays(today());
    }
 
    // Accessor untuk cek terlambat (hari)
    public function getTerlambatAttribute()
    {
        if (!$this->tanggal_kembali) {
            return 0;
        }

        if ($this->status == 'Dikembalikan') {
            if ($this->tanggal_dikembalikan > $this->tanggal_kembali) {
                return (int) $this->tanggal_kembali->diffInDays($this->tanggal_dikembalikan);
            }
            return 0;
        }
        
        if (today() > $this->tanggal_kembali) {
            return (int) $this->tanggal_kembali->diffInDays(today());
        }
        
        return 0;
    }

    public function getNominalDendaAttribute()
    {
        if ($this->status === 'Dipinjam') {
            return $this->terlambat * self::DENDA_PER_HARI;
        }

        return (int) ($this->denda ?? 0);
    }
 
    // Accessor untuk status badge HTML
    public function getStatusBadgeAttribute()
    {
        return $this->status == 'Dipinjam' 
            ? '<span class="badge bg-warning text-dark">Dipinjam</span>'
            : '<span class="badge bg-success">Dikembalikan</span>';
    }
}
