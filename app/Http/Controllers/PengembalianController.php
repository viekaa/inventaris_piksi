<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengembalianController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Pengembalian::with('peminjaman.barang');

        // Petugas hanya lihat pengembalian dari bidangnya
        if($user->role == 'petugas'){
            $query->whereHas('peminjaman.barang', function($q) use ($user){
                $q->where('bidang_id', $user->bidang_id);
            });
        }

        return view('pengembalian.index', [
            'pengembalian' => $query->get()
        ]);
    }

    public function create()
    {
        // 🔒 Admin tidak boleh input pengembalian
        if(Auth::user()->role == 'admin'){
            abort(403,'Admin hanya boleh melihat data pengembalian');
        }

        $user = Auth::user();

        // Ambil peminjaman yang belum dikembalikan
        $query = Peminjaman::whereDoesntHave('pengembalian')
                            ->with('barang');

        // Petugas hanya bisa akses peminjaman dari bidangnya
        if($user->role == 'petugas'){
            $query->whereHas('barang', function($q) use ($user){
                $q->where('bidang_id', $user->bidang_id);
            });
        }

        return view('pengembalian.create',[
            'peminjaman' => $query->get()
        ]);
    }

    public function store(Request $r)
    {
        // 🔒 Admin tidak boleh simpan pengembalian
        if(Auth::user()->role == 'admin'){
            abort(403,'Admin hanya boleh melihat data pengembalian');
        }

        $r->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tgl_kembali' => 'required|date',
            'kondisi_saat_kembali' => 'required|in:baik,rusak,perlu_perbaikan'
        ]);

        $peminjaman = Peminjaman::with(['barang','pengembalian'])
                        ->findOrFail($r->peminjaman_id);

        // 🔒 Petugas hanya boleh kembalikan barang bidangnya
        if(Auth::user()->role == 'petugas' &&
           $peminjaman->barang->bidang_id != Auth::user()->bidang_id){
            abort(403,'Bukan peminjaman dari bidang Anda');
        }

        // Cegah double pengembalian
        if($peminjaman->pengembalian){
            return back()->with('error','Peminjaman ini sudah dikembalikan');
        }

        // Simpan pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_kembali' => $r->tgl_kembali,
            'kondisi_saat_kembali' => $r->kondisi_saat_kembali
        ]);

        // Kembalikan stok
        $peminjaman->barang->increment('stok', $peminjaman->jumlah);

        return redirect()->route('petugas.pengembalian.index')
                         ->with('ok','Pengembalian berhasil disimpan, stok barang telah dikembalikan');
    }

    public function show(Pengembalian $pengembalian)
    {
        $this->authorizePengembalian($pengembalian);
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        // 🔒 Admin tidak boleh edit
        if(Auth::user()->role == 'admin'){
            abort(403,'Admin hanya boleh melihat data pengembalian');
        }

        $this->authorizePengembalian($pengembalian);

        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $r, Pengembalian $pengembalian)
    {
        // 🔒 Admin tidak boleh update
        if(Auth::user()->role == 'admin'){
            abort(403,'Admin hanya boleh melihat data pengembalian');
        }

        $this->authorizePengembalian($pengembalian);

        $r->validate([
            'tgl_kembali' => 'required|date',
            'kondisi_saat_kembali' => 'required|in:baik,rusak,perlu_perbaikan'
        ]);

        $pengembalian->update([
            'tgl_kembali' => $r->tgl_kembali,
            'kondisi_saat_kembali' => $r->kondisi_saat_kembali
        ]);

        return redirect()->route('pengembalian.index')
                         ->with('ok','Data pengembalian berhasil diperbarui');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        // 🔒 Admin tidak boleh hapus
        if(Auth::user()->role == 'admin'){
            abort(403,'Admin hanya boleh melihat data pengembalian');
        }

        $this->authorizePengembalian($pengembalian);

        // Jika pengembalian dihapus, stok harus dikurangi lagi
        $pengembalian->peminjaman->barang
                     ->decrement('stok', $pengembalian->peminjaman->jumlah);

        $pengembalian->delete();

        return redirect()->route('pengembalian.index')
                         ->with('ok','Data pengembalian berhasil dihapus, stok telah disesuaikan');
    }

    /* 🔒 SECURITY - Authorization bidang */
    private function authorizePengembalian($pengembalian)
    {
        $user = Auth::user();

        if($user->role == 'petugas' &&
           $pengembalian->peminjaman->barang->bidang_id != $user->bidang_id){
            abort(403,'Anda tidak memiliki akses ke pengembalian dari bidang lain');
        }
    }
}
