<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class KeranjangModel extends Model
{
    use HasFactory;
    protected $table = 'keranjang';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_produk',
        'qty',
        'catatan'
    ];
}
