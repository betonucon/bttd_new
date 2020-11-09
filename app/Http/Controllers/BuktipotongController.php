<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Ppn;
use App\Pph;
use PDF;
use Session;

use App\Imports\UserImport;
use App\Imports\PpnImport;
use App\Imports\PphImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class BuktipotongController extends Controller
{
    public function index(request $request){
        
        return view('pph.index');
    }
    public function index_import_pph(request $request){
        
        return view('pph.pph_import');
    }
    
    public function index_ppn(request $request){
        
        return view('ppn.index');
    }
    public function index_import_ppn(request $request){
        
        return view('ppn.ppn_import');
    }
    public function proses_import_pph(request $request){
        if (trim($request->file) == '') {$error[] = '- Upload file';}
        if (isset($error)) {echo 'Error-: <br />'.implode('<br />', $error).'</p>';} 
        else{
            error_reporting(0);
            // menangkap file excel
            $filess = $request->file('file');
            $nama_file = rand().$filess->getClientOriginalName();
            $filess->move('_file_excel',$nama_file);
            Excel::import(new PphImport, public_path('/_file_excel/'.$nama_file));
            Session::flash('sukses','ok');
        }
    }

    public function ppn_view($id){
        $id=$id;
        return view('ppn.ppn_view',compact('id'));
    }
    public function pph_view($id){
        $id=$id;
        return view('pph.pph_view',compact('id'));
    }

    
    
    public function api(){
        error_reporting(0);
       
        
        foreach(user_data(5) as $no=>$o){
        
            $show[]=array(
                "id" =>$o['id'],
                "name" =>$o['name'],
                "nik" =>$o['nik'],
                "email" =>$o['email'],
                "role" =>cek_role($o->role_id),
                "role_id" =>$role,
                "total" =>total_pph($o['nik']).' Dokumen',
                "total_ok" =>total_pph_ok($o['nik']).' Dokumen'
            );
        }

        echo json_encode($show);
        

        
       
    }

    public function api_ppn(){
        error_reporting(0);
       
        
            foreach(user_data(5) as $no=>$o){
            
                $show[]=array(
                    "id" =>$o['id'],
                    "name" =>$o['name'],
                    "nik" =>$o['nik'],
                    "email" =>$o['email'],
                    "role" =>cek_role($o->role_id),
                    "role_id" =>$role,
                    "total" =>total_ppn($o['nik']).' Dokumen',
                    "total_ok" =>total_ppn_ok($o['nik']).' Dokumen'
                );
            }

            echo json_encode($show);
    }

    public function api_view($id){
        error_reporting(0);
       
            $data=Pph::where('LIFNR',$id)->where('sts_pengambilan',null)->get();
            $cek=Pph::where('LIFNR',$id)->where('sts_pengambilan',null)->count();
            if($cek>0){
                foreach($data as $no=>$o){
                
                    $show[]=array(
                        "nomor" =>($no+1),
                        "proses" =>'<input type="checkbox" id="pilih" name="id[]" value="'.$o['id'].'">',
                        "id" =>$o['id'],
                        "no_dokumen" =>$o['DOCNO'],
                        "invoice" =>$o['BKTXT'],
                        "nik" =>$o['LIFNR'],
                        "faktur" =>$o['XBLNR'],
                        "tgl_faktur" =>date('Y-m-d',strtotime($o['BLDAT'])),
                        "dpp" =>number($o['DMBTR']),
                        "ppn" =>number($o['WRBTR'])
                    );
                }
            }else{
                $show[]=array(
                    "nomor" =>null,
                    "id" =>null,
                    "proses" =>null,
                    "no_dokumen" =>null,
                    "invoice" =>null,
                    "nik" =>null,
                    "faktur" =>null,
                    "tgl_faktur" =>null,
                    "dpp" =>null,
                    "ppn" =>null
                );
            }

            echo json_encode($show);
    }

    public function api_import_pph(){
        error_reporting(0);
       
            $data=Pph::where('tgl_import',date('Y-m-d'))->where('sts_pengambilan',null)->get();
            $cek=Pph::where('tgl_import',date('Y-m-d'))->where('sts_pengambilan',null)->count();
            if($cek>0){
                foreach($data as $no=>$o){
                
                    $show[]=array(
                        "nomor" =>($no+1),
                        "proses" =>'<input type="checkbox" id="pilih" name="id[]" value="'.$o['id'].'">',
                        "id" =>$o['id'],
                        "no_dokumen" =>$o['DOCNO'],
                        "invoice" =>$o['BKTXT'],
                        "nik" =>$o['LIFNR'],
                        "faktur" =>$o['XBLNR'],
                        "tgl_faktur" =>date('Y-m-d',strtotime($o['BLDAT'])),
                        "dpp" =>number($o['DMBTR']),
                        "ppn" =>number($o['WRBTR'])
                    );
                }
            }else{
                $show[]=array(
                    "nomor" =>null,
                    "id" =>null,
                    "proses" =>null,
                    "no_dokumen" =>null,
                    "invoice" =>null,
                    "nik" =>null,
                    "faktur" =>null,
                    "tgl_faktur" =>null,
                    "dpp" =>null,
                    "ppn" =>null
                );
            }

            echo json_encode($show);
    }

    public function api_view_ppn($id){
        error_reporting(0);
       
            $data=Ppn::where('LIFNR',$id)->where('sts_pengambilan',null)->get();
            $cek=Ppn::where('LIFNR',$id)->where('sts_pengambilan',null)->count();
            if($cek>0){
                foreach($data as $no=>$o){
                
                    $show[]=array(
                        "nomor" =>($no+1),
                        "proses" =>'<input type="checkbox" id="pilih" name="id[]" value="'.$o['id'].'">',
                        "id" =>$o['id'],
                        "invoice" =>$o['BKTXT'],
                        "nik" =>$o['LIFNR'],
                        "faktur" =>$o['XBLNR'],
                        "tgl_faktur" =>date('Y-m-d',strtotime($o['BLDAT'])),
                        "dpp" =>number($o['DMBTR']),
                        "ppn" =>number($o['WRBTR'])
                    );
                }
            }else{
                $show[]=array(
                    "nomor" =>null,
                    "id" =>null,
                    "proses" =>null,
                    "invoice" =>null,
                    "nik" =>null,
                    "faktur" =>null,
                    "tgl_faktur" =>null,
                    "dpp" =>null,
                    "ppn" =>null
                );
            }

            echo json_encode($show);
     }

    public function api_import_ppn(){
        error_reporting(0);
       
            $data=Ppn::where('tgl_import',date('Y-m-d'))->where('sts_pengambilan',null)->get();
            $cek=Ppn::where('tgl_import',date('Y-m-d'))->where('sts_pengambilan',null)->count();
            if($cek>0){
                foreach($data as $no=>$o){
                
                    $show[]=array(
                        "nomor" =>($no+1),
                        "proses" =>'<input type="checkbox" id="pilih" name="id[]" value="'.$o['id'].'">',
                        "id" =>$o['id'],
                        "invoice" =>$o['BKTXT'],
                        "nik" =>$o['LIFNR'],
                        "faktur" =>$o['XBLNR'],
                        "tgl_faktur" =>date('Y-m-d',strtotime($o['BLDAT'])),
                        "dpp" =>number($o['DMBTR']),
                        "ppn" =>number($o['WRBTR'])
                    );
                }
            }else{
                $show[]=array(
                    "nomor" =>null,
                    "id" =>null,
                    "proses" =>null,
                    "invoice" =>null,
                    "nik" =>null,
                    "faktur" =>null,
                    "tgl_faktur" =>null,
                    "dpp" =>null,
                    "ppn" =>null
                );
            }

            echo json_encode($show);
     }

    public function simpan_proses(request $request,$id){
        error_reporting(0);
        if (trim($request->penerima) == '') {$error[] = '- Nama penerima Harus disisi';}
        if (trim($request->tanggal) == '') {$error[] = '- Tanggal terima Harus disisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $jum=count($request->id);
            for($x=0;$x<$jum;$x++){
                $data=Ppn::where('id',$request->id[$x])->update([
                    'sts_pengambilan'=>1,
                    'tgl_pengambilan'=>$request->tanggal,
                    'nama_pengambil'=>$request->penerima,
                    'penginput'=>Auth::user()['nik']
                ]);
            }

            if($data){
                echo'ok';
            }
        }
        
    }

    public function simpan_proses_pph(request $request,$id){
        error_reporting(0);
        if (trim($request->penerima) == '') {$error[] = '- Nama penerima Harus disisi';}
        if (trim($request->tanggal) == '') {$error[] = '- Tanggal terima Harus disisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
            $jum=count($request->id);
            for($x=0;$x<$jum;$x++){
                $data=Pph::where('id',$request->id[$x])->update([
                    'sts_pengambilan'=>1,
                    'tgl_pengambilan'=>$request->tanggal,
                    'nama_pengambil'=>$request->penerima,
                    'penginput'=>Auth::user()['nik']
                ]);
            }

            if($data){
                echo'ok';
            }
        }
        
    }

    // public function view_rekening($id){
    //     $data=Bank::where('nik',$id)->orderBy('id','Desc')->get();
    //     echo'
    //         <tr>
    //             <th width="5%">No</th>
    //             <th width="25%">Vendor</th>
    //             <th>Bank Key</th>
    //             <th width="25%">No Rekening</th>
    //             <th width="10%">Matauang</th>
    //         </tr>
    //     ';
        
    //     foreach($data as $no=>$o){
    //         echo'
    //             <tr>
    //                 <td>'.($no+1).'</td>
    //                 <td>['.$o['nik'].'] '.cek_user($o['nik'])['name'].'</td>
    //                 <td>'.$o['bank_key'].'</td>
    //                 <td>'.$o['norek'].'</td>
    //                 <td>'.$o['matauang'].'</td>
                    
    //             </tr>
    //         ';
    //     }
    // }

    public function cetak_ppn(request $request,$id)
    {

        
        $jumlah=Ppn::where('LIFNR',$id)->where('sts_pengambilan',1)->count(); 
        $tot=$jumlah/10;
        $tam=explode('.',$tot);
        $nilai=count($tam);
        if($nilai==1){$add=0;}else{$add=1;}
        $ulang=$tam[0]+$add;


        
        
        foreach(get_ppn_all($id) as $no=>$o){
            $urut=Ppn::where('id',$o['id'])->update([
                'urut'=>($no+1)
            ]);
        }
        $id=$id;
        $tgl=$request->tgl;
        $pdf = PDF::loadView('ppn.pdf', ['id'=>$id,'tgl'=>$tgl,'ulang'=>$ulang])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
    public function cetak(request $request,$id)
    {

        
        $jumlah=Pph::where('LIFNR',$id)->where('sts_pengambilan',1)->count(); 
        $tot=$jumlah/10;
        $tam=explode('.',$tot);
        $nilai=count($tam);
        if($nilai==1){$add=0;}else{$add=1;}
        $ulang=$tam[0]+$add;


        
        
        foreach(get_pph_all($id) as $no=>$o){
            $urut=Pph::where('id',$o['id'])->update([
                'urut'=>($no+1)
            ]);
        }
        $id=$id;
        $tgl=$request->tgl;
        $pdf = PDF::loadView('pph.pdf', ['id'=>$id,'tgl'=>$tgl,'ulang'=>$ulang])->setPaper('a4', 'landscape');
        return $pdf->stream();
    }
}
