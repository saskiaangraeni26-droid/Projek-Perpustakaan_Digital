<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'buku_id',
        'user_id',
        'nama',
        'email',
        'telepon',
        'tgl_pinjam',
        'tgl_kembali',        // jatuh tempo
        'tgl_dikembalikan',   // input dari anggota
        'status',
        'denda'
    ];

    // 🔥 RELASI KE BUKU
    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id', 'id_buku');
    }

    // 🔥 RELASI KE USER
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    // 🔥 HITUNG DENDA (VERSI BENAR)
    public function hitungDenda()
    {
        // kalau belum ada tanggal dikembalikan → no denda
        if (!$this->tgl_dikembalikan || !$this->tgl_kembali) {
            $this->denda = 0;
            return 0;
        }

        $jatuhTempo = Carbon::parse($this->tgl_kembali);
        $dikembalikan = Carbon::parse($this->tgl_dikembalikan);

        // hitung selisih hari (kalau negatif = tidak telat)
        $terlambat = $jatuhTempo->diffInDays($dikembalikan, false);

        if ($terlambat > 0) {
            $this->denda = $terlambat * 1000; // 1000 per hari
        } else {
            $this->denda = 0;
        }

        return $this->denda;
    }
}