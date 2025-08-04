<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Karyawan; // [PERBAIKAN] Tambahkan ini
use App\Models\Jabatan;   // [BARU] Tambahkan ini untuk default
use App\Models\Golongan; // [BARU] Tambahkan ini untuk default
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        // Buat user baru
        $user = User::create([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Default role adalah 'user'
        ]);
        
        // [PERBAIKAN] Otomatis buat data karyawan baru yang terhubung
        // Cari jabatan & golongan pertama, atau buat jika tidak ada
        $jabatan = Jabatan::firstOrCreate(['nama_jabatan' => 'Staf'], ['deskripsi' => 'Posisi staf standar']);
        $golongan = Golongan::firstOrCreate(['nama_golongan' => 'I'], ['tunjangan' => 0]);

        Karyawan::create([
            'user_id' => $user->id,
            'nama' => $user->name,
            'email' => $user->email,
            'tanggal_lahir' => now(), 
            'tanggal_masuk' => now(),
            'alamat' => 'Belum diisi',
            'no_telepon' => '000',
            'jabatan_id' => $jabatan->id_jabatan,
            'golongan_id' => $golongan->id_golongan,
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('dashboard', absolute: false));
    }
}
