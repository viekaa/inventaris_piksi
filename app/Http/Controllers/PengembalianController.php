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

        if (Auth::user()->role == 'petugas' && $peminjaman->barang->bidang_id != Auth::user()->bidang_id) {
            abort(403);
        }

        if ($peminjaman->status === 'dikembalikan') {
            return back()->with('error', 'Peminjaman ini sudah dikembalikan.');
        }

        $jmlBaik      = (int) $r->kondisi['baik'];
        $jmlRusak     = (int) $r->kondisi['rusak'];
        $jmlPerbaikan = (int) $r->kondisi['perlu_perbaikan'];
        $total        = $jmlBaik + $jmlRusak + $jmlPerbaikan;

        if ($total != $peminjaman->jumlah) {
            return back()->withErrors(['kondisi' => 'Total kondisi harus sama dengan jumlah dipinjam (' . $peminjaman->jumlah . ').']);
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

        foreach (['baik' => $jmlBaik, 'rusak' => $jmlRusak, 'perlu_perbaikan' => $jmlPerbaikan] as $kondisi => $jumlah) {
            if ($jumlah > 0) {
                $pengembalian->details()->create(['kondisi' => $kondisi, 'jumlah' => $jumlah]);
            }
        }

        $peminjaman->update(['status' => 'dikembalikan']);

        $barang = $peminjaman->barang;

        // Stok hanya bertambah dari barang yang kembali dalam kondisi BAIK
        if ($jmlBaik > 0) {
            $barang->increment('stok', $jmlBaik);
        }

        // Kondisi barang diupdate berdasarkan prioritas terburuk:
        // rusak > perlu_perbaikan > baik
        // Barang bermasalah otomatis muncul di halaman perbaikan
        if ($jmlRusak > 0) {
            $barang->update(['kondisi' => 'rusak']);
        } elseif ($jmlPerbaikan > 0) {
            $barang->update(['kondisi' => 'perlu_perbaikan']);
        } else {
            // Semua kembali baik → pastikan kondisi barang = baik
            $barang->update(['kondisi' => 'baik']);
        }

        return redirect()->route('petugas.pengembalian.index')->with('ok', 'Pengembalian berhasil dicatat.');
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

        $jmlBaik      = (int) $r->kondisi['baik'];
        $jmlRusak     = (int) $r->kondisi['rusak'];
        $jmlPerbaikan = (int) $r->kondisi['perlu_perbaikan'];
        $total        = $jmlBaik + $jmlRusak + $jmlPerbaikan;

        if ($total != $pengembalian->peminjaman->jumlah) {
            return back()->withErrors(['kondisi' => 'Total kondisi harus sama dengan jumlah dipinjam (' . $pengembalian->peminjaman->jumlah . ').']);
        }

        $hariTelat = 0;
        if ($r->tgl_kembali_real > $pengembalian->peminjaman->tgl_kembali_rencana) {
            $hariTelat = Carbon::parse($pengembalian->peminjaman->tgl_kembali_rencana)
                                ->diffInDays(Carbon::parse($r->tgl_kembali_real));
        }

        // Simpan jumlah baik lama sebelum detail dihapus untuk koreksi stok
        $baikLama = (int) ($pengembalian->details()->where('kondisi', 'baik')->value('jumlah') ?? 0);

        $pengembalian->update([
            'tgl_kembali_real' => $r->tgl_kembali_real,
            'hari_telat'       => $hariTelat,
            'catatan'          => $r->catatan,
        ]);

        $pengembalian->details()->delete();
        foreach (['baik' => $jmlBaik, 'rusak' => $jmlRusak, 'perlu_perbaikan' => $jmlPerbaikan] as $kondisi => $jumlah) {
            if ($jumlah > 0) {
                $pengembalian->details()->create(['kondisi' => $kondisi, 'jumlah' => $jumlah]);
            }
        }

        $barang = $pengembalian->peminjaman->barang;

        // Koreksi stok: batalkan stok lama, terapkan stok baru
        if ($baikLama > 0) $barang->decrement('stok', $baikLama);
        if ($jmlBaik  > 0) $barang->increment('stok', $jmlBaik);

        // Update kondisi sesuai data terbaru
        if ($jmlRusak > 0) {
            $barang->update(['kondisi' => 'rusak']);
        } elseif ($jmlPerbaikan > 0) {
            $barang->update(['kondisi' => 'perlu_perbaikan']);
        } else {
            $barang->update(['kondisi' => 'baik']);
        }

        return redirect()->route('petugas.pengembalian.index')->with('ok', 'Pengembalian berhasil diperbarui.');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') abort(403);
        $this->authorizePengembalian($pengembalian);

        $pengembalian->load(['peminjaman.barang', 'details']);

        $barang   = $pengembalian->peminjaman->barang;
        $baikLama = (int) ($pengembalian->details()->where('kondisi', 'baik')->value('jumlah') ?? 0);

        // Batalkan stok yang sudah ditambah saat pengembalian dicatat
        if ($baikLama > 0) {
            $barang->decrement('stok', $baikLama);
        }

        // Kembalikan status peminjaman → dipinjam
        $pengembalian->peminjaman->update(['status' => 'dipinjam']);

        // Reset kondisi barang ke baik karena pengembalian dibatalkan
        // (barang dianggap masih berada di tangan peminjam)
        $barang->update(['kondisi' => 'baik']);

        $pengembalian->details()->delete();
        $pengembalian->delete();

        return redirect()->route('petugas.pengembalian.index')->with('ok', 'Pengembalian berhasil dihapus.');
    }

    private function authorizePengembalian($pengembalian): void
    {
        $user = Auth::user();
        if ($user->role == 'petugas' && $pengembalian->peminjaman->barang->bidang_id != $user->bidang_id) {
            abort(403);
        }
    }
}
