<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use File;
use App\Models\HelperModel;
use App\Models\BannerModel;

class BannerController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $data = [
            'data_banner' => BannerModel::all()
        ];
        return view('admin.pages.banner.index')->with($data);
    }

    public function edit($id){
        $data = [
            'data_banner' => BannerModel::where(DB::raw('md5(id)'), $id)->first()
        ];
        return view('admin.pages.banner.edit')->with($data);
    }

    public function store(Request $req){

        $rules = [
            'foto' => 'max:2120', //2MB
        ];

        $messages = [
            'foto.max' => 'Maksimal upload foto hanya 2MB!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $location = public_path('/uploads/banner');
        
        $url_foto = '';
        
        if($req->foto){

            $imageName = md5(date('ymdhis').'_'.Auth()->user()->id).'.'.$req->foto->getClientOriginalExtension();
            File::copy($req->foto, $location.'/'.$imageName);
            $url_foto = 'uploads/banner/'.$imageName;

        }else{
            $url_foto = 'assets/noimage.png';
        }

        $baru = new BannerModel;
        $baru->image = $url_foto;
        $baru->title = $req->title;
        $baru->subtitle = $req->subtitle;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data banner baru.');
    		return redirect()->route('banner');
        }else{
            Session::flash('error', 'Gagal menyimpan data banner baru.');
    		return redirect()->route('banner');
        }

    }

    public function delete($id){

        $data = BannerModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){

            if($data->image != null){

                $boom = explode("/", $data->image);
                $img = $boom[count($boom) - 1];

                if(strtolower($img) == 'noimage.png'){}else{

                    $ledl = public_path('uploads/banner/'.$img);

                    if (File::exists($ledl)) {
                        File::delete($ledl);
                    }

                }

            }
            
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data banner.');
            }else{
                Session::flash('error', 'Gagal menghapus data banner.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data banner.');
        }

    }

    public function update(Request $req){

        $rules = [
            'foto' => 'max:2120', //2MB
        ];

        $messages = [
            'foto.max' => 'Maksimal upload foto hanya 2MB!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }
        
        $get_data = BannerModel::find($req->id);
        if(null !== $get_data){

            $location = public_path('/uploads/banner');
            
            $url_foto = '';
            
            if($req->foto){

                if($get_data->image != null){

                    $boom = explode("/", $get_data->image);
                    $img = $boom[count($boom) - 1];
    
                    if(strtolower($img) == 'noimage.png'){}else{
    
                        $ledl = public_path('uploads/banner/'.$img);
    
                        if (File::exists($ledl)) {
                            File::delete($ledl);
                        }
    
                    }
    
                }
    
                $imageName = md5(date('ymdhis').'_'.Auth()->user()->id).'.'.$req->foto->getClientOriginalExtension();
                File::copy($req->foto, $location.'/'.$imageName);
                $url_foto = 'uploads/banner/'.$imageName;
    
            }else{
                $url_foto = $get_data->image;
            }
    
            $get_data->image = $url_foto;
            $get_data->title = $req->title;
            $get_data->subtitle = $req->subtitle;

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data banner.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data banner.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data banner.');
            return redirect()->route('banner');

        }

    }

   
}
