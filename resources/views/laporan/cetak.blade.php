<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Prioritas Produksi - {{ $periode->nama_periode }}</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            color: #000;
            background: #fff;
            font-size: 12pt;
        }

        .kop-surat {
            border-bottom: 3px double #000;
            padding-bottom: 12px;
            margin-bottom: 24px;
            text-align: center;
        }
        .kop-title {
            font-size: 16pt;
            font-weight: bold;
            letter-spacing: 1px;
            margin-bottom: 2px;
        }
        .kop-subtitle {
            font-size: 13pt;
            font-weight: bold;
            margin-bottom: 4px;
        }
        .kop-address {
            font-size: 10pt;
            margin-bottom: 0;
            line-height: 1.3;
        }

        .report-title {
            text-align: center;
            font-size: 13pt;
            font-weight: bold;
            text-decoration: underline;
            margin-bottom: 4px;
        }
        .report-subtitle {
            text-align: center;
            font-size: 11pt;
            margin-bottom: 20px;
        }

        .table-report th {
            background-color: #f2f2f2 !important;
            color: #000 !important;
            border: 1px solid #000 !important;
            font-size: 10pt;
            text-align: center;
            padding: 6px;
        }
        .table-report td {
            border: 1px solid #000 !important;
            font-size: 10pt;
            padding: 6px;
        }

        .ttd-box {
            margin-top: 40px;
            page-break-inside: avoid;
        }

        @media print {
            .no-print {
                display: none !important;
            }
            body {
                padding: 0;
                margin: 1.5cm;
            }
        }
    </style>
</head>
<body class="p-4">

    <!-- Print Action Bar -->
    <div class="no-print mb-4 p-3 bg-white border rounded-4 shadow-sm d-flex justify-content-between align-items-center">
        <div>
            <strong class="text-dark">Preview Cetak Dokumen Resmi</strong>
            <div class="small text-muted">Gunakan opsi print browser untuk menyimpan ke PDF atau mencetak ke kertas A4.</div>
        </div>
        <div class="d-flex gap-2">
            <button onclick="window.print()" class="btn btn-sm px-3 text-white" style="background: linear-gradient(135deg, #FF5B5B 0%, #E5383B 100%); border-radius: 9999px; font-weight: 600; border: none;">
                Cetak Dokumen Sekarang (Print/PDF)
            </button>
            <button onclick="window.close()" class="btn btn-sm btn-outline-secondary px-3" style="border-radius: 9999px; font-weight: 600;">
                Tutup
            </button>
        </div>
    </div>

    <!-- KOP SURAT RESMI -->
    <div class="kop-surat">
        <div class="kop-title">PELANGI NUSANTARA FOOD</div>
        <div class="kop-subtitle">(PERUSAHAAN ROTI PURNAMA)</div>
        <p class="kop-address">
            Pusat Produksi Roti Berkualitas, Higienis, dan Halal<br>
            Jl. Margodadi, Kec. Metro Selatan, Kota Metro, Lampung — Kode Pos 34122<br>
            Izin Depkes PIKT No: 2.06.1872.12.2009 | Telp: (0725) 456-xxx
        </p>
    </div>

    <!-- JUDUL DOKUMEN -->
    <div class="report-title">LAPORAN REKOMENDASI PENENTUAN VARIAN ROTI PRIORITAS PRODUKSI</div>
    <div class="report-subtitle">
        Metode Simple Additive Weighting (SAW) • {{ $periode->nama_periode }}
    </div>

    <!-- INFORMASI UMUM -->
    <table class="table table-borderless table-sm mb-3" style="font-size: 10.5pt; width: 100%;">
        <tr>
            <td style="width: 170px;"><strong>Periode Produksi</strong></td>
            <td style="width: 15px;">:</td>
            <td>{{ $periode->nama_periode }} (Bulan {{ sprintf('%02d', $periode->bulan) }} / {{ $periode->tahun }})</td>
            <td style="width: 150px;"><strong>Tanggal Cetak</strong></td>
            <td style="width: 15px;">:</td>
            <td>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</td>
        </tr>
        <tr>
            <td><strong>Status Keputusan</strong></td>
            <td>:</td>
            <td>
                @if($periode->status === 'divalidasi')
                    <strong>Telah Divalidasi Manajemen</strong>
                @else
                    Draf Rekomendasi Sistem SPK
                @endif
            </td>
            <td><strong>Penanggung Jawab</strong></td>
            <td>:</td>
            <td>Ibu Dian (Admin Operasional)</td>
        </tr>
        @if($periode->catatan_manajemen)
        <tr>
            <td><strong>Arahan Manajemen</strong></td>
            <td>:</td>
            <td colspan="4"><em>"{{ $periode->catatan_manajemen }}"</em></td>
        </tr>
        @endif
    </table>

    <!-- TABEL HASIL SAW -->
    <table class="table table-report table-sm mb-4">
        <thead>
            <tr>
                <th style="width: 50px;">Rank</th>
                <th style="width: 60px;">Kode</th>
                <th>Nama Varian Roti</th>
                <th style="width: 130px;">Kategori</th>
                <th style="width: 110px;">Nilai Preferensi (Vᵢ)</th>
                <th style="width: 130px;">Status Prioritas</th>
                <th>Rekomendasi Kebijakan Produksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($hasilSaw as $item)
                <tr>
                    <td class="text-center fw-bold">{{ $item->ranking }}</td>
                    <td class="text-center">{{ $item->varianRoti->kode }}</td>
                    <td><strong>{{ $item->varianRoti->nama_varian }}</strong></td>
                    <td>{{ $item->varianRoti->kategori }}</td>
                    <td class="text-center fw-bold">{{ $item->nilai_preferensi }}</td>
                    <td class="text-center">
                        @if($item->rekomendasi === 'Prioritas Utama')
                            <strong>Prioritas Utama</strong>
                        @elseif($item->rekomendasi === 'Prioritas Sedang')
                            Prioritas Sedang
                        @else
                            Prioritas Rendah
                        @endif
                    </td>
                    <td>{{ $item->catatan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="small mb-4" style="font-size: 9.5pt;">
        <strong>Catatan Metode:</strong><br>
        1. Nilai Preferensi (Vᵢ) diperoleh dari rumus <code>Vᵢ = ∑ (Wⱼ × Rᵢⱼ)</code> dengan 5 kriteria: Volume Penjualan (C1: 30%, Benefit), Keuntungan (C2: 25%, Benefit), Stok Bahan Baku (C3: 15%, Benefit), Waktu Produksi (C4: 15%, Cost), dan Sisa Stok Gudang (C5: 15%, Cost).<br>
        2. Varian berstatus <em>Prioritas Utama</em> direkomendasikan untuk didahulukan produksinya pada siklus bulanan berikutnya guna meminimalkan risiko <em>stockout</em> pada produk paling potensial.
    </div>

    <!-- TANDA TANGAN -->
    <div class="row ttd-box text-center" style="font-size: 10.5pt;">
        <div class="col-4">
            <div>Dibuat & Dihitung Oleh,</div>
            <div class="fw-semibold">Admin Operasional</div>
            <div style="height: 75px;"></div>
            <div class="fw-bold text-decoration-underline">Ibu Dian</div>
            <div class="small text-muted">Pelangi Nusantara Food</div>
        </div>
        <div class="col-4">
            <div>Disetujui & Divalidasi Oleh,</div>
            <div class="fw-semibold">Manajer Operasional</div>
            <div style="height: 75px;"></div>
            <div class="fw-bold text-decoration-underline">Wisnu Nur Yadi</div>
            <div class="small text-muted">Pelangi Nusantara Food</div>
        </div>
        <div class="col-4">
            <div>Mengetahui,</div>
            <div class="fw-semibold">Direktur Utama / Pemilik</div>
            <div style="height: 75px;"></div>
            <div class="fw-bold text-decoration-underline">H. Iwan Abdul Hamit</div>
            <div class="small text-muted">Perusahaan Roti Purnama</div>
        </div>
    </div>

</body>
</html>
