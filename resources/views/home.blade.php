@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
#list{
    background:#fff;
}
#list:hover{
    background:#efdada;
}

.kartu{
    border:solid 1px none;
    width:90px;
    margin:5px;
    height:100px;
    float:left;
    display:flex;
}
td{
    font-size:12px;
    padding:5px;
    border-bottom:solid 1px #ceb3b3;
}
@media only screen and (min-width: 650px) {
        #lisi-pengumuman{
            font-size:0.8vw;
            text-transform:uppercase;
        }
        #lisi-pengumuman:hover{
            background:yellow;
        }
    }
    @media only screen and (max-width: 649px) {
        #lisi-pengumuman{
            font-size:1vw;
            text-transform:uppercase;
        }
        
    }
</style>
<!-- Main content -->
<section class="content">

<div class="row">
  <div class="col-md-3">

    <!-- Profile Image -->
    <div class="box box-primary">
        <div class="box-body box-profile">
            <img class="profile-user-img img-responsive img-circle" src="{{url('/'.foto())}}" alt="User profile picture">

            <h3 class="profile-username text-center" style="font-size:12px">{{Auth::user()['name']}}</h3>

            <p class="text-muted text-center">{{Auth::user()['nik']}}</p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>Kode Vendor</b> <a class="pull-right">{{Auth::user()['nik']}}</a>
                </li>
                <li class="list-group-item">
                    <b>NPWP</b> <a class="pull-right">{{Auth::user()['npwp']}}</a>
                </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block" data-toggle="modal"  data-target="#modalfoto"><b><i class="fa fa-pencil"></i> Ubah Foto Profil</b></a>
        </div>
        
        <!-- /.box-header -->
        <div class="box-body">
            <strong><i class="fa fa-book margin-r-5"></i> Visi</strong>

            <p class="text-muted">
            B.S. in Computer Science from the University of Tennessee at Knoxville
            </p>

            <hr>

            <strong><i class="fa fa-book margin-r-5"></i> Misi</strong>

            <p class="text-muted">
            B.S. in Computer Science from the University of Tennessee at Knoxville
            </p>

            <hr>

            
        </div>
      <!-- /.box-body -->
    </div>

    
    <!-- /.box -->
  </div>
  <!-- /.col -->
  <div class="col-md-9">
        <div style="margin-bottom:0px" class="box box-primary color-palette-box">
            <div class="box-header" style="background: #6d6db5;color: #fff;">
                <h3 class="box-title"><i class="fa fa-newspaper-o"></i> Pengumuman</h3>
            </div>
            <div class="box-body" style="padding:1%" >
                <ul class="list-group list-group-unbordered">
                    @foreach(pengumuman() as $pengumuman)
                        <li class="list-group-item" onclick="lihat('{{$pengumuman['file']}}')" id="lisi-pengumuman">
                            <b>{{$pengumuman['name']}}</b> <a class="pull-right"><i class="fa fa-search"></i></a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
  </div>
  @if(in_array(Auth::user()['role_id'],role_loket()))
    <div class="col-md-9" style="margin-top:2%">
            <div style="margin-bottom:0px" class="box box-primary color-palette-box">
                <div class="box-header" style="background: #6d6db5;color: #fff;">
                    <h3 class="box-title"><i class="fa fa-newspaper-o"></i> File Upload</h3>
                </div>
                <div class="box-body" style="padding:1%" >
                    <table width="100%">
                        <tr>
                            <td><a href="{{url('tools/excel_pph.xlsx')}}" target="_blank"><i class="fa fa-cloud-download"></i> Format File Excel PPH</a></td>
                        </tr>
                        <tr>
                            <td><a href="{{url('tools/excel_ppn.xlsx')}}" target="_blank"><i class="fa fa-cloud-download"></i> Format File Excel PPN</a></td>
                        </tr>
                    </table>
                </div>
            </div>
    </div>
   @endif
  <!-- /.col -->
</div>
<!-- /.row -->

</section>
<!-- /.content -->

@include('modal-pengaturan')
@endsection

@push('simpan')
<script>
    function lihat(a){
        
            window.location.assign("{{url('_file_pengumuman/')}}/"+a);
        
    }
</script>
@endpush
