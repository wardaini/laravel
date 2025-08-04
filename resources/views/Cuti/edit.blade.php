@extends('layouts.app')
@section('title', 'Edit Cuti')
@section('content')
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-200">Edit Pengajuan Cuti</h1>
    </div>
    @if ($errors->any())
        <div class="bg-red-900 bg-opacity-50 border border-red-700 text-red-300 px-4 py-3 rounded-lg relative mb-5">
            <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
        </div>
    @endif
    @if (session('error')) {{-- Tambahkan pesan error dari controller --}}
        <div class="bg-red-900 bg-opacity-50 border border-red-700 text-red-300 p-4 rounded-lg mb-6" role="alert">
            <p class="font-bold">Error!</p>
            <p>{{ session('error') }}</p>
        </div>
    @endif
    <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg">
        <form action="{{ route('cuti.update', $cuti->id_cuti) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="karyawan_id" class="block text-sm font-medium text-gray-400 mb-1">Nama Karyawan</label>
                @if (Auth::user()->role == 'admin')
                    <select name="karyawan_id" id="karyawan_id" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>
                        @foreach($karyawan as $item)
                            <option value="{{ $item->id_karyawan }}" {{ (old('karyawan_id', $cuti->karyawan_id) == $item->id_karyawan) ? 'selected' : '' }}>{{ $item->nama }} ({{ $item->nip }})</option>
                        @endforeach
                    </select>
                @else
                    {{-- Pegawai hanya melihat diri sendiri --}}
                    <input type="text" value="{{ $cuti->karyawan->nama ?? 'N/A' }}" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" disabled>
                    <input type="hidden" name="karyawan_id" value="{{ $cuti->karyawan_id }}">
                @endif
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-4">
                <div>
                    <label for="tanggal_mulai" class="block text-sm font-medium text-gray-400 mb-1">Tanggal Mulai</label>
                    <input type="date" name="tanggal_mulai" id="tanggal_mulai" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('tanggal_mulai', $cuti->tanggal_mulai) }}" required>
                </div>
                <div>
                    <label for="tanggal_selesai" class="block text-sm font-medium text-gray-400 mb-1">Tanggal Selesai</label>
                    <input type="date" name="tanggal_selesai" id="tanggal_selesai" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" value="{{ old('tanggal_selesai', $cuti->tanggal_selesai) }}" required>
                </div>
            </div>
            <div class="mb-4">
                <label for="alasan" class="block text-sm font-medium text-gray-400 mb-1">Alasan Cuti</label>
                <textarea name="alasan" id="alasan" rows="4" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>{{ old('alasan', $cuti->alasan) }}</textarea>
            </div>
            <div class="mb-6">
                <label for="status" class="block text-sm font-medium text-gray-400 mb-1">Status Pengajuan</label>
                @if (Auth::user()->role == 'admin')
                    <select name="status" id="status" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" required>
                        <option value="pending" {{ (old('status', $cuti->status) == 'pending') ? 'selected' : '' }}>Pending</option>
                        <option value="disetujui" {{ (old('status', $cuti->status) == 'disetujui') ? 'selected' : '' }}>Disetujui</option>
                        <option value="ditolak" {{ (old('status', $cuti->status) == 'ditolak') ? 'selected' : '' }}>Ditolak</option>
                    </select>
                @else
                    {{-- Pegawai hanya bisa melihat status, tidak bisa mengubah --}}
                    <input type="text" value="{{ ucwords($cuti->status) }}" class="w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-lg text-gray-200" disabled>
                    <input type="hidden" name="status" value="{{ $cuti->status }}">
                @endif
            </div>
            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('cuti.index') }}" class="bg-gray-600 hover:bg-gray-500 text-white font-bold py-2 px-4 rounded-lg">Batal</a>
                <button type="submit" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg"><i class="fas fa-sync-alt mr-2"></i>Perbarui</button>
            </div>
        </form>
    </div>
@endsection