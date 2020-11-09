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
@media only screen and (min-width: 650px) {
        #inews{
            height: 510px;
            border: 1px dotted #fff;
            padding:0px 2px 0px 0px;
            overflow-y: scroll; /* Add the ability to scroll */
        }
        #inews::-webkit-scrollbar {
            display: none;
        }

        #inews {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        td{
            padding:5px;
            border:solid 1px none;
            font-weight:bold;
            color: #000;
            text-transform:uppercase;
            font-size: 0.9vw;
            font-family: sans-serif;
        }
        #item{
            padding: 5px 0px 0px 0px;
            font-size: 0.8vw;
        }
        .apl{
            
            border: solid 1px #e2dbdb;
            width:130px;
            height:100px;
            text-align:center;
            display:grid;
            float:left;
            padding-top:1% ;
            margin:1%;
        }
        .modal-lg {
            width: 90%;
        }
        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            width:100%;
            height:500px;;
            margin: auto;
        }
        .icon-apl{
            width:60px;
            height:60px;
        }
        .lab{
            font-size:0.8vw;
        }
    }
    @media only screen and (max-width: 649px) {
        #inews{
            height: 510px;
            border: 1px dotted #fff;
            padding:0px 2px 0px 0px;
            overflow-y: scroll; /* Add the ability to scroll */
        }
        #inews::-webkit-scrollbar {
            display: none;
        }
        .modal-lg {
            width: 95%;
        }
        #inews {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            font-family: sans-serif;
        }
        #item{
            padding: 5px 0px 0px 0px;
            font-size: 3vw;
        }
        .apl{
            
            border: solid 1px #e2dbdb;
            width:85px;
            height:100px;
            padding-top:2%;
            margin-bottom:5%;
            text-align:center;
            display:grid;
            float:left;
            margin:2%;
        }
        .carousel-inner > .item > img, .carousel-inner > .item > a > img {
            width:100%;
            height:400px;;
            margin: auto;
        }
        .icon-apl{
            width:50px;
            height:50px;
        }
        .lab{
            font-weight:bold;
            font-size:3vw;
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

            <h3 class="profile-username text-center">{{Auth::user()['name']}}</h3>

            <p class="text-muted text-center">{{Auth::user()['nik']}}</p>

            <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                    <b>No HP</b> <a class="pull-right">1,322</a>
                </li>
                <li class="list-group-item">
                    <b>Following</b> <a class="pull-right">543</a>
                </li>
            </ul>

            <a href="#" class="btn btn-primary btn-block" data-toggle="modal"  data-target="#modalfoto"><b><i class="fa fa-pencil"></i> Ubah Foto Profil</b></a>
        </div>
      <!-- /.box-body -->
    </div>

    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title">Tentang Saya</h3>
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
    <div class="nav-tabs-custom">
      <ul class="nav nav-tabs">
        <li class="@if($active=='datadiri') active @endif"><a href="#datadiri"  data-toggle="tab">Data Diri</a></li>
        <li class="@if($active=='slipgaji') active @endif"><a href="#slipgaji" data-toggle="tab">Slip Gaji</a></li>
        <li class="@if($active=='kartu') active @endif"><a href="#settings" data-toggle="tab">Settings</a></li>
      </ul>
      <div class="tab-content">
        <div class="@if($active=='datadiri') active @endif tab-pane" id="datadiri">
          
            <div class="post">
                <div class="form-group">
                    <label >Nama</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" readonly value="{{Auth::user()['name']}}">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label >NIK</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control" readonly value="{{Auth::user()['nik']}}">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                        </span>
                    </div>
                </div>
                <div class="form-group">
                    <label >Nomor Handphone</label>
                    <div class="input-group input-group-sm">
                        <input type="text" class="form-control">
                        <span class="input-group-btn">
                        <button type="button" class="btn btn-info btn-flat"><i class="fa fa-pencil"></i></button>
                        </span>
                    </div>
                </div>
                    
            </div>
            
          
        </div>

        <div class="@if($active=='slipgaji') active @endif tab-pane" id="slipgaji">
            <div class="post">
                <ul class="list-group list-group-unbordered">
                    @for($x=1;$x<13;$x++)
                        <li class="list-group-item" id="list">
                            <a href="#"><b>Slip Gaji {{bulan(bln($x))}}</b> <span class="pull-right">1,322</span></a>
                        </li>
                    @endfor
                </ul>
            </div>
        </div>

        <div class="@if($active=='kartu') active @endif tab-pane" id="settings">
            <div style="background:url('icon/kartu.jpg');padding:1%;width:62%;height:300px;margin-left:20%;border:solid 2px #000;border-radius:7px">
                <div class="kartu" style="border-bottom:solid 2px #211b27;width:100%;text-align:center;display:initial;height:89px"><img src="{{url('icon/kitt.png')}}" width="280px"></div>
                <div class="kartu" style="border:solid 2px #fff"><img style="width:100%" src="{{url('/'.foto())}}" alt="User profile picture"></div>
                <div class="kartu" style="width:380px;">
                    <table width="100%">
                        <tr>
                            <td width="30%">Nama</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>No KTP</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>: </td>
                        </tr>
                        <tr>
                            <td>Ttgl</td>
                            <td>: </td>
                        </tr>
                    </table>
                </div>
                <div class="kartu" style="width:380px;height:80px"></div>
                <div class="kartu" style="padding: 3px;width: 70px;height: 70px;;background:#fff">
                    <?php
                    $kodebar=Auth::user()['nik'].'-'.Auth::user()['name'];
                    ?>
                    {!!barcoderider($kodebar,2.5,2.5)!!}
                </div>
                
                <!-- <table width="100%" border="1">
                    <tr>
                        <td colspan="3" align="center"><img src="{{url('icon/kitt.png')}}" width="300px"></td>
                    </tr>
                    <tr>
                        <td width="20%" rowspan="5"><img class="profile-user-img img-responsive img-circle" src="{{url('/'.foto())}}" alt="User profile picture"></td>
                        <td>Nama</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: </td>
                    </tr>
                    <tr>
                        <td>Nama</td>
                        <td>: </td>
                    </tr>
                </table> -->
            </div>
        </div>

        <!-- /.tab-pane -->
      </div>
      <!-- /.tab-content -->
    </div>
    <!-- /.nav-tabs-custom -->
  </div>
  <!-- /.col -->
</div>
<!-- /.row -->

</section>
<!-- /.content -->

@include('modal-pengaturan')
@endsection

@push('simpan')
<script>
    function buka(link,php){
        if(php==1){
            window.location.assign(link+"?id={{base64_encode(Auth::user()['nik'])}}");
        }else{
            window.location.assign(link+"/a/{{base64_encode(Auth::user()['nik'])}}");
        }
        
    }
</script>
@endpush
