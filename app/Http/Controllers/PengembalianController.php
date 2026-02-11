<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /* ============================
        INDEX
    ============================ */
    public function index()
    {
        $user = Auth::user();

        $query = Pengembalian::with('peminjaman.barang');

        if ($user->role == 'petugas') {
            $query->whereHas('peminjaman.barang', function ($q) use ($user) {
                $q->where('bidang_id', $user->bidang_id);
            });
        }

        return view('pengembalian.index', [
            'pengembalian' => $query->latest()->get()
        ]);
    }

    /* ============================
        CREATE
    ============================ */
    public function create()
    {
        if (Auth::user()->role == 'admin') {
            abort(403, 'Admin hanya boleh melihat data pengembalian');
        }

        $user = Auth::user();

        $query = Peminjaman::where('status', 'dipinjam')->with('barang');

        if ($user->role == 'petugas') {
            $query->whereHas('barang', function ($q) use ($user) {
                $q->where('bidang_id', $user->bidang_id);
            });
        }

        return view('pengembalian.create', [
            'peminjaman' => $query->get()
        ]);
    }

    /* ============================
        STORE
    ============================ */
    public function store(Request $r)
    {
        if (Auth::user()->role == 'admin') {
            abort(403);
        }

        $r->validate([
            'peminjaman_id' => 'required|exists:peminjamans,id',
            'tgl_kembali_real' => 'required|date',
            'kondisi_saat_kembali' => 'required|in:baik,rusak,perlu_perbaikan',
            'catatan' => 'nullable|string'
        ]);

        $peminjaman = Peminjaman::with('barang')->findOrFail($r->peminjaman_id);

        if (
            Auth::user()->role == 'petugas' &&
            $peminjaman->barang->bidang_id != Auth::user()->bidang_id
        ) {
            abort(403);
        }

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Barang ini sudah dikembalikan');
        }

        // hitung hari telat
        $hariTelat = 0;
        if ($r->tgl_kembali_real > $peminjaman->tgl_kembali_rencana) {
            $hariTelat = Carbon::parse($peminjaman->tgl_kembali_rencana)
                ->diffInDays(Carbon::parse($r->tgl_kembali_real));
        }

        Pengembalian::create([
            'peminjaman_id' => $peminjaman->id,
            'tgl_kembali_real' => $r->tgl_kembali_real,
            'hari_telat' => $hariTelat,
            'kondisi_saat_kembali' => $r->kondisi_saat_kembali,
            'catatan' => $r->catatan
        ]);

        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        $peminjaman->barang->increment('stok', $peminjaman->jumlah);

        return redirect()->route('petugas.pengembalian.index')
            ->with('ok', 'Pengembalian berhasil dicatat');
    }

    /* ============================
        EDIT
    ============================ */
    public function edit(Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') {
            abort(403);
        }

        $this->authorizePengembalian($pengembalian);

        return view('pengembalian.edit', compact('pengembalian'));
    }

    /* ============================
        UPDATE
    ============================ */
    public function update(Request $r, Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') {
            abort(403);
        }

        $this->authorizePengembalian($pengembalian);

        $r->validate([
            'tgl_kembali_real' => 'required|date',
            'kondisi_saat_kembali' => 'required|in:baik,rusak,perlu_perbaikan',
            'catatan' => 'nullable|string'
        ]);

        $hariTelat = 0;
        if ($r->tgl_kembali_real > $pengembalian->peminjaman->tgl_kembali_rencana) {
            $hariTelat = Carbon::parse($pengembalian->peminjaman->tgl_kembali_rencana)
                ->diffInDays(Carbon::parse($r->tgl_kembali_real));
        }

        $pengembalian->update([
            'tgl_kembali_real' => $r->tgl_kembali_real,
            'hari_telat' => $hariTelat,
            'kondisi_saat_kembali' => $r->kondisi_saat_kembali,
            'catatan' => $r->catatan
        ]);

        return redirect()->route('petugas.pengembalian.index')
            ->with('ok', 'Pengembalian diperbarui');
    }

    /* ============================
        DELETE
    ============================ */
    public function destroy(Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') {
            abort(403);
        }

        $this->authorizePengembalian($pengembalian);

        $pengembalian->peminjaman->update([
            'status' => 'dipinjam'
        ]);

        $pengembalian->peminjaman->barang
            ->decrement('stok', $pengembalian->peminjaman->jumlah);

        $pengembalian->delete();

        return back()->with('ok', 'Pengembalian dihapus');
    }

    /* ============================
        SECURITY
    ============================ */
    private function authorizePengembalian($pengembalian)
    {
        $user = Auth::user();

        if (
            $user->role == 'petugas' &&
            $pengembalian->peminjaman->barang->bidang_id != $user->bidang_id
        ) {
            abort(403);
        }
    }

  public function show($id)
{
    $pengembalian = Pengembalian::with('peminjaman.barang','peminjaman.jurusan')
                    ->findOrFail($id);

    return view('pengembalian.show', compact('pengembalian'));
}


}
