@extends('layouts.app') {{-- Ganti kalau pakai layout lain --}}

@section('content')
<div class="container mx-auto p-4 md:p-8 bg-gray-900 text-gray-100 min-h-screen rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-400">Tambah Data Lembur</h1>

    {{-- Tampilkan pesan error kalau ada --}}
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

    {{-- Form untuk Admin --}}
    @if (auth()->user()->role === 'admin')
        <form action="{{ route('lembur.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Input Nama Pegawai (hanya untuk Admin) --}}
            <div class="form-group">
                <label for="karyawan_id" class="block text-sm font-medium text-gray-300 mb-1">Nama Pegawai</label>
                <select name="karyawan_id" id="karyawan_id"
                        class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                               @error('karyawan_id') border-red-500 @enderror">
                    <option value="">Pilih Karyawan</option>
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

            {{-- Input Tanggal Lembur --}}
            <div class="form-group">
                <label for="tanggal_lembur" class="block text-sm font-medium text-gray-300 mb-1">Tanggal Lembur</label>
                <input type="date" name="tanggal_lembur" id="tanggal_lembur"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('tanggal_lembur') border-red-500 @enderror"
                       value="{{ old('tanggal_lembur', date('Y-m-d')) }}"> {{-- Default ke hari ini --}}
                @error('tanggal_lembur')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Jam Mulai --}}
            <div class="form-group">
                <label for="jam_mulai" class="block text-sm font-medium text-gray-300 mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('jam_mulai') border-red-500 @enderror"
                       value="{{ old('jam_mulai') }}">
                @error('jam_mulai')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Jam Selesai --}}
            <div class="form-group">
                <label for="jam_selesai" class="block text-sm font-medium text-gray-300 mb-1">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('jam_selesai') border-red-500 @enderror"
                       value="{{ old('jam_selesai') }}">
                @error('jam_selesai')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Keterangan --}}
            <div class="form-group">
                <label for="keterangan" class="block text-sm font-medium text-gray-300 mb-1">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                                 @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-group flex justify-end space-x-4 mt-8">
                <a href="{{ route('lembur.index') }}" class="btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Batal</a>
                <button type="submit" class="btn bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Ajukan Lembur</button>
            </div>
        </form>

    {{-- Form untuk Karyawan Biasa --}}
    @else
        <form action="{{ route('lembur.store') }}" method="POST" class="space-y-6">
            @csrf

            {{-- Nama Pegawai (read-only untuk Karyawan) --}}
            <div class="form-group">
                <label for="nama_karyawan" class="block text-sm font-medium text-gray-300 mb-1">Nama Pegawai</label>
                <input type="text" id="nama_karyawan"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 cursor-not-allowed"
                       value="{{ $karyawan->nama }}" readonly>
                <input type="hidden" name="karyawan_id" value="{{ $karyawan->id_karyawan }}">
            </div>

            {{-- Input Tanggal Lembur --}}
            <div class="form-group">
                <label for="tanggal_lembur" class="block text-sm font-medium text-gray-300 mb-1">Tanggal Lembur</label>
                <input type="date" name="tanggal_lembur" id="tanggal_lembur"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('tanggal_lembur') border-red-500 @enderror"
                       value="{{ old('tanggal_lembur', date('Y-m-d')) }}"> {{-- Default ke hari ini --}}
                @error('tanggal_lembur')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Jam Mulai --}}
            <div class="form-group">
                <label for="jam_mulai" class="block text-sm font-medium text-gray-300 mb-1">Jam Mulai</label>
                <input type="time" name="jam_mulai" id="jam_mulai"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('jam_mulai') border-red-500 @enderror"
                       value="{{ old('jam_mulai') }}">
                @error('jam_mulai')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Jam Selesai --}}
            <div class="form-group">
                <label for="jam_selesai" class="block text-sm font-medium text-gray-300 mb-1">Jam Selesai</label>
                <input type="time" name="jam_selesai" id="jam_selesai"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('jam_selesai') border-red-500 @enderror"
                       value="{{ old('jam_selesai') }}">
                @error('jam_selesai')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Input Keterangan --}}
            <div class="form-group">
                <label for="keterangan" class="block text-sm font-medium text-gray-300 mb-1">Keterangan</label>
                <textarea name="keterangan" id="keterangan" rows="3"
                          class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                                 @error('keterangan') border-red-500 @enderror">{{ old('keterangan') }}</textarea>
                @error('keterangan')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- Tombol Aksi --}}
            <div class="form-group flex justify-end space-x-4 mt-8">
                <a href="{{ route('lembur.index') }}" class="btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Batal</a>
                <button type="submit" class="btn bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Ajukan Lembur</button>
            </div>
        </form>
    @endif
</div>
@endsection
