<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Gaji extends Model
{
    use HasFactory;

    protected $table = 'gaji';
    protected /* string */ $primaryKey = 'id_gaji'; // Primary key kustom

    protected $fillable = [
        'karyawan_id',
        'bulan',
        'tahun',
        'periode_gaji', // Tanggal awal periode (contoh: 2024-07-01)
        'gaji_pokok',
        'tunjangan_keluarga',
        'uang_makan',
        'uang_transport',
        'thr',
        'bonus',
        'tunjangan_lembur',
        'total_potongan_lain', // Potongan manual/lain-lain
        'bpjs_kesehatan',
        'potongan_absensi',
        'potongan_uang_makan_cuti',
        'potongan_transport_cuti',
        'potongan_pajak', // Potongan 1%
        'total_gaji_bruto',
        'total_gaji_netto',
        'status_pembayaran',
        'keterangan', // Keterangan tambahan (manual)
    ];

    protected $casts = [
        'periode_gaji' => 'date',
        'gaji_pokok' => 'decimal:2',
        'tunjangan_keluarga' => 'decimal:2',
        'uang_makan' => 'decimal:2',
        'uang_transport' => 'decimal:2',
        'thr' => 'decimal:2',
        'bonus' => 'decimal:2',
        'tunjangan_lembur' => 'decimal:2',
        'total_potongan_lain' => 'decimal:2',
        'bpjs_kesehatan' => 'decimal:2',
        'potongan_absensi' => 'decimal:2',
        'potongan_uang_makan_cuti' => 'decimal:2',
        'potongan_transport_cuti' => 'decimal:2',
        'potongan_pajak' => 'decimal:2',
        'total_gaji_bruto' => 'decimal:2',
        'total_gaji_netto' => 'decimal:2',
        'bulan' => 'integer',
        'tahun' => 'integer',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id_karyawan');
    }

    /**
     * Metode untuk menghitung ulang gaji netto berdasarkan semua komponen yang ada di model ini.
     * Dipanggil setelah atribut Gaji diupdate/di-fill.
     */
    public function hitungUlangGajiNetto()
    {
        // Perhitungan Bruto
        $this->total_gaji_bruto = ($this->gaji_pokok ?? 0)
                                + ($this->tunjangan_keluarga ?? 0)
                                + ($this->uang_makan ?? 0)
                                + ($this->uang_transport ?? 0)
                                + ($this->thr ?? 0)
                                + ($this->bonus ?? 0)
                                + ($this->tunjangan_lembur ?? 0);

        // Perhitungan Netto (Bruto - Potongan)
        $this->total_gaji_netto = $this->total_gaji_bruto
                                - ($this->total_potongan_lain ?? 0)
                                - ($this->bpjs_kesehatan ?? 0)
                                - ($this->potongan_absensi ?? 0)
                                - ($this->potongan_uang_makan_cuti ?? 0)
                                - ($this->potongan_transport_cuti ?? 0)
                                - ($this->potongan_pajak ?? 0);

        // Pastikan nilai tidak negatif
        if ($this->total_gaji_netto < 0) {
            $this->total_gaji_netto = 0;
        }
 
        
        // $this->save(); // Simpan perubahan ke database
    }
}