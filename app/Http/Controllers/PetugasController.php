<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class PetugasController extends Controller
{
    public function index()
    {
        $petugas = User::where('role', 'petugas')->with('bidang')->get();
        return view('admin.pengguna.index', compact('petugas'));
    }

    public function create()
    {
        $bidang = Bidang::all();
        return view('admin.pengguna.create', compact('bidang'));
    }

    public function store(Request $r)
    {
        $r->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email',
            'password'  => 'required|min:6',
            'bidang_id' => 'required',
        ]);

        User::create([
            'name'      => $r->name,
            'email'     => $r->email,
            'password'  => Hash::make($r->password),
            'role'      => 'petugas',
            'bidang_id' => $r->bidang_id,
            'status'    => 'aktif',
        ]);

        Alert::success('Berhasil', 'Pengguna berhasil ditambahkan');
        return redirect()->route('admin.petugas.index');
    }

    public function edit(User $user)
    {
        $bidang = Bidang::all();
        return view('admin.pengguna.edit', compact('user', 'bidang'));
    }

    public function update(Request $r, User $user)
    {
        $r->validate([
            'name'      => 'required',
            'email'     => 'required|email|unique:users,email,' . $user->id,
            'bidang_id' => 'required',
        ]);

        $user->update([
            'name'      => $r->name,
            'email'     => $r->email,
            'bidang_id' => $r->bidang_id,
        ]);

        Alert::success('Berhasil', 'Pengguna berhasil diperbarui');
        return redirect()->route('admin.petugas.index');
    }

    public function destroy(User $user)
    {
        if ($user->status === 'nonaktif') {
            Alert::info('Info', 'Akun sudah nonaktif sebelumnya');
            return back();
        }

        $user->update(['status' => 'nonaktif']);

        Alert::success('Berhasil', 'Akun berhasil dinonaktifkan');
        return redirect()->route('admin.petugas.index');
    }

    public function aktifkan(User $user)
    {
        if ($user->status === 'aktif') {
            Alert::info('Info', 'Akun sudah aktif');
            return back();
        }

        $user->update(['status' => 'aktif']);

        Alert::success('Berhasil', 'Akun berhasil diaktifkan kembali');
        return redirect()->route('admin.petugas.index');
    }
}
