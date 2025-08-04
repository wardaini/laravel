@extends('layouts.app')

@section('title', 'Edit Absensi')

@section('content')
    <h2 class="text-xl font-bold mb-4 text-white">Edit Data Absensi</h2>

    <form action="{{ route('absensi.update', $absensi) }}" method="POST" class="bg-gray-800 p-6 rounded-lg shadow">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="karyawan_id" class="block text-white mb-1">Karyawan</label>
            <select name="karyawan_id" id="karyawan_id" class="w-full p-2 rounded bg-gray-700 text-white">
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ $karyawan->id_karyawan == $absensi->karyawan_id ? 'selected' : '' }}>
                        {{ $karyawan->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="tanggal_absensi" class="block text-white mb-1">Tanggal Absensi</label>
            <input type="date" name="tanggal_absensi" id="tanggal_absensi" value="{{ $absensi->tanggal_absensi->format('Y-m-d') }}" class="w-full p-2 rounded bg-gray-700 text-white">
        </div>

        <div class="mb-4">
            <label for="waktu_masuk" class="block text-white mb-1">Waktu Masuk</label>
            <input type="time" name="waktu_masuk" id="waktu_masuk" value="{{ $absensi->waktu_masuk ? $absensi->waktu_masuk->format('H:i') : '' }}" class="w-full p-2 rounded bg-gray-700 text-white">
        </div>

        <div class="mb-4">
            <label for="waktu_keluar" class="block text-white mb-1">Waktu Keluar</label>
            <input type="time" name="waktu_keluar" id="waktu_keluar" value="{{ $absensi->waktu_keluar ? $absensi->waktu_keluar->format('H:i') : '' }}" class="w-full p-2 rounded bg-gray-700 text-white">
        </div>

        <div class="mb-4">
            <label for="status_kehadiran" class="block text-white mb-1">Status Kehadiran</label>
            <select name="status_kehadiran" id="status_kehadiran" class="w-full p-2 rounded bg-gray-700 text-white">
                @foreach(['hadir','terlambat','izin','sakit','cuti','alpa','libur'] as $status)
                    <option value="{{ $status }}" {{ $status == $absensi->status_kehadiran ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="keterangan" class="block text-white mb-1">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3" class="w-full p-2 rounded bg-gray-700 text-white">{{ $absensi->keterangan }}</textarea>
        </div>

        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">Perbarui Data</button>
    </form>
@endsection
