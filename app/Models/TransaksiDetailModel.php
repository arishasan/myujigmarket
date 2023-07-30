<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiDetailModel extends Model
{
    use HasFactory;
    protected $table = 'det_transaksi';
    protected $primaryKey = 'id';

    public $timestamps = false;

    protected $fillable = [
        'id_transaksi',
        'id_produk',
        'harga_satuan',
        'berat_satuan',
        'qty',
        'total',
        'catatan'
    ];
}
