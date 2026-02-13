<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengembalianDetail extends Model
{
    protected $fillable = [
        'pengembalian_id',
        'kondisi',
        'jumlah'
    ];

    public function pengembalian()
    {
        return $this->belongsTo(Pengembalian::class);
    }
}
