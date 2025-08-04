@extends('layouts.app')

@section('title', 'Tambah Data Lembur')

@section('content')
<div class="mb-6">
    <h1 class="text-2xl font-bold text-blue-200">Tambah Data Lembur</h1>
</div>

<div class="bg-white p-6 rounded shadow">
    <form action="{{ route('lembur.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block mb-1">Pilih Pegawai</label>
            <select name="karyawan_id" required class="w-full border rounded px-3 py-2">
                @foreach ($karyawans as $karyawan)
                    <option value="{{ $karyawan->id_karyawan }}">{{ $karyawan->nama }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block mb-1">Jam Mulai</label>
            <input type="time" name="jam_mulai" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">Jam Selesai</label>
            <input type="time" name="jam_selesai" required class="w-full border rounded px-3 py-2">
        </div>

        <div>
            <label class="block mb-1">Keterangan</label>
            <textarea name="keterangan" class="w-full border rounded px-3 py-2"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Simpan
            </button>
        </div>
    </form>
</div>
@endsection
