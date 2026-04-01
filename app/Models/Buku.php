<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';
    public $timestamps = false;

    protected $fillable = [
        'judul_buku',
        'penulis',
        'tahun_terbit',
        'stok',
        'cover'
    ];

    // 🔥 RELASI
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id', 'id_buku');
    }
}