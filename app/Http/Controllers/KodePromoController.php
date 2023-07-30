<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use App\Models\HelperModel;
use App\Models\KodePromoModel;

class KodePromoController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $data = [
            'data_promo' => KodePromoModel::all()
        ];
        return view('admin.pages.kode_promo.index')->with($data);
    }

    public function detail($id){
        $data = [
            'data_promo' => KodePromoModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.kode_promo.detail')->with($data);
    }

    public function edit($id){
        $data = [
            'data_promo' => KodePromoModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.kode_promo.edit')->with($data);
    }

    public function store(Request $req){

        $rules = [
            'kode_promo' => 'required|unique:kode_promo,kode_promo',
        ];

        $messages = [
            'kode_promo.unique' => 'Kode Promo '.$req->kode_promo.' sudah ada!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $baru = new KodePromoModel;
        $baru->kode_promo = $req->kode_promo;
        $baru->minimal_belanja = str_replace(".","", str_replace(",", "", $req->minimal_belanja));
        $baru->type_promo = $req->type_promo;
        $baru->value_promo = $req->value_promo;
        $baru->periode_mulai = $req->periode_mulai;
        $baru->periode_berakhir = $req->periode_berakhir;
        $baru->quota = $req->quota;
        $baru->status = $req->status;
        $baru->create_user = Auth()->user()->id;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data kode promo baru.');
    		return redirect()->route('kode-promo');
        }else{
            Session::flash('error', 'Gagal menyimpan data kode promo baru.');
    		return redirect()->route('kode-promo');
        }

    }

    public function delete($id){

        $data = KodePromoModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data kode promo.');
            }else{
                Session::flash('error', 'Gagal menghapus data kode promo.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data kode promo.');
        }

    }

    public function update(Request $req){

        $get_data = KodePromoModel::find($req->id);
        if(null !== $get_data){

            if($req->kode_promo == $get_data->kode_promo){}else{
                $rules = [
                    'kode_promo' => 'required|unique:kode_promo,kode_promo',
                ];
        
                $messages = [
                    'kode_promo.unique' => 'Kode Promo '.$req->kode_promo.' sudah ada!',
                ];
        
                $validator = Validator::make($req->all(), $rules, $messages);
        
                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }
            }
    
            $get_data->kode_promo = $req->kode_promo;
            $get_data->minimal_belanja = str_replace(".","", str_replace(",", "", $req->minimal_belanja));
            $get_data->type_promo = $req->type_promo;
            $get_data->value_promo = $req->value_promo;
            $get_data->periode_mulai = $req->periode_mulai;
            $get_data->periode_berakhir = $req->periode_berakhir;
            $get_data->quota = $req->quota;
            $get_data->status = $req->status;

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data kode promo.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data kode promo.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data kode promo.');
            return redirect()->route('kode-promo');

        }

    }

   
}
