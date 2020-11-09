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
        <i class="fa fa-users"></i> Role Akses
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <table  id="tabel_id" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="5%">No</th>
                                    <th>Nama</th>
                                    <th width="5%">Status</th>
                                    <th width="8%"></th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach(user() as $no=>$data)
                                <tr>
                                    <td>{{$no+1}}</td>
                                    <td>{{$data->name}}</td>
                                    <td>
                                        @if($data['sts']==1)
                                            <span class="btn btn-warning btn-xs">Actif</span>
                                        @else
                                            <span class="btn btn-default btn-xs">Off</span>
                                        @endif
                                       
                                    </td>
                                    <td>
                                        <span class="btn btn-success btn-xs" data-toggle="modal" data-target="#modaledit{{$data->id}}"><i class="fa fa-pencil"></i></span>_
                                        <span class="btn btn-danger btn-xs" onclick="hapus({{$data['id']}})"><i class="fa fa-remove"></i></span>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>
@foreach(user() as $no=>$data)
<div class="modal fade" id="modaledit{{$data->id}}" >
    <div class="modal-dialog">
        <div class="modal-content" >
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Role Akses </h4>
            </div>
            <div class="modal-body" >
                <div id="notifikasi_edit{{$data->id}}"></div>
                   
                    <form method="post" id="myedit_simpan_data{{$data->id}}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label>Nama </label>
                            <input type="text"  name="name" value="{{$data['name']}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Status Aktif</label>
                            <select  name="sts"  class="form-control">
                               
                                    <option value="1" @if($data['sts']==1) selected @endif>Active</option>
                                    <option value="0" @if($data['sts']==0) selected @endif>Off</option>
                               
                            </select>
                        </div>
                    </form>
                    
                    <div style="width:100%;display:flex;">
                        <span id="edit_simpan_data{{$data->id}}" style="margin-right:2%" onclick="edit_simpan_data({{$data->id}},{{$data['nik']}})" class="btn btn-primary pull-left">Simpan</span>
                        <span id="tutup_edit_simpan_data{{$data->id}}" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                        <div style="width:100%;text-align:center" id="proses_loading_edit_simpan_data{{$data->id}}">
                        
                        </div>
                    </div>
            </div>
            
        </div>
    </div>
</div>
@endforeach
<div class="modal fade" id="modaltambah" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Form Aplikasi </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
                <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                    @csrf
                        <div class="form-group">
                            <label>Nama </label>
                            <input type="text"  name="name" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text"  name="nik"  class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="text"  name="email"  class="form-control">
                        </div>
                </form>
                <div style="width:100%;display:flex;">
                     <span id="simpan_data" style="margin-right:2%" onclick="simpan_data()" class="btn btn-primary pull-left">Simpan</span>
                    <span id="tutup_simpan_data" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                    <div style="width:100%;text-align:center" id="proses_loading_simpan_data">
                    
                    </div>
                </div>
            </div>
            
        </div>
    </div>
</div>
<div class="modal fade" id="modalnotif" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Form Aplikasi </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasinya"></div>
                
                <div style="width:100%;display:flex;">
                     <span  style="margin-right:2%" onclick="tutup()" class="btn btn-primary pull-left">OK</span>
                    
                </div>
            </div>
            
        </div>
    </div>
</div>

@endsection

@push('simpan')

<script>
    $(function () {
        $('#example1').DataTable({
            'paging'      : true,
            'lengthChange': false,
            'searching'   : true,
            'ordering'    : true,
            'info'        : true,
            'autoWidth'   : false
        })
    });  
    function tutup(){
        location.reload();
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

    function simpan_data(){
        var form=document.getElementById('mysimpan_data');
        var a="{{$id}}";
            $.ajax({
                type: 'POST',
                url: "{{url('/user/simpan')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#simpan_data').hide();
                    $('#tutup_simpan_data').hide();
                    $('#proses_loading_simpan_data').html('Proses Data ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#simpan_data').show();
                        $('#tutup_simpan_data').show();
                        $('#proses_loading_simpan_data').html('');
                        $('#notifikasi').html(msg);
                    }
                    
                    
                }
            });

    } 

    function edit_simpan_data(a){
        var form=document.getElementById('myedit_simpan_data'+a);
        
            $.ajax({
                type: 'POST',
                url: "{{url('/user/simpan_akses')}}/"+a,
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    $('#edit_simpan_data'+a).hide();
                    $('#tutup_edit_simpan_data'+a).hide();
                    $('#proses_loading_edit_simpan_data'+a).html('Proses Pembayaran ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        location.reload();
                    }else{
                        $('#edit_simpan_data'+a).show();
                        $('#tutup_edit_simpan_data'+a).show();
                        $('#proses_loading_edit_simpan_data'+a).html('');
                        $('#notifikasi_edit'+a).html(msg);
                    }
                    
                    
                }
            });

    } 
</script>
@endpush
