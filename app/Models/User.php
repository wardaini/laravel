<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

// /**
//  * Mendefinisikan properti dan relasi untuk model User.
//  *
//  * @property int $id
//  * @property string $name
//  * @property string $username
//  * @property string $email
//  * @property string $password
//  * @property string $role
//  * @property \Illuminate\Support\Carbon|null $email_verified_at
//  * @property string|null $remember_token
//  * @property \Illuminate\Support\Carbon|null $created_at
//  * @property \Illuminate\Support\Carbon|null $updated_at
//  * @property-read \App\Models\Karyawan|null $karyawan
//  */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function karyawan(): HasOne
    {
        return $this->hasOne(Karyawan::class, 'user_id');
    }

    public function dibacaPengumuman()
    {
        return $this->belongsToMany(Pengumuman::class, 'pengumuman_user')
            ->withPivot('dibaca_pada')
            ->withTimestamps();
    }
}
