<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::all();
        return view('admin.kategori.index', compact('kategoris'));
    }

    public function create()
    {
        return view('admin.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);
        Alert::success('Berhasil', 'Kategori berhasil ditambahkan');
        return redirect()->route('admin.kategori.index');
    }

    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);
        Alert::success('Berhasil', 'Kategori berhasil diperbarui');
        return redirect()->route('admin.kategori.index');
    }
    public function show(Kategori $kategori)
{
    return redirect()->route('admin.kategori.index');
}
public function destroy(Kategori $kategori)
{
    if ($kategori->barangs()->count() > 0) {
        Alert::error('Gagal','Kategori masih dipakai oleh barang, tidak bisa dihapus.');
        return back();
    }

    $kategori->delete();
     Alert::success('Berhasil','Kategori berhasil dihapus' );
    return back();
}

}
