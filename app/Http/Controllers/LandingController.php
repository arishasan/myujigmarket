<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\BannerModel;
use App\Models\ProdukModel;
use App\Models\KategoriModel;
use App\Models\KeranjangModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\KecamatanModel;
use App\Models\KodePromoModel;

class LandingController extends Controller
{	
	public function __construct(){

	}
    
    public function index(){
        $data = array(
            'banner' => BannerModel::all(),
            'new_produk' => ProdukModel::select(DB::raw("produk.*, kategori_produk.nama as `nama_kategori`"))->leftJoin('kategori_produk', 'kategori_produk.id','=','produk.id_kategori')->where('status', 1)->where(DB::raw('MONTH(produk.created_at)'), date('m'))->orderBy('produk.id', 'DESC')->limit(8)->get(),
            'rekomendasi' => ProdukModel::select(DB::raw("produk.*, kategori_produk.nama as `nama_kategori`"))->leftJoin('kategori_produk', 'kategori_produk.id','=','produk.id_kategori')->where('status', 1)->inRandomOrder()->limit(10)->get(),
            'promo' => ProdukModel::where('status', 1)->where('is_promo', 1)->orderBy('value_promo', 'DESC')->limit(1)->get(),
            'dilihat' => ProdukModel::where('status', 1)->orderBy('dilihat', 'DESC')->limit(1)->get(),
        );
    	return view('landing.index')->with($data);
    }

    public function semuaProduk(Request $req, $kategori = null){

        $qproduk = ProdukModel::select(DB::raw("produk.*, kategori_produk.nama as `nama_kategori`"));
        $qproduk->leftJoin('kategori_produk', 'kategori_produk.id','=','produk.id_kategori');
        $qproduk->where('status', 1);
        if($kategori != null || $kategori != ''){
            if($kategori != 'semua'){
                $qproduk->where('id_kategori', $kategori);
            }
        }

        if(isset($req->cari)){
            $qproduk->where('nama_produk', 'like', '%' . $req->cari . '%');
        }

        if(isset($req->kondisi)){
            
            if($req->kondisi != 'semua'){
                $qproduk->where('is_new', ($req->kondisi == 'kondisi_baru' ? 1 : 0));
            }

        }

        if(isset($req->range_harga)){

            if($req->range_harga == '100'){
                $qproduk->where(function($query){
                    $query->where('harga_jual', '>', 0)
                   ->where('harga_jual','<=', 100000);
               });
            }else if($req->range_harga == '200'){
                $qproduk->where(function($query){
                    $query->where('harga_jual', '>', 100000)
                   ->where('harga_jual','<=', 200000);
               });
            }else if($req->range_harga == '500'){
                $qproduk->where(function($query){
                    $query->where('harga_jual', '>', 200000)
                   ->where('harga_jual','<=', 500000);
               });
            }else if($req->range_harga == '1000'){
                $qproduk->where(function($query){
                    $query->where('harga_jual', '>', 500000)
                   ->where('harga_jual','<=', 1000000);
               });
            }else{
                $qproduk->where(function($query){
                    $query->where('harga_jual', '>', 1000000);
               });
            }

        }

        if(isset($req->sort)){

            if($req->sort == 'nama'){
                $qproduk->orderBy('produk.nama_produk', 'ASC');
            }else if($req->sort == 'low_price'){
                $qproduk->orderBy('produk.harga_jual', 'ASC');
            }else if($req->sort == 'high_price'){
                $qproduk->orderBy('produk.harga_jual', 'DESC');
            }else if($req->sort == 'new'){
                $qproduk->orderBy('produk.created_at', 'DESC');
            }else if($req->sort == 'old'){
                $qproduk->orderBy('produk.created_at', 'ASC');
            }

        }else{
            $qproduk->orderBy('produk.nama_produk', 'ASC');
        }

        if(isset($req->limit)){
            // $dproduk = $qproduk->limit($req->limit)->get();   
            $dproduk = $qproduk->paginate($req->limit, ['*'], 'page', $req->page ?? 1);
        }else{
            // $dproduk = $qproduk->limit(6)->get();
            $dproduk = $qproduk->paginate(6, ['*'], 'page', $req->page ?? 1);
        }

        $data = array(
            'search_name' => isset($req->cari) ? $req->cari : null,
            'selected_kategori' => $kategori ?? 'semua', 
            'kategori' => KategoriModel::all(),
            'produk' => $dproduk,
            'range_harga' => isset($req->range_harga) ? $req->range_harga : null,
            'limit' => isset($req->limit) ? $req->limit : 6,
            'sort' => isset($req->sort) ? $req->sort : 'nama',
            'kondisi' => isset($req->kondisi) ? $req->kondisi : 'semua',
        );
        return view('landing.pembeli.search_produk')->with($data);

    }

    public function modalDetailProduct($id){

        $data = array(
            'produk' => ProdukModel::select(DB::raw("produk.*, kategori_produk.nama as `nama_kategori`"))->leftJoin('kategori_produk', 'kategori_produk.id','=','produk.id_kategori')->where('produk.id', $id)->first()
        );
    	return view('landing.detail_prod')->with($data);

    }

    public function modalDetailProductKeranjang($id){

        $qKeranjang = KeranjangModel::select(
            DB::raw('keranjang.*, 
            produk.nama_produk, 
            produk.image, 
            produk.image2, 
            produk.image3, 
            produk.slug, 
            produk.deskripsi, 
            produk.harga_jual, 
            produk.is_promo,
            produk.value_promo,
            produk.stok,
            produk.berat_gram,
            produk.is_new,
            kategori_produk.nama as `nama_kategori`
            '))
            ->leftJoin('produk', 'produk.id','=','keranjang.id_produk')
            ->leftJoin('kategori_produk', 'kategori_produk.id','=','produk.id_kategori')
            ->where('keranjang.id', $id)
            ->first();

        $data = array(
            'produk' => $qKeranjang
        );
    	return view('landing.detail_prod_keranjang')->with($data);

    }

    public function detailProduct($slug, $md5ID){

        $dProduk = ProdukModel::where(DB::raw('md5(id)'), $md5ID)->first();
        if($dProduk){
            $dProduk->dilihat = $dProduk->dilihat + 1;
            $dProduk->save();
        }

        $data = array(
            'produk' => ProdukModel::select(DB::raw("produk.*, kategori_produk.nama as `nama_kategori`"))->leftJoin('kategori_produk', 'kategori_produk.id','=','produk.id_kategori')->where(DB::raw('md5(produk.id)'), $md5ID)->first(),
        );
    	return view('landing.pembeli.detail_produk')->with($data);

    }

    public function getKota($id){
        echo json_encode(KotaModel::where('province_id', $id)->get());
    }

    public function getKecamatan($id){
        echo json_encode(KecamatanModel::where('city_id', $id)->get());
    }

    public function cekVoucher($kode, $nominal){

        $arr = [
            'valid' => false,
            'message' => ''
        ];
        $check = KodePromoModel::where('status', 1)->where('kode_promo', $kode)->first();
        
        if($check){

            $now = date('Y-m-d');
            $start = date('Y-m-d', strtotime($check->periode_mulai));
            $end = date('Y-m-d', strtotime($check->periode_berakhir));
                
            if (($now >= $start) && ($now <= $end)){

                if($check->quota <= 0){
                    $arr['valid'] = false;
                    $arr['message'] = 'Quota claim sudah habis, silahkan gunakan kode promo yang lain.';
                }else{

                    if($nominal < $check->minimal_belanja){
                        $arr['valid'] = false;
                        $arr['message'] = 'Kode promo tidak bisa dipakai. Minimal belanja Rp. '.number_format($check->minimal_belanja).'.';
                    }else{

                        $arr['valid'] = true;
                        
                        if($check->type_promo == 'Percentage'){
                            $arr['message'] = 'Kode Promo/Voucher berhasil digunakan. Mendapatkan potongan sebesar '.$check->value_promo.'% dari SubTotal Keranjang';
                        }else{
                            $arr['message'] = 'Kode Promo/Voucher berhasil digunakan. Mendapatkan potongan sebesar Rp. '.number_format($check->value_promo).' dari SubTotal Keranjang';
                        }

                        $arr['type_promo'] = $check->type_promo;
                        $arr['value_promo'] = $check->value_promo;

                    }

                }
                
            }else{
                $arr['valid'] = false;
                $arr['message'] = 'Kode Promo/Voucher sudah kadaluarsa / belum aktif.';
            }

        }else{

            $arr['valid'] = false;
            $arr['message'] = 'Kode Promo/Voucher tidak ditemukan.';

        }
        echo json_encode($arr);

    }

}
