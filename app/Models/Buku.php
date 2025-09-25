<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Buku extends Model
{
    //
     use HasFactory;

    protected $table = 'bukus';
    protected $primaryKey = 'buku_id';

    protected $fillable = [
        'judul',
        'isbn',
        'tahun_terbit',
        'stok',
        'kategori',
        'penerbit_id',
    ];

    protected $casts = [
        'tahun_terbit' => 'integer',
        'stok' => 'integer',
    ];

    public function penerbit()
    {
        return $this->belongsTo(Penerbit::class, 'penerbit_id');
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'buku_authors', 'buku_id', 'author_id');
    }

    public function peminjamans()
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function kategoriModel()
    {
        return $this->belongsTo(Kategori::class, 'kategori', 'nama_kategori');
    }

    public function isAvailable()
    {
        return $this->stok > 0;
    }

    public function getAuthorsNameAttribute()
    {
        return $this->authors->pluck('nama_author')->join(', ');
    }
}
