<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $query = Peminjaman::with(['barang','jurusan.fakultas']);

        // Petugas hanya lihat peminjaman dari bidangnya
        if($user->role == 'petugas'){
            $query->whereHas('barang', function($q) use ($user){
                $q->where('bidang_id', $user->bidang_id);
            });
        }

        return view('peminjaman.index', [
            'peminjaman' => $query->get()
        ]);
    }

    public function create()
    {
        $user = Auth::user();

        // Petugas hanya boleh pilih barang bidangnya
        $barang = $user->role == 'admin'
            ? Barang::all()
            : Barang::where('bidang_id', $user->bidang_id)->get();

        // Ambil jurusan + fakultas lalu kelompokkan per fakultas
        $jurusans = Jurusan::with('fakultas')
            ->orderBy('nama_jurusan')
            ->get()
            ->groupBy(fn($j) => $j->fakultas->nama_fakultas);

        return view('peminjaman.create', [
            'barang'   => $barang,
            'jurusans' => $jurusans
        ]);
    }

    public function store(Request $r)
    {
        $r->validate([
            'barang_id' => 'required|exists:barangs,id',
            'nama_peminjam' => 'required',
            'npm' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
            'angkatan' => 'required|digits:4',
            'jumlah' => 'required|integer|min:1',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'kondisi_saat_pinjam' => 'required'
        ]);

        $barang = Barang::findOrFail($r->barang_id);

        // 🔒 Petugas tidak boleh pinjam barang bidang lain
        if(Auth::user()->role=='petugas' && $barang->bidang_id != Auth::user()->bidang_id){
            abort(403,'Barang bukan bidang kamu');
        }

        // 🔒 Stok tidak boleh minus
        if($barang->stok < $r->jumlah){
            return back()->with('error','Stok tidak mencukupi');
        }

        Peminjaman::create([
            'barang_id' => $r->barang_id,
            'nama_peminjam' => $r->nama_peminjam,
            'npm' => $r->npm,
            'jurusan_id' => $r->jurusan_id,
            'angkatan' => $r->angkatan,
            'jumlah' => $r->jumlah,
            'tgl_pinjam' => $r->tgl_pinjam,
            'tgl_kembali_rencana' => $r->tgl_kembali_rencana,
            'kondisi_saat_pinjam' => $r->kondisi_saat_pinjam,
        ]);

        // Kurangi stok
        $barang->decrement('stok', $r->jumlah);

        return redirect()->route('peminjaman.index')->with('ok','Peminjaman berhasil');
    }

    public function show(Peminjaman $peminjaman)
    {
        $this->authorizePeminjaman($peminjaman);
        return view('peminjaman.show', compact('peminjaman'));
    }

    public function edit(Peminjaman $peminjaman)
    {
        $this->authorizePeminjaman($peminjaman);

        // Ambil jurusan + fakultas lalu kelompokkan per fakultas
        $jurusans = Jurusan::with('fakultas')
            ->orderBy('nama_jurusan')
            ->get()
            ->groupBy(fn($j) => $j->fakultas->nama_fakultas);

        return view('peminjaman.edit', [
            'peminjaman' => $peminjaman,
            'jurusans'   => $jurusans
        ]);
    }

    public function update(Request $r, Peminjaman $peminjaman)
    {
        $this->authorizePeminjaman($peminjaman);

        $r->validate([
            'nama_peminjam'=>'required',
            'npm'=>'required',
            'jurusan_id'=>'required|exists:jurusans,id',
            'angkatan'=>'required|digits:4',
            'tgl_pinjam'=>'required|date',
            'tgl_kembali_rencana'=>'required|date|after_or_equal:tgl_pinjam',
            'kondisi_saat_pinjam'=>'required'
        ]);

        $peminjaman->update([
            'nama_peminjam' => $r->nama_peminjam,
            'npm' => $r->npm,
            'jurusan_id' => $r->jurusan_id,
            'angkatan' => $r->angkatan,
            'tgl_pinjam' => $r->tgl_pinjam,
            'tgl_kembali_rencana' => $r->tgl_kembali_rencana,
            'kondisi_saat_pinjam' => $r->kondisi_saat_pinjam,
        ]);

        return redirect()->route('peminjaman.index')->with('ok','Peminjaman diupdate');
    }

    public function destroy(Peminjaman $peminjaman)
    {
        $this->authorizePeminjaman($peminjaman);

        // kembalikan stok saat hapus
        $peminjaman->barang->increment('stok', $peminjaman->jumlah);

        $peminjaman->delete();
        return back()->with('ok','Peminjaman dihapus & stok dikembalikan');
    }

    /* 🔒 SECURITY */
    private function authorizePeminjaman($peminjaman)
    {
        if(Auth::user()->role=='petugas' &&
           $peminjaman->barang->bidang_id != Auth::user()->bidang_id){
            abort(403,'Akses peminjaman bukan bidang kamu');
        }
    }
}
