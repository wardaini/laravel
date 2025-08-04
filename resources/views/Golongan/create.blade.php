@extends('layouts.app')
@section('title', 'Tambah Golongan')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-200">Tambah Golongan Baru</h1>
</div>
<div class="bg-gray-800 p-6 rounded-xl shadow-lg">
    <form action="{{ route('golongan.store') }}" method="POST">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Nama Golongan --}}
            <div>
                <label for="nama_golongan" class="block text-sm font-medium text-gray-400 mb-1">Nama Golongan</label>
                <input type="text" name="nama_golongan" id="nama_golongan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('nama_golongan') border-red-500 @enderror" value="{{ old('nama_golongan') }}" required>
                {{-- PERBAIKAN: Menampilkan pesan error --}}
                @error('nama_golongan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Gaji Pokok --}}
            <div>
                <label for="gaji_pokok" class="block text-sm font-medium text-gray-400 mb-1">Gaji Pokok (Rp)</label>
                <input type="number" name="gaji_pokok" id="gaji_pokok" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('gaji_pokok') border-red-500 @enderror" value="{{ old('gaji_pokok') }}" required>
                @error('gaji_pokok')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Tunjangan Keluarga --}}
            <div>
                <label for="tunjangan_keluarga" class="block text-sm font-medium text-gray-400 mb-1">Tunjangan Keluarga (Rp)</label>
                <input type="number" name="tunjangan_keluarga" id="tunjangan_keluarga" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('tunjangan_keluarga') border-red-500 @enderror" value="{{ old('tunjangan_keluarga', 0) }}" required>
                @error('tunjangan_keluarga')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Uang Makan Bulanan --}}
            <div>
                <label for="uang_makan_bulanan" class="block text-sm font-medium text-gray-400 mb-1">Uang Makan Bulanan (Rp)</label>
                <input type="number" name="uang_makan_bulanan" id="uang_makan_bulanan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('uang_makan_bulanan') border-red-500 @enderror" value="{{ old('uang_makan_bulanan', 0) }}" required>
                @error('uang_makan_bulanan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Uang Transport Bulanan --}}
            <div>
                <label for="uang_transport_bulanan" class="block text-sm font-medium text-gray-400 mb-1">Uang Transport Bulanan (Rp)</label>
                <input type="number" name="uang_transport_bulanan" id="uang_transport_bulanan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('uang_transport_bulanan') border-red-500 @enderror" value="{{ old('uang_transport_bulanan', 0) }}" required>
                @error('uang_transport_bulanan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- THR --}}
            <div>
                <label for="thr_nominal" class="block text-sm font-medium text-gray-400 mb-1">THR (Rp)</label>
                <input type="number" name="thr_nominal" id="thr_nominal" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('thr_nominal') border-red-500 @enderror" value="{{ old('thr_nominal') }}">
                @error('thr_nominal')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- BPJS Per Tanggungan --}}
            <div>
                <label for="bpjs_per_tanggungan" class="block text-sm font-medium text-gray-400 mb-1">BPJS Per Tanggungan (Rp)</label>
                <input type="number" name="bpjs_per_tanggungan" id="bpjs_per_tanggungan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('bpjs_per_tanggungan') border-red-500 @enderror" value="{{ old('bpjs_per_tanggungan', 0) }}" required>
                @error('bpjs_per_tanggungan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            {{-- Bonus Tahunan --}}
            <div>
                <label for="bonus_tahunan" class="block text-sm font-medium text-gray-400 mb-1">Bonus Tahunan (Rp)</label>
                <input type="number" name="bonus_tahunan" id="bonus_tahunan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500 @error('bonus_tahunan') border-red-500 @enderror" value="{{ old('bonus_tahunan') }}">
                @error('bonus_tahunan')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="flex items-center justify-end space-x-4 mt-6">
            <a href="{{ route('golongan.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg"><i class="fas fa-save mr-2"></i>Simpan</button>
        </div>
    </form>
</div>
@endsection
