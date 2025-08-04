@extends('layouts.app')

@section('title', 'Data Absensi')

@section('content')
    {{-- Container utama dengan tema gelap --}}
    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <h2 class="text-3xl font-bold text-purple-400 mb-6 border-b-2 border-gray-700 pb-2">Data Absensi</h2>

        @if (session('success'))
            <div class="bg-green-900 bg-opacity-50 border border-green-700 text-green-300 p-4 rounded-lg mb-6" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="bg-red-900 bg-opacity-50 border border-red-700 text-red-300 p-4 rounded-lg mb-6" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if (Auth::user()->role === 'admin')
            {{-- Filter karyawan dengan tema gelap --}}
            <div class="bg-gray-900 p-4 rounded-lg shadow-md mb-6">
                <h3 class="text-xl font-semibold text-gray-200 mb-3">Filter Data Absensi</h3>
                <form method="GET" action="{{ route('absensi.index') }}" class="flex flex-col sm:flex-row gap-4 items-end">
                    <div class="flex-grow w-full sm:w-auto">
                        <label for="karyawan_id" class="block text-sm font-medium text-gray-400 mb-1">Pilih Karyawan:</label>
                        <select name="karyawan_id" id="karyawan_id" class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500">
                            <option value="">-- Semua Karyawan --</option>
                            @foreach ($karyawans as $karyawan)
                                <option value="{{ $karyawan->id_karyawan }}" {{ request('karyawan_id') == $karyawan->id_karyawan ? 'selected' : '' }}>
                                    {{ $karyawan->nama }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white px-6 py-2 rounded-lg shadow-md w-full sm:w-auto">
                        Filter
                    </button>
                </form>
            </div>

            {{-- Tabel Absensi dengan tema gelap --}}
            <div class="overflow-x-auto mb-6 bg-gray-900 rounded-lg shadow-md">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Tanggal</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Nama Karyawan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Waktu Masuk</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Waktu Keluar</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Keterangan</th>
                            <th class="px-4 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-800 divide-y divide-gray-700">
                        @forelse ($absensis as $absensi)
                            <tr class="hover:bg-gray-750">
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-300">{{ $absensi->tanggal_absensi->format('Y-m-d') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-300">{{ $absensi->karyawan->nama }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm">
                                    @php
                                        $statusClass = '';
                                        switch ($absensi->status_kehadiran) {
                                            case 'hadir': $statusClass = 'bg-green-200 text-green-800'; break;
                                            case 'terlambat': $statusClass = 'bg-yellow-200 text-yellow-800'; break;
                                            case 'izin': $statusClass = 'bg-blue-200 text-blue-800'; break;
                                            case 'sakit': $statusClass = 'bg-purple-200 text-purple-800'; break;
                                            case 'alpa': $statusClass = 'bg-red-200 text-red-800'; break;
                                            case 'libur': $statusClass = 'bg-gray-200 text-gray-800'; break;
                                            case 'cuti': $statusClass = 'bg-teal-200 text-teal-800'; break;
                                            default: $statusClass = 'bg-gray-200 text-gray-800'; break;
                                        }
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $statusClass }}">
                                        {{ ucfirst($absensi->status_kehadiran) }}
                                    </span>
                                </td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-300">{{ optional($absensi->waktu_masuk)->format('H:i') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-300">{{ optional($absensi->waktu_keluar)->format('H:i') }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-300">{{ $absensi->keterangan ?? '-' }}</td>
                                <td class="px-4 py-2 whitespace-nowrap text-sm font-medium">
                                    <form method="POST" action="{{ route('absensi.destroy', $absensi->id) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('Hapus data ini?')" class="text-red-400 hover:text-red-500">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-4 text-center text-gray-500">Belum ada data absensi yang tersedia.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mb-6">
                {{ $absensis->links() }}
            </div>

            {{-- Form Tambah Absensi Manual dengan tema gelap --}}
            <div class="bg-gray-900 p-6 rounded-lg shadow-xl">
                <h3 class="text-2xl font-bold text-gray-200 mb-4 border-b border-gray-700 pb-2">Tambah Absensi Manual</h3>
                <form method="POST" action="{{ route('absensi.store') }}" class="space-y-5">
                    @csrf
                    <div>
                        <label for="karyawan_id_manual" class="block text-sm font-medium text-gray-400 mb-1">Karyawan:</label>
                        <select name="karyawan_id" id="karyawan_id_manual" class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500">
                            @foreach ($karyawans as $karyawan)
                                <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="tanggal_absensi" class="block text-sm font-medium text-gray-400 mb-1">Tanggal Absensi:</label>
                        <input type="date" name="tanggal_absensi" id="tanggal_absensi" class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" required>
                    </div>
                    <div>
                        <label for="waktu_masuk" class="block text-sm font-medium text-gray-400 mb-1">Waktu Masuk:</label>
                        <input type="time" name="waktu_masuk" id="waktu_masuk" class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="waktu_keluar" class="block text-sm font-medium text-gray-400 mb-1">Waktu Keluar:</label>
                        <input type="time" name="waktu_keluar" id="waktu_keluar" class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label for="status_kehadiran" class="block text-sm font-medium text-gray-400 mb-1">Status Kehadiran:</label>
                        <select name="status_kehadiran" id="status_kehadiran" class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" required>
                            <option value="hadir">Hadir</option>
                            <option value="terlambat">Terlambat</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                            <option value="alpa">Alpa</option>
                            <option value="libur">Libur</option>
                            <option value="cuti">Cuti</option>
                        </select>
                    </div>
                    <div>
                        <label for="keterangan" class="block text-sm font-medium text-gray-400 mb-1">Keterangan:</label>
                        <input type="text" name="keterangan" id="keterangan" class="w-full px-3 py-2 bg-gray-800 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500">
                    </div>
                    <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg shadow-md w-full sm:w-auto">Simpan Manual</button>
                </form>
            </div>
        @endif
    </div>
@endsection
