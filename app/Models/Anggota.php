<?php
 
namespace App\Models;
 
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
 
class Anggota extends Model
{
    use HasFactory;
 
    /**
     * Nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'anggota';
    protected $guarded = ['id']; // atau $fillable

    // ==========================================
    // 1. ACCESSOR
    // ==========================================

    public function getStatusBadgeAttribute(): string
    {
        return $this->status == 'Aktif' 
            ? '<span class="badge bg-success">Aktif</span>' 
            : '<span class="badge bg-secondary">Nonaktif</span>';
    }

    public function getKategoriUsiaAttribute(): string
    {
        // Pastikan tanggal_lahir tidak kosong sebelum diproses
        if (!$this->tanggal_lahir) return "Data tidak valid";

        // Carbon::parse akan mengubah string tanggal menjadi objek, lalu ->age akan menghitung umurnya
        $umur = Carbon::parse($this->tanggal_lahir)->age;

        if ($umur < 20) return "Remaja";
        if ($umur >= 20 && $umur <= 50) return "Dewasa";
        return "Senior";
    }

    // ==========================================
    // 2. SCOPE
    // ==========================================

    public function scopeTerdaftarBulanIni($query)
    {
        // Filter bulan dan tahun sama dengan bulan & tahun saat ini (realtime)
        return $query->whereMonth('tanggal_daftar', Carbon::now()->month)
                     ->whereYear('tanggal_daftar', Carbon::now()->year);
    }
 
    /**
     * Kolom yang dapat diisi secara mass assignment.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'kode_anggota',
        'nama',
        'email',
        'telepon',
        'alamat',
        'tanggal_lahir',
        'jenis_kelamin',
        'pekerjaan',
        'tanggal_daftar',
        'status',
    ];
 
    /**
     * Tipe casting untuk atribut.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_daftar' => 'date',
    ];
 
    /**
     * Accessor untuk menghitung umur.
     */
    public function getUmurAttribute(): int
    {
        return Carbon::parse($this->tanggal_lahir)->age;
    }
 
    /**
     * Accessor untuk lama menjadi anggota (dalam hari).
     */
    public function getLamaAnggotaAttribute(): int
    {
        return Carbon::parse($this->tanggal_daftar)->diffInDays(now());
    }
 
    /**
     * Scope untuk filter anggota aktif.
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'Aktif');
    }
 
    /**
     * Scope untuk filter berdasarkan jenis kelamin.
     */
    public function scopeJenisKelamin($query, $jenisKelamin)
    {
        return $query->where('jenis_kelamin', $jenisKelamin);
    }

    // Tambahkan method ini di class Anggota
    public function transaksis()
    {
        return $this->hasMany(Transaksi::class);
    }
}