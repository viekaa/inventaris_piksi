<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $fillable = [
        'nama_barang',
        'kategori_id',
        'lokasi_id',
        'bidang_id',
        'jumlah_total',
        'stok',
        'kondisi',  // baik | perlu_perbaikan | rusak
    ];

    // ── Relasi ───────────────────────────────────────────────────────

    public function kategori()
    {
        return $this->belongsTo(Kategori::class);
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class);
    }

    public function bidang()
    {
        return $this->belongsTo(Bidang::class);
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class);
    }

    // ── Accessor ─────────────────────────────────────────────────────

    public function getKondisiLabelAttribute(): string
    {
        return ucwords(str_replace('_', ' ', $this->kondisi));
    }

    // ── Scope ─────────────────────────────────────────────────────────

    public function scopePerluPerbaikan($query)
    {
        return $query->where('kondisi', 'perlu_perbaikan');
    }

    public function scopeRusak($query)
    {
        return $query->where('kondisi', 'rusak');
    }

    public function scopeStokMenipis($query, int $batas = 5)
    {
        return $query->where('stok', '<=', $batas);
    }
}
