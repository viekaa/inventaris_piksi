<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        return view('admin.pengguna.index', [
            'petugas' => User::where('role', 'petugas')->with('bidang')->get()
        ]);
    }

    public function create()
    {
        return view('admin.pengguna.create', [
            'bidang' => Bidang::all()
        ]);
    }

    public function store(Request $r)
    {
        User::create([
            'name'      => $r->name,
            'email'     => $r->email,
            'password'  => Hash::make($r->password),
            'role'      => 'petugas',
            'bidang_id' => $r->bidang_id,
        ]);

        return redirect()->route('admin.petugas.index');
    }

    public function edit(User $petugas)
    {
        return view('admin.pengguna.edit', [
            'petugas' => $petugas,
            'bidang'  => Bidang::all()
        ]);
    }

    public function update(Request $r, User $petugas)
    {
        $petugas->update([
            'name'      => $r->name,
            'email'     => $r->email,
            'bidang_id' => $r->bidang_id,
        ]);

        return redirect()->route('admin.petugas.index');
    }

    public function destroy(User $petugas)
    {
        $petugas->delete();

        return back();
    }
}
