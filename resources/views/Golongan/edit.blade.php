@extends('layouts.app')
@section('title', 'Edit Golongan')
@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-gray-200">Edit Golongan</h1>
</div>
<div class="bg-gray-800 p-6 rounded-xl shadow-lg">
    <form action="{{ route('golongan.update', $golongan->id_golongan) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="nama_golongan" class="block text-sm font-medium text-gray-400 mb-1">Nama Golongan</label>
                <input type="text" name="nama_golongan" id="nama_golongan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('nama_golongan', $golongan->nama_golongan) }}" required>
            </div>
            <div>
                <label for="gaji_pokok" class="block text-sm font-medium text-gray-400 mb-1">Gaji Pokok (Rp)</label>
                <input type="number" name="gaji_pokok" id="gaji_pokok" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('gaji_pokok', $golongan->gaji_pokok) }}" required>
            </div>
            <div>
                <label for="tunjangan_keluarga" class="block text-sm font-medium text-gray-400 mb-1">Tunjangan Keluarga (Rp)</label>
                <input type="number" name="tunjangan_keluarga" id="tunjangan_keluarga" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('tunjangan_keluarga', $golongan->tunjangan_keluarga) }}" required>
            </div>
            <div>
                <label for="uang_makan_bulanan" class="block text-sm font-medium text-gray-400 mb-1">Uang Makan Bulanan (Rp)</label>
                <input type="number" name="uang_makan_bulanan" id="uang_makan_bulanan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('uang_makan_bulanan', $golongan->uang_makan_bulanan) }}" required>
            </div>
            <div>
                <label for="uang_transport_bulanan" class="block text-sm font-medium text-gray-400 mb-1">Uang Transport Bulanan (Rp)</label>
                <input type="number" name="uang_transport_bulanan" id="uang_transport_bulanan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('uang_transport_bulanan', $golongan->uang_transport_bulanan) }}" required>
            </div>
            <div>
                <label for="thr_nominal" class="block text-sm font-medium text-gray-400 mb-1">THR (Rp)</label>
                <input type="number" name="thr_nominal" id="thr_nominal" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('thr_nominal', $golongan->thr_nominal) }}">
            </div>
            <div>
                <label for="bpjs_per_tanggungan" class="block text-sm font-medium text-gray-400 mb-1">BPJS Per Tanggungan (Rp)</label>
                <input type="number" name="bpjs_per_tanggungan" id="bpjs_per_tanggungan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('bpjs_per_tanggungan', $golongan->bpjs_per_tanggungan) }}" required>
            </div>
            <div>
                <label for="bonus_tahunan" class="block text-sm font-medium text-gray-400 mb-1">Bonus Tahunan (Rp)</label>
                <input type="number" name="bonus_tahunan" id="bonus_tahunan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200 focus:ring-indigo-500" value="{{ old('bonus_tahunan', $golongan->bonus_tahunan) }}">
            </div>
        </div>
        <div class="flex items-center justify-end space-x-4 mt-6">
            <a href="{{ route('golongan.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Batal</a>
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg"><i class="fas fa-sync-alt mr-2"></i>Perbarui</button>
        </div>
    </form>
</div>
@endsection