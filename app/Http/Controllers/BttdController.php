<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Bttd;
use App\Positionbttd;
use App\Tagihandetail;
use PDF;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
class BttdController extends Controller
{
    public function index(request $request)
    {
        if($request->bulan==''){
            $bulan=date('m');
            $tahun=date('Y');
        }else{
            $bulan=$request->bulan;
            $tahun=$request->tahun;
        }
        
        if(Auth::user()['role_id']==1){
            return view('bttd.index',compact('bulan','tahun'));
        }elseif(Auth::user()['role_id']==12){
            return view('bttd.index_user',compact('bulan','tahun'));
        }else{
            return view('bttd.index_admin',compact('bulan','tahun'));
        }
        
    }

    public function api_index_bttd($bulan,$tahun){
        error_reporting(0);
        if(Auth::user()['role_id']==12){
            $data=Bttd::whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->orderBy('id','Desc')->get();
        }else{
            $data=Bttd::where('nik',Auth::user()['nik'])->whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->orderBy('id','Desc')->get();
        }
        
        foreach($data as $o){
           
            $show[]=array(
                "id" =>$o['id'],
                "nik" =>$o['nik'],
                "name" =>cek_user($o['nik'])['name'],
                "no_faktur"=>$o['no_faktur'],
                "sts_faktur"=>$o['sts_faktur'],
                "no_kwitansi"=>$o['no_kwitansi'],
                "nilai_faktur"=>number($o['nilai_faktur']),
                "nilai_kwitansi"=>number($o['nilai_kwitansi']),
                "mata_uang"=>$o['mata_uang'],
                "status_proses"=>$o['proses'],
                "tgl_of_terima"=>$o['tgl_of_terima'],
                "posisi"=>posisi($o['status'])
            );
        }

        echo json_encode($show);
        
    }
    public function api_index_bttd_admin($bulan,$tahun){
        error_reporting(0);
        if(in_array(Auth::user()['role_id'],role_loket())){
            $data=Bttd::where('status',1)->whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->orderBy('id','Desc')->get();
        }else{
            $data=Bttd::where('status',Auth::user()['role_id'])->where('proses',10)->whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->orderBy('id','Desc')->get();
        }
        
        foreach($data as $o){
           
            $show[]=array(
                "id" =>$o['id'],
                "nik" =>$o['nik'],
                "name" =>cek_user($o['nik'])['name'],
                "no_faktur"=>$o['no_faktur'],
                "no_kwitansi"=>$o['no_kwitansi'],
                "nilai_faktur"=>number($o['nilai_faktur']),
                "nilai_kwitansi"=>number($o['nilai_kwitansi']),
                "mata_uang"=>$o['mata_uang'],
                "tgl_of_terima"=>$o['tgl_of_terima'],
                "posisi"=>posisi($o['status']),
                "status"=>cek_position_bttd($o['id'],$o['status']),
            );
        }

        echo json_encode($show);
        
    }
    public function api_index_bttd_admin_diterima($bulan,$tahun){
        error_reporting(0);
        $data=Bttd::where('status',Auth::user()['role_id'])->where('proses',status_proses(Auth::user()['role_id']))->whereYear('tgl_of_terima',date('Y'))->whereMonth('tgl_of_terima',date('m'))->where('sts_del',0)->orderBy('id','Desc')->get();
        
        foreach($data as $o){
           
            $show[]=array(
                "id" =>$o['id'],
                "nik" =>$o['nik'],
                "name" =>cek_user($o['nik'])['name'],
                "no_faktur"=>$o['no_faktur'],
                "no_kwitansi"=>$o['no_kwitansi'],
                "nilai_faktur"=>number($o['nilai_faktur']),
                "nilai_kwitansi"=>number($o['nilai_kwitansi']),
                "mata_uang"=>$o['mata_uang'],
                "tgl_of_terima"=>$o['tgl_of_terima'],
                "posisi"=>posisi($o['status']),
                "status"=>cek_position_bttd($o['id'],$o['status']),
                "diterima"=>position_bttd($o['id'],$o['status'])['tgl_terima'],
            );
        }

        echo json_encode($show);
        
    }
    public function index_non(request $request)
    {
        if($request->bulan==''){
            $bulan=date('m');
            $tahun=date('Y');
        }else{
            $bulan=$request->bulan;
            $tahun=$request->tahun;
        }
        
        if(Auth::user()['role_id']==1){
            return view('bttd.index_non',compact('bulan','tahun'));
        }elseif(Auth::user()['role_id']==12){
            return view('bttd.index_non_user',compact('bulan','tahun'));
        }else{
            return view('bttd.index_admin',compact('bulan','tahun'));
        }
        
    }

    public function index_diterima(request $request)
    {
        if($request->bulan==''){
            $bulan=date('m');
            $tahun=date('Y');
        }else{
            $bulan=$request->bulan;
            $tahun=$request->tahun;
        }
         return view('bttd.index_admin_diterima',compact('bulan','tahun'));
    }

    public function index_laporan(request $request)
    {
        if($request->mulai==''){
            $mulai=date('Y-m-d');
            $sampai=date('Y-m-d');
            $groupnya=1;
        }else{
            $mulai=$request->mulai;
            $sampai=$request->sampai;
            $groupnya=$request->group;
        }

        // dd(bttd_laporan($mulai,$sampai,$group));
         return view('bttd.index_laporan',compact('mulai','sampai','groupnya'));
    }

    public function tambah()
    {
        return view('bttd.tambah');
    }

    public function tambah_nonfaktur()
    {
        return view('bttd.tambah_nonfaktur');
    }
    public function edit($id)
    {
        $ide=decode($id);
        $data=Bttd::where('id',$ide)->first();
        return view('bttd.edit',compact('data','ide'));
    }
    public function edit_non_faktur($id)
    {
        $ide=decode($id);
        $data=Bttd::where('id',$ide)->first();
        return view('bttd.edit_non_faktur',compact('data','ide'));
    }

    public function cek_tagihan(request $request,$id){
        $data=Tagihandetail::where('tagihan_id',$id)->get();
        echo'<table width="100%" border="1">
                <tr bgcolor="aqua">
                    <td  width="5%">No</td>
                    <td>Nama</td>
                </tr>
                ';
        foreach($data as $x=>$o){
            echo'<tr bgcolor="#f8f5ff">
                    <td>'.($x+1).'</td>
                    <td>'.$o['name'].'</td>
                </tr>';
        }

        echo'</table>';
    }

    public function diterima(request $request){
        if(in_array(Auth::user()['role_id'],role_loket())){
            $jum=count($request->id);

            for($x=0;$x<$jum;$x++){
                $data=Bttd::where('id',$request->id[$x])->first();
                $bttd                   = Bttd::find($request->id[$x]);
                $bttd->proses           = 1;
                $bttd->status           = Auth::user()['role_id'];
                $bttd->tgl_of_terima     = date('Y-m-d');
                $bttd->save();
                
                $position                   = Positionbttd::where('bttd_id',$request->id[$x])->where('role_id',$data['status'])->first();
                $position->tgl_kirim        = date('Y-m-d');
                $position->sts              = 2;
                $position->save();

                $newposition                   = New Positionbttd;
                $newposition->bttd_id          = $request->id[$x];
                $newposition->tgl_terima       = date('Y-m-d');
                $newposition->sts              = 1;
                $newposition->role_id              = Auth::user()['role_id'];
                $newposition->save();

                
                
            }

            echo'ok';
        
        }else{
            $jum=count($request->id);

            for($x=0;$x<$jum;$x++){
                $data=Bttd::where('id',$request->id[$x])->first();
                $bttd                   = Bttd::find($request->id[$x]);
                $bttd->proses           = status_proses(Auth::user()['role_id']);
                $bttd->status           = Auth::user()['role_id'];
                $bttd->tgl_of_terima     = date('Y-m-d');
                $bttd->save();
                
                
            }

            echo'ok';
        }
    }

    public function dikirim(request $request,$role_id){
        error_reporting(0);
        $jum=count($request->id);

        if($jum==0){
            echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Silahkan centang dokumen</p>';
        }else{
            for($x=0;$x<$jum;$x++){
                $data=Bttd::where('id',$request->id[$x])->first();
                $cek=Positionbttd::where('bttd_id',$request->id[$x])->where('role_id',$role_id)->where('sts','!=',3)->count();
                if($cek>0){

                }else{    
                    $bttd                   = Bttd::find($request->id[$x]);
                    $bttd->status           = $role_id;
                    $bttd->proses           = 10;
                    $bttd->save();
                    
                    $position                   = Positionbttd::where('bttd_id',$request->id[$x])->where('role_id',Auth::user()['role_id'])->first();
                    $position->tgl_kirim        = date('Y-m-d');
                    $position->sts              = 2;
                    $position->save();

                    $newposition                   = New Positionbttd;
                    $newposition->bttd_id          = $request->id[$x];
                    $newposition->tgl_terima       = date('Y-m-d');
                    $newposition->sts              = 1;
                    $newposition->role_id          = $role_id;
                    $newposition->save();

                }
                
            }

            echo'ok';
        }
    }
    
    public function simpan(request $request,$act){
        
        if($act=='faktur'){
            if (trim($request->tgl_create) == '') {$error[] = '- Tanggal Faktur Pajak harus diisi';}
            if (trim($request->mata_uang) == '') {$error[] = '- Mata Uang harus diisi';} 
            if (trim($request->norek) == '') {$error[] = '- Nomor Rekening harus diisi';} 
            if (trim($request->nama_bank) == '') {$error[] = '- Nama BANK harus diisi';} 
            if (trim($request->nilai_faktur) == '') {$error[] = '- Nilai Invoice (DPP + PPN) harus diisi';} 
            if (trim($request->nilai_kwitansi) == '') {$error[] = '- Nilai Faktur Pajak (PPn 10%) harus diisi';} 
            if (trim($request->no_po) == '') {$error[] = '- No. Kwitansi & No.PO/Kontrak harus diisi';} 
            if (trim($request->no_faktur) == '') {$error[] = '- No. Faktur Pajak harus diisi';} 
            if (trim($request->email) == '') {$error[] = '- Email / Telp / Fax Vendor harus diisi';} 
            if (trim($request->tagihan_id) == '') {$error[] = '- Pilih Jenis Tagihan';} 
            if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $cek=Bttd::where('no_faktur',$request->no_faktur)->orWhere('no_kwitansi',$request->no_kwitansi)->count();

                    if($cek>0){
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Nomor Faktur Atau Invoice sudah terdaftar</p>';
                    }else{
                            $data                   = new Bttd;
                            $data->nik              = Auth::user()['nik'];
                            $data->tgl_create       = $request->tgl_create;
                            $data->sts_faktur       = 1;
                            $data->mata_uang        = $request->mata_uang;
                            $data->norek            = $request->norek;
                            $data->nama_bank        = $request->nama_bank;
                            $data->konv_idr         = cek_kurs($request->mata_uang,$request->nilai_kwitansi);
                            $data->nilai_faktur     = $request->nilai_faktur;
                            $data->nilai_kwitansi   = $request->nilai_kwitansi;
                            $data->no_po            = $request->no_po;
                            $data->no_faktur        = $request->no_faktur;
                            $data->tagihan_id       = $request->tagihan_id;
                            $data->ket              = $request->email;
                            $data->status           = 1;
                            $data->proses           = 0;
                            $data->sts_del          = 0;
                            $data->no_kwitansi      = $request->no_po;
                            $data->save();

                            if($data){
                                $position                   = new Positionbttd;
                                $position->bttd_id     = $data->id;
                                $position->tgl_kirim    = date('Y-m-d');
                                $position->role_id  = 1;
                                $position->sts      = 1;
                                $position->save();
                                if($position){
                                    echo'ok';
                                }

                            }
                    
                            
                    
                    }
                
            }
        }

        if($act=='non_faktur'){
            if (trim($request->mata_uang) == '') {$error[] = '- Mata Uang harus diisi';} 
            if (trim($request->norek) == '') {$error[] = '- Nomor Rekening harus diisi';} 
            if (trim($request->nama_bank) == '') {$error[] = '- Nama BANK harus diisi';} 
            if (trim($request->nilai_kwitansi) == '') {$error[] = '- Nilai Invoice harus diisi';} 
            if (trim($request->no_po) == '') {$error[] = '- Nomor : PO/Kontrak/Ket.Pembayaran';} 
            if (trim($request->email) == '') {$error[] = '- Email / Telp / Fax Vendor harus diisi';} 
            if (trim($request->tagihan_id) == '') {$error[] = '- Pilih Jenis Tagihan';} 
            if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $cek=Bttd::where('no_faktur',$request->no_faktur)->orWhere('no_kwitansi',$request->no_kwitansi)->count();

                    if($cek>0){
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Nomor Faktur Atau Invoice sudah terdaftar</p>';
                    }else{
                            $data                   = new Bttd;
                            $data->nik              = Auth::user()['nik'];
                            $data->tgl_create       = date('Y-m-d');
                            $data->mata_uang        = $request->mata_uang;
                            $data->norek            = $request->norek;
                            $data->nama_bank        = $request->nama_bank;
                            $data->konv_idr         = cek_kurs($request->mata_uang,$request->nilai_kwitansi);
                            $data->nilai_faktur     = 0;
                            $data->nilai_kwitansi   = $request->nilai_kwitansi;
                            $data->no_po            = $request->no_po;
                            $data->no_faktur        = 0;
                            $data->tagihan_id       = $request->tagihan_id;
                            $data->ket              = $request->email;
                            $data->status           = 1;
                            $data->sts_faktur       = 2;
                            $data->proses           = 0;
                            $data->sts_del          = 0;
                            $data->no_kwitansi      = $request->no_kwitansi;
                            $data->save();

                            if($data){
                                $position                   = new Positionbttd;
                                $position->bttd_id     = $data->id;
                                $position->tgl_kirim    = date('Y-m-d');
                                $position->role_id  = 1;
                                $position->sts      = 1;
                                $position->save();
                                if($position){
                                    echo'ok';
                                }

                            }
                    
                            
                    
                    }
                
            }
        }
            
    }

    public function simpan_edit(request $request,$act,$id){
        
        if($act=='faktur'){
            if (trim($request->tgl_create) == '') {$error[] = '- Tanggal Faktur Pajak harus diisi';}
            if (trim($request->mata_uang) == '') {$error[] = '- Mata Uang harus diisi';} 
            if (trim($request->norek) == '') {$error[] = '- Nomor Rekening harus diisi';} 
            if (trim($request->nama_bank) == '') {$error[] = '- Nama BANK harus diisi';} 
            if (trim($request->nilai_faktur) == '') {$error[] = '- Nilai Invoice (DPP + PPN) harus diisi';} 
            if (trim($request->nilai_kwitansi) == '') {$error[] = '- Nilai Faktur Pajak (PPn 10%) harus diisi';} 
            if (trim($request->no_po) == '') {$error[] = '- No. Kwitansi & No.PO/Kontrak harus diisi';} 
            if (trim($request->no_faktur) == '') {$error[] = '- No. Faktur Pajak harus diisi';} 
            if (trim($request->email) == '') {$error[] = '- Email / Telp / Fax Vendor harus diisi';} 
            if (trim($request->tagihan_id) == '') {$error[] = '- Pilih Jenis Tagihan';} 
            if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $cek=Bttd::where('no_faktur',$request->no_faktur)->orWhere('no_kwitansi',$request->no_kwitansi)->count();

                    if($cek>1){
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Nomor Faktur Atau Invoice sudah terdaftar</p>';
                    }else{
                            if(Auth::user()['role_id']==12){
                                $data                   = Bttd::where('id',$id)->first();
                                $data->tgl_create       = $request->tgl_create;
                                $data->mata_uang        = $request->mata_uang;
                                $data->norek            = $request->norek;
                                $data->nama_bank        = $request->nama_bank;
                                $data->konv_idr         = cek_kurs($request->mata_uang,$request->nilai_kwitansi);
                                $data->nilai_faktur     = $request->nilai_faktur;
                                $data->nilai_kwitansi   = $request->nilai_kwitansi;
                                $data->no_po            = $request->no_po;
                                $data->no_faktur        = $request->no_faktur;
                                $data->tagihan_id       = $request->tagihan_id;
                                $data->ket              = $request->email;
                                $data->proses              = 0;
                                $data->no_kwitansi      = $request->no_po;
                                $data->save();
    
                                if($data){
                                     echo'ok';
                                }
                            }else{
                                $data                   = Bttd::where('id',$id)->where('proses',0)->first();
                                $data->tgl_create       = $request->tgl_create;
                                $data->mata_uang        = $request->mata_uang;
                                $data->norek            = $request->norek;
                                $data->nama_bank        = $request->nama_bank;
                                $data->konv_idr         = cek_kurs($request->mata_uang,$request->nilai_kwitansi);
                                $data->nilai_faktur     = $request->nilai_faktur;
                                $data->nilai_kwitansi   = $request->nilai_kwitansi;
                                $data->no_po            = $request->no_po;
                                $data->no_faktur        = $request->no_faktur;
                                $data->tagihan_id       = $request->tagihan_id;
                                $data->ket              = $request->email;
                                $data->proses              = 0;
                                $data->no_kwitansi      = $request->no_po;
                                $data->save();

                                if($data){
                                    echo'ok';
                                }
                            }
                            
                    
                            
                    
                    }
                
            }
        }

        if($act=='non_faktur'){
            if (trim($request->mata_uang) == '') {$error[] = '- Mata Uang harus diisi';} 
            if (trim($request->norek) == '') {$error[] = '- Nomor Rekening harus diisi';} 
            if (trim($request->nama_bank) == '') {$error[] = '- Nama BANK harus diisi';} 
            if (trim($request->nilai_kwitansi) == '') {$error[] = '- Nilai Invoice harus diisi';} 
            if (trim($request->no_po) == '') {$error[] = '- Nomor : PO/Kontrak/Ket.Pembayaran';} 
            if (trim($request->email) == '') {$error[] = '- Email / Telp / Fax Vendor harus diisi';} 
            if (trim($request->tagihan_id) == '') {$error[] = '- Pilih Jenis Tagihan';} 
            if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
            else{
                $cek=Bttd::where('no_faktur',$request->no_faktur)->orWhere('no_kwitansi',$request->no_kwitansi)->count();

                    if($cek>1){
                        echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br /> Nomor Kwitansi Atau Invoice sudah terdaftar</p>';
                    }else{
                        if(Auth::user()['role_id']==12){
                            $data                   = Bttd::where('id',$id)->first();
                            $data->mata_uang        = $request->mata_uang;
                            $data->norek            = $request->norek;
                            $data->nama_bank        = $request->nama_bank;
                            $data->konv_idr         = cek_kurs($request->mata_uang,$request->nilai_kwitansi);
                            $data->nilai_kwitansi   = $request->nilai_kwitansi;
                            $data->no_po            = $request->no_po;
                            $data->tagihan_id       = $request->tagihan_id;
                            $data->ket              = $request->email;
                            $data->no_kwitansi      = $request->no_kwitansi;
                            $data->save();

                            if($data){
                                
                                    echo'ok';
                               
                            }
                        }else{
                            $data                   = Bttd::where('id',$id)->where('proses',0)->first();
                            $data->mata_uang        = $request->mata_uang;
                            $data->norek            = $request->norek;
                            $data->nama_bank        = $request->nama_bank;
                            $data->konv_idr         = cek_kurs($request->mata_uang,$request->nilai_kwitansi);
                            $data->nilai_kwitansi   = $request->nilai_kwitansi;
                            $data->no_po            = $request->no_po;
                            $data->tagihan_id       = $request->tagihan_id;
                            $data->ket              = $request->email;
                            $data->no_kwitansi      = $request->no_kwitansi;
                            $data->save();

                            if($data){
                                
                                    echo'ok';
                               
                            }
                        }
                            
                    }
                
            }
        
        }
            
    }

    public function laporan_bttd($id)
    {
        $ide=decode($id);
        $data=Bttd::where('id',$ide)->first();
        $pdf = PDF::loadView('bttd.pdf', ['data'=>$data]);
        return $pdf->stream();
    }

    public function pdf_berita_acara($mulai,$sampai,$group)
    {
        $mulai=$mulai;
        $sampai=$sampai;
        $groupnya=$group;
        
        $pdf = PDF::loadView('bttd.pdf_berita_acara', ['mulai'=>$mulai,'sampai'=>$sampai,'groupnya'=>$groupnya]);
        return $pdf->stream();
    }

    public function excel_ba_bttd($mulai,$sampai,$group)
    {
        $mulai=$mulai;
        $sampai=$sampai;
        $groupnya=$group;
        
        return view('bttd.berita_acara',compact('mulai','sampai','groupnya'));
    }

}
