<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Slip Gaji - {{ $gaji->karyawan->nama }} - {{ \Carbon\Carbon::create($gaji->tahun, $gaji->bulan)->translatedFormat('F Y') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            .no-print {
                display: none;
            }
        }
        .slip-gaji {
            font-family: 'sans-serif';
            max-width: 800px;
            margin: auto;
            padding: 2rem;
            border: 1px solid #e2e8f0;
            background-color: white;
        }
    </style>
</head>
<body class="bg-gray-100">

    <div class="slip-gaji my-8">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">SLIP GAJI KARYAWAN</h1>
            <p class="text-gray-600">Periode: {{ \Carbon\Carbon::create($gaji->tahun, $gaji->bulan)->translatedFormat('F Y') }}</p>
        </div>

        <div class="grid grid-cols-2 gap-x-8 gap-y-4 mb-8 text-sm">
            <div>
                <p class="font-semibold text-gray-700">Nama Karyawan</p>
                <p>{{ $gaji->karyawan->nama }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">NIP</p>
                <p>{{ $gaji->karyawan->nip }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Jabatan</p>
                <p>{{ $gaji->karyawan->jabatan->nama_jabatan ?? 'N/A' }}</p>
            </div>
            <div>
                <p class="font-semibold text-gray-700">Golongan</p>
                <p>{{ $gaji->karyawan->golongan->nama_golongan ?? 'N/A' }}</p>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
            <!-- PENDAPATAN -->
            <div>
                <h2 class="text-xl font-semibold border-b-2 border-gray-800 pb-2 mb-4 text-gray-800">Pendapatan</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span>Gaji Pokok</span> <span>Rp {{ number_format($gaji->gaji_pokok, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Keluarga</span> <span>Rp {{ number_format($gaji->tunjangan_keluarga, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Uang Makan</span> <span>Rp {{ number_format($gaji->uang_makan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Uang Transport</span> <span>Rp {{ number_format($gaji->uang_transport, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Tunjangan Lembur</span> <span>Rp {{ number_format($gaji->tunjangan_lembur, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>THR</span> <span>Rp {{ number_format($gaji->thr, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Bonus</span> <span>Rp {{ number_format($gaji->bonus, 0, ',', '.') }}</span></div>
                </div>
                <div class="flex justify-between font-bold text-base mt-4 pt-2 border-t border-gray-300">
                    <span>Total Pendapatan (Bruto)</span>
                    <span>Rp {{ number_format($gaji->total_gaji_bruto, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- POTONGAN -->
            <div>
                <h2 class="text-xl font-semibold border-b-2 border-red-500 pb-2 mb-4 text-gray-800">Potongan</h2>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span>Potongan Absensi</span> <span>Rp {{ number_format($gaji->potongan_absensi, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Cuti</span> <span>Rp {{ number_format($gaji->potongan_uang_makan_cuti, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>BPJS Kesehatan</span> <span>Rp {{ number_format($gaji->bpjs_kesehatan, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Pajak (PPh 21)</span> <span>Rp {{ number_format($gaji->potongan_pajak, 0, ',', '.') }}</span></div>
                    <div class="flex justify-between"><span>Potongan Lainnya</span> <span>Rp {{ number_format($gaji->total_potongan_lain, 0, ',', '.') }}</span></div>
                </div>
                <div class="flex justify-between font-bold text-base mt-4 pt-2 border-t border-gray-300">
                    <span>Total Potongan</span>
                    <span>Rp {{ number_format($gaji->total_gaji_bruto - $gaji->total_gaji_netto, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="bg-gray-800 text-white p-6 rounded-lg text-center">
            <p class="text-lg">Gaji Bersih (Take Home Pay)</p>
            <p class="text-4xl font-bold tracking-wider">Rp {{ number_format($gaji->total_gaji_netto, 0, ',', '.') }}</p>
        </div>

        <div class="mt-12 text-xs text-gray-500 text-center">
            <p>Ini adalah slip gaji yang dibuat secara otomatis oleh sistem.</p>
            <p>Dicetak pada: {{ now()->translatedFormat('d F Y, H:i:s') }}</p>
        </div>
    </div>

    <div class="text-center my-8 no-print">
        <button onclick="window.print()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-6 rounded-lg shadow-md">
            Cetak
        </button>
    </div>

</body>
</html>
