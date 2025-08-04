<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckProfileCompletion
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Pastikan ada user yang login sebelum melakukan pengecekan
        if (Auth::check()) {
            $user = Auth::user();

            // KONDISI FINAL YANG BENAR
            if (
                $user->role === 'pegawai' &&             // 1. Cek jika rolenya 'pegawai'
                is_null($user->karyawan) &&              // 2. Cek jika data karyawan benar-benar KOSONG
                !$request->routeIs('profile.create') &&  // 3. Izinkan akses ke halaman lengkapi profil
                !$request->routeIs('logout')             // 4. Izinkan akses untuk logout
            ) {
                // REDIRECT FINAL YANG BENAR
                return redirect()->route('profile.create')->with('warning', 'Harap lengkapi profil kepegawaian Anda untuk melanjutkan.');
            }
        }

        // Jika semua kondisi tidak terpenuhi, izinkan user lewat.
        return $next($request);
    }
}