<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Pengumuman;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index(){
        return view('pengumuman.index');
    }
    public function hapus($id){
        $data=Pengumuman::where('id',$id)->delete();
        echo'ok';
    }

    public function simpan(request $request){
        if (trim($request->name) == '') {$error[] = '- Judul harus diisi';}
        if (trim($request->file) == '') {$error[] = '- Upload file';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
               
                $cek=explode('/',$_FILES['file']['type']);
                $file_tmp=$_FILES['file']['tmp_name'];
                $file=explode('.',$_FILES['file']['name']);
                $filename=date('Ymdhis').'.'.$file[1];
                $lokasi='_file_pengumuman/';
                

                if($cek[1]=='pdf'){
                    if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                        $data           = new Pengumuman;
                        $data->name     = $request->name;
                        $data->file     = $filename;
                        $data->ipeng_dt     = date('Y-m-d H:i:s');
                        $data->ipeng_regno  = Auth::user()['nik'];
                        $data->save();

                        if($data){
                            echo'ok';

                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                    }
                }else{
                    echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file Harus PDF</p>';
                }
               

                
            
        }
    }

    public function edit(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Judul harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
            if($request->jenis==1){
                if ($request->file == '') { 
                        $cekfile=Pengumuman::where('id',$id)->first();
                        if($cekfile['type']=='pdf'){
                            $data           = Pengumuman::find($id);
                            $data->unit_kerja_id     = $request->unit_kerja_id;
                            $data->isi     = $request->isi;
                            $data->jenis     = $request->jenis;
                            $data->name     = $request->name;
                            $data->waktu    = date('Y-m-d H:i:s');
                            $data->nik      = Auth::user()['nik'];
                            $data->save();

                            if($data){
                                echo'ok';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file lama anda harus dirubah ke PDF</p>';
                        }
                }
                else{
                        $cek=explode('/',$_FILES['file']['type']);
                        $file_tmp=$_FILES['file']['tmp_name'];
                        $file=explode('.',$_FILES['file']['name']);
                        $filename=$request->name.'.'.$file[1];
                        $lokasi='_file_pengumuman/';
                        

                        if($cek[1]=='pdf'){
                            if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                                $data->name     = $request->name;
                                $data->file     = $filename;
                                $data->ipeng_dt     = date('Y-m-d H:i:s');
                                $data->ipeng_regno  = Auth::user()['nik'];
                                $data->save();

                                if($data){
                                    echo'ok';

                                }
                            }else{
                                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file pdf</p>';
                        }
                    }
            }

            if($request->jenis==2){
                if($request->file==''){
                        $data           = Pengumuman::find($id);
                        $data->unit_kerja_id     = $request->unit_kerja_id;
                        $data->isi      = $request->isi;
                        $data->jenis    = $request->jenis;
                        $data->name     = $request->name;
                        $data->waktu    = date('Y-m-d H:i:s');
                        $data->nik      = Auth::user()['nik'];
                        $data->save();

                        if($data){
                            echo'ok';
                        }
                }else{
                    $cek=explode('/',$_FILES['file']['type']);
                    $file_tmp=$_FILES['file']['tmp_name'];
                    $file=explode('.',$_FILES['file']['name']);
                    $filename=$request->name.'.'.$file[1];
                    $lokasi='_file_pengumuman/';
                    

                    if($cek[0]=='application' || $cek[0]=='image'){
                        if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                            $data           = Pengumuman::find($id);
                            $data->unit_kerja_id     = $request->unit_kerja_id;
                            $data->isi     = $request->isi;
                            $data->jenis     = $request->jenis;
                            $data->name     = $request->name;
                            $data->waktu    = date('Y-m-d H:i:s');
                            $data->nik      = Auth::user()['nik'];
                            $data->file     = $filename;
                            $data->type     = $file[1];
                            $data->save();

                            if($data){
                                echo'ok';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file excel,doc,images</p>';
                    }
                }
            }
            
        }
    }
}
