<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bidang extends Model
{
    protected $fillable = ['nama_bidang'];

    public function users(){
        return $this->hasMany(User::class, 'bidang_id');
    }

    public function barangs(){
        return $this->hasMany(Barang::class, 'bidang_id');
    }
}
