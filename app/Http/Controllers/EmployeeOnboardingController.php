<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Karyawan;

class EmployeeOnboardingController extends Controller
{
    // Menampilkan form untuk melengkapi profil
    public function create()
    {
        $karyawan = Auth::user()->karyawan;
        return view('profil.lengkapi', compact('karyawan'));
    }

    // Menyimpan data yang diisi oleh pegawai
    public function store(Request $request)
    {
        $karyawan = Auth::user()->karyawan;

        $validatedData = $request->validate([
            'nip' => 'nullable|string|max:50|unique:karyawan,nip,'.$karyawan->id_karyawan.',id_karyawan',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_pernikahan' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
        ]);
        
        $karyawan->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Terima kasih! Profil Anda berhasil diperbarui.');
    }
}
