<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class BukuAuthor extends Pivot
{
    //
    protected $table = 'buku_authors';

    public function buku()
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    public function author()
    {
        return $this->belongsTo(Author::class, 'author_id');
    }
}
