<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\JabatanController;
use App\Http\Controllers\GolonganController;
use App\Http\Controllers\KaryawanController;
use App\Http\Controllers\CutiController;
use App\Http\Controllers\GajiController; // Pastikan ini ada
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\AbsensiController;
use App\Http\Controllers\PengumumanController;
use App\Http\Controllers\LemburController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Versi rapi dengan pemisahan hak akses yang jelas antara Pegawai dan Admin.
|
*/

// Rute publik utama
Route::get('/', function () {
    return view('welcome');
});

// Semua rute di dalam grup ini memerlukan pengguna untuk login dan terverifikasi emailnya
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard (akses awal setelah login, sebelum cek profil lengkap)
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // --- RUTE UNTUK PEGAWAI BARU YANG BELUM MELENGKAPI PROFIL ---
    // Middleware 'profile.completed' akan mengarahkan ke sini jika profil belum lengkap
    Route::controller(KaryawanController::class)->group(function() {
        Route::get('/lengkapi-profil', 'createProfile')->name('profile.create');
        Route::post('/lengkapi-profil', 'storeProfile')->name('profile.store');
    });

    // --- SEMUA RUTE UTAMA APLIKASI (HANYA UNTUK PROFIL LENGKAP) ---
    Route::middleware(['profile.completed'])->group(function() {

        // Dashboard (setelah profil lengkap)
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Pengumuman (bisa diakses semua pegawai)
        Route::resource('pengumuman', PengumumanController::class);

        // --- PERBAIKAN: RUTE BARU UNTUK MENAMPILKAN FOTO PROFIL ---
        // Rute ini akan melayani gambar secara langsung dari storage.
        Route::get('/karyawan/foto/{filename}', [KaryawanController::class, 'showProfileImage'])->name('karyawan.foto');

        // --- Fitur Absensi ---
        Route::controller(AbsensiController::class)->prefix('absensi')->name('absensi.')->group(function () {
            // Untuk semua pegawai
            Route::get('/', 'index')->name('index');
            Route::post('/', 'store')->name('store');
            Route::put('/{absensi}', 'update')->name('update');
            Route::get('/get-events', 'getEvents')->name('get_events');
            Route::get('/karyawan/{karyawan}', 'showKaryawanAbsensi')->name('karyawan_detail');

            // Khusus Admin
            Route::middleware('admin')->group(function() {
                Route::delete('/{absensi}', 'destroy')->name('destroy');
                Route::get('/{absensi}/edit', 'edit')->name('edit'); // Perbaiki rute edit
            });
        });

        // --- Fitur Lembur ---
        Route::controller(LemburController::class)->prefix('lembur')->name('lembur.')->group(function () {
            // Untuk semua pegawai (melihat riwayat & mengajukan)
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');

            // Khusus Admin (mengelola & approval)
            Route::middleware('admin')->group(function () {
                Route::get('/{lembur}/edit', 'edit')->name('edit');
                Route::put('/{lembur}', 'update')->name('update');
                Route::delete('/{lembur}', 'destroy')->name('destroy');
                Route::patch('/{lembur}/approve', 'approve')->name('approve');
                Route::patch('/{lembur}/reject', 'reject')->name('reject');
            });
        });

        // --- Fitur Cuti ---
        Route::controller(CutiController::class)->prefix('cuti')->name('cuti.')->group(function () {
            // Untuk semua pegawai (melihat riwayat & mengajukan)
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');

            // Khusus Admin (mengelola data cuti)
            Route::middleware('admin')->group(function () {
                Route::get('/{cuti}/edit', 'edit')->name('edit');
                Route::put('/{cuti}', 'update')->name('update');
                Route::delete('/{cuti}', 'destroy')->name('destroy');
            });
        });

        // --- Fitur Gaji (Akses untuk Semua Pegawai & Admin) ---
        // Rute untuk pegawai melihat gajinya sendiri (dan admin melihat semua)
        Route::get('/gaji', [GajiController::class, 'index'])->name('gaji.index');
        // Rute untuk mencetak slip gaji (bisa diakses pegawai dan admin)
        Route::get('/gaji/{gaji}/cetak', [LaporanController::class, 'cetakSlipGaji'])->name('gaji.cetak');


        // --- GRUP KHUSUS UNTUK ADMIN ---
        Route::middleware('admin')->group(function() {
            // Manajemen Master Data (CRUD)
            Route::resource('jabatan', JabatanController::class)->except(['show']);
            Route::resource('golongan', GolonganController::class)->except(['show']);
            Route::resource('karyawan', KaryawanController::class); // Karyawan resource sudah lengkap

            // Manajemen Gaji (CRUD & Generate oleh Admin)
            Route::controller(GajiController::class)->prefix('gaji')->name('gaji.')->group(function() {
                // Rute untuk generate gaji
                Route::get('/generate', 'showGenerateForm')->name('generate.show'); // Mengubah nama rute menjadi .show agar konsisten
                Route::post('/generate', 'generateStore')->name('generate.store');

                // Rute untuk edit, update, delete gaji (admin)
                Route::get('/{gaji}/edit', 'edit')->name('edit');
                Route::put('/{gaji}', 'update')->name('update');
                Route::delete('/{gaji}', 'destroy')->name('destroy');
            });
        });


        // --- Rute Profil Bawaan Laravel (Edit, Update, Delete Profil Sendiri) ---
        Route::controller(ProfileController::class)->prefix('profile')->name('profile.')->group(function() {
            Route::get('/', 'edit')->name('edit');
            Route::patch('/', 'update')->name('update');
            Route::delete('/', 'destroy')->name('destroy');
        });

    });
});

require __DIR__.'/auth.php';
