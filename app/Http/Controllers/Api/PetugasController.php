<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class PetugasController extends Controller
{
    // 📋 GET semua petugas
    public function index()
    {
        $petugas = User::where('role', 'petugas')
            ->with('bidang')
            ->get()
            ->map(fn($u) => $this->format($u));

        return response()->json([
            'status'  => true,
            'message' => 'Data petugas berhasil diambil',
            'data'    => $petugas
        ]);
    }

    // ➕ POST tambah petugas
public function store(Request $request)
{
    $request->validate([
        'name'      => 'required|string|max:255',
        'email'     => 'required|email|unique:users,email',
        'password'  => 'required|min:6',
        'bidang_id' => 'required|exists:bidangs,id',
    ]);

    $petugas = User::create([
        'name'      => $request->name,
        'email'     => $request->email,
        'password'  => Hash::make($request->password),
        'role'      => 'petugas',
        'bidang_id' => $request->bidang_id,
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Petugas berhasil ditambahkan',
        'data'    => $this->format($petugas->load('bidang'))
    ], 201);
}

 // 🔍 GET detail petugas
public function show($id)
{
    $petugas = User::where('id', $id)->where('role', 'petugas')->with('bidang')->first();

    if (!$petugas) {
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    return response()->json([
        'status'  => true,
        'message' => 'Detail petugas berhasil diambil',
        'data'    => $this->format($petugas)
    ]);
}

// ✏️ PUT update petugas
public function update(Request $request, $id)
{
    $petugas = User::where('id', $id)->where('role', 'petugas')->first();

    if (!$petugas) {
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    $request->validate([
        'name'      => 'sometimes|string|max:255',
        'email'     => ['sometimes', 'email', Rule::unique('users')->ignore($petugas->id)],
        'password'  => 'sometimes|min:6',
        'bidang_id' => 'sometimes|exists:bidangs,id',
    ]);

    $petugas->update([
        'name'      => $request->name      ?? $petugas->name,
        'email'     => $request->email     ?? $petugas->email,
        'bidang_id' => $request->bidang_id ?? $petugas->bidang_id,
        ...($request->filled('password') ? ['password' => Hash::make($request->password)] : []),
    ]);

    return response()->json([
        'status'  => true,
        'message' => 'Petugas berhasil diupdate',
        'data'    => $this->format($petugas->fresh('bidang'))
    ]);
}

// 🗑️ DELETE petugas
public function destroy($id)
{
    $petugas = User::where('id', $id)->where('role', 'petugas')->first();

    if (!$petugas) {
        return response()->json(['status' => false, 'message' => 'Data tidak ditemukan'], 404);
    }

    $petugas->tokens()->delete();
    $petugas->delete();

    return response()->json([
        'status'  => true,
        'message' => 'Petugas berhasil dihapus'
    ]);
}

    // 🔧 Helper format response
    private function format(User $u): array
    {
        return [
            'id'     => $u->id,
            'name'   => $u->name,
            'email'  => $u->email,
            'role'   => $u->role,
            'bidang' => $u->bidang ? [
                'id'          => $u->bidang->id,
                'nama_bidang' => $u->bidang->nama_bidang
            ] : null,
            'created_at' => $u->created_at->toDateTimeString(),
        ];
    }
}
