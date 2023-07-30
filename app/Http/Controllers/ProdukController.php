<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use DB;
use File;
use App\Models\HelperModel;
use App\Models\KategoriModel;
use App\Models\ProdukModel;
use Illuminate\Support\Str;

class ProdukController extends Controller
{
    public function __construct(){

    }

    public function index(){
        $data = [
            'data_kategori' => KategoriModel::all(),
            'data_produk' => ProdukModel::select(DB::raw('produk.*, kategori_produk.nama as `nama_kategori`'))->join('kategori_produk', 'produk.id_kategori','=','kategori_produk.id')->get()
        ];
        return view('admin.pages.produk.index')->with($data);
    }

    public function detail($id){
        $data = [
            'data_produk' => ProdukModel::select(DB::raw('produk.*, kategori_produk.nama as `nama_kategori`'))->join('kategori_produk', 'produk.id_kategori','=','kategori_produk.id')->where(DB::raw('md5(produk.id)'), $id)->first()
        ];
        return view('admin.pages.produk.detail')->with($data);
    }

    public function edit($id){
        $data = [
            'data_kategori' => KategoriModel::all(),
            'data_produk' => ProdukModel::select(DB::raw('produk.*, kategori_produk.nama as `nama_kategori`'))->join('kategori_produk', 'produk.id_kategori','=','kategori_produk.id')->where(DB::raw('md5(produk.id)'), $id)->first()
        ];
        return view('admin.pages.produk.edit')->with($data);
    }

    public function store(Request $req){

        $rules = [
            'foto' => 'max:2120', //2MB
            'foto2' => 'max:2120', //2MB
            'foto3' => 'max:2120', //2MB
        ];

        $messages = [
            'foto.max' => 'Maksimal upload foto hanya 2MB!',
            'foto2.max' => 'Maksimal upload foto hanya 2MB!',
            'foto3.max' => 'Maksimal upload foto hanya 2MB!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $location = public_path('/uploads');
        $kd = ProdukModel::generate_kode();
        
        $url_foto = '';
        $url_foto2 = '';
        $url_foto3 = '';
        
        if($req->foto){

            $imageName = $kd.'__1.'.$req->foto->getClientOriginalExtension();
            File::copy($req->foto, $location.'/'.$imageName);
            $url_foto = 'uploads/'.$imageName;

        }else{
            $url_foto = 'assets/noimage.png';
        }

        if($req->foto2){

            $imageName2 = $kd.'__2.'.$req->foto2->getClientOriginalExtension();
            File::copy($req->foto2, $location.'/'.$imageName2);
            $url_foto2 = 'uploads/'.$imageName2;

        }else{
            $url_foto2 = 'assets/noimage.png';
        }

        if($req->foto3){

            $imageName3 = $kd.'__3.'.$req->foto3->getClientOriginalExtension();
            File::copy($req->foto3, $location.'/'.$imageName3);
            $url_foto3 = 'uploads/'.$imageName3;

        }else{
            $url_foto3 = 'assets/noimage.png';
        }
        
        $baru = new ProdukModel;
        $baru->id_kategori = $req->kategori;
        $baru->kode_produk = $kd;
        
        $baru->image = $url_foto;
        $baru->image2 = $url_foto2;
        $baru->image3 = $url_foto3;

        $baru->nama_produk = $req->nama;
        $baru->slug = Str::slug($req->nama);

        $baru->deskripsi = $req->deskripsi;
        $baru->harga_beli = str_replace(".","", str_replace(",", "", $req->harga_beli));
        $baru->harga_jual = str_replace(".","", str_replace(",", "", $req->harga_jual));

        $baru->is_promo = (null !== $req->is_promo ? 1 : 0);
        $baru->value_promo = (null !== $req->is_promo ? $req->promo : 0);
        
        $baru->stok = $req->stok;
        $baru->berat_gram = $req->berat_gram;
        $baru->is_new = $req->is_new;
        $baru->status = $req->status;
        $baru->create_user = Auth()->user()->id;
        $baru->dilihat = 0;

        if($baru->save()){
            Session::flash('success', 'Berhasil menyimpan data produk baru.');
    		return redirect()->route('produk');
        }else{
            Session::flash('error', 'Gagal menyimpan data produk baru.');
    		return redirect()->route('produk');
        }

    }

    public function delete($id){

        $data = ProdukModel::where(DB::raw('md5(id)'), $id)->first();
        if(null !== $data){

            if($data->image != null){

                $boom = explode("/", $data->image);
                $img = $boom[count($boom) - 1];

                if(strtolower($img) == 'noimage.png'){}else{

                    $location = public_path('uploads/'.$img);

                    if (File::exists($location)) {
                        File::delete($location);
                    }

                }

            }

            if($data->image2 != null){

                $boom = explode("/", $data->image2);
                $img = $boom[count($boom) - 1];

                if(strtolower($img) == 'noimage.png'){}else{

                    $location = public_path('uploads/'.$img);

                    if (File::exists($location)) {
                        File::delete($location);
                    }

                }

            }

            if($data->image3 != null){

                $boom = explode("/", $data->image3);
                $img = $boom[count($boom) - 1];

                if(strtolower($img) == 'noimage.png'){}else{

                    $location = public_path('uploads/'.$img);

                    if (File::exists($location)) {
                        File::delete($location);
                    }

                }

            }
            
            if($data->delete()){
                Session::flash('success', 'Berhasil menghapus data produk.');
            }else{
                Session::flash('error', 'Gagal menghapus data produk.');
            }

        }else{
            Session::flash('error', 'Gagal menghapus data produk.');
        }

    }

    public function update(Request $req){

        $rules = [
            'foto' => 'max:2120', //2MB
            'foto2' => 'max:2120', //2MB
            'foto3' => 'max:2120', //2MB
        ];

        $messages = [
            'foto.max' => 'Maksimal upload foto hanya 2MB!',
            'foto2.max' => 'Maksimal upload foto hanya 2MB!',
            'foto3.max' => 'Maksimal upload foto hanya 2MB!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $get_data = ProdukModel::find($req->id);
        if(null !== $get_data){

            $location = public_path('/uploads');

            $url_foto = '';
            $url_foto2 = '';
            $url_foto3 = '';

            if($req->foto){

                if($get_data->image != null){

                    $boom = explode("/", $get_data->image);
                    $img = $boom[count($boom) - 1];
    
                    if(strtolower($img) == 'noimage.png'){}else{
    
                        $ldel = public_path('uploads/'.$img);
    
                        if (File::exists($ldel)) {
                            File::delete($ldel);
                        }
    
                    }
    
                }

                $imageName = $get_data->kode_produk.'__1.'.$req->foto->getClientOriginalExtension();
                File::copy($req->foto, $location.'/'.$imageName);
                $url_foto = 'uploads/'.$imageName;

            }else{
                $url_foto = $get_data->image;
            }

            if($req->foto2){

                if($get_data->image2 != null){

                    $boom = explode("/", $get_data->image2);
                    $img = $boom[count($boom) - 1];
    
                    if(strtolower($img) == 'noimage.png'){}else{
    
                        $ldel = public_path('uploads/'.$img);
    
                        if (File::exists($ldel)) {
                            File::delete($ldel);
                        }
    
                    }
    
                }

                $imageName2 = $get_data->kode_produk.'__2.'.$req->foto2->getClientOriginalExtension();
                File::copy($req->foto2, $location.'/'.$imageName2);
                $url_foto2 = 'uploads/'.$imageName2;

            }else{
                $url_foto2 = $get_data->image2;
            }

            if($req->foto3){

                if($get_data->image3 != null){

                    $boom = explode("/", $get_data->image3);
                    $img = $boom[count($boom) - 1];
    
                    if(strtolower($img) == 'noimage.png'){}else{
    
                        $ldel = public_path('uploads/'.$img);
    
                        if (File::exists($ldel)) {
                            File::delete($ldel);
                        }
    
                    }
    
                }

                $imageName3 = $get_data->kode_produk.'__3.'.$req->foto3->getClientOriginalExtension();
                File::copy($req->foto3, $location.'/'.$imageName3);
                $url_foto3 = 'uploads/'.$imageName3;

            }else{
                $url_foto3 = $get_data->image3;
            }

            $get_data->id_kategori = $req->kategori;
            
            $get_data->image = $url_foto;
            $get_data->image2 = $url_foto2;
            $get_data->image3 = $url_foto3;

            $get_data->nama_produk = $req->nama;
            $get_data->slug = Str::slug($req->nama);

            $get_data->deskripsi = $req->deskripsi;
            $get_data->harga_beli = str_replace(".","", str_replace(",", "", $req->harga_beli));
            $get_data->harga_jual = str_replace(".","", str_replace(",", "", $req->harga_jual));

            $get_data->is_promo = (null !== $req->is_promo ? 1 : 0);
            $get_data->value_promo = (null !== $req->is_promo ? $req->promo : 0);
            
            $get_data->is_new = $req->is_new;
            $get_data->stok = $req->stok;
            $get_data->berat_gram = $req->berat_gram;
            $get_data->status = $req->status;

            if($get_data->save()){
                Session::flash('success', 'Berhasil update data produk.');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal update data produk.');
                return redirect()->back();
            }

        }else{

            Session::flash('error', 'Gagal update data produk.');
            return redirect()->route('produk');

        }

    }

   
}
