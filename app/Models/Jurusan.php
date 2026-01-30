<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jurusan extends Model
{
    protected $table = 'jurusans';

    protected $fillable = [
        'fakultas_id',
        'nama_jurusan'
    ];

    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }
}
