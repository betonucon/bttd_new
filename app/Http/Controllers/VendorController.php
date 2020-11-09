<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Role;
use App\Bank;
use PDF;
use Session;

use App\Imports\UserImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
class VendorController extends Controller
{
    public function index(request $request){
        
        return view('vendor.index',compact('role'));
    }

    public function rekening($id){
        $data=User::where('nik',$id)->first();
        return view('vendor.rekening',compact('data'));
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
                    "sts" =>sts_user($o['sts'])
                );
            }

            echo json_encode($show);
        

        
       
    }

    public function simpan_rekening(request $request,$id){
        if (trim($request->bank_key) == '') {$error[] = '- Bank Key Harus disisi';}
        if (trim($request->norek) == '') {$error[] = '- Nomor Rekening Harus disisi';}
        if (isset($error)) {echo '<p style="padding:5px;background:#d1ffae"><b>Error</b>: <br />'.implode('<br />', $error).'</p>';} 
        else{
                $data               = New Bank;
                $data->nik          = $id;
                $data->bank_key     = $request->bank_key;
                $data->norek        = $request->norek;
                $data->matauang     = $request->matauang;
                $data->save();

                if($data){
                    echo'ok';
                }
        }
        
    }

    public function view_rekening($id){
        $data=Bank::where('nik',$id)->orderBy('id','Desc')->get();
        echo'
            <tr>
                <th width="5%">No</th>
                <th width="25%">Vendor</th>
                <th>Bank Key</th>
                <th width="25%">No Rekening</th>
                <th width="10%">Matauang</th>
            </tr>
        ';
        
        foreach($data as $no=>$o){
            echo'
                <tr>
                    <td>'.($no+1).'</td>
                    <td>['.$o['nik'].'] '.cek_user($o['nik'])['name'].'</td>
                    <td>'.$o['bank_key'].'</td>
                    <td>'.$o['norek'].'</td>
                    <td>'.$o['matauang'].'</td>
                    
                </tr>
            ';
        }
    }
}
