<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'nis';

    protected $fillable = [
        'nis',
        'nama_santri',
        'tanggal_lahir',
        'alamat',
        'no_hp',
        'jenis_kelamin',
        'nama_wali',
        'subsidi',
        'jumlah_tunggakan',
        'id_kelas',
        'tahun_keluar'
    ];
}
