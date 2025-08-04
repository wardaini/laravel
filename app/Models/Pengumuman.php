<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    protected $fillable = [
        'judul',
        'isi',
        'tanggal',
    ];
    public function dibacaOleh()
    {
        return $this->belongsToMany(User::class, 'pengumuman_user')->withPivot('dibaca_pada')->withTimestamps();
    }
}
