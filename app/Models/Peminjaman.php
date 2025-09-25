<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Buku;
use App\Models\Anggota;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Peminjaman extends Model
{
    //
    use HasFactory;

    protected $table = 'peminjamans';
    protected $primaryKey = 'peminjaman_id';

    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_kembali',
        'tanggal_dikembalikan',
        'status',
        'denda',
    ];

    protected $casts = [
        'tanggal_pinjam' => 'datetime',
        'tanggal_kembali' => 'datetime',
        'tanggal_dikembalikan' => 'datetime',
        'denda' => 'decimal:2',
    ];

    public function anggota()
    {
        return $this->belongsTo(Anggota::class, 'anggota_id');
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function isOverdue()
    {
        return $this->tanggal_kembali && 
               $this->status === 'DIPINJAM' && 
               Carbon::now()->isAfter($this->tanggal_kembali);
    }

    public function getDaysOverdue()
    {
        if (!$this->isOverdue()) {
            return 0;
        }

        return Carbon::now()->diffInDays($this->tanggal_kembali);
    }

    public function calculateDenda($dendaPerHari = 1000)
    {
        $daysOverdue = $this->getDaysOverdue();
        return $daysOverdue * $dendaPerHari;
    }

    // Boot method untuk auto-update status
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($peminjaman) {
            if (!$peminjaman->tanggal_kembali) {
                $peminjaman->tanggal_kembali = Carbon::now()->addDays(7); // Default 7 hari
            }
        });

        static::updating(function ($peminjaman) {
            if ($peminjaman->tanggal_dikembalikan && $peminjaman->status === 'DIPINJAM') {
                $peminjaman->status = 'DIKEMBALIKAN';
            }
        });
    }
}
