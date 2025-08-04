<?php

namespace App\Http\Controllers;

use App\Models\Karyawan;
use App\Models\Jabatan;
use App\Models\Golongan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response; // Tambahkan ini
use Illuminate\Validation\Rule;

class KaryawanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Karyawan::query()->with(['jabatan', 'golongan']);

        if ($request->has('search') && $request->input('search') != '') {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                  ->orWhere('nip', 'like', "%{$search}%");
            });
        }

        $karyawans = $query->latest()->paginate(10); 

        return view('karyawan.index', compact('karyawans'));
    }

    /**
     * FUNGSI BARU: Melayani file gambar profil secara langsung.
     * Ini adalah metode yang lebih andal daripada menggunakan storage link.
     */
    public function showProfileImage($filename)
    {
        $path = "foto_profil/{$filename}";

        if (!Storage::disk('public')->exists($path)) {
            abort(404, 'File gambar tidak ditemukan.');
        }

        $file = Storage::disk('public')->get($path);
        $type = Storage::disk('public')->mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $jabatan = Jabatan::all();
        $golongan = Golongan::all();
        return view('karyawan.create', compact('jabatan', 'golongan'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nip' => 'nullable|string|max:50|unique:karyawan,nip',
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_pernikahan' => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => 'required|email|unique:karyawan,email',
            'tanggal_masuk' => 'required|date',
            'golongan_id' => 'required|exists:golongan,id_golongan',
            'jabatan_id' => 'required|exists:jabatan,id_jabatan',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $validatedData['foto_profil'] = $path;
        }

        Karyawan::create($validatedData);
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Karyawan $karyawan)
    {
        $karyawan->load(['jabatan', 'golongan', 'cuti', 'absensi', 'gaji', 'lembur']);
        return view('karyawan.show', compact('karyawan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Karyawan $karyawan)
    {
        $jabatan = Jabatan::all();
        $golongan = Golongan::all();
        return view('karyawan.edit', compact('karyawan', 'jabatan', 'golongan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Karyawan $karyawan)
    {
        $validatedData = $request->validate([
            'nip' => ['nullable', 'string', 'max:50', Rule::unique('karyawan', 'nip')->ignore($karyawan->id_karyawan, 'id_karyawan')],
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'agama' => 'nullable|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_pernikahan' => 'nullable|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'email' => ['required', 'email', Rule::unique('karyawan', 'email')->ignore($karyawan->id_karyawan, 'id_karyawan')],
            'tanggal_masuk' => 'required|date',
            'golongan_id' => 'required|exists:golongan,id_golongan',
            'jabatan_id' => 'required|exists:jabatan,id_jabatan',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($karyawan->foto_profil) {
                Storage::disk('public')->delete($karyawan->foto_profil);
            }
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $validatedData['foto_profil'] = $path;
        }

        $karyawan->update($validatedData);
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Karyawan $karyawan)
    {
        if ($karyawan->foto_profil) {
            Storage::disk('public')->delete($karyawan->foto_profil);
        }
        $karyawan->delete();
        return redirect()->route('karyawan.index')->with('success', 'Data karyawan berhasil dihapus!');
    }

    /**
     * Menampilkan halaman form untuk melengkapi profil (untuk pegawai).
     */
    public function createProfile()
    {
        $karyawan = Auth::user()->karyawan;
        $jabatan = Jabatan::all();
        $golongan = Golongan::all();
        return view('karyawan.lengkapi-profil', compact('karyawan', 'jabatan', 'golongan'));
    }

    /**
     * Menyimpan data profil yang baru diisi oleh pengguna (untuk pegawai).
     */
    public function storeProfile(Request $request)
    {
        $user = Auth::user();

        $validatedData = $request->validate([
            'nip' => ['nullable', 'string', 'max:50', Rule::unique('karyawan', 'nip')->ignore(Auth::user()->karyawan?->id_karyawan, 'id_karyawan')],
            'nama' => 'required|string|max:255',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'agama' => 'required|in:Islam,Kristen,Katolik,Hindu,Buddha,Konghucu',
            'status_pernikahan' => 'required|in:Belum Menikah,Menikah,Cerai Hidup,Cerai Mati',
            'alamat' => 'required|string',
            'no_telepon' => 'required|string|max:20',
            'tanggal_masuk' => 'required|date',
            'jabatan_id' => 'required|exists:jabatan,id_jabatan',
            'golongan_id' => 'required|exists:golongan,id_golongan',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bio' => 'nullable|string',
        ]);

        $dataToStore = $validatedData;
        $dataToStore['user_id'] = $user->id;
        $dataToStore['email'] = $user->email;

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('foto_profil', 'public');
            $dataToStore['foto_profil'] = $path;
        }

        Karyawan::updateOrCreate(
            ['user_id' => $user->id],
            $dataToStore
        );

        return redirect()->route('dashboard')->with('success', 'Profil Anda berhasil disimpan! Selamat datang.');
    }
}
