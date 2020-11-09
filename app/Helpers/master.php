<?php

function aplikasi(){
    $data=App\Aplikasi::orderBy('name','Asc')->get();

    return $data;
}



function inews_home(){
    $data=App\Inews::orderBy('id','Desc')->paginate(20);
    return $data;
}
function inews(){
    $data=App\Inews::orderBy('id','Desc')->get();

    return $data;
}

function cek_inews($id){
    $data=App\Inews::where('id',$id)->first();

    return $data;
}

function pengumuman_home(){
    $data=App\Pengumuman::orderBy('id','Desc')->paginate(20);

    return $data;
}

function pengumuman(){
    $data=App\Pengumuman::orderBy('id','Desc')->get();

    return $data;
}

function cek_pengumuman($id){
    $data=App\Pengumuman::where('id',$id)->first();

    return $data;
}


function cek_user($nik){
    $data=App\User::where('nik',$nik)->first();

    return $data;
}

function cek_role($id){
    $data=App\Role::where('id',$id)->first();

    return $data['name'];
}

function matauang(){
    $data=App\Matauang::all();

    return $data;
}
function tagihan(){
    $data=App\Tagihan::all();

    return $data;
}
function detail_tagihan($id){
    $data=App\Tagihandetail::where('tagihan_id',$id)->get();

    return $data;
}

function cek_tagihan($id){
    $data=App\Tagihan::where('id',$id)->first();

    return $data;
}

function cek_bttd($id){
    $data=App\Bttd::where('id',$id)->first();

    return $data;
}



function cek_kurs($matauang,$nilai){
    $data=App\Kurs::where('FCURR',$matauang)->orderBy('id','Desc')->max('UKURS');

    $nilai=$nilai*$data;

    return $nilai;
}
function tagihan_detail($id){
    $data=App\Tagihandetail::where('tagihan_id',$id)->get();

    return $data;
}
function bank(){
    $data=App\Bank::where('nik',Auth::user()['nik'])->get();

    return $data;
}
function bank_edit($nik){
    if(Auth::user()['role_id']==12){
        $data=App\Bank::where('nik',$nik)->get();
    }else{
        $data=App\Bank::where('nik',Auth::user()['nik'])->get();
    }
    

    return $data;
}

function role(){
    $data=App\Role::all();

    return $data;
}

function role_loket(){
    $data  = array_column(
        App\Role::where('group',1)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}
function role_officer(){
    $data  = array_column(
        App\Role::where('group',2)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}
function role_spv(){
    $data  = array_column(
        App\Role::where('group',3)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}
function role_spt(){
    $data  = array_column(
        App\Role::where('group',4)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}
function role_pd(){
    $data  = array_column(
        App\Role::where('group',6)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}
function role_mgr(){
    $data  = array_column(
        App\Role::where('group',7)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}
function role_vendor(){
    $data  = array_column(
        App\Role::where('group',5)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}
function role_admin(){
    $data  = array_column(
        App\Role::where('group',0)->where('sts',1)
        ->get()
        ->toArray(),'id'
    );

    return $data;
}

function user(){
    $data=App\Role::all();

    return $data;
}
function group(){
    $data  = App\Group::all();
    return $data;
}

function user_data($role){
    $akses  = array_column(
        App\Role::where('group',$role)
        ->get()
        ->toArray(),'id'
    );
    
    if($role=='all'){
        $data=App\User::where('role_id',1)->get();
    }elseif($role=='5'){
        $data=App\User::where('role_id',1)->get();
    }else{
        $data=App\User::whereIn('role_id',$akses)->where('role_id','!=',5)->get();
    }
    

    
    return $data;
}

function bttd_laporan($mulai,$sampai,$group){
    $akses  = array_column(
        App\Role::where('group',$group)
        ->get()
        ->toArray(),'id'
    );
    
    
    $data=App\Bttd::whereIn('status',$akses)->whereBetween('tgl_create',[$mulai,$sampai])->get();
    
    
    return $data;
}

function ba_total_nilai_faktur($mulai,$sampai,$group){
    $akses  = array_column(
        App\Role::where('group',$group)
        ->get()
        ->toArray(),'id'
    );
    
    
    $data=App\Bttd::whereIn('status',$akses)->whereBetween('tgl_create',[$mulai,$sampai])->sum('nilai_faktur');
    
    
    return $data;
}
function ba_total_dok_faktur($mulai,$sampai,$group){
    $akses  = array_column(
        App\Role::where('group',$group)
        ->get()
        ->toArray(),'id'
    );
    
    
    $data=App\Bttd::whereIn('status',$akses)->whereBetween('tgl_create',[$mulai,$sampai])->where('no_faktur','!=',0)->count();
    
    
    return $data;
}
function ba_total_dok_non_faktur($mulai,$sampai,$group){
    $akses  = array_column(
        App\Role::where('group',$group)
        ->get()
        ->toArray(),'id'
    );
    
    
    $data=App\Bttd::whereIn('status',$akses)->whereBetween('tgl_create',[$mulai,$sampai])->where('no_faktur',0)->count();
    
    
    return $data;
}
function ba_total_nilai_kwitansi($mulai,$sampai,$group){
    $akses  = array_column(
        App\Role::where('group',$group)
        ->get()
        ->toArray(),'id'
    );
    
    
    $data=App\Bttd::whereIn('status',$akses)->whereBetween('tgl_create',[$mulai,$sampai])->sum('nilai_kwitansi');
    
    
    return $data;
}

function status_proses($role_id){
    
    $rol=App\Role::where('id',$role_id)->first();
        
    $data=App\Statusproses::where('group',$rol['group'])->first();
        
    return $data['id'];
}

function bttd($bulan=null,$tahun=null){
    if($bulan==''){
        
            $data=App\Bttd::where('nik',Auth::user()['nik'])->whereYear('tgl_create',date('Y'))->whereMonth('tgl_create',date('m'))->where('sts_del',0)->orderBy('id','Desc')->get();
        
    }else{
        
            $data=App\Bttd::where('nik',Auth::user()['nik'])->whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->orderBy('id','Desc')->get();
        
    }
    

    return $data;
}
function bttd_non_faktur($bulan=null,$tahun=null){
   
    $data=App\Bttd::where('nik',Auth::user()['nik'])->whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->where('no_faktur',0)->orderBy('id','Desc')->get();
        
    
    return $data;
}



function bttd_baru($bulan,$tahun){
    
        if(in_array(Auth::user()['role_id'],role_loket())){
            $data=App\Bttd::where('status',1)->whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->orderBy('id','Desc')->get();
        }else{
            $data=App\Bttd::where('status',Auth::user()['role_id'])->where('proses',10)->whereYear('tgl_create',$tahun)->whereMonth('tgl_create',$bulan)->where('sts_del',0)->orderBy('id','Desc')->get();
        }
        
   
    return $data;
}

function bttd_diterima($bulan=null,$tahun=null){
   
    $data=App\Bttd::where('status',Auth::user()['role_id'])->where('proses',status_proses(Auth::user()['role_id']))->whereYear('tgl_of_terima',date('Y'))->whereMonth('tgl_of_terima',date('m'))->where('sts_del',0)->orderBy('id','Desc')->get();
    
    return $data;
}

function posisi($id){
    
        $pos=App\Role::where('id',$id)->first();
        $data=$pos['name'];
    

    return $data;
}

function cek_position_bttd($id,$role){
    
        $pos=App\Positionbttd::where('role_id',$role)->where('bttd_id',$id)->first();
        $data=$pos['sts'];
    

    return $data;
}
function position_bttd($id,$role){
    
        $data=App\Positionbttd::where('role_id',$role)->where('bttd_id',$id)->first();
        
    

    return $data;
}

function role_kirim(){
    
        $rol=App\Role::where('id',Auth::user()['role_id'])->first();
        if($rol['group']==1){
            $data=App\Role::whereIn('group',[2,3])->where('sts',1)->orderBy('group','Asc')->get();
        }
        if($rol['group']==2){
            $data=App\Role::whereIn('group',[3,4])->where('sts',1)->orderBy('group','Asc')->get();
        }
        if($rol['group']==3){
            $data=App\Role::whereIn('group',[4,6,7])->where('sts',1)->orderBy('group','Asc')->get();
        }
        if($rol['group']==4){
            $data=App\Role::whereIn('group',[6,7])->where('sts',1)->orderBy('group','Asc')->get();
        }
        if($rol['group']==6){
            $data=App\Role::where('group',7)->where('sts',1)->orderBy('group','Asc')->get();
        }
        
        
    

    return $data;
}

function total_pph($id){
    $data=App\Pph::where('LIFNR',$id)->count();

    return $data;
}

function total_pph_ok($id){
    $data=App\Pph::where('LIFNR',$id)->where('sts_pengambilan',1)->count();

    return $data;
}

function total_ppn($id){
    $data=App\Ppn::where('LIFNR',$id)->count();

    return $data;
}

function total_ppn_ok($id){
    $data=App\Ppn::where('LIFNR',$id)->where('sts_pengambilan',1)->count();

    return $data;
}

function get_pph($id,$mulai,$sampai){
    $data=App\Pph::where('LIFNR',$id)->where('sts_pengambilan',1)->whereBetween('urut',[$mulai,$sampai])->get();

    return $data;
}
function get_pph_all($id){
    $data=App\Pph::where('LIFNR',$id)->where('sts_pengambilan',1)->get();

    return $data;
}
function get_ppn($id,$mulai,$sampai){
    $data=App\Ppn::where('LIFNR',$id)->where('sts_pengambilan',1)->whereBetween('urut',[$mulai,$sampai])->get();

    return $data;
}
function get_ppn_all($id){
    $data=App\Ppn::where('LIFNR',$id)->where('sts_pengambilan',1)->get();

    return $data;
}

?>