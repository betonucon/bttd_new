<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tagihan;
use App\Tagihandetail;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TagihanController extends Controller
{
    public function index(){
        return view('tagihan.index');
    }
    public function index_detail($id){
        $ide=$id;
        $head=Tagihan::where('id',$id)->first();
        return view('tagihan.index_detail',compact('head','ide'));
    }
    public function hapus($id){
        $data=Tagihan::where('id',$id)->delete();
        echo'ok';
    }
    public function hapus_detail($id){
        $data=Tagihandetail::where('id',$id)->delete();
        echo'ok';
    }

    public function simpan(request $request){
        if (trim($request->name) == '') {$error[] = '- Nama Tagihan harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data           = new Tagihan;
            $data->name     = $request->name;
            $data->save();

            if($data){
                echo'ok';
            } 
               
        }
    }

    public function simpan_detail(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama Tagihan Detail harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $data           = new Tagihandetail;
            $data->tagihan_id     = $id;
            $data->name     = $request->name;
            $data->save();

            if($data){
                echo'ok';
            } 
               
        }
    }

    public function edit(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama Tagihan harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
                $data           = Tagihan::find($id);
                $data->name     = $request->name;
                $data->save();

                if($data){
                    echo'ok';
                }
        }
    }

    public function edit_detail(request $request,$id){
        if (trim($request->name) == '') {$error[] = '- Nama Tagihan Detail  harus diisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            
            
                $data           = Tagihandetail::find($id);
                $data->name     = $request->name;
                $data->save();

                if($data){
                    echo'ok';
                }
                        
            
        }
    }
}
