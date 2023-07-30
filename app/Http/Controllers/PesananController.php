<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Session;
use Hash;
use File;
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

class PesananController extends Controller
{	
	public function __construct(){

	}
    
    public function index(Request $req){

        $query = TransaksiModel::orderBy('created_at', 'DESC');
        if(isset($req->dari)){
            $query->whereBetween('tgl_transaksi', [$req->dari, $req->ke]);
        }

        $data = array(
            'transaksi' => $query->get(),
            'dari' => $req->dari ?? date('Y-m-01'),
            'ke' => $req->ke ?? date('Y-m-t')
        );
        return view('admin.pages.pesanan.index')->with($data);

    }

    public function detailTransaksi($md5){

        $trx = TransaksiModel::where(DB::raw('md5(id)'), $md5)->first();

        $qDetail = TransaksiDetailModel::select(
            DB::raw('det_transaksi.*, 
            produk.nama_produk, 
            produk.image, 
            produk.slug, 
            produk.deskripsi
            '))
            ->leftJoin('produk', 'produk.id','=','det_transaksi.id_produk')
            ->where('id_transaksi', $trx->id)
            ->get();

        $data = array(
            'transaksi' => $trx,
            'produk' => $qDetail,
            'rekening' => RekeningModel::all()
        );
        return view('admin.pages.pesanan.detail')->with($data);

    }

    public function ubahStatusTransaksi($id, $stat, $noresi){

        $getTRX = TransaksiModel::find($id);
        if($getTRX){
            
            $getTRX->status = $stat;

            if($stat == 'DIKIRIM'){
                $getTRX->no_resi = $noresi;
            }

            $getTRX->save();
            Session::flash('success', 'Status pesanan dengan kode transaksi: <b>'.$getTRX->kode_transaksi.'</b> berhasil diubah menjadi <b>'.$stat.'</b>.');

        }else{
            Session::flash('error', 'Data pesanan tidak ditemukan.');
        }

    }

}