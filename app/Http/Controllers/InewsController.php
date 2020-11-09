<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inews;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InewsController extends Controller
{
    public function index(){
        return view('inews.index');
    }
    public function hapus($id){
        $data=Inews::where('id',$id)->delete();
        echo'ok';
    }

    public function simpan(request $request){
        if (trim($request->name) == '') {$error[] = '- Judul harus diisi';}
        if (trim($request->file) == '') {$error[] = '- Lampiran PDF harus diisi';} 
        if (trim($request->background) == '') {$error[] = '- Background harus diisi';} 
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $cek=explode('/',$_FILES['file']['type']);
            $file_tmp=$_FILES['file']['tmp_name'];
            $file=explode('.',$_FILES['file']['name']);
            $filename=$request->name.'.'.$cek[1];
            $lokasi='_file_inews/';

            $ceks=explode('/',$_FILES['background']['type']);
            $files_tmp=$_FILES['background']['tmp_name'];
            $files=explode('.',$_FILES['background']['name']);
            $filenames='BG'.$request->name.'.'.$ceks[1];
            $lokasis='_file_inews/';


            if($ceks[0]=='image'){
                if($cek[1]=='pdf'){
                    if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                        move_uploaded_file($files_tmp, $lokasis.$filenames);

                        $data           = new Inews;
                        $data->name     = $request->name;
                        $data->waktu    = date('Y-m-d H:i:s');
                        $data->nik      = Auth::user()['nik'];
                        $data->file     = $filename;
                        $data->background     = $filenames;
                        $data->save();

                        if($data){
                            echo'ok';
                        }
                    }else{
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                    }
                }else{
                    echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus PDF</p>';
                }
            }else{
                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format Background Harus Gambar</p>';
            }
            
        }
    }

    public function edit(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama aplikasi harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
                if($request->file=='' && $request->background==''){
                    $data           = Inews::find($id);
                    $data->name     = $request->name;
                    $data->waktu    = date('Y-m-d H:i:s');
                    $data->nik      = Auth::user()['nik'];
                    $data->save();

                    if($data){
                        echo'ok';
                    }
                }

                if($request->file!='' && $request->background==''){
                        $cek=explode('/',$_FILES['file']['type']);
                        $file_tmp=$_FILES['file']['tmp_name'];
                        $file=explode('.',$_FILES['file']['name']);
                        $filename=$request->name.'.'.$cek[1];
                        $lokasi='_file_inews/';
        
        
                        if($cek[1]=='pdf'){
                            if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                                $data           = Inews::find($id);
                                $data->name     = $request->name;
                                $data->waktu    = date('Y-m-d H:i:s');
                                $data->nik      = Auth::user()['nik'];
                                $data->file     = $filename;
                                $data->save();
        
                                if($data){
                                    echo'ok';
                                }
                            }else{
                                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus PDF</p>';
                        }
                }

                if($request->file=='' && $request->background!=''){
                        $cek=explode('/',$_FILES['background']['type']);
                        $file_tmp=$_FILES['background']['tmp_name'];
                        $file=explode('.',$_FILES['background']['name']);
                        $filename='BG'.$request->name.'.'.$cek[1];
                        $lokasi='_file_inews/';
        
        
                        if($cek[0]=='image'){
                            if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                                $data           = Inews::find($id);
                                $data->name     = $request->name;
                                $data->waktu    = date('Y-m-d H:i:s');
                                $data->nik      = Auth::user()['nik'];
                                $data->background     = $filename;
                                $data->save();
        
                                if($data){
                                    echo'ok';
                                }
                            }else{
                                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus Gambar</p>';
                        }
                }

                if($request->file!='' && $request->background!=''){
                        $cek=explode('/',$_FILES['file']['type']);
                        $file_tmp=$_FILES['file']['tmp_name'];
                        $file=explode('.',$_FILES['file']['name']);
                        $filename=$request->name.'.'.$cek[1];
                        $lokasi='_file_inews/';
            
                        $ceks=explode('/',$_FILES['background']['type']);
                        $files_tmp=$_FILES['background']['tmp_name'];
                        $files=explode('.',$_FILES['background']['name']);
                        $filenames='BG'.$request->name.'.'.$ceks[1];
                        $lokasis='_file_inews/';
        
        
                        if($ceks[0]=='image'){
                            if($cek[1]=='pdf'){
                                if(move_uploaded_file($file_tmp, $lokasi.$filename)){
                                    move_uploaded_file($files_tmp, $lokasis.$filenames);
                                    $data           = Inews::find($id);
                                    $data->name     = $request->name;
                                    $data->waktu    = date('Y-m-d H:i:s');
                                    $data->nik      = Auth::user()['nik'];
                                    $data->file     = $filename;
                                    $data->background     = $filenames;
                                    $data->save();
            
                                    if($data){
                                        echo'ok';
                                    }
                                }else{
                                    echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Gagal upload</p>';
                                }
                            }else{
                                echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus PDF</p>';
                            }
                        }else{
                            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Format file harus Gambar</p>';
                        }

                }
                
                
            
        }
    }
}
