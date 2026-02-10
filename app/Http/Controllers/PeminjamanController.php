<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Jurusan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /* ============================
        INDEX
    ============================ */
    public function index()
    {
        $user = Auth::user();

        $query = Peminjaman::with(['barang','jurusan.fakultas']);

        if ($user->role == 'petugas') {
            $query->whereHas('barang', function ($q) use ($user) {
                $q->where('bidang_id', $user->bidang_id);
            });
        }

        return view('peminjaman.index', [
            'peminjaman' => $query->latest()->get()
        ]);
    }

    /* ============================
        CREATE
    ============================ */
    public function create()
    {
        $this->onlyPetugas();

        $user = Auth::user();

        $barang = Barang::where('bidang_id', $user->bidang_id)->get();

        $jurusans = Jurusan::with('fakultas')
            ->orderBy('nama_jurusan')
            ->get()
            ->groupBy(fn($j) => $j->fakultas->nama_fakultas);

        return view('peminjaman.create', compact('barang','jurusans'));
    }

    /* ============================
        STORE
    ============================ */
    public function store(Request $r)
    {
        $this->onlyPetugas();

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

        if ($barang->bidang_id != Auth::user()->bidang_id) {
            abort(403,'Barang bukan bidang kamu');
        }

        if ($barang->stok < $r->jumlah) {
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
            'status' => 'dipinjam'
        ]);

        $barang->decrement('stok', $r->jumlah);

        return redirect()->route('petugas.peminjaman.index')
                         ->with('ok','Peminjaman berhasil');
    }

    /* ============================
        SHOW
    ============================ */
    public function show(Peminjaman $peminjaman)
    {
        $this->authorizeBidang($peminjaman);
        return view('peminjaman.show', compact('peminjaman'));
    }

    /* ============================
        EDIT
    ============================ */
    public function edit(Peminjaman $peminjaman)
    {
        $this->onlyPetugas();
        $this->authorizePeminjaman($peminjaman);

        $jurusans = Jurusan::with('fakultas')
            ->orderBy('nama_jurusan')
            ->get()
            ->groupBy(fn($j) => $j->fakultas->nama_fakultas);

        return view('peminjaman.edit', compact('peminjaman','jurusans'));
    }

    /* ============================
        UPDATE
    ============================ */
    public function update(Request $r, Peminjaman $peminjaman)
    {
        $this->onlyPetugas();
        $this->authorizePeminjaman($peminjaman);

        $r->validate([
            'nama_peminjam' => 'required',
            'npm' => 'required',
            'jurusan_id' => 'required|exists:jurusans,id',
            'angkatan' => 'required|digits:4',
            'tgl_pinjam' => 'required|date',
            'tgl_kembali_rencana' => 'required|date|after_or_equal:tgl_pinjam',
            'kondisi_saat_pinjam' => 'required'
        ]);

        $peminjaman->update($r->only([
            'nama_peminjam','npm','jurusan_id','angkatan',
            'tgl_pinjam','tgl_kembali_rencana','kondisi_saat_pinjam'
        ]));

        return redirect()->route('petugas.peminjaman.index')
                         ->with('ok','Peminjaman diupdate');
    }

    /* ============================
        KEMBALIKAN BARANG
    ============================ */
    public function kembalikan(Peminjaman $peminjaman)
    {
        $this->onlyPetugas();
        $this->authorizePeminjaman($peminjaman);

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error','Barang sudah dikembalikan');
        }

        $peminjaman->barang->increment('stok', $peminjaman->jumlah);

        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        return back()->with('ok','Barang berhasil dikembalikan');
    }

    /* ============================
        DELETE
    ============================ */
    public function destroy(Peminjaman $peminjaman)
    {
        $this->onlyPetugas();
        $this->authorizePeminjaman($peminjaman);

        // hanya yang masih dipinjam boleh dihapus
        $peminjaman->barang->increment('stok', $peminjaman->jumlah);
        $peminjaman->delete();

        return back()->with('ok','Peminjaman dihapus & stok dikembalikan');
    }

    /* ============================
        SECURITY
    ============================ */

    private function onlyPetugas()
    {
        if (Auth::user()->role !== 'petugas') {
            abort(403,'Admin hanya boleh melihat data');
        }
    }

    private function authorizeBidang($peminjaman)
    {
        if (
            Auth::user()->role === 'petugas' &&
            $peminjaman->barang->bidang_id != Auth::user()->bidang_id
        ) {
            abort(403,'Akses peminjaman bukan bidang kamu');
        }
    }

    private function authorizePeminjaman($peminjaman)
    {
        $this->authorizeBidang($peminjaman);

        if ($peminjaman->status === 'dikembalikan') {
            abort(403,'Barang sudah dikembalikan, data dikunci');
        }
    }
}
