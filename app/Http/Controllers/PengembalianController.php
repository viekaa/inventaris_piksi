<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    public function index()
    {
        $user   = Auth::user();
        $search = request('search');

        $query = Pengembalian::with(['peminjaman.barang', 'peminjaman.jurusan', 'details']);

        if ($user->role == 'petugas') {
            $query->whereHas('peminjaman.barang', fn ($q) => $q->where('bidang_id', $user->bidang_id));
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('peminjaman', fn ($p) => $p->where('nama_peminjam', 'like', "%{$search}%"))
                  ->orWhereHas('peminjaman.barang', fn ($b) => $b->where('nama_barang', 'like', "%{$search}%"));
            });
        }

        return view('pengembalian.index', ['pengembalian' => $query->latest()->get()]);
    }

    public function exportPdf()
    {
        $user   = Auth::user();
        $search = request('search');

        $query = Pengembalian::with(['peminjaman.barang', 'peminjaman.jurusan', 'details']);

        if ($user->role == 'petugas') {
            $query->whereHas('peminjaman.barang', fn ($q) => $q->where('bidang_id', $user->bidang_id));
        }

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('peminjaman', fn ($p) => $p->where('nama_peminjam', 'like', "%{$search}%"))
                  ->orWhereHas('peminjaman.barang', fn ($b) => $b->where('nama_barang', 'like', "%{$search}%"));
            });
        }

        return view('pdf.pengembalian', ['pengembalian' => $query->latest()->get()]);
    }

    public function create()
    {
        if (Auth::user()->role == 'admin') abort(403, 'Admin hanya boleh melihat data');

        $user  = Auth::user();
        $query = Peminjaman::where('status', 'dipinjam')->with('barang', 'jurusan');

        if ($user->role == 'petugas') {
            $query->whereHas('barang', fn ($q) => $q->where('bidang_id', $user->bidang_id));
        }

        return view('pengembalian.create', ['peminjaman' => $query->get()]);
    }

    public function store(Request $r)
    {
        if (Auth::user()->role == 'admin') abort(403);

        $r->validate([
            'peminjaman_id'           => 'required|exists:peminjamans,id',
            'tgl_kembali_real'        => 'required|date',
            'kondisi.baik'            => 'required|integer|min:0',
            'kondisi.rusak'           => 'required|integer|min:0',
            'kondisi.perlu_perbaikan' => 'required|integer|min:0',
            'catatan'                 => 'nullable|string',
        ]);

        $peminjaman = Peminjaman::with('barang')->findOrFail($r->peminjaman_id);

        if (Auth::user()->role == 'petugas' && $peminjaman->barang->bidang_id != Auth::user()->bidang_id) abort(403);
        if ($peminjaman->status === 'dikembalikan') return back()->with('error', 'Sudah dikembalikan');

        $total = $r->kondisi['baik'] + $r->kondisi['rusak'] + $r->kondisi['perlu_perbaikan'];
        if ($total != $peminjaman->jumlah) {
            return back()->withErrors(['kondisi' => 'Total harus ' . $peminjaman->jumlah]);
        }

        $hariTelat = 0;
        if ($r->tgl_kembali_real > $peminjaman->tgl_kembali_rencana) {
            $hariTelat = Carbon::parse($peminjaman->tgl_kembali_rencana)
                                ->diffInDays(Carbon::parse($r->tgl_kembali_real));
        }

        $pengembalian = Pengembalian::create([
            'peminjaman_id'    => $peminjaman->id,
            'tgl_kembali_real' => $r->tgl_kembali_real,
            'hari_telat'       => $hariTelat,
            'catatan'          => $r->catatan,
        ]);

        foreach ($r->kondisi as $kondisi => $jumlah) {
            if ($jumlah > 0) {
                $pengembalian->details()->create(['kondisi' => $kondisi, 'jumlah' => $jumlah]);
            }
        }

        $peminjaman->update(['status' => 'dikembalikan']);
        $barang = $peminjaman->barang;
        $barang->increment('stok', $r->kondisi['baik']);

        // ── Update kondisi barang berdasarkan prioritas terburuk ──────────
        // rusak > perlu_perbaikan > baik (kondisi tidak diubah jika semua baik)
        if ($r->kondisi['rusak'] > 0) {
            $barang->update(['kondisi' => 'rusak']);
        } elseif ($r->kondisi['perlu_perbaikan'] > 0) {
            $barang->update(['kondisi' => 'perlu_perbaikan']);
        }
        // Jika semua baik → kondisi barang tetap 'baik', tidak perlu update

        return redirect()->route('petugas.pengembalian.index')->with('ok', 'Pengembalian berhasil');
    }

    public function show($id)
    {
        $pengembalian = Pengembalian::with(['peminjaman.barang', 'peminjaman.jurusan', 'details'])->findOrFail($id);
        $this->authorizePengembalian($pengembalian);
        return view('pengembalian.show', compact('pengembalian'));
    }

    public function edit(Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') abort(403);
        $this->authorizePengembalian($pengembalian);
        $pengembalian->load(['peminjaman.barang', 'peminjaman.jurusan', 'details']);
        return view('pengembalian.edit', compact('pengembalian'));
    }

    public function update(Request $r, Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') abort(403);
        $this->authorizePengembalian($pengembalian);

        $r->validate([
            'tgl_kembali_real'        => 'required|date',
            'kondisi.baik'            => 'required|integer|min:0',
            'kondisi.rusak'           => 'required|integer|min:0',
            'kondisi.perlu_perbaikan' => 'required|integer|min:0',
            'catatan'                 => 'nullable|string',
        ]);

        $pengembalian->load('peminjaman.barang');
        $total = $r->kondisi['baik'] + $r->kondisi['rusak'] + $r->kondisi['perlu_perbaikan'];
        if ($total != $pengembalian->peminjaman->jumlah) {
            return back()->withErrors(['kondisi' => 'Total harus ' . $pengembalian->peminjaman->jumlah]);
        }

        $hariTelat = 0;
        if ($r->tgl_kembali_real > $pengembalian->peminjaman->tgl_kembali_rencana) {
            $hariTelat = Carbon::parse($pengembalian->peminjaman->tgl_kembali_rencana)
                                ->diffInDays(Carbon::parse($r->tgl_kembali_real));
        }

        $baikLama = $pengembalian->details()->where('kondisi', 'baik')->value('jumlah') ?? 0;
        $baikBaru = $r->kondisi['baik'];

        $pengembalian->update([
            'tgl_kembali_real' => $r->tgl_kembali_real,
            'hari_telat'       => $hariTelat,
            'catatan'          => $r->catatan,
        ]);

        $pengembalian->details()->delete();
        foreach ($r->kondisi as $kondisi => $jumlah) {
            if ($jumlah > 0) $pengembalian->details()->create(['kondisi' => $kondisi, 'jumlah' => $jumlah]);
        }

        $barang = $pengembalian->peminjaman->barang;
        $barang->decrement('stok', $baikLama);
        $barang->increment('stok', $baikBaru);

        // Update kondisi sesuai data terbaru
        if ($r->kondisi['rusak'] > 0) {
            $barang->update(['kondisi' => 'rusak']);
        } elseif ($r->kondisi['perlu_perbaikan'] > 0) {
            $barang->update(['kondisi' => 'perlu_perbaikan']);
        } else {
            $barang->update(['kondisi' => 'baik']);
        }

        return redirect()->route('petugas.pengembalian.index')->with('ok', 'Pengembalian diperbarui');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') abort(403);
        $this->authorizePengembalian($pengembalian);

        $barang = $pengembalian->peminjaman->barang;
        $baik   = $pengembalian->details()->where('kondisi', 'baik')->value('jumlah') ?? 0;

        $barang->decrement('stok', $baik);
        $pengembalian->peminjaman->update(['status' => 'dipinjam']);
        $pengembalian->details()->delete();
        $pengembalian->delete();

        return redirect()->route('petugas.pengembalian.index')->with('ok', 'Pengembalian dihapus');
    }

    private function authorizePengembalian($pengembalian)
    {
        $user = Auth::user();
        if ($user->role == 'petugas' && $pengembalian->peminjaman->barang->bidang_id != $user->bidang_id) {
            abort(403);
        }
    }
}
