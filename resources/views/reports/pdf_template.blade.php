<!DOCTYPE html>
<html>
<head>
    <title>Laporan Keuangan BOS</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #666; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th { background-color: #f2f2f2; border: 1px solid #ddd; padding: 10px; text-align: left; text-transform: uppercase; font-size: 10px; }
        td { border: 1px solid #ddd; padding: 10px; }
        
        .summary { margin-top: 30px; margin-left: auto; width: 300px; }
        .summary-row { display: table; width: 100%; margin-bottom: 5px; }
        .summary-label { display: table-cell; font-weight: bold; }
        .summary-value { display: table-cell; text-align: right; }
        
        .footer { margin-top: 50px; text-align: right; }
        .signature { margin-top: 60px; font-weight: bold; }

        .status-badge { background-color: #d1fae5; color: #065f46; padding: 3px 8px; border-radius: 4px; font-size: 9px; font-weight: bold; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Laporan Pertanggungjawaban Keuangan</div>
        <div class="subtitle">BOS Management System - Academic Year {{ $rkas->tahun_ajaran ?? '-' }}</div>
        @if($month)
            <div style="margin-top: 5px;">Periode: {{ date('F', mktime(0, 0, 0, $month, 1)) }}</div>
        @endif
    </div>

    <table style="width: 100%; margin-bottom: 20px;">
        <tr>
            <td style="border: none; width: 50%;">
                <strong>Kepada Yth,</strong><br>
                Kepala Sekolah (Principal)<br>
                Di Tempat
            </td>
            <td style="border: none; text-align: right;">
                <strong>Tanggal Laporan:</strong> {{ $date }}<br>
                <strong>Status:</strong> Terverifikasi Sistem
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 15%;">Tanggal</th>
                <th style="width: 35%;">Keterangan Transaksi</th>
                <th style="width: 25%;">Kategori Anggaran</th>
                <th style="width: 25%; text-align: right;">Jumlah (IDR)</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($t->tanggal_pencairan)->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $t->judul }}</strong><br>
                        <span style="font-size: 9px; color: #777;">{{ $t->deskripsi }}</span>
                    </td>
                    <td>{{ $t->rkas->kegiatan_list[$t->kegiatan_idx]['name'] ?? 'Lainnya' }}</td>
                    <td style="text-align: right;">Rp {{ number_format($t->jumlah_dana, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div class="summary-row" style="border-top: 2px solid #eee; padding-top: 10px;">
            <div class="summary-label text-lg">TOTAL REALISASI</div>
            <div class="summary-value" style="font-size: 14px; font-weight: bold;">Rp {{ number_format($total, 0, ',', '.') }}</div>
        </div>
    </div>

    <div class="footer">
        <p>Laporan ini dicetak secara otomatis melalui sistem per {{ $date }}</p>
        <div class="signature">
            Mengetahui,<br><br><br><br>
            ( ............................................ )<br>
            Kepala Sekolah
        </div>
    </div>
</body>
</html>
