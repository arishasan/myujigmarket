<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Validator;
use Session;
use Hash;
use File;
use Carbon\Carbon;
use DataTables;
use Illuminate\Support\Facades\DB;
use App\Models\HelperModel;
use App\Models\UserModel;

class UserAdminController extends Controller
{
    public function __construct(){

    }
    
    public function index(){
        $data = [
            'data_user' => UserModel::where('type', 'ADMIN')->get()
        ];
        return view('admin.system.admin.index')->with($data);
    }

    public function edit($id){
        $data = [
            'data_user' => UserModel::where(DB::raw('md5(id)'), $id)->first(),
        ];
        return view('admin.system.admin.edit')->with($data);
    }

    public function myacc(){
        $data = [
            'data_user' => Auth()->user(),
        ];
        return view('admin.system.admin.akun_saya')->with($data);
    }

    public function myacc_update(Request $req){

        try {
            
            $data = UserModel::find($req->id);

            if($data){

                $rules = [
                ];
                $messages = [
                ];

                if($data->username != $req->username){
                    $rules['username'] = 'required|unique:users,username';
                    $messages['username.unique'] = 'Username sudah digunakan!';
                }

                if($data->email != $req->email){
                    $rules['email'] = 'required|unique:users,email';
                    $messages['email.unique'] = 'Email sudah digunakan!';
                }

                if($req->password == null || $req->password == ""){}else{
                    $rules['password'] = 'required|min:6|confirmed';
                    $rules['password_confirmation'] = 'required|min:6';
                }

                $validator = Validator::make($req->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }
                
                $user = $data;
                $user->name = $req->nama;
                $user->username = $req->username;
                $user->email = $req->email;
                
                if($req->password == null || $req->password == ""){}else{
                    $user->password = Hash::make($req->password);
                }

                if($user->save()){
                    Session::flash('success', 'Berhasil mengubah data user admin!');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal mengubah data user admin!');
                    return redirect()->back();
                }
            }else{
                Session::flash('error', 'Data user admin tidak ditemukan!');
                return redirect()->route('admin');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Data user admin tidak ditemukan!');
            return redirect()->route('admin');
        }

    }

    public function store(Request $req){

        $rules = [
            'username' => 'required|unique:users,username',
            'email' => 'required|unique:users,email',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required|min:6'
        ];

        $messages = [
            'username.unique' => 'Username sudah digunakan!',
            'email.unique' => 'Email sudah digunakan!',
        ];

        $validator = Validator::make($req->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $user = new UserModel;
        $user->name = $req->nama;
        $user->username = $req->username;
        $user->email = $req->email;
        $user->password = Hash::make($req->password);
        $user->type = 'ADMIN';

        if($user->save()){
            Session::flash('success', 'Berhasil menambahkan admin baru!');
            return redirect()->route('data-admin');
        }else{
            Session::flash('error', 'Gagal menambahkan admin baru!');
            return redirect()->route('data-admin');
        }

    }

    public function update(Request $req){

        try {
            
            $data = UserModel::find($req->id);

            if($data){

                $rules = [
                ];
                $messages = [
                ];

                if($data->username != $req->username){
                    $rules['username'] = 'required|unique:users,username';
                    $messages['username.unique'] = 'Username sudah digunakan!';
                }

                if($data->email != $req->email){
                    $rules['email'] = 'required|unique:users,email';
                    $messages['email.unique'] = 'Email sudah digunakan!';
                }

                if($req->password == null || $req->password == ""){}else{
                    $rules['password'] = 'required|min:6|confirmed';
                    $rules['password_confirmation'] = 'required|min:6';
                }

                $validator = Validator::make($req->all(), $rules, $messages);

                if($validator->fails()){
                    return redirect()->back()->withErrors($validator)->withInput($req->all());
                }
                
                $user = $data;
                $user->name = $req->nama;
                $user->username = $req->username;
                $user->email = $req->email;
                
                if($req->password == null || $req->password == ""){}else{
                    $user->password = Hash::make($req->password);
                }

                if($user->save()){
                    Session::flash('success', 'Berhasil mengubah data admin!');
                    return redirect()->back();
                }else{
                    Session::flash('error', 'Gagal mengubah data admin!');
                    return redirect()->back();
                }
            }else{
                Session::flash('error', 'Data admin tidak ditemukan!');
                return redirect()->route('data-admin');
            }

        } catch (Exception $e) {
            Session::flash('error', 'Data admin tidak ditemukan!');
            return redirect()->route('data-admin');
        }

    }

    public function delete($id){

        if(md5(Auth()->user()->id) == $id){
            Session::flash('error', 'User sedang digunakan! tidak dapat dihapus.');
        }else{

            $user = UserModel::where(DB::raw('md5(id)'), $id);
            if($user->count() > 0){

                if($user->delete()){
                    Session::flash('success', 'Berhasil menghapus data user!');
                }else{
                    Session::flash('error', 'Gagal menghapus data user!');
                }


            }else{
                Session::flash('error', 'Gagal menghapus data user!');
            }
        }
        
    }

}
