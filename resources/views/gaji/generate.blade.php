@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-8 bg-gray-900 text-gray-100 min-h-screen rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-400">Generate Gaji Karyawan</h1>

    @if (session('error'))
        <div class="bg-red-700 text-white p-4 rounded-lg mb-6 shadow-md" role="alert">
            {{ session('error') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-700 text-white p-4 rounded-lg mb-6 shadow-md" role="alert">
            <h5 class="font-bold text-lg mb-2">Terjadi kesalahan:</h5>
            <ul class="list-disc list-inside mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('gaji.generate.store') }}" method="POST" class="space-y-6">
        @csrf

        {{-- Input Pilih Karyawan (Opsional, untuk generate per karyawan) --}}
        <div class="form-group">
            <label for="karyawan_id" class="block text-sm font-medium text-gray-300 mb-1">Pilih Karyawan (Opsional)</label>
            <select name="karyawan_id" id="karyawan_id"
                    class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                           @error('karyawan_id') border-red-500 @enderror">
                <option value="">-- Semua Karyawan --</option>
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}" {{ old('karyawan_id') == $karyawan->id_karyawan ? 'selected' : '' }}>
                        {{ $karyawan->nama }}
                    </option>
                @endforeach
            </select>
            @error('karyawan_id')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Pilih Bulan --}}
        <div class="form-group">
            <label for="bulan" class="block text-sm font-medium text-gray-300 mb-1">Bulan</label>
            <select name="bulan" id="bulan"
                    class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                           @error('bulan') border-red-500 @enderror">
                @for ($i = 1; $i <= 12; $i++)
                    <option value="{{ $i }}" {{ old('bulan', date('n')) == $i ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
            @error('bulan')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Input Pilih Tahun --}}
        <div class="form-group">
            <label for="tahun" class="block text-sm font-medium text-gray-300 mb-1">Tahun</label>
            <input type="number" name="tahun" id="tahun"
                   class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                          @error('tahun') border-red-500 @enderror"
                   value="{{ old('tahun', date('Y')) }}" min="2000" max="{{ date('Y') + 5 }}">
            @error('tahun')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-group flex justify-end space-x-4 mt-8">
            <a href="{{ route('gaji.index') }}" class="btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Batal</a>
            <button type="submit" class="btn bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Generate Gaji</button>
        </div>
    </form>
</div>
@endsection
