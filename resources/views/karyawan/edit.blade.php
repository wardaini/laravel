@extends('layouts.app')

@section('title', 'Edit Karyawan')

@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Edit Data Karyawan</h1>
    </div>

    @if ($errors->any())
        <div class="bg-red-900 bg-opacity-50 border border-red-700 text-red-300 px-4 py-3 rounded-lg relative mb-5">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif

    <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg">
        <form action="{{ route('karyawan.update', $karyawan->id_karyawan) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <div class="mb-4">
                        <label for="nip" class="block text-sm font-medium text-gray-400 mb-1">ID</label>
                        <input type="text" name="nip" id="nip" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('nip', $karyawan->nip) }}">
                    </div>
                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-400 mb-1">Nama</label>
                        <input type="text" name="nama" id="nama" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('nama', $karyawan->nama) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="email" class="block text-sm font-medium text-gray-400 mb-1">Email</label>
                        <input type="email" name="email" id="email" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('email', $karyawan->email) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="no_telepon" class="block text-sm font-medium text-gray-400 mb-1">No. Telepon</label>
                        <input type="text" name="no_telepon" id="no_telepon" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('no_telepon', $karyawan->no_telepon) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-400 mb-1">Alamat</label>
                        <textarea name="alamat" id="alamat" rows="3" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>{{ old('alamat', $karyawan->alamat) }}</textarea>
                    </div>
                </div>
                <div>
                    <div class="mb-4">
                        <label for="tanggal_lahir" class="block text-sm font-medium text-gray-400 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('tanggal_lahir', $karyawan->tanggal_lahir) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="jenis_kelamin" class="block text-sm font-medium text-gray-400 mb-1">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                            <option value="Laki-laki" {{ $karyawan->jenis_kelamin == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ $karyawan->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="agama" class="block text-sm font-medium text-gray-400 mb-1">Agama</label>
                        <select name="agama" id="agama" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                            <option value="Islam" {{ $karyawan->agama == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ $karyawan->agama == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ $karyawan->agama == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ $karyawan->agama == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ $karyawan->agama == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                            <option value="Konghucu" {{ $karyawan->agama == 'Konghucu' ? 'selected' : '' }}>Konghucu</option>
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="status_pernikahan" class="block text-sm font-medium text-gray-400 mb-1">Status Pernikahan</label>
                        <select name="status_pernikahan" id="status_pernikahan" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                            <option value="Belum Menikah" {{ $karyawan->status_pernikahan == 'Belum Menikah' ? 'selected' : '' }}>Belum Menikah</option>
                            <option value="Menikah" {{ $karyawan->status_pernikahan == 'Menikah' ? 'selected' : '' }}>Menikah</option>
                            <option value="Cerai Hidup" {{ $karyawan->status_pernikahan == 'Cerai Hidup' ? 'selected' : '' }}>Cerai Hidup</option>
                            <option value="Cerai Mati" {{ $karyawan->status_pernikahan == 'Cerai Mati' ? 'selected' : '' }}>Cerai Mati</option>
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-400 mb-1">Tanggal Masuk</label>
                        <input type="date" name="tanggal_masuk" id="tanggal_masuk" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('tanggal_masuk', $karyawan->tanggal_masuk) }}" required>
                    </div>
                    <div class="mb-4">
                        <label for="jabatan_id" class="block text-sm font-medium text-gray-400 mb-1">Jabatan</label>
                        <select name="jabatan_id" id="jabatan_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>
                            @foreach($jabatan as $item)
                                <option value="{{ $item->id_jabatan }}" {{ $karyawan->jabatan_id == $item->id_jabatan ? 'selected' : '' }}>{{ $item->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="golongan_id" class="block text-sm font-medium text-gray-400 mb-1">Golongan</label>
                        <select name="golongan_id" id="golongan_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>
                            @foreach($golongan as $item)
                                <option value="{{ $item->id_golongan }}" {{ $karyawan->golongan_id == $item->id_golongan ? 'selected' : '' }}>{{ $item->nama_golongan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-4">
                        <label for="foto_profil" class="block text-sm font-medium text-gray-400 mb-1">Ganti Foto</label>
                        <input type="file" name="foto_profil" id="foto_profil" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200">
                        @if($karyawan->foto_profil)
                            <img src="{{ Storage::url($karyawan->foto_profil) }}" alt="Foto" class="mt-3 h-24 w-24 rounded-full object-cover">
                        @endif
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end space-x-4 mt-6 border-t border-gray-700 pt-6">
                <a href="{{ route('karyawan.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg"><i class="fas fa-sync-alt mr-2"></i>Perbarui</button>
            </div>
        </form>
    </div>
@endsection