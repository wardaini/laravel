@extends('layouts.app')
@section('title', 'Tambah Data Gaji')
@section('content')
<div class="mb-4">
    <a href="{{ route('gaji.index') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>
<h1 class="text-2xl font-bold text-gray-200 mb-6">Tambah Data Gaji</h1>
@if ($errors->any())
    <div class="bg-red-900 bg-opacity-50 text-red-300 p-4 rounded-lg mb-6">
        <ul class="list-disc pl-5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<div class="bg-gray-800 p-6 rounded-xl shadow-lg">
    <form action="{{ route('gaji.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <div>
                <label for="karyawan_id" class="block text-sm font-medium text-gray-300 mb-1">Nama Karyawan</label>
                <select id="karyawan_id" name="karyawan_id" class="w-full bg-gray-700 text-white rounded-md p-2">
                    <option value="">-- Pilih Karyawan --</option>
                    @foreach($karyawan as $item)
                        <option value="{{ $item->id_karyawan }}" {{ old('karyawan_id') == $item->id_karyawan ? 'selected' : '' }}>
                            {{ $item->nama }} ({{ $item->nip }})
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label for="bulan" class="block text-sm font-medium text-gray-300 mb-1">Bulan</label>
                    <input type="number" id="bulan" name="bulan" value="{{ old('bulan', date('m')) }}" class="w-full bg-gray-700 text-white rounded-md p-2" min="1" max="12">
                </div>
                <div>
                    <label for="tahun" class="block text-sm font-medium text-gray-300 mb-1">Tahun</label>
                    <input type="number" id="tahun" name="tahun" value="{{ old('tahun', date('Y')) }}" class="w-full bg-gray-700 text-white rounded-md p-2">
                </div>
            </div>
            {{-- Potongan Lain (jika ini satu-satunya input manual potongan yang tersisa) --}}
            <div>
                <label for="total_potongan_lain" class="block text-sm font-medium text-gray-300 mb-1">Potongan Lain-lain (Rp)</label>
                <input type="number" id="total_potongan_lain" name="total_potongan_lain" value="{{ old('total_potongan_lain', 0) }}" class="w-full bg-gray-700 text-white rounded-md p-2">
            </div>

            <div>
                <label for="status_pembayaran" class="block text-sm font-medium text-gray-300 mb-1">Status Pembayaran</label>
                <select id="status_pembayaran" name="status_pembayaran" class="w-full bg-gray-700 text-white rounded-md p-2">
                    <option value="pending" {{ old('status_pembayaran') == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="dibayar" {{ old('status_pembayaran') == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
                </select>
            </div>
            <div>
                <label for="keterangan" class="block text-sm font-medium text-gray-300 mb-1">Keterangan (Opsional)</label>
                <textarea id="keterangan" name="keterangan" rows="3" class="w-full bg-gray-700 text-white rounded-md p-2">{{ old('keterangan') }}</textarea>
            </div>
        </div>
        <div class="mt-8 text-right">
            <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3 px-6 rounded-lg">
                Simpan Data Gaji
            </button>
        </div>
    </form>
</div>
@endsection