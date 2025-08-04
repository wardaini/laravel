<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lembur extends Model
{
    use HasFactory;

    protected $table = 'lembur';
    protected $primaryKey = 'id_lembur';

    protected $fillable = [
        'karyawan_id',
        'tanggal_lembur',
        'jam_mulai',
        'jam_selesai',
        'durasi_jam', // Durasi dalam jam
        'keterangan',
        'status', // pending, disetujui, ditolak
    ];

    protected $casts = [
        'tanggal_lembur' => 'date',
        'durasi_jam' => 'float',
    ];

    public function karyawan(): BelongsTo
    {
        return $this->belongsTo(Karyawan::class, 'karyawan_id', 'id_karyawan');
    }
}

