<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', 'App\Http\Controllers\LandingController@index');
Route::get('landing/produk/{kategori?}', 'App\Http\Controllers\LandingController@semuaProduk');
Route::post('landing/produk/{kategori?}', 'App\Http\Controllers\LandingController@semuaProduk');

Route::get('landing/get_detail_product/{id}', 'App\Http\Controllers\LandingController@modalDetailProduct');
Route::get('landing/get_detail_product_keranjang/{id}', 'App\Http\Controllers\LandingController@modalDetailProductKeranjang');


Route::get('landing/produk/detail/{slug}/{id}', 'App\Http\Controllers\LandingController@detailProduct');

Route::get('customer/login', 'App\Http\Controllers\PembeliController@loginPembeli');
Route::post('customer/login', 'App\Http\Controllers\PembeliController@doLoginPembeli')->name('masuk-pembeli');
Route::get('customer/register', 'App\Http\Controllers\PembeliController@registerPembeli');
Route::post('customer/register', 'App\Http\Controllers\PembeliController@doRegisterPembeli')->name('daftar-pembeli');
Route::post('customer/add_keranjang', 'App\Http\Controllers\PembeliController@addKeranjang');
Route::post('customer/add_wishlist', 'App\Http\Controllers\PembeliController@addWishlist');
Route::post('customer/update_keranjang', 'App\Http\Controllers\PembeliController@updateKeranjang');
Route::post('customer/del_keranjang', 'App\Http\Controllers\PembeliController@deleteKeranjang');
Route::post('customer/del_wishlist', 'App\Http\Controllers\PembeliController@deleteWishlist');

Route::get('customer/keranjang', 'App\Http\Controllers\PembeliController@keranjang')->name('keranjang-belanja');

Route::get('customer/keranjang/checkout', 'App\Http\Controllers\PembeliController@checkoutKeranjang')->name('do-checkout');
Route::get('landing/cek_validasi_kupon/{kode}/{nominal}', 'App\Http\Controllers\LandingController@cekVoucher');
Route::get('customer/get_alamat/{id}', 'App\Http\Controllers\PembeliController@getAlamat');
Route::get('customer/get_kurir/{prov}/{kota}/{kec}/{berat}', 'App\Http\Controllers\PembeliController@getListKurir');
Route::post('customer/keranjang/checkout/validate', 'App\Http\Controllers\PembeliController@doCheckout')->name('exec-checkout');

Route::get('customer/akun/history_transaksi', 'App\Http\Controllers\PembeliController@historyTransaksi')->name('historyku');
Route::get('customer/akun/history_transaksi/{id}', 'App\Http\Controllers\PembeliController@detHistoryTransaksi');

Route::post('customer/akun/history_transaksi/upload_bukti', 'App\Http\Controllers\PembeliController@uploadBuktiTf')->name('upload-bukti-tf');
Route::post('customer/akun/history_transaksi/cancel_transaksi', 'App\Http\Controllers\PembeliController@cancelTransaksi');
Route::post('customer/akun/history_transaksi/selesaikan_transaksi', 'App\Http\Controllers\PembeliController@selesaikanTransaksi');

Route::get('customer/akun/history_transaksi/review/{trx}/{prod}', 'App\Http\Controllers\PembeliController@getFormReview');
Route::post('customer/akun/history_transaksi/review/simpan', 'App\Http\Controllers\PembeliController@simpanReview')->name('simpan-review');


Route::get('customer/akun/wishlist', 'App\Http\Controllers\PembeliController@wishlistku')->name('wishlistku');
Route::get('customer/akun/pengaturan', 'App\Http\Controllers\PembeliController@akunku')->name('akunku');
Route::get('customer/akun/pengaturan/alamat', 'App\Http\Controllers\PembeliController@pengaturanAlamat')->name('alamatku');

Route::get('landing/get_kota/{id}', 'App\Http\Controllers\LandingController@getKota');
Route::get('landing/get_kecamatan/{id}', 'App\Http\Controllers\LandingController@getKecamatan');

Route::post('customer/akun/simpan_alamat', 'App\Http\Controllers\PembeliController@saveAlamat');
Route::post('customer/akun/update_alamat', 'App\Http\Controllers\PembeliController@updateAlamat');
Route::post('customer/akun/alamat/ganti_utama', 'App\Http\Controllers\PembeliController@gantiAlamatUtama');
Route::post('customer/akun/alamat/hapus_alamat', 'App\Http\Controllers\PembeliController@hapusAlamat');
Route::get('customer/akun/pengaturan/alamat/edit/{id}', 'App\Http\Controllers\PembeliController@editAlamat');
Route::post('customer/akun/pengaturan/save_akun', 'App\Http\Controllers\PembeliController@saveAkun')->name('simpan-customer');
Route::get('customer/akun/logout', 'App\Http\Controllers\PembeliController@logout')->name('logout-customer');


// ANDMIN

Route::get('admin/login', 'App\Http\Controllers\AuthController@showFormLogin')->name('admin-login');
Route::post('admin/login', 'App\Http\Controllers\AuthController@login')->name('admin-login');

Route::group(['middleware' => 'auth'], function(){
	Route::get('logout', 'App\Http\Controllers\AuthController@logout')->name('logout');

	Route::get('admin', 'App\Http\Controllers\AdminController@index')->name('admin');
        Route::post('admin', 'App\Http\Controllers\AdminController@index');
	// Route::post('admin', 'App\Http\Controllers\AdminController@index')->name('dashboard-filter');

	// DASHBOARD

        // BANNER

        Route::get('master/banner', 'App\Http\Controllers\BannerController@index')->name('banner');
        Route::post('master/banner/simpan', 'App\Http\Controllers\BannerController@store')->name('simpan-banner');
        Route::post('master/banner/update', 'App\Http\Controllers\BannerController@update')->name('update-banner');
        Route::get('master/banner/edit/{id}', 'App\Http\Controllers\BannerController@edit');
        Route::get('master/banner/delete/{id}', 'App\Http\Controllers\BannerController@delete');

        // END OF BANNER

        // KODE PROMO

        Route::get('master/kode_promo', 'App\Http\Controllers\KodePromoController@index')->name('kode-promo');
        Route::post('master/kode_promo/simpan', 'App\Http\Controllers\KodePromoController@store')->name('simpan-kode-promo');
        Route::post('master/kode_promo/update', 'App\Http\Controllers\KodePromoController@update')->name('update-kode-promo');
        Route::get('master/kode_promo/edit/{id}', 'App\Http\Controllers\KodePromoController@edit');
        Route::get('master/kode_promo/delete/{id}', 'App\Http\Controllers\KodePromoController@delete');
        Route::get('master/kode_promo/detail/{id}', 'App\Http\Controllers\KodePromoController@detail');

        // END OF KODE PROMO
        
        // KATEGORI

        Route::get('master/kategori', 'App\Http\Controllers\KategoriController@index')->name('kategori');
        Route::post('master/kategori/simpan', 'App\Http\Controllers\KategoriController@store')->name('simpan-kategori');
        Route::post('master/kategori/update', 'App\Http\Controllers\KategoriController@update')->name('update-kategori');
        Route::get('master/kategori/edit/{id}', 'App\Http\Controllers\KategoriController@edit');
        Route::get('master/kategori/delete/{id}', 'App\Http\Controllers\KategoriController@delete');

        // END OF KATEGORI

        // REKENING

        Route::get('master/rekening', 'App\Http\Controllers\RekeningController@index')->name('rekening');
        Route::post('master/rekening/simpan', 'App\Http\Controllers\RekeningController@store')->name('simpan-rekening');
        Route::post('master/rekening/update', 'App\Http\Controllers\RekeningController@update')->name('update-rekening');
        Route::get('master/rekening/edit/{id}', 'App\Http\Controllers\RekeningController@edit');
        Route::get('master/rekening/delete/{id}', 'App\Http\Controllers\RekeningController@delete');

        // END OF REKENING

        // PRODUK

        Route::get('master/produk', 'App\Http\Controllers\ProdukController@index')->name('produk');
        Route::post('master/produk/simpan', 'App\Http\Controllers\ProdukController@store')->name('simpan-produk');
        Route::post('master/produk/update', 'App\Http\Controllers\ProdukController@update')->name('update-produk');
        Route::get('master/produk/detail/{id}', 'App\Http\Controllers\ProdukController@detail');
        Route::get('master/produk/delete/{id}', 'App\Http\Controllers\ProdukController@delete');
        Route::get('master/produk/edit/{id}', 'App\Http\Controllers\ProdukController@edit');

        // END OF PRODUK

        // TRANSAKSI / PESANAN

        Route::get('pesanan', 'App\Http\Controllers\PesananController@index')->name('data-pesanan');
        Route::post('pesanan', 'App\Http\Controllers\PesananController@index');
        Route::get('pesanan/detail/{id}', 'App\Http\Controllers\PesananController@detailTransaksi');
        Route::get('pesanan/ubah_status/{id}/{kode}/{noresi}', 'App\Http\Controllers\PesananController@ubahStatusTransaksi');

        // END OF TRANSAKSI / PESANAN

        // SYSTEM ROUTE

        Route::get('sys/admin', 'App\Http\Controllers\UserAdminController@index')->name('data-admin');
        Route::post('sys/admin/simpan', 'App\Http\Controllers\UserAdminController@store')->name('simpan-admin');
        Route::post('sys/admin/update', 'App\Http\Controllers\UserAdminController@update')->name('update-admin');
        Route::get('my_account', 'App\Http\Controllers\UserAdminController@myacc')->name('myacc');
        Route::post('sys/admin/my_acc/update', 'App\Http\Controllers\UserAdminController@myacc_update')->name('update-myacc');
        Route::get('sys/admin/delete/{id}', 'App\Http\Controllers\UserAdminController@delete');
        Route::get('sys/admin/edit/{id}', 'App\Http\Controllers\UserAdminController@edit');

        Route::get('sys/pembeli', 'App\Http\Controllers\UserPembeliController@index')->name('data-pembeli');
        Route::post('sys/pembeli/simpan', 'App\Http\Controllers\UserPembeliController@store')->name('simpan-pembeli');
        Route::post('sys/pembeli/update', 'App\Http\Controllers\UserPembeliController@update')->name('update-pembeli');
        Route::get('sys/pembeli/delete/{id}', 'App\Http\Controllers\UserPembeliController@delete');
        Route::get('sys/pembeli/edit/{id}', 'App\Http\Controllers\UserPembeliController@edit');

        // END OF SYSTEM ROUTE
    
	// END OF DASHBOARD
});