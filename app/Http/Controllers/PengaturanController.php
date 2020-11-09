<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengaturan;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengaturanController extends Controller
{
    public function index(request $request){
        error_reporting(0);
        if($request->active==''){
            $active='datadiri';
        }else{
            $active=$request->active;
        }
        return view('pengaturan',compact('active'));
    }
    public function hapus($id){
        $data=Aplikasi::where('id',$id)->delete();
        echo'ok';
    }

    public function simpan_foto(request $request){
        if (trim($request->foto) == '') {$error[] = '- Upload foto profil';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cekdata=Pengaturan::where('nik',Auth::user()['nik'])->where('name','foto')->count();
            $cek=explode('/',$_FILES['foto']['type']);
            $file_tmp=$_FILES['foto']['tmp_name'];
            $file=explode('.',$_FILES['foto']['name']);
            $filename=Auth::user()['nik'].'.'.$file[1];
            $lokasi='_file_upload/';


            if($cekdata==0){
                if($cek[0]=='image'){
                    if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                        $data           = new Pengaturan;
                        $data->nik      = Auth::user()['nik'];
                        $data->name     = 'foto';
                        $data->value    = $filename;
                        $data->save();

                        if($data){
                            echo'ok';
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                    }
                }else{
                    echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus gambar</p>';
                }
            }

            if($cekdata>0){
                if($cek[0]=='image'){
                    if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                        $data           = Pengaturan::where('nik',Auth::user()['nik'])->where('name','foto')->first();
                        $data->value    = $filename;
                        $data->save();

                        if($data){
                            echo'ok';
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                    }
                }else{
                    echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus gambar</p>';
                }
            }
            
            
        }
    }

    public function edit(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama aplikasi harus diisi';}
        if (trim($request->singkatan) == '') {$error[] = '- Singkatan harus diisi';} 
        if (trim($request->link) == '') {$error[] = '- Link/Url harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
                if($request->icon==''){
                    $data           = Aplikasi::find($id);
                    $data->name     = $request->name;
                    $data->singkatan     = $request->singkatan;
                    $data->php_versi_id     = $request->php_versi_id;
                    $data->link     = $request->link;
                    $data->save();

                    if($data){
                        echo'ok';
                    }
                }else{
                    $cek=explode('/',$_FILES['icon']['type']);
                    $file_tmp=$_FILES['icon']['tmp_name'];
                    $file=explode('.',$_FILES['icon']['name']);
                    $filename=md5(date('Ymdhis')).'.'.$file[1];
                    $lokasi='_file_upload/';
    
    
                    if($cek[0]=='image'){
                        if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                            $data           = Aplikasi::find($id);
                            $data->name     = $request->name;
                            $data->singkatan     = $request->singkatan;
                            $data->php_versi_id     = $request->php_versi_id;
                            $data->link     = $request->link;
                            $data->icon     = $filename;
                            $data->save();
    
                            if($data){
                                echo'ok';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus gambar</p>';
                    }
                }
            
        }
    }
}
