<?php

namespace App\Http\Controllers;

use App\Models\Lokasi;
use Illuminate\Http\Request;

class LokasiController extends Controller
{
    public function index()
    {
        $lokasis = Lokasi::all();
        return view('lokasi.index', compact('lokasis'));
    }

    public function create()
    {
        return view('lokasi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        Lokasi::create([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()->route('lokasi.index')->with('success','Lokasi berhasil ditambahkan');
    }

    public function show(Lokasi $lokasi)
    {
        return redirect()->route('lokasi.index');
    }

    public function edit(Lokasi $lokasi)
    {
        return view('lokasi.edit', compact('lokasi'));
    }

    public function update(Request $request, Lokasi $lokasi)
    {
        $request->validate([
            'nama_lokasi' => 'required|string|max:255'
        ]);

        $lokasi->update([
            'nama_lokasi' => $request->nama_lokasi
        ]);

        return redirect()->route('lokasi.index')->with('success','Lokasi berhasil diupdate');
    }

    public function destroy(Lokasi $lokasi)
    {
        if ($lokasi->barangs()->count() > 0) {
            return back()->with('error','Lokasi masih dipakai oleh barang, tidak bisa dihapus.');
        }
    
        $lokasi->delete();
        return redirect()->route('lokasi.index')->with('success','Lokasi berhasil dihapus');
    }
    
}
