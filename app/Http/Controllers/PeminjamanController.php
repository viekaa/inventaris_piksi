<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\Barang;
use App\Models\Jurusan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    /* =====================================================
        INDEX
    ===================================================== */
    public function index()
    {
        $user = Auth::user();

        $query = Peminjaman::with(['barang','jurusan.fakultas']);

        // Petugas hanya melihat barang dari bidangnya
        if ($user->role === 'petugas') {
            $query->whereHas('barang', function ($q) use ($user) {
                $q->where('bidang_id', $user->bidang_id);
            });
        }

        return view('peminjaman.index', [
            'peminjaman' => $query->latest()->get()
        ]);
    }

    /* =====================================================
        CREATE
    ===================================================== */
    public function create()
    {
        $this->onlyPetugas();

        $user = Auth::user();

        // Barang hanya dari bidang petugas
        $barang = Barang::where('bidang_id', $user->bidang_id)->get();

        $jurusans = Jurusan::with('fakultas')
            ->orderBy('nama_jurusan')
            ->get()
            ->groupBy(fn ($j) => $j->fakultas->nama_fakultas);

        return view('peminjaman.create', compact('barang','jurusans'));
    }

    /* =====================================================
        STORE
    ===================================================== */
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

        // Cegah petugas pinjam barang dari bidang lain
        if ($barang->bidang_id != Auth::user()->bidang_id) {
            abort(403,'Barang bukan bidang kamu');
        }

        // Cek stok
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

        // Kurangi stok
        $barang->decrement('stok', $r->jumlah);

        return redirect()->route('petugas.peminjaman.index')
            ->with('ok','Peminjaman berhasil disimpan');
    }

    /* =====================================================
        SHOW
    ===================================================== */
    public function show(Peminjaman $peminjaman)
    {
        $this->authorizeBidang($peminjaman);

        return view('peminjaman.show', compact('peminjaman'));
    }

    /* =====================================================
        EDIT
    ===================================================== */
    public function edit(Peminjaman $peminjaman)
    {
        $this->onlyPetugas();
        $this->authorizePeminjaman($peminjaman);

        $jurusans = Jurusan::with('fakultas')
            ->orderBy('nama_jurusan')
            ->get()
            ->groupBy(fn ($j) => $j->fakultas->nama_fakultas);

        return view('peminjaman.edit', compact('peminjaman','jurusans'));
    }

    /* =====================================================
        UPDATE
    ===================================================== */
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
            'nama_peminjam',
            'npm',
            'jurusan_id',
            'angkatan',
            'tgl_pinjam',
            'tgl_kembali_rencana',
            'kondisi_saat_pinjam'
        ]));

        return redirect()->route('petugas.peminjaman.index')
            ->with('ok','Peminjaman berhasil diupdate');
    }

    /* =====================================================
        DELETE
    ===================================================== */
    public function destroy(Peminjaman $peminjaman)
    {
        $this->onlyPetugas();
        $this->authorizePeminjaman($peminjaman);

        // Kembalikan stok
        $peminjaman->barang->increment('stok', $peminjaman->jumlah);

        $peminjaman->delete();

        return back()->with('ok','Peminjaman dihapus dan stok dikembalikan');
    }

    /* =====================================================
        SECURITY FUNCTIONS
    ===================================================== */

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
