@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-8 bg-gray-900 text-gray-100 min-h-screen rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-400">Riwayat Gaji Karyawan</h1>

    @if (auth()->user()->role === 'admin')
        <div class="mb-4 flex justify-end">
            <a href="{{ route('gaji.generate.show') }}" class="btn bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">
                Generate Gaji Baru
            </a>
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-700 text-white p-4 rounded-lg mb-6 shadow-md" role="alert">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-700 text-white p-4 rounded-lg mb-6 shadow-md" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($gaji->isEmpty())
        <p class="text-center text-gray-400">Belum ada data gaji yang dihitung.</p>
    @else
        <div class="overflow-x-auto rounded-lg shadow-md">
            <table class="min-w-full bg-gray-800 rounded-lg overflow-hidden">
                <thead class="bg-gray-700">
                    <tr>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Karyawan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Periode</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Gaji Pokok</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tunj. Keluarga</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Uang Makan</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Uang Transport</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tunj. Lembur</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pot. Absensi</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pot. Cuti</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">BPJS</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Pot. Pajak</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Bruto</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Total Netto</th>
                        <th class="px-4 py-2 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                        {{-- PERBAIKAN: Judul kolom 'Aksi' diubah menjadi text-center --}}
                        <th class="px-4 py-2 text-center text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @foreach ($gaji as $item)
                        <tr class="hover:bg-gray-750">
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">{{ $item->karyawan->nama }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">{{ \Carbon\Carbon::createFromDate($item->tahun, $item->bulan, 1)->translatedFormat('F Y') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->gaji_pokok, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->tunjangan_keluarga, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->uang_makan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->uang_transport, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->tunjangan_lembur, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->potongan_absensi, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->potongan_uang_makan_cuti + $item->potongan_transport_cuti, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->bpjs_kesehatan, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">Rp {{ number_format($item->potongan_pajak, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200 font-semibold text-blue-400">Rp {{ number_format($item->total_gaji_bruto, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200 font-semibold text-green-400">Rp {{ number_format($item->total_gaji_netto, 0, ',', '.') }}</td>
                            <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-200">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                    {{ $item->status_pembayaran === 'dibayar' ? 'bg-green-200 text-green-800' : 'bg-yellow-200 text-yellow-800' }}">
                                    {{ ucfirst($item->status_pembayaran) }}
                                </span>
                            </td>
                            {{-- PERBAIKAN: Sel kolom 'Aksi' diubah menjadi text-center --}}
                            <td class="px-4 py-2 whitespace-nowrap text-sm font-medium text-center">
                                {{-- Tombol Cetak selalu ada untuk semua user --}}
                                <a href="{{ route('gaji.cetak', $item->id_gaji) }}" target="_blank" class="text-green-400 hover:text-green-500 mr-2">Cetak</a>
                                
                                {{-- Tombol Edit dan Hapus hanya untuk admin --}}
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ route('gaji.edit', $item->id_gaji) }}" class="text-indigo-400 hover:text-indigo-600 mr-2">Edit</a>
                                    <form action="{{ route('gaji.destroy', $item->id_gaji) }}" method="POST" class="inline-block" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data gaji ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-600">Hapus</button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if (method_exists($gaji, 'links') && auth()->user()->role === 'admin')
            <div class="mt-4">
                {{ $gaji->links() }}
            </div>
        @endif
    @endif
</div>
@endsection
