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
        $r->validate([
            'nama_barang'   => 'required',
            'kategori_id'   => 'required',
            'lokasi_id'     => 'required',
            'bidang_id'     => 'required_if:' . Auth::user()->role . ',admin',
            'jumlah_total'  => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0',
            'kondisi'       => 'required'
        ]);

        Barang::create([
            'nama_barang'   => $r->nama_barang,
            'kategori_id'   => $r->kategori_id,
            'lokasi_id'     => $r->lokasi_id,
            'bidang_id'     => Auth::user()->role == 'admin'
                                ? $r->bidang_id
                                : Auth::user()->bidang_id,
            'jumlah_total'  => $r->jumlah_total,
            'stok'          => $r->stok,
            'kondisi'       => $r->kondisi
        ]);

        return redirect()->route('barang.index')->with('ok','Barang berhasil ditambahkan');
    }

    public function show(Barang $barang)
    {
        $this->authorizeBarang($barang);
        return view('barang.show', compact('barang'));
    }

    public function edit(Barang $barang)
    {
        $this->authorizeBarang($barang);

        return view('barang.edit', [
            'barang'   => $barang,
            'kategori' => Kategori::all(),
            'lokasi'   => Lokasi::all()
        ]);
    }

    public function update(Request $r, Barang $barang)
    {
        $this->authorizeBarang($barang);

        $r->validate([
            'nama_barang'   => 'required',
            'kategori_id'   => 'required',
            'lokasi_id'     => 'required',
            'jumlah_total'  => 'required|integer|min:1',
            'stok'          => 'required|integer|min:0',
            'kondisi'       => 'required'
        ]);

        $barang->update($r->except('bidang_id'));

        return redirect()->route('barang.index')->with('ok','Barang berhasil diupdate');
    }

    public function destroy(Barang $barang)
    {
        $this->authorizeBarang($barang);
        $barang->delete();
        return back()->with('ok','Barang dihapus');
    }

    private function authorizeBarang($barang)
    {
        if (Auth::user()->role == 'petugas' && $barang->bidang_id != Auth::user()->bidang_id) {
            abort(403,'Akses barang bukan bidang kamu');
        }
    }
}
