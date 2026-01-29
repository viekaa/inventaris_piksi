<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BarangController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $barang = $user->role == 'admin'
            ? Barang::with(['kategori','lokasi','bidang'])->get()
            : Barang::with(['kategori','lokasi','bidang'])
                ->where('bidang_id', $user->bidang_id)
                ->get();

        return view('barang.index', compact('barang'));
    }

    public function create()
    {
        $user = Auth::user();

        return view('barang.create', [
            'kategori' => Kategori::all(),
            'lokasi'   => Lokasi::all(),
            'bidang'   => $user->role == 'admin'
                            ? Bidang::all()
                            : Bidang::where('id', $user->bidang_id)->get()
        ]);
    }

    public function store(Request $r)
    {
        $user = Auth::user();

        // Validation rules
        $rules = [
            'nama_barang'   => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategoris,id',
            'lokasi_id'     => 'required|exists:lokasis,id',
            'jumlah_total'  => 'required|integer|min:0',
            'stok'          => 'required|integer|min:0',
            'kondisi'       => 'required|in:baik,rusak,perlu_perbaikan'
        ];

        // Only admin can choose bidang
        if ($user->role == 'admin') {
            $rules['bidang_id'] = 'required|exists:bidangs,id';
        }

        $validated = $r->validate($rules);

        // Create barang
        Barang::create([
            'nama_barang'   => $validated['nama_barang'],
            'kategori_id'   => $validated['kategori_id'],
            'lokasi_id'     => $validated['lokasi_id'],
            'bidang_id'     => $user->role == 'admin'
                                ? $validated['bidang_id']
                                : $user->bidang_id,
            'jumlah_total'  => $validated['jumlah_total'],
            'stok'          => $validated['stok'],
            'kondisi'       => $validated['kondisi']
        ]);

        return redirect()->route('barang.index')
                         ->with('success','Barang berhasil ditambahkan!');
    }

    public function show(Barang $barang)
    {
        $this->authorizeBarang($barang);
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $this->authorizeBarang($barang);

        $user = Auth::user();

        return view('barang.edit', [
            'barang'   => $barang,
            'kategori' => Kategori::all(),
            'lokasi'   => Lokasi::all(),
            'bidang'   => $user->role == 'admin'
                            ? Bidang::all()
                            : Bidang::where('id', $user->bidang_id)->get()
        ]);
    }

    public function update(Request $r, Barang $barang)
    {
        $this->authorizeBarang($barang);

        $user = Auth::user();

        // Validation rules
        $rules = [
            'nama_barang'   => 'required|string|max:255',
            'kategori_id'   => 'required|exists:kategoris,id',
            'lokasi_id'     => 'required|exists:lokasis,id',
            'jumlah_total'  => 'required|integer|min:0',
            'stok'          => 'required|integer|min:0|lte:jumlah_total',
            'kondisi'       => 'required|in:baik,rusak,perlu_perbaikan'
        ];

        // Only admin can change bidang
        if ($user->role == 'admin') {
            $rules['bidang_id'] = 'required|exists:bidangs,id';
        }

        $validated = $r->validate($rules);

        // Prepare update data
        $updateData = [
            'nama_barang'   => $validated['nama_barang'],
            'kategori_id'   => $validated['kategori_id'],
            'lokasi_id'     => $validated['lokasi_id'],
            'jumlah_total'  => $validated['jumlah_total'],
            'stok'          => $validated['stok'],
            'kondisi'       => $validated['kondisi']
        ];

        // Only admin can update bidang
        if ($user->role == 'admin' && isset($validated['bidang_id'])) {
            $updateData['bidang_id'] = $validated['bidang_id'];
        }

        $barang->update($updateData);

        return redirect()->route('barang.index')
                         ->with('success','Barang berhasil diperbarui!');
    }

    public function destroy(Barang $barang)
    {
        $this->authorizeBarang($barang);

        $namaBarang = $barang->nama_barang;
        $barang->delete();

        return redirect()->route('barang.index')
                         ->with('success', "Barang '{$namaBarang}' berhasil dihapus!");
    }

    /**
     * Authorization check for petugas
     * Petugas can only access barang from their bidang
     */
    private function authorizeBarang($barang)
    {
        $user = Auth::user();

        if ($user->role == 'petugas' && $barang->bidang_id != $user->bidang_id) {
            abort(403, 'Anda tidak memiliki akses ke barang dari bidang lain.');
        }
    }
}
