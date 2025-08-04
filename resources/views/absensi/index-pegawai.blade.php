@extends('layouts.app')

@section('title', 'Riwayat Absensi Saya')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h2 class="text-3xl font-bold text-white mb-6">Riwayat Absensi Saya</h2>

        <!-- Ringkasan Bulan Ini -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="bg-gradient-to-br from-green-500 to-teal-600 p-6 rounded-xl shadow-lg text-white">
                <p class="text-sm font-medium text-green-100 uppercase">Hadir Bulan Ini</p>
                <p class="text-4xl font-bold">{{ $statistik['hadir'] ?? 0 }} <span class="text-2xl font-medium">Hari</span></p>
            </div>
            <div class="bg-gradient-to-br from-yellow-500 to-orange-600 p-6 rounded-xl shadow-lg text-white">
                <p class="text-sm font-medium text-yellow-100 uppercase">Terlambat Bulan Ini</p>
                <p class="text-4xl font-bold">{{ $statistik['terlambat'] ?? 0 }} <span class="text-2xl font-medium">Kali</span></p>
            </div>
            <div class="bg-gradient-to-br from-red-500 to-rose-600 p-6 rounded-xl shadow-lg text-white">
                <p class="text-sm font-medium text-red-100 uppercase">Izin/Sakit Bulan Ini</p>
                <p class="text-4xl font-bold">{{ $statistik['lainnya'] ?? 0 }} <span class="text-2xl font-medium">Hari</span></p>
            </div>
        </div>

        <!-- Tabel Daftar Absensi -->
        <div class="bg-gray-800 p-4 sm:p-6 rounded-xl shadow-lg overflow-x-auto">
            <h3 class="text-xl font-bold text-white mb-4">Detail Riwayat</h3>
            <table class="min-w-full">
                <thead>
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Tanggal</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Jam Masuk</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Jam Keluar</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-400 uppercase">Keterangan</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-700">
                    @forelse ($absensis as $absensi)
                        <tr class="hover:bg-gray-700/50">
                            <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">{{ $absensi->tanggal_absensi?->format('d M Y') ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $absensi->status_kehadiran == 'hadir' ? 'bg-green-100 text-green-800' : 
                                       ($absensi->status_kehadiran == 'terlambat' ? 'bg-yellow-100 text-yellow-800' : 
                                       'bg-red-100 text-red-800') }}">
                                    {{ ucwords(str_replace('_', ' ', $absensi->status_kehadiran)) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">{{ $absensi->waktu_masuk?->format('H:i:s') ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-300 whitespace-nowrap">{{ $absensi->waktu_keluar?->format('H:i:s') ?? '-' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-400 whitespace-nowrap">{{ $absensi->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                Anda belum memiliki riwayat absensi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- Paginasi -->
        <div class="mt-6">
            {{ $absensis->links() }}
        </div>
    </div>
@endsection
