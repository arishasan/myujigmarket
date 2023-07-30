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
use App\Models\UserModel;
use App\Models\KeranjangModel;
use App\Models\WishlistModel;
use App\Models\AlamatModel;
use App\Models\ProvinsiModel;
use App\Models\KotaModel;
use App\Models\KecamatanModel;
use App\Models\HelperModel;
use App\Models\TransaksiModel;
use App\Models\TransaksiDetailModel;
use App\Models\KodePromoModel;
use App\Models\RekeningModel;
use App\Models\DashboardModel;

class AdminController extends Controller
{	
	public function __construct(){

	}
    
    public function index(Request $req){

        $bulan = date('m');
        $tahun = date('Y');
        
        if(isset($req->tahun)){

            $bulan = $req->bulan;
            $tahun = $req->tahun;

        }else{

        }

        $data = array(
            'transaksi_count' => TransaksiModel::where(DB::raw('MONTH(tgl_transaksi)'), $bulan)->where(DB::raw('YEAR(tgl_transaksi)'), $tahun)->count(),
            'produkbaru_count' => ProdukModel::where(DB::raw('MONTH(created_at)'), $bulan)->where(DB::raw('YEAR(created_at)'), $tahun)->count(),
            'pesanan_sukses' => TransaksiModel::where(DB::raw('MONTH(tgl_transaksi)'), $bulan)->where(DB::raw('YEAR(tgl_transaksi)'), $tahun)->where('status', 'SELESAI')->count(),
            'produk_stok' => ProdukModel::where('stok','<',10)->count(),
            'chart_jml_transaksi' => json_encode(DashboardModel::getChartJmlTransaksi($tahun, $bulan)),
            'chart_metode_bayar' => json_encode(DashboardModel::getChartMetodeBayar($tahun, $bulan)),
            'transaksi_terakhir' => TransaksiModel::where(DB::raw('MONTH(tgl_transaksi)'), $bulan)->where(DB::raw('YEAR(tgl_transaksi)'), $tahun)->orderBy('created_at', 'DESC')->limit(6)->get(),
            'bulan' => $req->bulan ?? date('m'),
            'tahun' => $req->tahun ?? date('Y'),
        );

    	return view('admin.index')->with($data);
    }

}
