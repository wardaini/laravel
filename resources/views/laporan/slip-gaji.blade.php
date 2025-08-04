<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->nama }} - {{ \Carbon\Carbon::parse($gaji->bulan_tahun)->translatedFormat('F Y') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #e5e7eb;
            font-family: 'Roboto', sans-serif;
        }
        .page-container {
            max-width: 850px;
            margin: 1rem auto;
            padding: 2rem 2.5rem 2.5rem;
            background-color: white;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 4px 0;
            font-size: 14px;
        }
        .rincian-table th, .rincian-table td {
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            font-size: 14px;
        }
        .rincian-table thead th {
            background-color: #f9fafb;
            font-weight: 500;
            text-align: center;
        }
        .rincian-table .amount {
            text-align: right;
        }
        .summary-table td {
            border: 1px solid #d1d5db;
            padding: 8px 12px;
            font-weight: 500;
        }
        @media print {
            body {
                background-color: white;
            }
            .page-container {
                margin: 0;
                padding: 0;
                box-shadow: none;
            }
        }
    </style>
</head>
<body>

    <div class="page-container">
        {{-- KOP SURAT --}}
        <header class="text-center" style="text-align: center;">
            <h1 class="text-xl font-bold uppercase">Slip Gaji</h1>
            <p class="text-sm">PT Arkalora Cakrawala</p>
            <p class="text-xs text-gray-500">Jl. Jendral Sudirman No. 123, Lhokseumawe</p>
        </header>
        <hr class="border-t-2 border-gray-900 mt-2 mb-8">

        {{-- INFORMASI KARYAWAN (2 KOLOM) --}}
        <section class="mb-6">
            <table class="info-table">
                <tr>
                    <td class="w-1/4">Tanggal Masuk</td>
                    <td class="w-1/4">: {{ $gaji->karyawan->created_at->format('d-m-Y') }}</td>
                    <td class="w-1/4">Nama Karyawan</td>
                    <td class="w-1/4">: {{ $gaji->karyawan->nama }}</td>
                </tr>
                <tr>
                    <td>Periode Gaji</td>
                    <td>: {{ \Carbon\Carbon::parse($gaji->bulan_tahun)->translatedFormat('F Y') }}</td>
                    <td>Divisi</td>
                    <td>: {{ $gaji->karyawan->jabatan->nama_jabatan ?? 'N/A' }}</td>
                </tr>
                 <tr>
                    <td></td>
                    <td></td>
                    <td>NIP</td>
                    <td>: {{ $gaji->karyawan->nip ?? 'N/A' }}</td>
                </tr>
            </table>
        </section>

        {{-- RINCIAN PENDAPATAN & POTONGAN --}}
        @php
            $pendapatan = [
                ['deskripsi' => 'Gaji Pokok', 'jumlah' => $gaji->gaji_pokok],
                ['deskripsi' => 'Tunjangan Keluarga', 'jumlah' => $gaji->tunjangan_keluarga],
                ['deskripsi' => 'Uang Makan', 'jumlah' => $gaji->uang_makan],
                ['deskripsi' => 'Uang Transport', 'jumlah' => $gaji->uang_transport],
                ['deskripsi' => 'Tunjangan Lembur', 'jumlah' => $gaji->tunjangan_lembur],
            ];
            $pengurang = [
                ['deskripsi' => 'Potongan Absensi', 'jumlah' => $gaji->potongan_absensi],
                ['deskripsi' => 'Potongan Cuti', 'jumlah' => $gaji->potongan_cuti],
                ['deskripsi' => 'Potongan BPJS', 'jumlah' => $gaji->potongan_bpjs],
                ['deskripsi' => 'Potongan Pajak', 'jumlah' => $gaji->potongan_pajak],
                ['deskripsi' => 'Potongan Lain-lain', 'jumlah' => $gaji->potongan_lain],
            ];
            $rowCount = max(count($pendapatan), count($pengurang));
        @endphp
        <section>
            <table class="rincian-table">
                <thead>
                    <tr>
                        <th>Pendapatan</th>
                        <th class="w-1/4">Amount</th>
                        <th>Pengurang</th>
                        <th class="w-1/4">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @for ($i = 0; $i < $rowCount; $i++)
                    <tr>
                        <td>{{ $pendapatan[$i]['deskripsi'] ?? '' }}</td>
                        <td class="amount">{{ isset($pendapatan[$i]) ? 'Rp ' . number_format($pendapatan[$i]['jumlah'], 0, ',', '.') : '' }}</td>
                        <td>{{ $pengurang[$i]['deskripsi'] ?? '' }}</td>
                        <td class="amount">{{ isset($pengurang[$i]) ? 'Rp ' . number_format($pengurang[$i]['jumlah'], 0, ',', '.') : '' }}</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
            <table class="summary-table mt-[-1px]">
                <tr>
                    <td class="w-1/2 font-bold">Total Pendapatan</td>
                    <td class="w-1/4 amount">Rp {{ number_format($gaji->total_gaji_bruto, 0, ',', '.') }}</td>
                    <td class="w-1/2 font-bold">Total Pengurang</td>
                    <td class="w-1/4 amount">Rp {{ number_format($gaji->total_potongan, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="font-bold text-center bg-gray-100">Gaji Bersih</td>
                    <td class="amount font-bold bg-gray-100">Rp {{ number_format($gaji->total_gaji_netto, 0, ',', '.') }}</td>
                </tr>
            </table>
        </section>

        {{-- TANDA TANGAN --}}
        {{-- PERBAIKAN FINAL: Menggunakan tabel untuk memaksa posisi di kanan --}}
        <footer class="mt-24 text-sm">
            <table class="w-full">
                <tr>
                    <td class="w-2/3"></td> {{-- Kolom kosong di kiri untuk mendorong tanda tangan ke kanan --}}
                    <td class="w-1/3 text-center">
                        <p>Ttd Perusahaan</p>
                        <div class="mt-16 pt-4"></div> {{-- Jarak untuk tanda tangan --}}
                        <p class="font-medium">(Manajer HRD)</p>
                    </td>
                </tr>
            </table>
        </footer>
    </div>

</body>
</html>
