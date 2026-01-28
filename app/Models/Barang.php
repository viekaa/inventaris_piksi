<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model{
    protected $fillable=['nama_barang','kategori_id','lokasi_id','bidang_id','jumlah_total','stok','kondisi'];
    public function kategori(){ return $this->belongsTo(Kategori::class); }
    public function lokasi(){ return $this->belongsTo(Lokasi::class); }
    public function bidang(){ return $this->belongsTo(Bidang::class); }
    public function peminjamans(){ return $this->hasMany(Peminjaman::class); }
    public function getKondisiLabelAttribute()
{
    return ucwords(str_replace('_',' ', $this->kondisi));
}
}
