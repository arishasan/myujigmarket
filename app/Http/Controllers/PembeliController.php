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
use App\Models\ReviewModel;

class PembeliController extends Controller
{	
	public function __construct(){

	}
    
    public function loginPembeli(){

        $data = array();
        return view('landing.pembeli.login')->with($data);
        
    }

    public function keranjang(){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $qKeranjang = KeranjangModel::select(
            DB::raw('keranjang.*, 
            produk.nama_produk, 
            produk.image, 
            produk.slug, 
            produk.deskripsi, 
            produk.harga_jual, 
            produk.is_promo,
            produk.value_promo,
            produk.stok,
            produk.berat_gram
            '))
            ->leftJoin('produk', 'produk.id','=','keranjang.id_produk')
            ->where('keranjang.id_user', Session::get('sess_id'))
            ->get();

        $data = array(
            'produk' => $qKeranjang,
        );
        return view('landing.pembeli.keranjang')->with($data);

    }

    public function checkoutKeranjang(){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $qKeranjang = KeranjangModel::select(
            DB::raw('keranjang.*, 
            produk.nama_produk, 
            produk.image, 
            produk.slug, 
            produk.deskripsi, 
            produk.harga_jual, 
            produk.is_promo,
            produk.value_promo,
            produk.stok,
            produk.berat_gram
            '))
            ->leftJoin('produk', 'produk.id','=','keranjang.id_produk')
            ->where('keranjang.id_user', Session::get('sess_id'))
            ->get();

        $peringatan = [];

        if(count($qKeranjang) > 0){}else{
            Session::flash('error', 'Tidak ada yang diproses!');
            return redirect()->back();
        }

        foreach ($qKeranjang as $key => $value) {
            
            if($value->qty > $value->stok){
                array_push($peringatan, 'QTY yang dipesan untuk produk <b><i>'.$value->nama_produk.'</i></b> sebanyak ('.$value->qty.') melebihi Stok yang tersedia ('.$value->stok.')');
            }

        }

        if(count($peringatan) > 0){
            Session::flash('peringatan', $peringatan);
            return redirect('customer/keranjang');
        }

        $cek_alamat = AlamatModel::where('id_user', Session::get('sess_id'))->count();
        if($cek_alamat == 0){
            Session::flash('error', 'Anda belum menambahkan alamat pengiriman di akun anda!');
            return redirect()->back();
        }

        $data = array(
            'produk' => $qKeranjang,
            'alamat_utama' => AlamatModel::where('id_user', Session::get('sess_id'))->where('is_alamat_utama', 1)->first(),
            'alamat' => AlamatModel::where('id_user', Session::get('sess_id'))->get()
        );
        return view('landing.pembeli.keranjang_checkout')->with($data);

    }

    public function wishlistku(){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $qWishlist = WishlistModel::select(
            DB::raw('wishlist.*, 
            produk.nama_produk, 
            produk.image, 
            produk.slug, 
            produk.deskripsi, 
            produk.harga_jual, 
            produk.is_promo,
            produk.value_promo,
            produk.stok,
            produk.berat_gram
            '))
            ->leftJoin('produk', 'produk.id','=','wishlist.id_produk')
            ->where('wishlist.id_user', Session::get('sess_id'))
            ->get();

        $data = array(
            'produk' => $qWishlist,
        );
        return view('landing.pembeli.wishlist')->with($data);

    }

    public function akunku(){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $data = array(
            'user' => Session::get('sess_user')
        );
        return view('landing.pembeli.akunku')->with($data);

    }

    public function pengaturanAlamat(){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $data = array(
            'alamat' => AlamatModel::where('id_user', Session::get('sess_id'))->get(),
            'prov' => ProvinsiModel::all(),
        );
        return view('landing.pembeli.alamatku')->with($data);

    }

    public function editAlamat($mdID){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $alamat = AlamatModel::where(DB::raw('md5(id)'), $mdID)->first();

        if($alamat){}else{
            return redirect()->route('alamatku');
        }

        $data = array(
            'alamat' => $alamat,
            'prov' => ProvinsiModel::all(),
            'kota' => KotaModel::where('province_id', $alamat->provinsi)->get(),
            'kecamatan' => KecamatanModel::where('city_id', $alamat->kota)->get(),
        );
        return view('landing.pembeli.alamatku_edit')->with($data);

    }

    public function gantiAlamatUtama(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $alamat = AlamatModel::find($req->id);
        
        if($alamat){
            $alamat->is_alamat_utama = 1;
            $ubah = AlamatModel::where('id_user', Session::get('sess_id'))->where('is_alamat_utama', 1)->get();
            foreach ($ubah as $key => $value) {
                $temp = AlamatModel::find($value->id);
                if($temp){
                    $temp->is_alamat_utama = 0;
                    $temp->save();
                }
            }

            if($alamat->save()){
                echo "yes";
            }else{
                echo "Gagal menyimpan perubahan alamat utama.";
            }
        }else{
            echo "Tidak menemukan data alamat.";
        }

    }

    public function hapusAlamat(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $alamat = AlamatModel::find($req->id);
        
        if($alamat){
            if($alamat->delete()){
                echo "yes";
            }else{
                echo "Gagal menghapus data alamat.";
            }
        }else{
            echo "Tidak menemukan data alamat.";
        }

    }

    public function saveAlamat(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $alamat = new AlamatModel;
        $alamat->label = $req->label;
        $alamat->kode_pos = $req->kode_pos;
        $alamat->alamat = $req->alamat;
        $alamat->provinsi = $req->provinsi;
        $alamat->kota = $req->kota;
        $alamat->kecamatan = $req->kecamatan;
        $alamat->id_user = Session::get('sess_id');
        $alamat->is_alamat_utama = $req->alamat_utama;
        $alamat->penerima = $req->penerima;
        $alamat->no_hp = $req->no_hp;

        if($req->alamat_utama == 1){

            $ubah = AlamatModel::where('id_user', Session::get('sess_id'))->where('is_alamat_utama', 1)->get();
            foreach ($ubah as $key => $value) {
                $temp = AlamatModel::find($value->id);
                if($temp){
                    $temp->is_alamat_utama = 0;
                    $temp->save();
                }
            }

        }

        if($alamat->save()){
            Session::flash('success', 'Berhasil menambahkan alamat baru.');
            return redirect()->back();
        }else{
            Session::flash('error', 'Gagal menambahkan alamat baru!');
            return redirect()->back();
        }

    }

    public function updateAlamat(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }

        $alamat = AlamatModel::find($req->id);

        $alamat->label = $req->label;
        $alamat->kode_pos = $req->kode_pos;
        $alamat->alamat = $req->alamat;
        $alamat->provinsi = $req->provinsi;
        $alamat->kota = $req->kota;
        $alamat->kecamatan = $req->kecamatan;
        $alamat->penerima = $req->penerima;
        $alamat->no_hp = $req->no_hp;
        
        if($req->alamat_utama == $alamat->is_alamat_utama){}else{
            $ubah = AlamatModel::where('id_user', Session::get('sess_id'))->where('is_alamat_utama', 1)->get();
            foreach ($ubah as $key => $value) {
                $temp = AlamatModel::find($value->id);
                if($temp){
                    $temp->is_alamat_utama = 0;
                    $temp->save();
                }
            }
        }

        $alamat->is_alamat_utama = $req->alamat_utama;

        if($alamat->save()){
            Session::flash('success', 'Berhasil mengupdate alamat.');
            return redirect()->back();
        }else{
            Session::flash('error', 'Gagal mengupdate alamat!');
            return redirect()->back();
        }

    }

    public function getAlamat($id){

        $alamat_utama = AlamatModel::find($id);
        if($alamat_utama){
            
            echo "<b>".$alamat_utama->label."</b><br/>";
            echo "<small>".$alamat_utama->alamat."</small><br/>";
            echo "<small><b>Penerima:</b> ".$alamat_utama->penerima."</small> <br/>";
            echo "<small><b>No. HP:</b> ".$alamat_utama->no_hp."</small>";
            echo "<br/>";
            echo "<small>".
            "<b>Provinsi: </b>". HelperModel::getAlamat($alamat_utama->provinsi, 'prov') .', '.
            '<b>Kota: </b>'. HelperModel::getAlamat($alamat_utama->kota, 'kota') .', '.
            '<b>Kecamatan: </b>'. HelperModel::getAlamat($alamat_utama->kecamatan, 'kec') .', '. 
            '<b>Kode Pos: </b>'. $alamat_utama->kode_pos.
            "</small>";

        }else{
            echo "Gagal menampilkan detail.";
        }

    }

    public function saveAkun(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
            // return;
        }
        
        $data = UserModel::find(Session::get('sess_id'));

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
                Session::put('sess_id', $user->id);
                Session::put('sess_nama', $user->name);
                Session::put('sess_user', $user);
                Session::flash('success', 'Berhasil mengubah data user!');
                return redirect()->back();
            }else{
                Session::flash('error', 'Gagal mengubah data user!');
                return redirect()->back();
            }
        }else{
            Session::flash('error', 'Data user tidak ditemukan!');
            return redirect('customer/login');
        }

    }

    public function doLoginPembeli(Request $req){

        $rules = [
            'username' => 'required',
            'password' => 'required',
        ];

        $validator = Validator::make($req->all(), $rules);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($req->all());
        }

        $uname = $req->username;
        $pas = $req->password;

        $validateUser = UserModel::where('type','PEMBELI')->where('username', $uname);
        if($validateUser->count() > 0){

            $dataUser = $validateUser->first();
            
            if(Hash::check($pas, $dataUser->password)) {
                
                Session::put('sess_id', $dataUser->id);
                Session::put('sess_nama', $dataUser->name);
                Session::put('sess_user', $dataUser);
                Session::put('is_pembeli_login', true);
                return redirect('/');

            }else{

                Session::flash('error', 'Password yang anda masukkan salah.');
                return redirect('customer/login');

            }   

        }else{

            Session::flash('error', 'User dengan username tersebut tidak ditemukan.');
            return redirect('customer/login');

        }

    }

    public function registerPembeli(){
        $data = array();
        return view('landing.pembeli.register')->with($data);
    }

    public function doRegisterPembeli(Request $req){

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
        $user->type = 'PEMBELI';

        if($user->save()){
            Session::flash('success', 'Berhasil mendaftarkan akun anda! Silahkan login untuk memulai sesi.');
            return redirect('customer/login');
        }else{
            Session::flash('error', 'Gagal mendaftarkan akun anda!');
            return redirect('customer/register');
        }

    }

    public function addKeranjang(Request $req){

        if (Session::get('is_pembeli_login')) {
            
            $produk = ProdukModel::find($req->id);
            if($produk){

                if($req->qty <= 0){
                    echo "QTY tidak boleh 0 atau kurang dari 0.";
                    exit();
                }

                if($req->qty > $produk->stok){
                    echo "QTY yang ditentukan melebihi stok yang tersedia.";
                }else{
                    
                    $usr = Session::get('sess_id');
                    $checkKeranjang = KeranjangModel::where('id_user', $usr)->where('id_produk', $req->id);
                    if($checkKeranjang->count() > 0){
                        
                        $exist = $checkKeranjang->first();

                        $tambah_qty = $exist->qty + $req->qty;
                        if($tambah_qty > $produk->stok){
                            echo "QTY yang ditambahkan melebihi stok yang tersedia.";
                            exit();
                        }
                        
                        $exist->qty = $tambah_qty;
                        $exist->catatan = $req->catatan;
                        if($exist->save()){
                            echo "yes";
                        }else{
                            echo "Gagal menambahkan produk kedalam keranjang.";
                        }

                    }else{

                        $new = new KeranjangModel;
                        $new->id_user = $usr;
                        $new->id_produk = $req->id;
                        $new->qty = $req->qty;
                        $new->catatan = $req->catatan;
                        
                        if($new->save()){
                            echo "yes";
                        }else{
                            echo "Gagal menambahkan produk kedalam keranjang.";
                        }

                    }

                }

            }else{
                echo 'Produk tidak ditemukan, silahkan ulangi lagi.';
            }

        }else{
            echo 'login';
        }

    }

    public function addWishlist(Request $req){

        if (Session::get('is_pembeli_login')) {
            
            $usr = Session::get('sess_id');
            $checkWishlist = WishlistModel::where('id_user', $usr)->where('id_produk', $req->id);
            if($checkWishlist->count() > 0){
                
                $exist = $checkWishlist->first();
                $exist->delete();
                echo "del";

            }else{

                $new = new WishlistModel;
                $new->id_user = $usr;
                $new->id_produk = $req->id;
                $new->save();
                echo "yes";

            }

        }else{
            echo 'login';
        }

    }

    public function deleteWishlist(Request $req){

        $qWishlist = WishlistModel::find($req->id);
        if($qWishlist){
            
            if($qWishlist->delete()){
                echo "del";
            }else{
                echo "Gagal menghapus produk dari wishlist.";
            }

        }else{

            echo "Produk tidak ditemukan dalam wishlist.";

        }

    }

    public function deleteKeranjang(Request $req){

        $qKeranjang = KeranjangModel::find($req->id);
        if($qKeranjang){
            
            if($qKeranjang->delete()){
                echo "del";
            }else{
                echo "Gagal menghapus produk dari keranjang belanja.";
            }

        }else{

            echo "Produk tidak ditemukan dalam keranjang belanja.";

        }

    }

    public function updateKeranjang(Request $req){

        if (Session::get('is_pembeli_login')) {
            
            $qKeranjang = KeranjangModel::find($req->id);
            if($qKeranjang){}else{
                echo "Item keranjang tidak ditemukan.";
                exit();
            }

            $produk = ProdukModel::find($qKeranjang->id_produk);
            if($produk){

                if($req->qty <= 0){
                    echo "QTY tidak boleh 0 atau kurang dari 0.";
                    exit();
                }

                if($req->qty > $produk->stok){
                    echo "QTY yang ditentukan melebihi stok yang tersedia.";
                }else{
                    
                    $qKeranjang->qty = $req->qty;
                    $qKeranjang->catatan = $req->catatan;
                    if($qKeranjang->save()){
                        echo "yes";
                    }else{
                        echo "Gagal mengupdate keranjang belanja.";
                    }

                }

            }else{
                echo 'Produk tidak ditemukan, silahkan ulangi lagi.';
            }

        }else{
            echo 'login';
        }

    }

    public function logout(){

        Session::forget('sess_id');
        Session::forget('sess_nama');
        Session::forget('sess_user');
        Session::forget('is_pembeli_login');
        return redirect('/');

    }

    public function getListKurir($prov, $kota, $kec, $berat){

        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.rajaongkir.com/starter/cost",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "POST",
        CURLOPT_POSTFIELDS => "origin=152&destination=".$kota."&weight=".$berat."&courier=jne",
        CURLOPT_HTTPHEADER => array(
            "content-type: application/x-www-form-urlencoded",
            "key: abc7e9c6e198f02125c36a31f61906e1"
        ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        $ret = [];
        $temp = [];

        if ($err) {
            echo "fail";
            exit();
        } else {
            
            $temp = json_decode($response);
            foreach ($temp->rajaongkir->results as $key => $value) {
                
                foreach($value->costs as $k2 => $v2){
                    
                    foreach($v2->cost as $k3 => $v3){
                        $arr = [
                            'channel' => $value->code,
                            'service' => $v2->service,
                            'desc' => $v2->description,
                            'value' => $v3->value,
                            'est' => $v3->etd
                        ];
                        array_push($ret, $arr);
                    }

                }

            }
            echo json_encode($ret);

        }

    }

    public function doCheckout(Request $req){
        
        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

        $qKeranjang = KeranjangModel::select(
            DB::raw('keranjang.*, 
            produk.nama_produk, 
            produk.image, 
            produk.slug, 
            produk.deskripsi, 
            produk.harga_jual, 
            produk.is_promo,
            produk.value_promo,
            produk.stok,
            produk.berat_gram
            '))
            ->leftJoin('produk', 'produk.id','=','keranjang.id_produk')
            ->where('keranjang.id_user', Session::get('sess_id'))
            ->get();

        $peringatan = [];

        if(count($qKeranjang) > 0){}else{
            Session::flash('error', 'Tidak ada yang diproses!');
            return redirect('customer/keranjang');
        }

        foreach ($qKeranjang as $key => $value) {
            
            if($value->qty > $value->stok){
                array_push($peringatan, 'QTY yang dipesan untuk produk <b><i>'.$value->nama_produk.'</i></b> sebanyak ('.$value->qty.') melebihi Stok yang tersedia ('.$value->stok.')');
            }

        }

        if(count($peringatan) > 0){
            Session::flash('peringatan', $peringatan);
            return redirect('customer/keranjang');
        }
        
        $kode_trx = TransaksiModel::generate_kode();

        $stat = '';

        if($req->metode_bayar == 'TRANSFER'){
            $stat = 'MENUNGGU_PEMBAYARAN';
        }else if($req->metode_bayar == 'DATANG_LANGSUNG'){
            $stat = 'MENUNGGU_KONFIRMASI';
        }else{
            $stat = 'MENUNGGU_KONFIRMASI';
        }

        $trx = new TransaksiModel;
        $trx->id_user = Session::get('sess_id');
        $trx->tgl_transaksi = date('Y-m-d');
        $trx->kode_transaksi = $kode_trx;
        $trx->total_tagihan_produk = $req->sum_keranjang;
        $trx->berat_produk_total = $req->berat_total;
        $trx->kurir_pilihan = $req->kurir_pilihan;
        $trx->kode_promo = ($req->diskon_voucher > 0 ? $req->kupon : null);
        $trx->total_ongkir = ($req->metode_bayar == 'DATANG_LANGSUNG' ? 0 : $req->total_ongkir);
        $trx->nominal_promo = $req->diskon_voucher;
        $trx->total_transaksi = $req->total_bayar_all;
        $trx->metode_bayar = $req->metode_bayar;
        $trx->status = $stat;
        $trx->provinsi = $req->id_prov;
        $trx->kota = $req->id_kota;
        $trx->kecamatan = $req->id_kec;
        $trx->kode_pos = AlamatModel::find($req->id_alamat)->kode_pos ?? '';
        $trx->alamat_lengkap = AlamatModel::find($req->id_alamat)->alamat ?? '';
        $trx->no_hp = AlamatModel::find($req->id_alamat)->no_hp ?? '';
        $trx->penerima = AlamatModel::find($req->id_alamat)->penerima ?? '';
        
        if($req->metode_bayar == 'TRANSFER'){
            $trx->limit_datetime = date('Y-m-d H:i:s', strtotime('+1 day'));
        }

        if($trx->save()){
            
            if($req->diskon_voucher > 0){
                if($req->kupon != '' || $req->kupon != null){
                    $dPromo = KodePromoModel::where('kode_promo', $req->kupon)->first();
                    if($dPromo){
                        $dPromo->quota = $dPromo->quota - 1;
                        $dPromo->save();
                    }
                }
            }

            $last_id = $trx->id;
            foreach ($qKeranjang as $key => $value) {
                
                $item = KeranjangModel::find($value->id);

                $hsatuan = HelperModel::getFinalPrice($value->is_promo, $value->harga_jual, $value->value_promo);
                $det = new TransaksiDetailModel;
                $det->id_transaksi = $last_id;
                $det->id_produk = $value->id_produk;
                $det->harga_satuan = $hsatuan;
                $det->berat_satuan = $value->berat_gram;
                $det->qty = $value->qty;
                $det->total = $hsatuan * $value->qty;
                $det->catatan = $value->catatan;
                $det->save();

                // UPDATE STOK

                $prod = ProdukModel::find($value->id_produk);
                $prod->stok = ($prod->stok - $value->qty);
                $prod->save();

                // END OF UPDATE STOK

                $item->delete();

            }

            Session::flash('success', 'Berhasil melakukan checkout!');
            return redirect('customer/akun/history_transaksi/'.md5($last_id));

        }else{

            Session::flash('error', 'Gagal melakukan checkout!');
            return redirect('customer/keranjang');

        }

    }

    public function historyTransaksi(){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

        $query = TransaksiModel::where('id_user', Session::get('sess_id'));
        $query2 = TransaksiModel::where('id_user', Session::get('sess_id'));
        $query3 = TransaksiModel::where('id_user', Session::get('sess_id'));
        $query4 = TransaksiModel::where('id_user', Session::get('sess_id'));
        $query5 = TransaksiModel::where('id_user', Session::get('sess_id'));
        $query6 = TransaksiModel::where('id_user', Session::get('sess_id'));

        $data = array(
            'menunggu_pembayaran' => $query->where('status', 'MENUNGGU_PEMBAYARAN')->get(),
            'menunggu_konfirmasi' => $query2->where('status', 'MENUNGGU_KONFIRMASI')->get(),
            'diproses' => $query3->where('status', 'DIPROSES')->get(),
            'dikirim' => $query4->where('status', 'DIKIRIM')->get(),
            'selesai' => $query5->where('status', 'SELESAI')->get(),
            'cancel' => $query6->where('status', 'CANCEL')->get(),
        );
        return view('landing.pembeli.history_transaksi')->with($data);

    }

    public function detHistoryTransaksi($md5){
        
        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

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
        return view('landing.pembeli.detail_transaksi')->with($data);

    }

    public function uploadBuktiTf(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

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

        $location = public_path('/uploads/bukti_tf');

        $trx = TransaksiModel::find($req->id_transaksi);

        $url_foto = '';
        
        if($req->foto){

            $imageName = 'BUKTI_TF_'.md5($req->id_transaksi).'.'.$req->foto->getClientOriginalExtension();
            File::copy($req->foto, $location.'/'.$imageName);
            $url_foto = 'uploads/bukti_tf/'.$imageName;

        }else{
            $url_foto = 'assets/noimage.png';
        }

        $trx->bukti_tf = $url_foto;
        $trx->rekening_tf = $req->rekening_tujuan;
        $trx->status = 'MENUNGGU_KONFIRMASI';

        if($trx->save()){
            Session::flash('success', 'Berhasil mengupload bukti transfer.');
            return redirect('customer/akun/history_transaksi/'.md5($req->id_transaksi));
        }else{
            Session::flash('error', 'Gagal mengupload bukti transfer, silahkan ulangi lagi.');
            return redirect('customer/akun/history_transaksi/'.md5($req->id_transaksi));
        }

    }

    public function cancelTransaksi(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

        try {
            
            $transaksi = TransaksiModel::find($req->id);
            $transaksi->status = 'CANCEL';
            $transaksi->save();

            $detail = TransaksiDetailModel::where('id_transaksi', $req->id)->get();
            foreach ($detail as $key => $value) {
                
                $cek = ProdukModel::find($value->id_produk);
                if($cek){
                    $cek->stok = $cek->stok + $value->qty;
                    $cek->save();
                }

            }

            Session::flash('success', 'Berhasil melakukan pembatalan pesanan.');
            // return redirect()->route('historyku');

        } catch (\Throwable $th) {
            Session::flash('error', 'Terjadi kesalahan saat pembatalan pesanan, silahkan ulangi lagi.');
            // return redirect()->route('historyku');
        }

    }

    public function selesaikanTransaksi(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

        try {
            
            $transaksi = TransaksiModel::find($req->id);
            $transaksi->status = 'SELESAI';
            $transaksi->save();

            $detail = TransaksiDetailModel::where('id_transaksi', $req->id)->get();
            foreach ($detail as $key => $value) {
                
                $cek = ProdukModel::find($value->id_produk);
                if($cek){
                    $cek->stok = $cek->stok + $value->qty;
                    $cek->save();
                }

            }

            Session::flash('success', 'Berhasil melakukan penyelesaian pesanan.');
            // return redirect()->route('historyku');

        } catch (\Throwable $th) {
            Session::flash('error', 'Terjadi kesalahan saat menyelesaikan pesanan, silahkan ulangi lagi.');
            // return redirect()->route('historyku');
        }

    }

    public function getFormReview($trx, $prod){
        
        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

        $query = ReviewModel::where('id_transaksi', $trx)->where('id_produk', $prod)->where('id_user', Session::get('sess_id'))->first();
        $data = array(
            'review' => $query,
            'is_new' => $query->id ?? 'new',
            'produk' => ProdukModel::find($prod),
            'trx' => $trx,
            'prod' => $prod
        );

        return view('landing.pembeli.form_review')->with($data);

    }

    public function simpanReview(Request $req){

        if (Session::get('is_pembeli_login')) {}else{
            return redirect('customer/login');
        }

        $is_new = $req->id_review;

        if($is_new == 'new'){

            $review = new ReviewModel;
            $review->id_transaksi = $req->transaksi_id;
            $review->id_produk = $req->produk_id;
            $review->id_user = Session::get('sess_id');
            $review->rate = $req->rating ?? 1;
            $review->catatan = $req->catatan;

        }else{

            $review = ReviewModel::find($is_new);
            $review->rate = $req->rating ?? 1;
            $review->catatan = $req->catatan;
            
        }

        if($review->save()){
            Session::flash('success', 'Berhasil menyimpan review produk!');
            return redirect('customer/akun/history_transaksi/'.md5($req->transaksi_id));
        }else{
            Session::flash('error', 'Gagal menyimpan review produk!');
            return redirect('customer/akun/history_transaksi/'.md5($req->transaksi_id));
        }

    }

}
