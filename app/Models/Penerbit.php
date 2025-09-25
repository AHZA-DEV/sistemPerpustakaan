<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Penerbit extends Model
{
    //
    use HasFactory;

    protected $table = 'penerbits';
    protected $primaryKey = 'penerbit_id';

    protected $fillable = [
        'nama_penerbit',
        'alamat',
        'telepon',
        'email',
    ];

    public function bukus()
    {
        return $this->hasMany(Buku::class, 'penerbit_id');
    }
}
