<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;

class Karyawan extends Model
{
    use HasFactory;

    protected $table = 'karyawan';
    protected $primaryKey = 'id_karyawan';

    public $incrementing = true;
    protected $keyType = 'int';

    protected $fillable = [
        'nip',
        'nama',
        // 'gaji_pokok' tidak ada di sini, karena berada di tabel golongan
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_pernikahan',
        'alamat',
        'no_telepon',
        'email',
        'tanggal_masuk',
        'golongan_id',
        'jabatan_id',
        'foto_profil',
        'bio',
        'user_id',
        'status' // Menambahkan status karyawan
    ];

    // Relasi ke Jabatan
    public function jabatan(): BelongsTo
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id_jabatan');
    }

    // Relasi ke Golongan
    public function golongan(): BelongsTo
    {
        return $this->belongsTo(Golongan::class, 'golongan_id', 'id_golongan');
    }

    // Relasi ke User
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Absensi
    public function absensi(): HasMany
    {
        return $this->hasMany(Absensi::class, 'karyawan_id', 'id_karyawan');
    }

    // Relasi ke Gaji
    public function gaji(): HasMany
    {
        return $this->hasMany(Gaji::class, 'karyawan_id', 'id_karyawan');
    }

    // Relasi ke Cuti
    public function cuti(): HasMany
    {
        return $this->hasMany(Cuti::class, 'karyawan_id', 'id_karyawan');
    }

    // Relasi ke Lembur
    public function lembur(): HasMany
    {
        return $this->hasMany(Lembur::class, 'karyawan_id', 'id_karyawan');
    }

    /**
     * Menghitung Tunjangan Lembur berdasarkan data yang disetujui.
     */
    public function hitungTunjanganLembur($bulan, $tahun)
    {
        $tanggalAwal = Carbon::createFromDate($tahun, $bulan, 1)->startOfMonth();
        $tanggalAkhir = Carbon::createFromDate($tahun, $bulan, 1)->endOfMonth();

        $lemburRecords = $this->lembur()
            ->whereRaw('LOWER(status) = ?', ['disetujui'])
            ->whereBetween('tanggal_lembur', [$tanggalAwal, $tanggalAkhir])
            ->get();

        $totalJamLembur = $lemburRecords->sum(function ($lembur) {
            return abs($lembur->durasi_jam);
        });

        if ($totalJamLembur <= 0) {
            return 0;
        }

        // --- PERBAIKAN UTAMA ---
        // Gaji pokok diambil dari relasi 'golongan', bukan dari '$this->gaji_pokok'.
        $gajiPokok = $this->golongan->gaji_pokok ?? 0;
        
        if (!is_numeric($gajiPokok) || $gajiPokok <= 0) {
            return 0;
        }

        // Rumus upah lembur per jam (1/173 dari gaji pokok)
        $uangLemburPerJam = $gajiPokok / 173;

        return round($totalJamLembur * $uangLemburPerJam);
    }

    /**
     * Menghitung jumlah hari hadir efektif dalam sebulan.
     */
    public function hitungHariHadir($bulan, $tahun)
    {
        return $this->absensi()
            ->whereMonth('tanggal_absensi', $bulan)
            ->whereYear('tanggal_absensi', $tahun)
            ->where('status_kehadiran', 'hadir')
            ->count();
    }

    /**
     * Menghitung total potongan karena tidak hadir (Alpa).
     */
    public function hitungPotonganAbsensi($bulan, $tahun)
    {
        $totalTidakHadir = $this->absensi()
            ->where('status_kehadiran', 'alpa')
            ->whereMonth('tanggal_absensi', $bulan)
            ->whereYear('tanggal_absensi', $tahun)
            ->count();

        if ($totalTidakHadir == 0) return 0;

        $uangMakanHarian = ($this->golongan->uang_makan_bulanan ?? 0) / 22; // Asumsi 22 hari kerja
        $uangTransportHarian = ($this->golongan->uang_transport_bulanan ?? 0) / 22;

        return round($totalTidakHadir * ($uangMakanHarian + $uangTransportHarian));
    }

    /**
     * Menghitung total potongan uang makan & transport karena cuti.
     */
    public function hitungPotonganCuti($bulan, $tahun)
    {
        $cutis = $this->cuti()
            ->whereRaw('LOWER(status) = ?', ['disetujui'])
            ->where(function ($query) use ($bulan, $tahun) {
                $query->whereMonth('tanggal_mulai', $bulan)->whereYear('tanggal_mulai', $tahun);
            })
            ->get();

        if ($cutis->isEmpty()) {
            return 0;
        }

        $totalHariCuti = 0;
        foreach ($cutis as $cuti) {
            $mulai = Carbon::parse($cuti->tanggal_mulai);
            $selesai = Carbon::parse($cuti->tanggal_selesai);
            $totalHariCuti += $mulai->diffInWeekdays($selesai->addDay());
        }

        if ($totalHariCuti == 0) return 0;

        $uangMakanHarian = ($this->golongan->uang_makan_bulanan ?? 0) / 22;
        $uangTransportHarian = ($this->golongan->uang_transport_bulanan ?? 0) / 22;

        return round($totalHariCuti * ($uangMakanHarian + $uangTransportHarian));
    }

    /**
     * Menghitung jumlah tanggungan untuk BPJS.
     */
    public function jumlahTanggungan()
    {
        $tanggungan = 1; // Diri sendiri
        if (strtolower($this->status_pernikahan) == 'menikah') {
            $tanggungan += 1;
        }
        $tanggungan += $this->jumlah_anak ?? 0;
        return $tanggungan;
    }
}
