<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Author extends Model
{
    //
    use HasFactory;

    protected $table = 'authors';
    protected $primaryKey = 'author_id';

    protected $fillable = [
        'nama_author',
        'biografi',
        'email',
    ];

    public function bukus()
    {
        return $this->belongsToMany(Buku::class, 'buku_authors', 'author_id', 'buku_id');
    }
}
