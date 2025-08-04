{{-- <x-app-layout>
    @php
        $absensiHariIni = $absensiHariIni ?? null;
    @endphp
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Absensi Manual') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('absensi.store') }}">
                    @csrf

                    <!-- Pilih Karyawan -->
                    <div class="mb-4">
                        <label for="karyawan_id" class="block text-gray-700 font-bold mb-2">Pilih Karyawan</label>
                        <select name="karyawan_id" id="karyawan_id" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Karyawan --</option>
                            @foreach($karyawans as $karyawan)
                                <option value="{{ $karyawan->id }}">{{ $karyawan->nama }}</option>
                            @endforeach
                        </select>
                        @error('karyawan_id')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Absensi -->
                    <div class="mb-4">
                        <label for="tanggal_absensi" class="block text-gray-700 font-bold mb-2">Tanggal Absensi</label>
                        <input type="date" name="tanggal_absensi" id="tanggal_absensi"
                               value="{{ old('tanggal_absensi', now()->format('Y-m-d')) }}"
                               class="w-full border-gray-300 rounded-md shadow-sm" required>
                        @error('tanggal_absensi')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Waktu Masuk -->
                    <div class="mb-4">
                        <label for="waktu_masuk" class="block text-gray-700 font-bold mb-2">Waktu Masuk</label>
                        <input type="time" name="waktu_masuk" id="waktu_masuk"
                               value="{{ old('waktu_masuk') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('waktu_masuk')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Waktu Keluar -->
                    <div class="mb-4">
                        <label for="waktu_keluar" class="block text-gray-700 font-bold mb-2">Waktu Keluar</label>
                        <input type="time" name="waktu_keluar" id="waktu_keluar"
                               value="{{ old('waktu_keluar') }}"
                               class="w-full border-gray-300 rounded-md shadow-sm">
                        @error('waktu_keluar')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Status Kehadiran -->
                    <div class="mb-4">
                        <label for="status_kehadiran" class="block text-gray-700 font-bold mb-2">Status Kehadiran</label>
                        <select name="status_kehadiran" id="status_kehadiran" class="w-full border-gray-300 rounded-md shadow-sm" required>
                            <option value="">-- Pilih Status --</option>
                            @foreach($statusOptions as $status)
                                <option value="{{ $status }}" {{ old('status_kehadiran') == $status ? 'selected' : '' }}>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status_kehadiran')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Catatan -->
                    <div class="mb-4">
                        <label for="catatan" class="block text-gray-700 font-bold mb-2">Catatan</label>
                        <textarea name="catatan" id="catatan" rows="3"
                                  class="w-full border-gray-300 rounded-md shadow-sm">{{ old('catatan') }}</textarea>
                        @error('catatan')
                            <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex justify-end">
                        <a href="{{ route('absensi.index') }}" class="mr-2 px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">Batal</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Simpan</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout> --}}
