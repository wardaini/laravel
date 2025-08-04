<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Golongan extends Model
{
    use HasFactory;

    protected $table = 'golongan';
    protected $primaryKey = 'id_golongan';

    protected $fillable = [
        'nama_golongan',
        'gaji_pokok',
        'tunjangan_keluarga',
        'uang_makan_bulanan',
        'uang_transport_bulanan',
        'thr_nominal',
        'bpjs_per_tanggungan',
        'bonus_tahunan',
        // Tambahkan ke $fillable
        'uang_lembur_per_jam',

    ];

    protected $casts = [
        'gaji_pokok' => 'decimal:2',
        'tunjangan_keluarga' => 'decimal:2',
        'uang_makan_bulanan' => 'decimal:2',
        'uang_transport_bulanan' => 'decimal:2',
        'thr_nominal' => 'decimal:2',
        'bpjs_per_tanggungan' => 'decimal:2',
        'bonus_tahunan' => 'decimal:2',
        'uang_lembur_per_jam' => 'decimal:2',
    ];

    public function karyawan(): HasMany
    {
        return $this->hasMany(Karyawan::class, 'golongan_id', 'id_golongan');
    }
}