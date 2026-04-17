<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Buku; // 🔥 WAJIB
use Carbon\Carbon;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'buku_id',
        'judul_buku', // 🔥 backup
        'penulis',
        'user_id',
        'nama',
        'email',
        'telepon',
        'tgl_pinjam',
        'tgl_kembali',
        'tgl_dikembalikan',
        'status',
        'denda'
    ];

    // 🔥 RELASI KE BUKU (SUPPORT SOFT DELETE)
    public function buku()
{
    return $this->belongsTo(Buku::class, 'buku_id', 'id_buku')->withTrashed();
}
    // 🔥 RELASI KE USER
    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}