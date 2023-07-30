<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransaksiModel extends Model
{
    use HasFactory;
    protected $table = 'transaksi';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'tgl_transaksi',
        'kode_transaksi',
        'total_tagihan_produk',
        'berat_produk_total',
        'kurir_pilihan',
        'total_ongkir',
        'kode_promo',
        'nominal_promo',
        'total_transaksi',
        'bukti_tf',
        'rekening_tf',
        'metode_bayar',
        'catatan',
        'status',
        'no_resi',
        'provinsi',
        'kota',
        'kecamatan',
        'kode_pos',
        'alamat_lengkap',
        'no_hp',
        'penerima',
        'limit_datetime'
    ];

    static function generate_kode(){

        $bulan = date('m');
        $tahun = date('Y');
        $default = 'TRX/'.$bulan.'/'.$tahun.'/001';

        $getExistingData = TransaksiModel::where(DB::raw('MONTH(tgl_transaksi)'), $bulan)->where(DB::raw('YEAR(tgl_transaksi)'), $tahun)->orderBy('created_at', 'desc');
        $temp = '';

        if($getExistingData->count() > 0){

            $last_data = $getExistingData->first();
            $temp = $last_data->kode_transaksi;

            $boom = explode("/", $temp);
            $increment = $boom[3] + 1;

            $susun = 'TRX/'.$bulan.'/'.$tahun.'/'.str_pad($increment, 3, '0', STR_PAD_LEFT);
            return $susun;

        }else{
            return $default;
        }

    }

}
