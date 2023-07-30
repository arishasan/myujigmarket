<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AlamatModel extends Model
{
    use HasFactory;
    protected $table = 'alamat';
    protected $primaryKey = 'id';

    protected $fillable = [
        'label',
        'alamat',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'no_hp',
        'penerima',
        'is_alamat_utama',
        'id_user'
    ];
}
