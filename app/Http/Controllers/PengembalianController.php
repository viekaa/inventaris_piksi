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

        $query = Pengembalian::with('peminjaman.barang','peminjaman.user');

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
    $user = Auth::user();

    $query = Peminjaman::whereDoesntHave('pengembalian')
                        ->with('barang');

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
        $r->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tgl_kembali' => 'required|date',
            'kondisi_saat_kembali' => 'required'
        ]);

        $peminjaman = Peminjaman::with(['barang','pengembalian'])->findOrFail($r->peminjaman_id);

        // petugas tidak boleh kembalikan barang luar bidangnya
        if(Auth::user()->role=='petugas' &&
           $peminjaman->barang->bidang_id != Auth::user()->bidang_id){
            abort(403,'Bukan peminjaman dari bidang kamu');
        }

        // cegah double pengembalian
        if($peminjaman->pengembalian){
            return back()->with('error','Peminjaman ini sudah dikembalikan');
        }

        // simpan pengembalian
        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_kembali' => $r->tgl_kembali,
            'kondisi_saat_kembali' => $r->kondisi_saat_kembali
        ]);

        // kembalikan stok
        $peminjaman->barang->increment('stok', $peminjaman->jumlah);

        return redirect()->route('pengembalian.index')
                         ->with('ok','Pengembalian berhasil, stok barang kembali');
    }

    public function show(Pengembalian $pengembalian)
    {
        $this->authorizePengembalian($pengembalian);
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function destroy(Pengembalian $pengembalian)
    {
        $this->authorizePengembalian($pengembalian);

        // jika pengembalian dihapus, stok harus dikurangi lagi
        $pengembalian->peminjaman->barang
                     ->decrement('stok', $pengembalian->peminjaman->jumlah);

        $pengembalian->delete();

        return back()->with('ok','Pengembalian berhasil dihapus');
    }

    private function authorizePengembalian($pengembalian)
    {
        if(Auth::user()->role=='petugas' &&
           $pengembalian->peminjaman->barang->bidang_id != Auth::user()->bidang_id){
            abort(403,'Akses bukan bidang kamu');
        }
    }
}
