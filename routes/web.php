<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::group(['middleware'    => 'auth'],function(){
    Route::get('/home', 'HomeController@index')->name('home');
    Route::get('/proses_turun', 'HomeController@proses_turun');
    
    Route::get('/pdf', 'HomeController@pdf')->name('pdf');
    

    Route::group(['prefix' => 'pengaturan'], function(){
        Route::get('/', 'PengaturanController@index')->name('pengaturan');
        Route::post('/simpan_foto/', 'PengaturanController@simpan_foto');
        
        
    });

    Route::group(['prefix' => 'aplikasi'], function(){
        Route::get('/', 'AplikasiController@index');
        
        Route::get('/hapus/{id}', 'AplikasiController@hapus');
        Route::post('/edit/{id}', 'AplikasiController@edit');
        Route::post('/simpan/faktur', 'AplikasiController@simpan');
        
        
    });

    Route::group(['prefix' => 'api'], function(){
        Route::get('/bttd/{bulan}/{tahun}', 'BttdController@api_index_bttd');
        Route::get('/bttd_admin/{bulan}/{tahun}', 'BttdController@api_index_bttd_admin');
        Route::get('/bttd_admin_diterima/{bulan}/{tahun}', 'BttdController@api_index_bttd_admin_diterima');
    });
    Route::group(['prefix' => 'bttd'], function(){
        Route::get('/', 'BttdController@index');
        Route::get('/non_faktur', 'BttdController@index_non');
        Route::get('/terima', 'BttdController@index_diterima');
        Route::get('/berita_acara/{mulai}/{sampai}/{group}', 'BttdController@excel_ba_bttd');
        Route::get('/pdf_berita_acara/{mulai}/{sampai}/{group}', 'BttdController@pdf_berita_acara');
        Route::get('/laporan', 'BttdController@index_laporan');
        Route::get('/tambah', 'BttdController@tambah');
        Route::get('/tambah_nonfaktur', 'BttdController@tambah_nonfaktur');
        Route::get('/cek_tagihan/{id}', 'BttdController@cek_tagihan');
        Route::get('/laporan_bttd/{id}', 'BttdController@laporan_bttd');
        Route::get('/hapus/{id}', 'BttdController@hapus');
        Route::get('/edit/{id}', 'BttdController@edit');
        Route::get('/edit_non_faktur/{id}', 'BttdController@edit_non_faktur');
        Route::post('/simpan/{act}', 'BttdController@simpan');
        Route::post('/simpan_edit/{act}/{id}', 'BttdController@simpan_edit');
        Route::post('/diterima/', 'BttdController@diterima');
        Route::post('/dikirim/{role_id}', 'BttdController@dikirim');
        
        
    });

    Route::group(['prefix' => 'inews'], function(){
        Route::get('/', 'InewsController@index');
        Route::get('/hapus/{id}', 'InewsController@hapus');
        Route::post('/edit/{id}', 'InewsController@edit');
        Route::post('/simpan/', 'InewsController@simpan');
        
        
    });

    Route::group(['prefix' => 'pengumuman'], function(){
        Route::get('/', 'PengumumanController@index');
        Route::get('/hapus/{id}', 'PengumumanController@hapus');
        Route::post('/edit/{id}', 'PengumumanController@edit');
        Route::post('/simpan/', 'PengumumanController@simpan');
    });

    Route::group(['prefix' => 'vendor'], function(){
        Route::get('/', 'VendorController@index');
        Route::get('/rekening/{id}', 'VendorController@rekening');
        Route::get('/view_rekening/{id}', 'VendorController@view_rekening');
        Route::get('/api', 'VendorController@api');
        Route::get('/hapus/{id}', 'VendorController@hapus');
        Route::post('/edit/{id}', 'VendorController@edit');
        Route::post('/simpan_rekening/{id}', 'VendorController@simpan_rekening');
    });

    Route::group(['prefix' => 'bukti'], function(){
        Route::get('/', 'BuktipotongController@index');
        Route::get('/import_pph', 'BuktipotongController@index_import_pph');
        Route::get('/import_ppn', 'BuktipotongController@index_import_ppn');
        Route::get('/ppn', 'BuktipotongController@index_ppn');
        Route::get('/api', 'BuktipotongController@api');
        Route::get('/api_ppn', 'BuktipotongController@api_ppn');
        Route::get('/api_view/{id}', 'BuktipotongController@api_view');
        Route::get('/api_import_pph/', 'BuktipotongController@api_import_pph');
        Route::get('/api_import_ppn/', 'BuktipotongController@api_import_ppn');
        Route::get('/api_view_ppn/{id}', 'BuktipotongController@api_view_ppn');
        Route::get('/hapus/{id}', 'BuktipotongController@hapus');
        Route::get('/cetak_ppn/{id}', 'BuktipotongController@cetak_ppn');
        Route::get('/cetak/{id}', 'BuktipotongController@cetak');
        Route::get('/ppn_view/{id}', 'BuktipotongController@ppn_view');
        Route::get('/pph_view/{id}', 'BuktipotongController@pph_view');
        Route::post('/edit/{id}', 'BuktipotongController@edit');
        Route::post('/proses_import_pph/', 'BuktipotongController@proses_import_pph');
        Route::post('/simpan_proses/{id}', 'BuktipotongController@simpan_proses');
        Route::post('/simpan_proses_pph/{id}', 'BuktipotongController@simpan_proses_pph');
        Route::post('/simpan_proses_ppn/{id}', 'BuktipotongController@simpan_proses_ppn');
    });

    Route::group(['prefix' => 'tagihan'], function(){
        Route::get('/', 'TagihanController@index');
        Route::get('/detail/{id}', 'TagihanController@index_detail');
        Route::get('/hapus/{id}', 'TagihanController@hapus');
        Route::get('/hapus_detail/{id}', 'TagihanController@hapus_detail');
        Route::post('/edit/{id}', 'TagihanController@edit');
        Route::post('tagihan_detil/edit/{id}', 'TagihanController@edit_detail');
        Route::post('tagihan_detil/simpan/{id}', 'TagihanController@simpan_detail');
        Route::post('/simpan/', 'TagihanController@simpan');
    });

    Route::group(['prefix' => 'cuti'], function(){
        Route::get('/', 'CutiController@index');
        Route::get('/admin', 'CutiController@index_admin');
        Route::get('/validasi_all', 'CutiController@validasi_all');
        Route::get('/tolak_validasi_all', 'CutiController@tolak_validasi_all');
        Route::get('/acc', 'CutiController@index_acc');
        Route::get('/persetujuan', 'CutiController@index_persetujuan');
        Route::get('/persetujuan_selesai', 'CutiController@index_persetujuan_selesai');
        Route::get('/hapus/{id}', 'CutiController@hapus');
        Route::post('/edit/{id}', 'CutiController@edit');
        Route::post('/simpan/', 'CutiController@simpan');
        Route::post('/validasi_data/{id}', 'CutiController@validasi');
        
        
    });
    
    Route::group(['prefix' => 'user'], function(){
        Route::get('/', 'UserController@index');
        Route::get('/akses', 'UserController@index_akses');
        Route::get('/api/{id}', 'UserController@api');
        Route::get('/hapus/{id}', 'UserController@hapus');
        Route::get('/ubah/{id}', 'UserController@ubah');
        Route::post('/edit/{id}', 'UserController@edit');
        Route::post('/simpan/', 'UserController@simpan');
        Route::post('/import_data/', 'UserController@import_data');
        Route::post('/simpan_akses/{id}', 'UserController@simpan_akses');
        
    });
});

