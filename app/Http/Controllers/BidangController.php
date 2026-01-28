<?php

namespace App\Http\Controllers;

use App\Models\Bidang;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BidangController extends Controller
{
    // list bidang
    public function index(){
        return view('bidang.index', [
            'bidangs' => Bidang::withCount('users')->get()
        ]);
    }

    // form tambah bidang
    public function create(){
        return view('bidang.create');
    }

    // simpan bidang
    public function store(Request $r){
        $r->validate([
            'nama_bidang'=>'required'
        ]);

        Bidang::create($r->all());
        return redirect()->route('bidang.index');
    }

    // DETAIL BIDANG + LIST PETUGAS
    public function show(Bidang $bidang){
        $bidang->load('users');
        return view('bidang.show', compact('bidang'));
    }

    // edit bidang
    public function edit(Bidang $bidang){
        return view('bidang.edit', compact('bidang'));
    }

    public function update(Request $r, Bidang $bidang){
        $r->validate([
            'nama_bidang'=>'required'
        ]);

        $bidang->update($r->all());
        return redirect()->route('bidang.index');
    }

    public function destroy(Bidang $bidang){
        $bidang->delete();
        return back();
    }

    /* ===================== */
    /* CRUD PETUGAS DALAM BIDANG */
    /* ===================== */

    public function storePetugas(Request $r, Bidang $bidang){
        $r->validate([
            'name'=>'required',
            'email'=>'required|email|unique:users',
            'password'=>'required|min:6'
        ]);

        User::create([
            'name'=>$r->name,
            'email'=>$r->email,
            'password'=>Hash::make($r->password),
            'role'=>'petugas',
            'bidang_id'=>$bidang->id
        ]);

        return back();
    }

    public function destroyPetugas(User $user){
        $user->delete();
        return back();
    }
}
