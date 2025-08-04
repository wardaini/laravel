{{-- <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Absensi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="mb-4">
                    <h3 class="text-lg font-bold text-gray-800 mb-2">Informasi Absensi</h3>
                    <p><strong>ID:</strong> {{ $absensi->id }}</p>
                    <p><strong>Karyawan:</strong> {{ $absensi->karyawan->nama ?? '-' }}</p>
                    <p><strong>Tanggal:</strong> {{ $absensi->tanggal_absensi?->format('d M Y') }}</p>
                    <p><strong>Waktu Masuk:</strong> {{ $absensi->waktu_masuk?->format('H:i') ?? '-' }}</p>
                    <p><strong>Waktu Keluar:</strong> {{ $absensi->waktu_keluar?->format('H:i') ?? '-' }}</p>
                    <p><strong>Status Kehadiran:</strong> {{ ucfirst($absensi->status_kehadiran) }}</p>
                    <p><strong>Catatan:</strong> {{ $absensi->catatan ?? '-' }}</p>
                </div>

                <div class="flex justify-end">
                    <a href="{{ route('absensi.index') }}" class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Kembali</a>
                </div>

            </div>
        </div>
    </div>
</x-app-layout> --}}
