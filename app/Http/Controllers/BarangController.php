<?php

namespace App\Http\Controllers;

use App\Models\Barang;
use App\Models\Kategori;
use App\Models\Lokasi;
use App\Models\Bidang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage; // Penting untuk hapus file
use RealRashid\SweetAlert\Facades\Alert;

class BarangController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $search = request('search');

        $query = Barang::with(['kategori', 'lokasi', 'bidang']);

        if ($user->role == 'petugas') {
            $query->where('bidang_id', $user->bidang_id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhereHas('kategori', fn ($k) => $k->where('nama_kategori', 'like', "%{$search}%"))
                  ->orWhereHas('lokasi',   fn ($l) => $l->where('nama_lokasi',   'like', "%{$search}%"))
                  ->orWhereHas('bidang',   fn ($b) => $b->where('nama_bidang',   'like', "%{$search}%"));
            });
        }

        return view('barang.index', ['barang' => $query->get()]);
    }

    public function exportPdf()
    {
        $user   = Auth::user();
        $search = request('search');

        $query = Barang::with(['kategori', 'lokasi', 'bidang']);

        if ($user->role == 'petugas') {
            $query->where('bidang_id', $user->bidang_id);
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('nama_barang', 'like', "%{$search}%")
                  ->orWhereHas('kategori', fn ($k) => $k->where('nama_kategori', 'like', "%{$search}%"))
                  ->orWhereHas('lokasi',   fn ($l) => $l->where('nama_lokasi',   'like', "%{$search}%"))
                  ->orWhereHas('bidang',   fn ($b) => $b->where('nama_bidang',   'like', "%{$search}%"));
            });
        }

        return view('pdf.barang', ['barang' => $query->get()]);
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

        $rules = [
            'nama_barang'  => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,id',
            'lokasi_id'    => 'required|exists:lokasis,id',
            'jumlah_total' => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0',
            'kondisi'      => 'required|in:baik,rusak,perlu_perbaikan',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048' // Validasi foto
        ];

        if ($user->role == 'admin') {
            $rules['bidang_id'] = 'required|exists:bidangs,id';
        }

        $validated = $r->validate($rules);

        // Handle Upload Foto
        if ($r->hasFile('foto')) {
            $validated['foto'] = $r->file('foto')->store('barang', 'public');
        }

        $validated['bidang_id'] = $user->role == 'admin' ? $validated['bidang_id'] : $user->bidang_id;

        Barang::create($validated);

        Alert::success('Berhasil', 'Barang berhasil di tambahkan!');
        return redirect()->route('barang.index');
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

        $rules = [
            'nama_barang'  => 'required|string|max:255',
            'kategori_id'  => 'required|exists:kategoris,id',
            'lokasi_id'    => 'required|exists:lokasis,id',
            'jumlah_total' => 'required|integer|min:0',
            'stok'         => 'required|integer|min:0|lte:jumlah_total',
            'kondisi'      => 'required|in:baik,rusak,perlu_perbaikan',
            'foto'         => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ];

        if ($user->role == 'admin') {
            $rules['bidang_id'] = 'required|exists:bidangs,id';
        }

        $validated = $r->validate($rules);

        // Handle Update Foto
        if ($r->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($barang->foto) {
                Storage::disk('public')->delete($barang->foto);
            }
            // Simpan foto baru
            $validated['foto'] = $r->file('foto')->store('barang', 'public');
        }

        if ($user->role != 'admin') {
            unset($validated['bidang_id']); // Pastikan bidang_id petugas tidak berubah sembarangan
        }

        $barang->update($validated);

        Alert::success('Berhasil', 'Barang berhasil diperbarui!');
        return redirect()->route('barang.index');
    }

    public function destroy(Barang $barang)
    {
        $this->authorizeBarang($barang);

        // Hapus file fisik foto dari storage sebelum hapus data
        if ($barang->foto) {
            Storage::disk('public')->delete($barang->foto);
        }

        $barang->delete();
        Alert::success('Berhasil', 'Barang berhasil dihapus!');
        return redirect()->route('barang.index');
    }

    private function authorizeBarang($barang)
    {
        $user = Auth::user();
        if ($user->role == 'petugas' && $barang->bidang_id != $user->bidang_id) {
            abort(403, 'Anda tidak memiliki akses ke barang dari bidang lain.');
        }
    }
}
