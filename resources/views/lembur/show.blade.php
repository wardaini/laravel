@extends('layouts.app')

@section('title', 'Detail Lembur')

@section('content')
    <h2 class="text-2xl font-bold text-white mb-6">Detail Lembur</h2>

    <div class="bg-white p-6 rounded shadow">
        <p><strong>Karyawan:</strong> {{ $lembur->karyawan->nama ?? '-' }}</p>
        <p><strong>Tanggal:</strong> {{ $lembur->tanggal_lembur?->format('d F Y') }}</p>
        <p><strong>Durasi:</strong> {{ $lembur->durasi_jam }} jam</p>
        <p><strong>Status:</strong> {{ ucwords($lembur->status) }}</p>
        <p><strong>Keterangan:</strong> {{ $lembur->keterangan ?? '-' }}</p>

        <div class="mt-4">
            <a href="{{ route('lembur.edit', $lembur->id) }}" class="bg-yellow-600 text-white px-4 py-2 rounded">Edit</a>
            <a href="{{ route('lembur.index') }}" class="bg-gray-600 text-white px-4 py-2 rounded ml-2">Kembali</a>
        </div>
    </div>
@endsection
