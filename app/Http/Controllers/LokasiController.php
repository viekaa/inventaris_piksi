<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::all();
        return view('admin.lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('admin.lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi
        ]);
          Alert::success('Berhasil', 'Lokasi berhasil ditambahkan');
        return redirect()->route('admin.lokasi.index');
    }

    public function show(Lokasi $lokasi)
    {
        return redirect()->route('admin.lokasi.index');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('admin.lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        Alert::success('Berhasil', 'Lokasi berhasil diperbarui');
        return redirect()->route('admin.lokasi.index');
    }
    
    public function destroy(Lokasi $lokasi)
    {
        if ($lokasi->barangs()->count() > 0) {
            Alert::error('Gagal','Lokasi masih dipakai oleh barang, tidak bisa dihapus.' );
            return back();
        }

        $lokasi->delete();
         Alert::success('Berhasil', 'Lokasi berhasil dihapus');
        return redirect()->route('admin.lokasi.index');
    }

}
