@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4 md:p-8 bg-gray-900 text-gray-100 min-h-screen rounded-lg shadow-lg">
    <h1 class="text-3xl font-bold mb-6 text-center text-purple-400">Edit Data Gaji</h1>

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

    <form action="{{ route('gaji.update', $gaji->id_gaji) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Karyawan ID (Read-only) --}}
        <div class="form-group">
            <label for="karyawan_id" class="block text-sm font-medium text-gray-300 mb-1">Karyawan</label>
            <input type="text" id="karyawan_nama" value="{{ $gaji->karyawan->nama }}"
                   class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 cursor-not-allowed" readonly>
            <input type="hidden" name="karyawan_id" value="{{ $gaji->karyawan_id }}">
        </div>

        {{-- Bulan dan Tahun (Read-only) --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="bulan" class="block text-sm font-medium text-gray-300 mb-1">Bulan</label>
                <input type="text" id="bulan_display" value="{{ \Carbon\Carbon::create()->month($gaji->bulan)->translatedFormat('F') }}"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 cursor-not-allowed" readonly>
                <input type="hidden" name="bulan" value="{{ $gaji->bulan }}">
            </div>
            <div class="form-group">
                <label for="tahun" class="block text-sm font-medium text-gray-300 mb-1">Tahun</label>
                <input type="text" id="tahun_display" value="{{ $gaji->tahun }}"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 cursor-not-allowed" readonly>
                <input type="hidden" name="tahun" value="{{ $gaji->tahun }}">
            </div>
        </div>

        {{-- Komponen Gaji --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-purple-300">Komponen Gaji</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="gaji_pokok" class="block text-sm font-medium text-gray-300 mb-1">Gaji Pokok</label>
                <input type="number" name="gaji_pokok" id="gaji_pokok" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('gaji_pokok') border-red-500 @enderror"
                       value="{{ old('gaji_pokok', $gaji->gaji_pokok) }}">
                @error('gaji_pokok')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="tunjangan_keluarga" class="block text-sm font-medium text-gray-300 mb-1">Tunjangan Keluarga</label>
                <input type="number" name="tunjangan_keluarga" id="tunjangan_keluarga" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('tunjangan_keluarga') border-red-500 @enderror"
                       value="{{ old('tunjangan_keluarga', $gaji->tunjangan_keluarga) }}">
                @error('tunjangan_keluarga')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="uang_makan" class="block text-sm font-medium text-gray-300 mb-1">Uang Makan (Bulanan)</label>
                <input type="number" name="uang_makan" id="uang_makan" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('uang_makan') border-red-500 @enderror"
                       value="{{ old('uang_makan', $gaji->uang_makan) }}">
                @error('uang_makan')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="uang_transport" class="block text-sm font-medium text-gray-300 mb-1">Uang Transport (Bulanan)</label>
                <input type="number" name="uang_transport" id="uang_transport" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('uang_transport') border-red-500 @enderror"
                       value="{{ old('uang_transport', $gaji->uang_transport) }}">
                @error('uang_transport')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="tunjangan_lembur" class="block text-sm font-medium text-gray-300 mb-1">Tunjangan Lembur</label>
                <input type="number" name="tunjangan_lembur" id="tunjangan_lembur" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('tunjangan_lembur') border-red-500 @enderror"
                       value="{{ old('tunjangan_lembur', $gaji->tunjangan_lembur) }}">
                @error('tunjangan_lembur')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="thr" class="block text-sm font-medium text-gray-300 mb-1">THR</label>
                <input type="number" name="thr" id="thr" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('thr') border-red-500 @enderror"
                       value="{{ old('thr', $gaji->thr) }}">
                @error('thr')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="bonus" class="block text-sm font-medium text-gray-300 mb-1">Bonus</label>
                <input type="number" name="bonus" id="bonus" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('bonus') border-red-500 @enderror"
                       value="{{ old('bonus', $gaji->bonus) }}">
                @error('bonus')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Komponen Potongan --}}
        <h2 class="text-xl font-semibold mt-8 mb-4 text-red-300">Komponen Potongan</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="form-group">
                <label for="potongan_absensi" class="block text-sm font-medium text-gray-300 mb-1">Potongan Absensi</label>
                <input type="number" name="potongan_absensi" id="potongan_absensi" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('potongan_absensi') border-red-500 @enderror"
                       value="{{ old('potongan_absensi', $gaji->potongan_absensi) }}">
                @error('potongan_absensi')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="potongan_uang_makan_cuti" class="block text-sm font-medium text-gray-300 mb-1">Potongan Uang Makan Cuti</label>
                <input type="number" name="potongan_uang_makan_cuti" id="potongan_uang_makan_cuti" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('potongan_uang_makan_cuti') border-red-500 @enderror"
                       value="{{ old('potongan_uang_makan_cuti', $gaji->potongan_uang_makan_cuti) }}">
                @error('potongan_uang_makan_cuti')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="potongan_transport_cuti" class="block text-sm font-medium text-gray-300 mb-1">Potongan Transport Cuti</label>
                <input type="number" name="potongan_transport_cuti" id="potongan_transport_cuti" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('potongan_transport_cuti') border-red-500 @enderror"
                       value="{{ old('potongan_transport_cuti', $gaji->potongan_transport_cuti) }}">
                @error('potongan_transport_cuti')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="bpjs_kesehatan" class="block text-sm font-medium text-gray-300 mb-1">BPJS Kesehatan</label>
                <input type="number" name="bpjs_kesehatan" id="bpjs_kesehatan" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('bpjs_kesehatan') border-red-500 @enderror"
                       value="{{ old('bpjs_kesehatan', $gaji->bpjs_kesehatan) }}">
                @error('bpjs_kesehatan')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="potongan_pajak" class="block text-sm font-medium text-gray-300 mb-1">Potongan Pajak</label>
                <input type="number" name="potongan_pajak" id="potongan_pajak" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('potongan_pajak') border-red-500 @enderror"
                       value="{{ old('potongan_pajak', $gaji->potongan_pajak) }}">
                @error('potongan_pajak')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="form-group">
                <label for="total_potongan_lain" class="block text-sm font-medium text-gray-300 mb-1">Total Potongan Lain</label>
                <input type="number" name="total_potongan_lain" id="total_potongan_lain" step="0.01"
                       class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                              @error('total_potongan_lain') border-red-500 @enderror"
                       value="{{ old('total_potongan_lain', $gaji->total_potongan_lain) }}">
                @error('total_potongan_lain')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        {{-- Status Pembayaran dan Keterangan --}}
        <div class="form-group">
            <label for="status_pembayaran" class="block text-sm font-medium text-gray-300 mb-1">Status Pembayaran</label>
            <select name="status_pembayaran" id="status_pembayaran"
                    class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                           @error('status_pembayaran') border-red-500 @enderror">
                <option value="pending" {{ old('status_pembayaran', $gaji->status_pembayaran) == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="dibayar" {{ old('status_pembayaran', $gaji->status_pembayaran) == 'dibayar' ? 'selected' : '' }}>Dibayar</option>
            </select>
            @error('status_pembayaran')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="keterangan" class="block text-sm font-medium text-gray-300 mb-1">Keterangan</label>
            <textarea name="keterangan" id="keterangan" rows="3"
                      class="form-control w-full p-2 border border-gray-600 rounded-md bg-gray-800 text-gray-100 focus:ring-purple-500 focus:border-purple-500
                             @error('keterangan') border-red-500 @enderror">{{ old('keterangan', $gaji->keterangan) }}</textarea>
            @error('keterangan')
                <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Tombol Aksi --}}
        <div class="form-group flex justify-end space-x-4 mt-8">
            <a href="{{ route('gaji.index') }}" class="btn bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Batal</a>
            <button type="submit" class="btn bg-purple-600 hover:bg-purple-700 text-white font-bold py-2 px-6 rounded-lg shadow-md transition duration-300 ease-in-out transform hover:scale-105">Update Gaji</button>
        </div>
    </form>
</div>
@endsection
