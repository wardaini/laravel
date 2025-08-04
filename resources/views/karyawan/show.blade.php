@extends('layouts.app')

@section('title', 'Detail Karyawan: ' . $karyawan->nama)

@section('content')
    <div class="mb-6">
        <a href="{{ route('karyawan.index') }}" class="inline-flex items-center text-indigo-400 hover:text-indigo-300 font-medium">
            <i class="fas fa-arrow-left mr-2"></i>
            Kembali ke Daftar Karyawan
        </a>
    </div>

    {{-- Kartu Profil Utama --}}
    <div class="bg-gray-800 rounded-xl shadow-lg p-6 md:p-8 mb-8">
        <div class="flex flex-col md:flex-row items-center md:items-start gap-6">
            <div class="flex-shrink-0">
                @if($karyawan->foto_profil)
                    {{-- PERBAIKAN UTAMA: Menggunakan rute 'karyawan.foto' untuk menampilkan gambar --}}
                    <img class="h-32 w-32 rounded-full object-cover shadow-md border-4 border-gray-700" src="{{ route('karyawan.foto', ['filename' => basename($karyawan->foto_profil)]) }}" alt="Foto profil">
                @else
                    {{-- Menggunakan placeholder SVG yang konsisten --}}
                    <div class="h-32 w-32 rounded-full bg-gray-700 flex items-center justify-center border-4 border-gray-600 shadow-md">
                        <svg class="h-20 w-20 text-gray-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                @endif
            </div>
            <div class="text-center md:text-left flex-1">
                <h1 class="text-3xl font-bold text-gray-100">{{ $karyawan->nama }}</h1>
                <p class="text-lg text-indigo-400 font-semibold">{{ $karyawan->jabatan->nama_jabatan }}</p>
                <p class="text-md text-gray-400 mt-1">NIP: {{ $karyawan->nip ?? '-' }}</p>
                <div class="flex items-center justify-center md:justify-start gap-4 mt-3 text-sm text-gray-400">
                    <span class="flex items-center"><i class="fas fa-envelope mr-2"></i>{{ $karyawan->email }}</span>
                    <span class="flex items-center"><i class="fas fa-phone mr-2"></i>{{ $karyawan->no_telepon }}</span>
                </div>
            </div>
            <div class="flex-shrink-0">
                <a href="{{ route('karyawan.edit', $karyawan->id_karyawan) }}" class="inline-block bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-lg shadow-md hover:shadow-lg transition-all">
                    <i class="fas fa-edit mr-2"></i>Edit Profil
                </a>
            </div>
        </div>
    </div>

    {{-- Grid diubah menjadi 2 kolom dengan kartu yang digabung --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        {{-- Kolom Kiri: Info Karyawan --}}
        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-700">
                   <h3 class="text-xl font-semibold text-gray-200">Info Karyawan</h3>
            </div>
            {{-- Detail Personal --}}
            <div class="p-6 border-b border-gray-700">
                <h4 class="font-semibold text-gray-300 mb-4">Detail Personal</h4>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Tanggal Lahir:</span>
                        <span class="text-gray-300">{{ \Carbon\Carbon::parse($karyawan->tanggal_lahir)->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Jenis Kelamin:</span>
                        <span class="text-gray-300">{{ $karyawan->jenis_kelamin ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Agama:</span>
                        <span class="text-gray-300">{{ $karyawan->agama ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Status Pernikahan:</span>
                        <span class="text-gray-300">{{ $karyawan->status_pernikahan ?? '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Alamat:</span>
                        <span class="text-gray-300 text-right">{{ $karyawan->alamat }}</span>
                    </div>
                </div>
            </div>
            {{-- Detail Pekerjaan --}}
            <div class="p-6">
                <h4 class="font-semibold text-gray-300 mb-4">Detail Pekerjaan</h4>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Tanggal Masuk:</span>
                        <span class="text-gray-300">{{ \Carbon\Carbon::parse($karyawan->tanggal_masuk)->format('d F Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Golongan:</span>
                        <span class="text-gray-300 font-semibold">{{ $karyawan->golongan->nama_golongan }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="font-medium text-gray-400">Tunjangan:</span>
                        <span class="text-gray-300">Rp {{ number_format($karyawan->golongan->tunjangan ?? 0, 0, ',', '.') }}</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Riwayat Aktivitas --}}
        <div class="bg-gray-800 rounded-xl shadow-lg overflow-hidden">
            <div class="p-6 border-b border-gray-700">
                <h3 class="text-xl font-semibold text-gray-200">Riwayat Aktivitas</h3>
            </div>
            {{-- Riwayat Cuti --}}
            <div class="p-6 border-b border-gray-700">
                <h4 class="font-semibold text-gray-300 mb-2">Riwayat Cuti</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <tbody>
                            @forelse ($karyawan->cuti as $cuti)
                                <tr class="border-b border-gray-700 last:border-b-0">
                                    <td class="py-2 text-gray-300">{{ \Carbon\Carbon::parse($cuti->tanggal_mulai)->format('d/m/y') }} - {{ \Carbon\Carbon::parse($cuti->tanggal_selesai)->format('d/m/y') }}</td>
                                    <td class="py-2 text-gray-300 text-center">{{ Str::limit($cuti->alasan, 20) }}</td>
                                    <td class="py-2 text-right">
                                         @if($cuti->status == 'disetujui')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-900 text-green-200">Disetujui</span>
                                        @elseif($cuti->status == 'ditolak')
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-red-900 text-red-200">Ditolak</span>
                                        @else
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full bg-yellow-900 text-yellow-200">Pending</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4 text-gray-500">Belum ada riwayat cuti.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{-- Riwayat Gaji --}}
            <div class="p-6">
                <h4 class="font-semibold text-gray-300 mb-2">Riwayat Gaji</h4>
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                         @php $namaBulan = [1=>'Jan',2=>'Feb',3=>'Mar',4=>'Apr',5=>'Mei',6=>'Jun',7=>'Jul',8=>'Ags',9=>'Sep',10=>'Okt',11=>'Nov',12=>'Des']; @endphp
                        <tbody>
                             @forelse ($karyawan->gaji as $gaji)
                                <tr class="border-b border-gray-700 last:border-b-0">
                                    <td class="py-2 text-gray-300">{{ $namaBulan[$gaji->bulan] }} {{ $gaji->tahun }}</td>
                                    <td class="py-2 text-gray-300 text-center">Rp {{ number_format($gaji->total_gaji_netto, 0, ',', '.') }}</td>
                                    <td class="py-2 text-right text-gray-400">{{ Str::limit($gaji->keterangan, 25) ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="3" class="text-center py-4 text-gray-500">Belum ada riwayat gaji.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
