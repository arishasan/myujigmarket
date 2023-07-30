<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use DateTime;
use Session;

class HelperModel extends Model
{
    use HasFactory;

    static function getCountTrx($stat){

        $id = Session::get('sess_id');
        return TransaksiModel::where('id_user', $id)->where('status', $stat)->count();

    }

    static function getReviewProduk($type, $pid){

        $getReview = ReviewModel::where('id_produk', $pid)->orderBy('created_at', 'DESC');
        
        if($type == 'rate'){

            $rateTotal = 0;
            $iterate = 0;
            foreach ($getReview->get() as $key => $value) {
                $iterate++;
                $rateTotal += $value->rate;
            }
            
            return $rateTotal <= 0 ? 0 : $rateTotal / $iterate;

        }else if($type == 'count'){

            return $getReview->count();

        }else if($type == 'person'){

            return $getReview->get();

        }

    }

    static function getStars($rate){

        $str = '';
        if($rate > 0 && $rate <= 1){
            $str = '<i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>';
        }else if($rate > 1 && $rate <= 2){
            $str = '<i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>';
        }else if($rate > 2 && $rate <= 3){
            $str = '<i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>';
        }else if($rate > 3 && $rate <= 4){
            $str = '<i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star"></i>';
        }else if($rate > 4 && $rate <= 5){
            $str = '<i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>
                    <i class="fa fa-star" style="color: orange"></i>';
        }else{
            $str = '<i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>
                    <i class="fa fa-star"></i>';
        }
        return $str;

    }

    static function truncate(string $text, int $length = 20): string {
        if (strlen($text) <= $length) {
            return $text;
        }
        $text = substr($text, 0, $length);
        $text = substr($text, 0, strrpos($text, " "));
        $text .= "...";
        return $text;
    }

    static function getCount($type){

        $usr = Session::get('sess_id');
        if($type == 'wl'){

            $getWishlist = WishlistModel::where('id_user', $usr)->count();
            return $getWishlist;

        }else if($type == 'cart'){

            $getCart = KeranjangModel::where('id_user', $usr)->count();
            return $getCart;

        }

    }

    static function getLoginPembeli(){
        
        if(Session::get('is_pembeli_login')){
            return true;
        }else{
            return false;
        }

    }

    static function inWishlist($id_prod){

        if(Session::get('is_pembeli_login')){
            
            $usr = Session::get('sess_id');
            $getWishlist = WishlistModel::where('id_user', $usr)->where('id_produk', $id_prod);

            if($getWishlist->count() > 0){
                return true;
            }else{
                return false;
            }

        }else{
            return false;
        }

    }

    static function getAllKategori(){
        return KategoriModel::all();
    }

    static function getAlamat($id, $type){

        $ret = '';
        if($type == 'prov'){
            $get = ProvinsiModel::find($id);
            return $get->province_name ?? '-';
        }else if($type == 'kota'){
            $get = KotaModel::find($id);
            return $get->city_name ?? '-';
        }else if($type == 'kec'){
            $get = KecamatanModel::find($id);
            return $get->subdistrict_name ?? '-';
        }

    }

    static function getCountProdukByKategoriNama($kategori, $nama_produk, $range, $kondisi){

        $eq = ProdukModel::where('status',1);

        if($kategori != 'semua'){
            $eq->where('id_kategori', $kategori);
        }

        if($nama_produk != null || $nama_produk != ''){
            $eq->where('nama_produk', 'like', '%' . $nama_produk . '%');
        }

        if(isset($kondisi)){
            
            if($kondisi != 'semua'){
                $eq->where('is_new', ($kondisi == 'kondisi_baru' ? 1 : 0));
            }

        }

        if($range == '100'){
            $eq->where(function($query){
                $query->where('harga_jual', '>', 0)
               ->where('harga_jual','<=', 100000);
           });
        }else if($range == '200'){
            $eq->where(function($query){
                $query->where('harga_jual', '>', 100000)
               ->where('harga_jual','<=', 200000);
           });
        }else if($range == '500'){
            $eq->where(function($query){
                $query->where('harga_jual', '>', 200000)
               ->where('harga_jual','<=', 500000);
           });
        }else if($range == '1000'){
            $eq->where(function($query){
                $query->where('harga_jual', '>', 500000)
               ->where('harga_jual','<=', 1000000);
           });
        }else{
            $eq->where(function($query){
                $query->where('harga_jual', '>', 1000000);
           });
        }

        return $eq->count();

    }

    static function getFinalPrice($isPromo, $harga_jual, $persentase){

        if($isPromo == 1){
            $potongan = ($harga_jual * $persentase) / 100;
            $penjumlahan = $harga_jual - $potongan;
            return $penjumlahan;
        }else{
            return $harga_jual;
        }

    }

    static function time_elapsed_string($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;

        $string = array(
            'y' => 'tahun',
            'm' => 'bulan',
            'w' => 'minggu',
            'd' => 'hari',
            'h' => 'jam',
            'i' => 'menit',
            's' => 'detik',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? '' : '');
            } else {
                unset($string[$k]);
            }
        }

        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' yang lalu' : 'baru saja';
    }

    static function convertBulanTahunIndo($string){

        try {
            $boom = explode("-", $string);
            $bb = '';

            if($boom[0] == '01'){
                $bb = 'Januari';
            }else if($boom[0] == '02'){
                $bb = 'Februari';
            }else if($boom[0] == '03'){
                $bb = 'Maret';
            }else if($boom[0] == '04'){
                $bb = 'April';
            }else if($boom[0] == '05'){
                $bb = 'Mei';
            }else if($boom[0] == '06'){
                $bb = 'Juni';
            }else if($boom[0] == '07'){
                $bb = 'Juli';
            }else if($boom[0] == '08'){
                $bb = 'Agustus';
            }else if($boom[0] == '09'){
                $bb = 'September';
            }else if($boom[0] == '10'){
                $bb = 'Oktober';
            }else if($boom[0] == '11'){
                $bb = 'November';
            }else if($boom[0] == '12'){
                $bb = 'Desember';
            }

            return $bb.' '.$boom[1];
        } catch (\Throwable $th) {
            return '-';
        }
            
    }

    static function getNamaBulan($string){

        try {
            $boom = $string;
            $bb = '';

            if($boom == '01'){
                $bb = 'Januari';
            }else if($boom == '02'){
                $bb = 'Februari';
            }else if($boom == '03'){
                $bb = 'Maret';
            }else if($boom == '04'){
                $bb = 'April';
            }else if($boom == '05'){
                $bb = 'Mei';
            }else if($boom == '06'){
                $bb = 'Juni';
            }else if($boom == '07'){
                $bb = 'Juli';
            }else if($boom == '08'){
                $bb = 'Agustus';
            }else if($boom == '09'){
                $bb = 'September';
            }else if($boom == '10'){
                $bb = 'Oktober';
            }else if($boom == '11'){
                $bb = 'November';
            }else if($boom == '12'){
                $bb = 'Desember';
            }

            return $bb;
        } catch (\Throwable $th) {
            return '-';
        }
            
    }

}
