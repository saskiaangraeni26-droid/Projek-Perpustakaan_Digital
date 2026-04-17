<?php

namespace App\Models;
use App\Models\Category;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Buku extends Model
{
    use SoftDeletes;

    protected $table = 'buku';
    protected $primaryKey = 'id_buku';

    public $timestamps = false;

    protected $fillable = [
    'judul_buku',
    'penulis',
    'tahun_terbit',
    'stok',
    'cover',
    'category_id'
    ];

    protected $dates = ['deleted_at'];

    /*
    |--------------------------------------------------------------------------
    | RELASI
    |--------------------------------------------------------------------------
    */

    // 🔥 Relasi ke peminjaman
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id', 'id_buku');
    }

    /*
    |--------------------------------------------------------------------------
    | HELPER / LOGIC
    |--------------------------------------------------------------------------
    */

    // ✅ Cek apakah buku masih tersedia
    public function isTersedia()
    {
        return $this->stok > 0 && $this->deleted_at == null;
    }

    // ✅ Cek apakah buku sedang dipinjam
    public function sedangDipinjam()
    {
        return $this->peminjaman()
            ->where('status', 'dipinjam')
            ->exists();
    }

    // ✅ Kurangi stok saat dipinjam
    public function kurangiStok()
    {
        if ($this->stok > 0) {
            $this->stok -= 1;
            $this->save();
        }
    }

    // ✅ Tambah stok saat dikembalikan
    public function tambahStok()
    {
        $this->stok += 1;
        $this->save();
    }

    /*
    |--------------------------------------------------------------------------
    | EVENT (AUTO HANDLE)
    |--------------------------------------------------------------------------
    */

    protected static function booted()
    {
        static::deleting(function ($buku) {

            // 🔥 AUTO TOLAK peminjaman yang masih menunggu
            \App\Models\Peminjaman::where('buku_id', $buku->id_buku)
                ->where('status', 'menunggu')
                ->update([
                    'status' => 'ditolak',
                    'keterangan' => 'Buku sudah tidak tersedia'
                ]);
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}