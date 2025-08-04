@extends('layouts.app')

@section('title', 'Edit Kehadiran')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Edit Data Kehadiran</h1>
    </div>

    <div class="bg-gray-800 p-6 rounded-xl shadow-lg">
        <form action="{{ route('kehadiran.update', $kehadiran->id_kehadiran) }}" method="POST">
            @csrf
            @method('PUT')
             <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="karyawan_id" class="block text-sm font-medium text-gray-400 mb-1">Nama Karyawan</label>
                    <select name="karyawan_id" id="karyawan_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>
                        @foreach($karyawan as $item)
                            <option value="{{ $item->id_karyawan }}" {{ $kehadiran->karyawan_id == $item->id_karyawan ? 'selected' : '' }}>{{ $item->nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label for="tanggal" class="block text-sm font-medium text-gray-400 mb-1">Tanggal</label>
                    <input type="date" name="tanggal" id="tanggal" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ $kehadiran->tanggal }}" required>
                </div>
            </div>
            <div class="mt-4">
                <label for="status" class="block text-sm font-medium text-gray-400 mb-1">Status Kehadiran</label>
                <select name="status" id="status" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>
                    <option value="hadir" {{ $kehadiran->status == 'hadir' ? 'selected' : '' }}>Hadir</option>
                    <option value="sakit" {{ $kehadiran->status == 'sakit' ? 'selected' : '' }}>Sakit</option>
                    <option value="izin" {{ $kehadiran->status == 'izin' ? 'selected' : '' }}>Izin</option>
                    <option value="alfa" {{ $kehadiran->status == 'alfa' ? 'selected' : '' }}>Alfa</option>
                </select>
            </div>
             <div class="mt-4">
                <label for="keterangan" class="block text-sm font-medium text-gray-400 mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" id="keterangan" rows="3" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">{{ $kehadiran->keterangan }}</textarea>
            </div>
            <div class="mt-6 flex items-center justify-end space-x-4">
                <a href="{{ route('kehadiran.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg"><i class="fas fa-sync-alt mr-2"></i>Perbarui</button>
            </div>
        </form>
    </div>
@endsection
