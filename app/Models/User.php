<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name','email','password','role','bidang_id'
    ];

    protected $hidden = ['password','remember_token'];

    public function bidang(){
        return $this->belongsTo(Bidang::class);
    }

    public function barangs(){
        return $this->hasMany(Barang::class,'bidang_id','bidang_id');
    }
}
