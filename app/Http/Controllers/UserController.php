<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index(){
        return view('petugas.index',[
            'petugas'=>User::where('role','petugas')->with('bidang')->get()
        ]);
    }

    public function create(){
        return view('petugas.create',['bidang'=>Bidang::all()]);
    }

    public function store(Request $r){
        User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password),
            'role'=>'petugas',
            'bidang_id'=>$r->bidang_id
        ]);
        return redirect()->route('petugas.index');
    }

    public function edit(User $petuga){
        return view('petugas.edit',[
            'petugas'=>$petuga,
            'bidang'=>Bidang::all()
        ]);
    }

    public function update(Request $r,User $petuga){
        $petuga->update([
            'name'=>$r->name,
            'email'=>$r->email,
            'bidang_id'=>$r->bidang_id
        ]);
        return redirect()->route('petugas.index');
    }

    public function destroy(User $petuga){
        $petuga->delete();
        return back();
    }
}
