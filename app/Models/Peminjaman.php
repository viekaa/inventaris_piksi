<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjamans';

    protected $fillable = [
        'barang_id',
        'nama_peminjam',
        'jumlah',
        'tgl_pinjam',
        'tgl_kembali_rencana',
        'kondisi_saat_pinjam'
    ];

    public function barang()
    {
        return $this->belongsTo(Barang::class);
    }

    public function pengembalian()
    {
        return $this->hasOne(Pengembalian::class);
    }
}
