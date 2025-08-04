<?php

namespace App\Http\Controllers;

use App\Models\Gaji;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\View\View;

class GajiController extends Controller
{
    /**
     * Menampilkan riwayat gaji.
     */
    public function index(): View
    {
        $user = Auth::user();
        if ($user->role == 'admin') {
            $gaji = Gaji::with('karyawan.golongan')->latest()->paginate(15);
        } else {
            if ($user->karyawan) {
                $karyawanId = $user->karyawan->id_karyawan;
                $gaji = Gaji::where('karyawan_id', $karyawanId)->with('karyawan.golongan')->latest()->get();
            } else {
                $gaji = collect();
            }
        }
        return view('gaji.index', compact('gaji'));
    }

    /**
     * Menampilkan form untuk memilih bulan dan tahun generate gaji.
     */
    public function showGenerateForm(): View
    {
        $karyawans = Karyawan::where('status', 'aktif')->get();
        return view('gaji.generate', compact('karyawans'));
    }

    /**
     * Membuat atau memperbarui data gaji untuk karyawan berdasarkan periode yang dipilih.
     */
    public function generateStore(Request $request)
    {
        $validated = $request->validate([
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2020|max:' . (date('Y') + 1),
            'karyawan_id' => 'nullable|exists:karyawan,id_karyawan',
        ]);

        $bulan = $validated['bulan'];
        $tahun = $validated['tahun'];
        $targetKaryawanId = $validated['karyawan_id'] ?? null;

        $karyawanQuery = Karyawan::where('status', 'aktif')->with('golongan');

        if ($targetKaryawanId) {
            $karyawanQuery->where('id_karyawan', $targetKaryawanId);
        }

        $karyawans = $karyawanQuery->get();
        $gajiGeneratedCount = 0;

        DB::beginTransaction();
        try {
            foreach ($karyawans as $karyawan) {
                if (!$karyawan->golongan) {
                    continue;
                }

                $golongan = $karyawan->golongan;

                $gajiPokok = $golongan->gaji_pokok ?? 0;
                $tunjanganKeluarga = $golongan->tunjangan_keluarga ?? 0;
                $bpjsKesehatan = ($golongan->bpjs_per_tanggungan ?? 0) * $karyawan->jumlahTanggungan();
                $uangMakanBulanan = $golongan->uang_makan_bulanan ?? 0;
                $uangTransportBulanan = $golongan->uang_transport_bulanan ?? 0;

                $tunjanganLembur = $karyawan->hitungTunjanganLembur($bulan, $tahun);
                $potonganAbsensi = $karyawan->hitungPotonganAbsensi($bulan, $tahun);
                $potonganCuti = $karyawan->hitungPotonganCuti($bulan, $tahun);
                
                $thr = 0;
                $bonus = 0;
                
                $totalGajiBruto = $gajiPokok + $tunjanganKeluarga + $uangMakanBulanan + $uangTransportBulanan + $tunjanganLembur + $thr + $bonus;
                $potonganPajak = $totalGajiBruto * 0.01;
                $totalPotonganLain = 0;
                $totalPotongan = $bpjsKesehatan + $potonganAbsensi + $potonganCuti + $potonganPajak + $totalPotonganLain;
                $totalGajiNetto = $totalGajiBruto - $totalPotongan;

                Gaji::updateOrCreate(
                    [
                        'karyawan_id' => $karyawan->id_karyawan,
                        'bulan' => $bulan,
                        'tahun' => $tahun,
                    ],
                    [
                        'periode_gaji' => Carbon::createFromDate($tahun, $bulan, 1)->format('Y-m-d'),
                        'gaji_pokok' => $gajiPokok,
                        'tunjangan_keluarga' => $tunjanganKeluarga,
                        'uang_makan' => $uangMakanBulanan,
                        'uang_transport' => $uangTransportBulanan,
                        'thr' => $thr,
                        'bonus' => $bonus,
                        'tunjangan_lembur' => $tunjanganLembur,
                        'potongan_absensi' => $potonganAbsensi,
                        'potongan_uang_makan_cuti' => $potonganCuti,
                        'potongan_transport_cuti' => 0,
                        'bpjs_kesehatan' => $bpjsKesehatan,
                        'total_potongan_lain' => $totalPotonganLain,
                        'potongan_pajak' => $potonganPajak,
                        'total_gaji_bruto' => $totalGajiBruto,
                        'total_gaji_netto' => $totalGajiNetto,
                        'status_pembayaran' => 'pending',
                        'keterangan' => 'Gaji otomatis periode ' . Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y'),
                    ]
                );
                $gajiGeneratedCount++;
            }

            DB::commit();
            $message = "Berhasil membuat/memperbarui data gaji untuk {$gajiGeneratedCount} karyawan pada periode " . Carbon::createFromDate($tahun, $bulan, 1)->translatedFormat('F Y') . ".";
            return redirect()->route('gaji.index')->with('success', $message);

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan saat membuat data gaji: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan form edit gaji.
     */
    public function edit(Gaji $gaji): View
    {
        // PERBAIKAN: Mengganti $this->authorize dengan pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        $karyawans = Karyawan::all();
        return view('gaji.edit', compact('gaji', 'karyawans'));
    }

    /**
     * Memperbarui data gaji secara manual.
     */
    public function update(Request $request, Gaji $gaji)
    {
        // PERBAIKAN: Mengganti $this->authorize dengan pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        $validated = $request->validate([
            'karyawan_id' => 'required|exists:karyawan,id_karyawan',
            'bulan' => 'required|integer|min:1|max:12',
            'tahun' => 'required|integer|min:2000',
            'gaji_pokok' => 'required|numeric|min:0',
            'tunjangan_keluarga' => 'nullable|numeric|min:0',
            'uang_makan' => 'nullable|numeric|min:0',
            'uang_transport' => 'nullable|numeric|min:0',
            'thr' => 'nullable|numeric|min:0',
            'bonus' => 'nullable|numeric|min:0',
            'tunjangan_lembur' => 'nullable|numeric|min:0',
            'potongan_absensi' => 'nullable|numeric|min:0',
            'potongan_uang_makan_cuti' => 'nullable|numeric|min:0',
            'potongan_transport_cuti' => 'nullable|numeric|min:0',
            'total_potongan_lain' => 'nullable|numeric|min:0',
            'bpjs_kesehatan' => 'nullable|numeric|min:0',
            'potongan_pajak' => 'nullable|numeric|min:0',
            'status_pembayaran' => 'required|in:pending,dibayar',
            'keterangan' => 'nullable|string|max:255',
        ]);
        
        $totalGajiBruto = array_sum(array_values($request->only(['gaji_pokok', 'tunjangan_keluarga', 'uang_makan', 'uang_transport', 'thr', 'bonus', 'tunjangan_lembur'])));
        $totalPotongan = array_sum(array_values($request->only(['bpjs_kesehatan', 'potongan_pajak', 'potongan_absensi', 'potongan_uang_makan_cuti', 'potongan_transport_cuti', 'total_potongan_lain'])));
        $totalGajiNetto = $totalGajiBruto - $totalPotongan;

        $updateData = $validated;
        $updateData['total_gaji_bruto'] = $totalGajiBruto;
        $updateData['total_gaji_netto'] = $totalGajiNetto;
        
        $gaji->update($updateData);

        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil diperbarui!');
    }

    /**
     * Menghapus data gaji.
     */
    public function destroy(Gaji $gaji)
    {
        // PERBAIKAN: Mengganti $this->authorize dengan pengecekan role manual
        if (Auth::user()->role !== 'admin') {
            abort(403, 'ANDA TIDAK MEMILIKI AKSES.');
        }

        $gaji->delete();
        return redirect()->route('gaji.index')->with('success', 'Data gaji berhasil dihapus!');
    }
}
