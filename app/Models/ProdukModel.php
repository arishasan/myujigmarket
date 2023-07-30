<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class ProdukModel extends Model
{
    use HasFactory;
    protected $table = 'produk';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_kategori',
        'kode_produk',
        'nama_produk',
        'image',
        'slug',
        'deskripsi',
        'is_new',
        'harga_beli',
        'harga_jual',
        'is_promo',
        'value_promo',
        'stok',
        'berat_gram',
        'status',
        'create_user',
        'dilihat'
    ];

    static function generate_kode(){

        $bulan = date('m');
        $default = 'BR.'.$bulan.'.001';

        $getExistingData = ProdukModel::where(DB::raw('SUBSTR(kode_produk, 4, 2)'), $bulan)->orderBy('created_at', 'desc');
        $temp = '';

        if($getExistingData->count() > 0){

            $last_data = $getExistingData->first();
            $temp = $last_data->kode_produk;

            $boom = explode(".", $temp);
            $increment = $boom[2] + 1;

            $susun = 'BR.'.$bulan.'.'.str_pad($increment, 3, '0', STR_PAD_LEFT);
            return $susun;

        }else{
            return $default;
        }

    }

}
