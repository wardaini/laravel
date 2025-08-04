<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Slip Gaji - {{ $gaji->karyawan->nama }} - {{ \Carbon\Carbon::create($gaji->tahun, $gaji->bulan)->translatedFormat('F Y') }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
        }
        .container {
            /* PERBAIKAN: Lebar diatur di inline style untuk presisi */
            width: 100%;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
        }
        .header h2 {
            margin: 0;
            font-size: 22px;
        }
        .header p {
            margin: 5px 0 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 8px;
            text-align: left;
            font-size: 13px;
        }
        .info-table td {
            border: none;
        }
        .rincian-table th, .rincian-table td {
            border: 1px solid #ddd;
        }
        .rincian-table th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .total-row td {
            font-weight: bold;
            background-color: #e9e9e9;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    {{-- PERBAIKAN: Menggunakan tabel luar untuk memastikan konten berada di tengah --}}
    <table width="100%">
        <tr>
            <td align="center">
                <div class="container" style="width: 700px;">
                    <div class="header">
                        <h2>SLIP GAJI KARYAWAN</h2>
                        <p>Periode: {{ \Carbon\Carbon::create($gaji->tahun, $gaji->bulan)->translatedFormat('F Y') }}</p>
                    </div>

                    <table class="info-table">
                        <tr>
                            <td style="width: 20%;">Nama Karyawan</td>
                            <td style="width: 5%;">:</td>
                            <td>{{ $gaji->karyawan->nama }}</td>
                        </tr>
                        <tr>
                            <td>Jabatan</td>
                            <td>:</td>
                            <td>{{ $gaji->karyawan->jabatan->nama_jabatan ?? 'N/A' }}</td>
                        </tr>
                    </table>

                    <h4>Rincian Gaji:</h4>
                    <table class="rincian-table">
                        <thead>
                            <tr>
                                <th>Deskripsi</th>
                                <th style="width: 30%;" class="text-right">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Gaji Pokok</td>
                                <td class="text-right">Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Tunjangan Keluarga</td>
                                <td class="text-right">Rp {{ number_format($gaji->tunjangan_keluarga, 0, ',', '.') }}</td>
                            </tr>
                             <tr>
                                <td>Uang Makan</td>
                                <td class="text-right">Rp {{ number_format($gaji->uang_makan, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Uang Transport</td>
                                <td class="text-right">Rp {{ number_format($gaji->uang_transport, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Tunjangan Lembur</td>
                                <td class="text-right">Rp {{ number_format($gaji->tunjangan_lembur, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="total-row">
                                <td>Total Gaji Bruto</td>
                                <td class="text-right">Rp {{ number_format($gaji->total_gaji_bruto, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Potongan Absensi</td>
                                <td class="text-right">- Rp {{ number_format($gaji->potongan_absensi, 0, ',', '.') }}</td>
                            </tr>
                             <tr>
                                <td>Potongan Cuti</td>
                                <td class="text-right">- Rp {{ number_format($gaji->potongan_uang_makan_cuti, 0, ',', '.') }}</td>
                            </tr>
                             <tr>
                                <td>Potongan BPJS</td>
                                <td class="text-right">- Rp {{ number_format($gaji->bpjs_kesehatan, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Potongan Pajak</td>
                                <td class="text-right">- Rp {{ number_format($gaji->potongan_pajak, 0, ',', '.') }}</td>
                            </tr>
                            <tr>
                                <td>Potongan Lain-lain</td>
                                <td class="text-right">- Rp {{ number_format($gaji->total_potongan_lain, 0, ',', '.') }}</td>
                            </tr>
                            <tr class="total-row">
                                <td>Total Gaji Netto Diterima</td>
                                <td class="text-right">Rp {{ number_format($gaji->total_gaji_netto, 0, ',', '.') }}</td>
                            </tr>
                            @if(!empty($gaji->keterangan))
                            <tr>
                                <td>Keterangan</td>
                                <td colspan="2">{{ $gaji->keterangan }}</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </td>
        </tr>
    </table>
</body>
</html>
