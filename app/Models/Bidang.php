<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    use HasFactory;

    protected $table = 'bidangs';

    protected $fillable = [
        'nama_bidang',

    ];

    /**
     * Relasi ke User (One to Many)
     * Satu bidang punya banyak user
     */
    public function users()
    {
        return $this->hasMany(User::class, 'bidang_id');
    }

    /**
     * Relasi ke Barang (One to Many)
     * Satu bidang punya banyak barang
     */
    public function barang()
    {
        return $this->hasMany(Barang::class, 'bidang_id');
    }

    /**
     * Relasi ke Peminjaman (One to Many)
     * Satu bidang punya banyak peminjaman
     */
    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class, 'bidang_id');
    }
}
