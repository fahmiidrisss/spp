<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tahunajaran extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'id_tahun';

    protected $fillable = [
        'jumlah_bulan',
        'tahun_ajaran'
    ];
}
