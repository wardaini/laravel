<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Absensi Karyawan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <h3 class="text-lg font-bold text-gray-800 mb-4">Data Karyawan</h3>
                <p><strong>Nama:</strong> {{ $karyawan->nama }}</p>
                <p><strong>NIK:</strong> {{ $karyawan->nik ?? '-' }}</p>
                <p><strong>Jabatan:</strong> {{ $karyawan->jabatan->nama ?? '-' }}</p>

                <h3 class="text-lg font-bold text-gray-800 mt-6 mb-4">Riwayat Absensi</h3>

                <table class="min-w-full divide-y divide-gray-200">
                    <thead>
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Tanggal</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Masuk</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Keluar</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Catatan</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($absensisKaryawan as $absensi)
                            <tr>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $absensi->tanggal_absensi?->format('d M Y') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $absensi->waktu_masuk?->format('H:i') ?? '-' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $absensi->waktu_keluar?->format('H:i') ?? '-' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ ucfirst($absensi->status_kehadiran) }}</td>
                                <td class="px-4 py-2 whitespace-nowrap">{{ $absensi->catatan ?? '-' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">Belum ada data absensi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4">
                    <a href="{{ route('absensi.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
