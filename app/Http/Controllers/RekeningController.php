<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use App\Models\HelperModel;
use App\Models\RekeningModel;

class RekeningController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $data = [
            'data_rekening' => RekeningModel::all()
        ];
        return view('admin.pages.rekening.index')->with($data);
    }

    public function edit($id){
        $data = [
            'data_rekening' => RekeningModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.rekening.edit')->with($data);
    }

    public function store(Request $req){

        $baru = new RekeningModel;
        $baru->nama_bank = $req->nama_bank;
        $baru->no_rekening = $req->no_rekening;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data rekening baru.');
    		return redirect()->route('rekening');
        }else{
            Session::flash('error', 'Gagal menyimpan data rekening baru.');
    		return redirect()->route('rekening');
        }

    }

    public function delete($id){

        $data = RekeningModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){
            
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data rekening.');
            }else{
                Session::flash('error', 'Gagal menghapus data rekening.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data rekening.');
        }

    }

    public function update(Request $req){

        $get_data = RekeningModel::find($req->id);
        if(null !== $get_data){

            $get_data->nama_bank = $req->nama_bank;
            $get_data->no_rekening = $req->no_rekening;

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data rekening.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data rekening.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data rekening.');
            return redirect()->route('rekening');

        }

    }

   
}
