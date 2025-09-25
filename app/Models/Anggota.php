<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Anggota extends Authenticatable
{
    //
    use HasFactory, Notifiable;

    protected $table = 'anggotas';
    protected $primaryKey = 'anggota_id';

    protected $fillable = [
        'nisn_nim',
        'nama',
        'email',
        'password',
        'alamat',
        'telepon',
        'status_keanggotaan',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
    ];

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    public function isActive()
    {
        return $this->status_keanggotaan === 'AKTIF';
    }
}
