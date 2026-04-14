<?php

namespace App\Http\Controllers;

use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\PengembalianDetail;
use App\Models\Barang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use RealRashid\SweetAlert\Facades\Alert;

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

        if ($peminjaman->status === 'dikembalikan') {
            Alert::error('Gagal', 'Peminjaman ini sudah dikembalikan.');
            return back();
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

        if ($jmlBaik > 0) {
            $barang->increment('stok', $jmlBaik);
        }

        $barang->update(['kondisi' => 'baik']);

        Alert::success('Berhasil', 'Pengembalian berhasil dicatat.');
        return redirect()->route('petugas.pengembalian.index');
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

        $barang  = $pengembalian->peminjaman->barang;
        $jmlBaik = (int) $r->kondisi['baik'];
        $baikLama = (int) ($pengembalian->details()->where('kondisi', 'baik')->value('jumlah') ?? 0);

        if ($baikLama > 0) $barang->decrement('stok', $baikLama);

        $pengembalian->update([
            'tgl_kembali_real' => $r->tgl_kembali_real,
            'catatan'          => $r->catatan,
        ]);

        $pengembalian->details()->delete();
        foreach (['baik' => $jmlBaik, 'rusak' => $r->kondisi['rusak'], 'perlu_perbaikan' => $r->kondisi['perlu_perbaikan']] as $kondisi => $jumlah) {
            if ($jumlah > 0) {
                $pengembalian->details()->create(['kondisi' => $kondisi, 'jumlah' => $jumlah]);
            }
        }

        if ($jmlBaik > 0) $barang->increment('stok', $jmlBaik);
        $barang->update(['kondisi' => 'baik']);

        Alert::success('Berhasil', 'Pengembalian berhasil diperbarui.');
        return redirect()->route('petugas.pengembalian.index');
    }

    public function destroy(Pengembalian $pengembalian)
    {
        if (Auth::user()->role == 'admin') abort(403);
        $this->authorizePengembalian($pengembalian);

        $barang   = $pengembalian->peminjaman->barang;
        $baikLama = (int) ($pengembalian->details()->where('kondisi', 'baik')->value('jumlah') ?? 0);

        if ($baikLama > 0) $barang->decrement('stok', $baikLama);

        $pengembalian->peminjaman->update(['status' => 'dipinjam']);
        $barang->update(['kondisi' => 'baik']);

        $pengembalian->details()->delete();
        $pengembalian->delete();

        Alert::success('Berhasil', 'Pengembalian berhasil dihapus.');
        return redirect()->route('petugas.pengembalian.index');
    }

    private function authorizePengembalian($pengembalian): void
    {
        $user = Auth::user();
        if ($user->role == 'petugas' && $pengembalian->peminjaman->barang->bidang_id != $user->bidang_id) {
            abort(403);
        }
    }
}
