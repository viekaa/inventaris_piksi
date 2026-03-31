<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Pengembalian - Inpiksi</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=EB+Garamond:ital,wght@0,400;0,700&family=Source+Sans+3:wght@400;600;700&display=swap');

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'Source Sans 3', sans-serif;
            background: #ede9f8;
            color: #1a1a1a;
        }

        /* ── TOMBOL ── */
        .btn-area {
            position: fixed;
            top: 18px; right: 18px;
            display: flex; gap: 10px; z-index: 999;
        }

        .btn {
            padding: 9px 20px;
            border-radius: 7px;
            font-size: 13px; font-weight: 600;
            cursor: pointer; border: none;
            font-family: 'Source Sans 3', sans-serif;
            text-decoration: none;
            display: inline-block;
            transition: background 0.15s;
        }

        .btn-back {
            background: #fff; color: #4a1d96;
            border: 1.5px solid #4a1d96;
        }
        .btn-back:hover { background: #f3eeff; }

        .btn-print {
            background: #4a1d96; color: #fff;
            box-shadow: 0 4px 14px rgba(74,29,150,0.25);
        }
        .btn-print:hover { background: #3b0f7e; }

        /* ── PAGE ── */
        .page {
            width: 297mm;
            min-height: 210mm;
            margin: 0 auto;
            padding: 14mm 18mm 20mm;
            background: #fff;
            box-shadow: 0 2px 32px rgba(74,29,150,0.10);
        }

        /* ── KOP ── */
      .kop {
            display: flex; align-items: center; gap: 16px;
            padding-bottom: 10px;
            border-bottom: 2.5px solid #4a1d96;
        }

        .kop-logo {  position: relative; left: 98px; top: -7.5px ; width: 160px; height: 130px; flex-shrink: 0; }
        .kop-logo img { width: 100%; height: 100%; object-fit: contain; }

        .kop-text {  position: relative; left: -50px; flex: 1; text-align: center; }

        .kop-instansi {
            font-size: 7.8pt; color: #4a1d96; font-weight: 700;
            letter-spacing: 0.6px; text-transform: uppercase;
        }

        .kop-nama {
            font-family: 'EB Garamond', serif;
            font-size: 22pt; font-weight: 700;
            color: #4a1d96; line-height: 1.1;
        }

        .kop-alamat {
            font-size: 7.3pt; color: #666;
            margin-top: 3px; line-height: 1.55;
        }

        .kop-strip {
            height: 3px;
            background: linear-gradient(90deg, #4a1d96 0%, #7c3aed 55%, #c4b5fd 100%);
            margin-bottom: 12px;
        }

        /* ── JUDUL ── */
        .report-header {
            text-align: center;
            margin: 10px 0 9px;
            padding: 8px 0;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }

        .report-title {
            font-family: 'EB Garamond', serif;
            font-size: 15pt; font-weight: 700;
            color: #1a1a1a; letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .report-subtitle { font-size: 8.2pt; color: #666; margin-top: 2px; }

        /* ── META ── */
        .report-meta {
            display: flex;
            justify-content: space-between;
            font-size: 8.2pt; color: #444;
            margin: 8px 0 13px;
            padding: 6px 12px;
            background: #f7f4ff;
            border-left: 3px solid #7c3aed;
            border-radius: 0 4px 4px 0;
        }

        /* ── TABEL UTAMA ── */
        .report-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 8.5pt;
            border: 1.5px solid #4a1d96;
            border-radius: 6px;
            overflow: hidden;
        }

        .report-table thead tr { background: #4a1d96; }

        .report-table thead th {
            padding: 9px 11px;
            color: #fff; font-weight: 700;
            font-size: 7.8pt; letter-spacing: 0.5px;
            text-transform: uppercase; text-align: left;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        .report-table thead th:last-child { border-right: none; }
        .report-table thead th.tc { text-align: center; }

        .report-table tbody tr { border-bottom: 1px solid #e8e2f5; }
        .report-table tbody tr:nth-child(even) { background: #f9f7ff; }
        .report-table tbody tr:last-child { border-bottom: none; }
        .report-table tbody tr:hover { background: #f1ecff; }

        .report-table tbody td {
            padding: 7.5px 11px;
            vertical-align: middle; color: #2d2d2d;
            border-right: 1px solid #ede8f8;
        }
        .report-table tbody td:last-child { border-right: none; }
        .report-table tbody td.tc { text-align: center; }
        .report-table tbody td.no-col {
            text-align: center; color: #aaa;
            font-weight: 700; font-size: 8pt;
        }

        /* ── BADGE ── */
        .badge {
            display: inline-block;
            padding: 3px 11px; border-radius: 20px;
            font-size: 7.8pt; font-weight: 700;
        }
        .badge-telat  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-ontime { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }

        .pill {
            display: inline-block;
            padding: 2px 8px; border-radius: 12px;
            font-size: 7.5pt; font-weight: 700; margin: 1px;
        }
        .pill-ok   { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .pill-warn { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }
        .pill-bad  { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }

        /* ── TABEL RINGKASAN ── */
          .summary-section { margin-top: 16px; }

        .summary-title {
            font-size: 7.8pt; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: #4a1d96; margin-bottom: 6px;
            padding-left: 2px;
            text-align: left;
        }

        .summary-table {
            border-collapse: separate;
            border-spacing: 0;
            font-size: 8.5pt;
            border: 1.5px solid #4a1d96;
            border-radius: 6px;
            overflow: hidden;
        }

        .summary-table thead tr { background: #4a1d96; }

        .summary-table thead th {
            padding: 7px 28px;
            color: #fff; font-weight: 700;
            font-size: 7.8pt; text-transform: uppercase;
            letter-spacing: 0.4px; text-align: center;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        .summary-table thead th:last-child { border-right: none; }

        .summary-table tbody td {
            padding: 8px 28px; text-align: center;
            border-right: 1px solid #ede8f8;
            background: #f9f7ff;
        }
        .summary-table tbody td:last-child { border-right: none; }

        .sv { font-size: 13pt; font-weight: 700; display: block; line-height: 1.1; }
        .sv-label  { font-size: 7.5pt; color: #888; margin-top: 1px; }
        .sv-total  { color: #4a1d96; }
        .sv-tepat  { color: #059669; }
        .sv-telat  { color: #dc2626; }

        /* ── BOTTOM ── */
        .report-bottom {
            margin-top: 16px;
            display: flex; justify-content: flex-end;
        }

        .ttd-block { text-align: center; font-size: 8.5pt; color: #333; }
        .ttd-space {
            height: 52px; border-bottom: 1px solid #555;
            width: 140px; margin: 8px auto 5px;
        }
        .ttd-name { font-weight: 700; font-size: 9pt; }
        .ttd-role { color: #777; font-size: 8pt; }

        * {
            -webkit-print-color-adjust: exact !important;
            print-color-adjust: exact !important;
            color-adjust: exact !important;
        }
        /* ── PRINT ── */
        @media print {
            body { background: #fff; }
            .btn-area { display: none !important; }
            .page { box-shadow: none; padding: 10mm 13mm 13mm; width: 100%; }
            @page { size: A4 landscape; margin: 0; }
        }
    </style>
</head>
<body>

{{-- TOMBOL --}}
<div class="btn-area">
    @if(auth()->user()->role == 'admin')
        <a href="{{ route('admin.pengembalian.index') }}" class="btn btn-back">&#8592; Kembali</a>
    @else
        <a href="{{ route('petugas.pengembalian.index') }}" class="btn btn-back">&#8592; Kembali</a>
    @endif
    <button onclick="window.print()" class="btn btn-print">Cetak / Simpan PDF</button>
</div>

<div class="page">

    {{-- KOP --}}
    <div class="kop">
        <div class="kop-logo">
             <img src="{{ asset('storage/images/logo_piksi.png') }}" onerror="this.style.display='none'" alt="Logo">
        </div>
        <div class="kop-text">
            <div class="report-title">Laporan Data Pengembalian Barang Inventaris</div>
            <div class="kop-nama">Politeknik Piksi Ganesha</div>
            <div class="kop-alamat">
                Jl. Jend. Gatot Subroto 301 Bandung 40274 &nbsp;|&nbsp; Telp. 022-87340030 &nbsp;|&nbsp; Fax. 022-87340086<br>
                www.piksi-ganesha-online.ac.id &nbsp;|&nbsp; piksionline@yahoo.com
            </div>
        </div>
    </div>
    <div class="kop-strip"></div>

    {{-- JUDUL --}}
    <div class="report-header">

    {{-- META --}}
    <div class="report-meta">
        <span>Tanggal Cetak &nbsp;: &nbsp;{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y, H:i') }} WIB</span>
        <span>Dicetak oleh &nbsp;: &nbsp;{{ auth()->user()->name }}</span>
        @if(request('search'))
            <span>Filter &nbsp;: &nbsp;&ldquo;{{ request('search') }}&rdquo;</span>
        @endif
    </div>

    {{-- TABEL --}}
    <table class="report-table">
        <thead>
            <tr>
                <th style="width:30px">No</th>
                <th>Barang</th>
                <th>Peminjam</th>
                <th class="tc" style="width:46px">Jml</th>
                <th class="tc" style="width:84px">Tgl Kembali</th>
                <th class="tc" style="width:106px">Keterlambatan</th>
                <th class="tc">Kondisi Barang</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pengembalian as $item)
            <tr>
                <td class="no-col">{{ $loop->iteration }}</td>
                <td><strong>{{ $item->peminjaman->barang->nama_barang }}</strong></td>
                <td>{{ $item->peminjaman->nama_peminjam }}</td>
                <td class="tc">{{ $item->peminjaman->jumlah }}</td>
                <td class="tc">{{ \Carbon\Carbon::parse($item->tgl_kembali_real)->format('d/m/Y') }}</td>
                <td class="tc">
                    @if($item->hari_telat > 0)
                        <span class="badge badge-telat">{{ $item->hari_telat }} hari</span>
                    @else
                        <span class="badge badge-ontime">Tepat Waktu</span>
                    @endif
                </td>
                <td class="tc">
                    @php
                        $baik  = $item->details()->where('kondisi','baik')->value('jumlah') ?? 0;
                        $rusak = $item->details()->where('kondisi','rusak')->value('jumlah') ?? 0;
                        $perlu = $item->details()->where('kondisi','perlu_perbaikan')->value('jumlah') ?? 0;
                    @endphp
                    @if($baik > 0)  <span class="pill pill-ok">{{ $baik }} Baik</span> @endif
                    @if($rusak > 0) <span class="pill pill-bad">{{ $rusak }} Rusak</span> @endif
                    @if($perlu > 0) <span class="pill pill-warn">{{ $perlu }} Perlu Perbaikan</span> @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7"
                    style="text-align:center;padding:22px;color:#aaa;font-style:italic;">
                    Tidak ada data pengembalian
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- RINGKASAN --}}
    @php
        $total     = $pengembalian->count();
        $tepat     = $pengembalian->where('hari_telat','<=',0)->count();
        $terlambat = $pengembalian->where('hari_telat','>',0)->count();
    @endphp

    <div class="summary-section">
        <div class="summary-title">Ringkasan</div>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Total Data</th>
                    <th>Tepat Waktu</th>
                    <th>Terlambat</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="sv sv-total">{{ $total }}</span><span class="sv-label">data</span></td>
                    <td><span class="sv sv-tepat">{{ $tepat }}</span><span class="sv-label">data</span></td>
                    <td><span class="sv sv-telat">{{ $terlambat }}</span><span class="sv-label">data</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- TTD --}}
    <div class="report-bottom">
        <div class="ttd-block">
            <div>Bandung, {{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</div>
            <div>Penanggung Jawab,</div>
            <div class="ttd-space"></div>
            <div class="ttd-name">{{ auth()->user()->name }}</div>
            <div class="ttd-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
    </div>

</div>
</body>
</html>
