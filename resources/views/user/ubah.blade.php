@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
@media only screen and (min-width: 650px) {
        th{
            font-size: 0.9vw;
            font-family: sans-serif;
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.9vw;
            font-family: sans-serif;
        }
    }
    @media only screen and (max-width: 649px) {
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            font-family: sans-serif;
        }
    }
</style>
<section class="head">
    <div class="judul">
        <i class="fa fa-users"></i> User Akses
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                            @csrf
                            
                                <div class="form-group">
                                    <label>Nama {{$rolenya}}</label>
                                    <input type="text"  name="name" value="{{$data['name']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>NIK</label>
                                    <input type="text"  name="nik"  value="{{$data['nik']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Akses</label>
                                    <select  name="role_id"  class="form-control">
                                        @foreach(role() as $role)
                                            <option value="{{$role['id']}}" @if($role['id']==$data['role_id']) selected @endif>{{$role['name']}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="text"  name="email"  value="{{$data['email']}}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label>Status</label>
                                    <select  name="sts"  class="form-control">
                                    
                                            <option value="1" @if($data['sts']==1) selected @endif>Active</option>
                                            <option value="0" @if($data['sts']==0) selected @endif>Off</option>
                                    
                                    </select>
                                </div>
                                
                        </form>
                        <div style="width:100%;display:flex;">
                            <span id="simpan_data" style="margin-right:1%" onclick="simpan_data({{$data->id}})" class="btn btn-primary pull-left">Simpan</span>
                            <span id="tutup_simpan_data" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                            <div style="width:100%;text-align:center" id="proses_loading_simpan_data">
                            
                            </div>
                        </div>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>


<div class="modal fade" id="modalnotif" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Form Aplikasi </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
                
                <div style="width:100%;display:flex;">
                     <span  style="margin-right:2%" onclick="tutup()" class="btn btn-primary pull-left">OK</span>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal modal-fullscreen fade" id="modalloading" >
    <div class="modal-dialog" style="margin-top: 15%;">
        <div class="modal-content" style="background: transparent;">
            
            <div class="modal-body" style="text-align:center">
                <img src="{{url('icon/loading.gif')}}">
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('simpan')

<script>
    
    function tutup(){
        location.reload();
    }

    function ubah(a){
        window.location.assign("{{url('user/ubah/')}}/"+a)
    }

    function hapus(a){
        //$('#modalnotif').modal({backdrop: 'static', keyboard: false});
        $.ajax({
            type: 'GET',
            url: "{{url('/user/hapus')}}/"+a,
            data: "id="+a,
            success: function(msg){
                $('#modalnotif').modal({backdrop: 'static', keyboard: false});
                $('#notifikasinya').html('Sukses Dihapus');
            }
        });
    }

    function simpan_data(a){
        var form=document.getElementById('mysimpan_data');
        var roless="{{$rolenya}}";
        
            $.ajax({
                type: 'POST',
                url: "{{url('/user/edit')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_data').hide();
                    $('#tutup_simpan_data').hide();
                    $('#modalloading').modal({backdrop: 'static', keyboard: false});
                    
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        window.location.assign("{{url('user')}}?role="+roless)
                    }else{
                        $('#simpan_data').show();
                        $('#tutup_simpan_data').show();
                        $('#modalloading').modal('hide');
                        $('#modalnotif').modal('show');
                        $('#notifikasi').html(msg);
                    }
                    
                    
                }
            });

    } 

    

</script>
@endpush
