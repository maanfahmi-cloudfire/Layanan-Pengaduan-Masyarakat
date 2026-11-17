<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Rekapitulasi Pengaduan Masyarakat Gayo Lues</title>

    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            color: #1e293b;
            margin: 0;
            padding: 24px;
            font-size: 11px;
            line-height: 1.4;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }

        .header h1 {
            font-size: 16px;
            font-weight: 800;
            text-transform: uppercase;
            margin: 0;
            letter-spacing: 0.5px;
        }

        .header h2 {
            font-size: 13px;
            font-weight: 600;
            margin: 4px 0 0 0;
        }

        .header p {
            font-size: 10px;
            color: #64748b;
            margin: 4px 0 0 0;
        }

        .meta-box {
            display: flex;
            justify-content: space-between;
            margin-bottom: 16px;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }

        th, td {
            border: 1px solid #cbd5e1;
            padding: 6px 8px;
            text-align: left;
        }

        th {
            background-color: #f1f5f9;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f8fafc;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
            font-weight: bold;
        }

        .signature {
            display: flex;
            justify-content: flex-end;
            margin-top: 40px;
            page-break-inside: avoid;
        }

        .signature-box {
            text-align: center;
            width: 200px;
        }

        .signature-line {
            margin-top: 60px;
            border-bottom: 1px solid #000;
            font-weight: bold;
        }

        .no-print {
            background-color: #0284c7;
            color: white;
            padding: 10px 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            font-weight: bold;
            font-size: 12px;
            margin-bottom: 20px;
        }

        @media print {
            .no-print {
                display: none;
            }
            body {
                padding: 0;
            }
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="no-print">🖨️ Cetak Dokumen / Simpan PDF</button>

    <!-- Header Dokumen -->
    <div class="header">
        <h1>Layanan Pengaduan Masyarakat Kabupaten Gayo Lues</h1>
        <h2>Laporan Rekapitulasi Data Pengaduan Masuk</h2>
        <p>Negeri Seribu Bukit • Provinsi Aceh • Tanggal Cetak: {{ date('d F Y, H:i') }} WIB</p>
    </div>

    <!-- Parameter Filter -->
    <div class="meta-box">
        <div>
            <strong>Total Rekapitulasi:</strong> {{ $complaints->count() }} Data Pengaduan
        </div>
        <div>
            <strong>Dicetak Oleh:</strong> {{ auth()->user()->name }} (Administrator)
        </div>
    </div>

    <!-- Tabel Rekap Data -->
    <table>
        <thead>
            <tr>
                <th style="width: 30px;">No</th>
                <th style="width: 90px;">No Tiket</th>
                <th style="width: 70px;">Tanggal</th>
                <th style="width: 100px;">Nama Pelapor</th>
                <th style="width: 90px;">Kecamatan</th>
                <th style="width: 100px;">Kategori</th>
                <th>Judul & Rincian Pengaduan</th>
                <th style="width: 80px;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($complaints as $index => $c)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="font-family: monospace; font-weight: bold;">{{ $c->ticket_number }}</td>
                    <td>{{ $c->incident_date->format('d/m/Y') }}</td>
                    <td>
                        <strong>{{ $c->user ? $c->user->name : '-' }}</strong><br>
                        <span style="color: #64748b; font-size: 9px;">{{ $c->user ? $c->user->phone : '-' }}</span>
                    </td>
                    <td>{{ $c->kecamatan }} ({{ $c->desa }})</td>
                    <td>{{ $c->category ? $c->category->name : '-' }}</td>
                    <td>
                        <strong>{{ $c->title }}</strong><br>
                        <span style="color: #64748b;">{{ Str::limit($c->description, 100) }}</span>
                    </td>
                    <td>
                        <span class="status-badge">{{ $c->status_label }}</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 20px; color: #64748b;">
                        Tidak ada data pengaduan yang ditemukan.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Tanda Tangan Pengesahan -->
    <div class="signature">
        <div class="signature-box">
            <div>Blangkejeren, {{ date('d F Y') }}</div>
            <div style="margin-top: 4px;">Mengetahui,</div>
            <div style="font-weight: 600;">Administrator Pengaduan Gayo Lues</div>
            <div class="signature-line">{{ auth()->user()->name }}</div>
            <div style="font-size: 9px; color: #64748b; margin-top: 2px;">NIP / ID: ADM-GL-{{ date('Y') }}</div>
        </div>
    </div>

</body>
</html>

