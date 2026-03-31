<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Data Barang - Inpiksi</title>
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
            width: 210mm;
            min-height: 297mm;
            margin: 0 auto;
            padding: 15mm 20mm 20mm;
            background: #fff;
            box-shadow: 0 2px 32px rgba(74,29,150,0.10);
        }

        /* ── KOP ── */
      .kop {
            display: flex; align-items: center; gap: 16px;
            padding-bottom: 10px;
            border-bottom: 2.5px solid #4a1d96;
        }

        .kop-logo {  position: relative; left: -9px; top: -7.5px ; width: 160px; height: 130px; flex-shrink: 0; }
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
            font-size: 8.8pt;
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

        /* ── BADGE KONDISI ── */
        .badge {
            display: inline-block;
            padding: 3px 11px; border-radius: 20px;
            font-size: 7.8pt; font-weight: 700;
        }
        .badge-baik  { background: #d1fae5; color: #065f46; border: 1px solid #6ee7b7; }
        .badge-rusak { background: #fee2e2; color: #991b1b; border: 1px solid #fca5a5; }
        .badge-perlu { background: #fef3c7; color: #92400e; border: 1px solid #fcd34d; }

        /* ── TABEL RINGKASAN ── */
        .summary-section { margin-top: 16px; }

        .summary-title {
            font-size: 7.8pt; font-weight: 700;
            text-transform: uppercase; letter-spacing: 0.6px;
            color: #4a1d96; margin-bottom: 6px;
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
            padding: 7px 20px;
            color: #fff; font-weight: 700;
            font-size: 7.8pt; text-transform: uppercase;
            letter-spacing: 0.4px; text-align: center;
            border-right: 1px solid rgba(255,255,255,0.15);
        }
        .summary-table thead th:last-child { border-right: none; }

        .summary-table tbody td {
            padding: 8px 20px; text-align: center;
            border-right: 1px solid #ede8f8;
            background: #f9f7ff;
        }
        .summary-table tbody td:last-child { border-right: none; }

        .sv { font-size: 13pt; font-weight: 700; display: block; line-height: 1.1; }
        .sv-label { font-size: 7.5pt; color: #888; margin-top: 1px; }
        .sv-total  { color: #4a1d96; }
        .sv-tipis  { color: #dc2626; }
        .sv-baik   { color: #059669; }
        .sv-perlu  { color: #d97706; }
        .sv-rusak  { color: #991b1b; }

        /* ── BOTTOM ── */
        .report-bottom {
            margin-top: 16px;
            display: flex; justify-content: flex-end;
        }

        .ttd-block { text-align: center; font-size: 8.5pt; color: #333; }
        .ttd-space {
            height: 54px; border-bottom: 1px solid #555;
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
            .page { box-shadow: none; padding: 12mm 16mm 16mm; width: 100%; }
            @page { size: A4 portrait; margin: 0; }
        }
    </style>
</head>
<body>

{{-- TOMBOL --}}
<div class="btn-area">
    <a href="{{ route('barang.index') }}" class="btn btn-back">&#8592; Kembali</a>
    <button onclick="window.print()" class="btn btn-print">Cetak / Simpan PDF</button>
</div>

<div class="page">

    {{-- KOP --}}
    <div class="kop">
        <div class="kop-logo">
              <img src="{{ asset('storage/images/logo_piksi.png') }}" onerror="this.style.display='none'" alt="Logo">
        </div>
        <div class="kop-text">
            <div class="report-title">Laporan Data Barang Inventaris</div>
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

    </div>

    {{-- META --}}
    <div class="report-meta">
        <span>Tanggal Cetak &nbsp;: &nbsp;{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y, H:i') }}WIB</span>
        <span>Dicetak oleh &nbsp;: &nbsp;{{ auth()->user()->name }}</span>
        @if(request('search'))
            <span>Filter &nbsp;: &nbsp;&ldquo;{{ request('search') }}&rdquo;</span>
        @endif
        @if(request('bidang'))
            <span>Bidang &nbsp;: &nbsp;{{ request('bidang') }}</span>
        @endif
    </div>

    {{-- TABEL --}}
    <table class="report-table">
        <thead>
            <tr>
                <th style="width:32px">No</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Lokasi</th>
                @if(auth()->user()->role == 'admin')
                    <th>Bidang</th>
                @endif
                <th class="tc" style="width:56px">Stok</th>
                <th class="tc" style="width:76px">Jml Total</th>
                <th class="tc" style="width:110px">Kondisi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($barang as $item)
            <tr>
                <td class="no-col">{{ $loop->iteration }}</td>
                <td><strong>{{ $item->nama_barang }}</strong></td>
                <td>{{ $item->kategori->nama_kategori }}</td>
                <td>{{ $item->lokasi->nama_lokasi }}</td>
                @if(auth()->user()->role == 'admin')
                    <td>{{ $item->bidang->nama_bidang ?? '-' }}</td>
                @endif
                <td class="tc"><strong>{{ $item->stok }}</strong></td>
                <td class="tc">{{ $item->jumlah_total }}</td>
                <td class="tc">
                    @php
                        $cls = match($item->kondisi) {
                            'baik'            => 'badge-baik',
                            'rusak'           => 'badge-rusak',
                            'perlu_perbaikan' => 'badge-perlu',
                            default           => 'badge-perlu',
                        };
                        $lbl = match($item->kondisi) {
                            'baik'            => 'Baik',
                            'rusak'           => 'Rusak',
                            'perlu_perbaikan' => 'Perlu Perbaikan',
                            default           => ucfirst($item->kondisi),
                        };
                    @endphp
                    <span class="badge {{ $cls }}">{{ $lbl }}</span>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="{{ auth()->user()->role == 'admin' ? 8 : 7 }}"
                    style="text-align:center;padding:22px;color:#aaa;font-style:italic;">
                    Tidak ada data barang
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    {{-- RINGKASAN --}}
    @php
        $total     = $barang->count();
        $stokTipis = $barang->where('stok','<=',5)->count();
        $kondBaik  = $barang->where('kondisi','baik')->count();
        $kondPerlu = $barang->where('kondisi','perlu_perbaikan')->count();
        $kondRusak = $barang->where('kondisi','rusak')->count();
    @endphp

    <div class="summary-section">
        <div class="summary-title">Ringkasan</div>
        <table class="summary-table">
            <thead>
                <tr>
                    <th>Total Barang</th>
                    <th>Stok Menipis (&le;5)</th>
                    <th>Kondisi Baik</th>
                    <th>Perlu Perbaikan</th>
                    <th>Rusak</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><span class="sv sv-total">{{ $total }}</span><span class="sv-label">item</span></td>
                    <td><span class="sv sv-tipis">{{ $stokTipis }}</span><span class="sv-label">item</span></td>
                    <td><span class="sv sv-baik">{{ $kondBaik }}</span><span class="sv-label">item</span></td>
                    <td><span class="sv sv-perlu">{{ $kondPerlu }}</span><span class="sv-label">item</span></td>
                    <td><span class="sv sv-rusak">{{ $kondRusak }}</span><span class="sv-label">item</span></td>
                </tr>
            </tbody>
        </table>
    </div>

    {{-- TTD --}}
    <div class="report-bottom">
        <div class="ttd-block">
            <div>Bandung,{{ \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y') }}</div>
            <div>Penanggung Jawab,</div>
            <div class="ttd-space"></div>
            <div class="ttd-name">{{ auth()->user()->name }}</div>
            <div class="ttd-role">{{ ucfirst(auth()->user()->role) }}</div>
        </div>
    </div>

</div>
</body>
</html>
