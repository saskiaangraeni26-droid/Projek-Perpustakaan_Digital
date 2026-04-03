<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
    'buku_id',
    'user_id',
    'nama',
    'nis',
    'telepon',
    'tgl_pinjam',
    'tgl_kembali',
    'status',        // dipinjam, menunggu_konfirmasi, dikembalikan
    'denda'          // baru: simpan denda otomatis
];

    // 🔥 RELASI KE BUKU
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id_buku');
    }

    public function user()
    {
    return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function hitungDenda()
{
    $today = now();
    $tglKembali = \Carbon\Carbon::parse($this->tgl_kembali);
    $terlambat = $today->greaterThan($tglKembali) ? $tglKembali->diffInDays($today) : 0;
    $this->denda = $terlambat * 1000; // Rp 1000 per hari
    $this->save();
    return $this->denda;
}
}