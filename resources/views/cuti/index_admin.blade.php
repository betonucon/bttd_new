@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
@media only screen and (min-width: 650px) {
        th{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
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
        .tth{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.9vw;
            background:aqua;
            font-family: sans-serif;
        }
        .ttd{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 0.9vw;
            background:#fff;
            font-family: sans-serif;
        }
    }
    @media only screen and (max-width: 649px) {
        th{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            font-family: sans-serif;
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            font-family: sans-serif;
        }
        .tth{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            background:aqua;
            font-size: 3vw;
            font-family: sans-serif;
        }
        .ttd{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 3vw;
            background:#fff;
            font-family: sans-serif;
        }
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <div class="input-group " style="background:#eaeaea;width:100%;padding:5px;margin-bottom:2%">
                            <form method="post" id="mydataini" enctype="multipart/form-data">
                                @csrf
                                <select name="bulan" class="form-control" style="width:20%">
                                    @for($x=1;$x<13;$x++)
                                        <option value="{{bln($x)}}">{{bulan(bln($x))}}</option>
                                    @endfor
                                </select>    
                                <span  id="upload" class="btn btn-primary btn-sm"   onclick="upload_data_unit()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-search"></i> Upload</span>
                                <span  class="btn btn-default btn-sm" onclick="reload()"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-refresh"></i> Reload</span>
                            </form>
                        </div>
                        <div class="div-scroll">
                            <table  id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Unit Kerja</th>
                                        <th>Total</th>
                                        <th>Sisa Cuti</th>
                                        <th width="5%">Detail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach(cuti_admin($bulan,$tahun) as $no=>$data)
                                    <tr>
                                        <td>{{$no+1}}</td>
                                        <td>{{$data->nik}}</td>
                                        <td>{{cek_user($data->nik)['name']}}</td>
                                        <td>
                                            <b>Unit Kerja : </b>{{cek_unitkerja(cek_user($data->nik)['unit_kerja_id'])['name']}}<br>
                                            <b>Manager : </b>{{cek_user(cek_unitkerja(cek_user($data->nik)['unit_kerja_id'])['nik_atasan'])['name']}}
                                        </td>
                                        <td>{{cuti_admin_detail($data->nik,$bulan,$tahun)}} Hari</td>
                                        <td>{{sisa_cuti_bulanan($data->nik,$bulan,$tahun)}}</td>
                                        <td>
                                            <span class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaledit{{$data->id}}"><i class="fa fa-search"></i></span>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>
@foreach(cuti_admin($bulan,$tahun) as $no=>$data)
<div class="modal fade" id="modaledit{{$data->id}}" >
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Detail Cuti</h4>
            </div>
            <div class="modal-body">
                <table width="100%">
                    <tr>
                        <th class="tth" width="6%">No</th>
                        <th class="tth" width="20%">Nama</th>
                        <th class="tth" width="15%">NIk</th>
                        <th class="tth" width="30%">Cuti</th>
                        <th class="tth" >Pengajuan</th>
                    </tr>
                    @foreach(get_cuti_admin_detail($data['nik'],$bulan,$tahun) as $x=>$detail)
                        <tr>
                            <td class="ttd">{{$x+1}}</td>
                            <td class="ttd">{{cek_user($detail['nik'])['name']}}</td>
                            <td class="ttd">{{$detail['nik']}}</td>
                            <td class="ttd">{{$detail['tanggal_cuti']}}</td>
                            <td class="ttd">{{$detail['tanggal']}}</td>
                        </tr>
                    @endforeach
                </table>
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
                <h4 class="modal-title">Form Pengajuan Cuti </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
                <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                    @csrf
                        
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" disabled value="{{Auth::user()['nik']}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" disabled value="{{Auth::user()['name']}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Mulai</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="tanggal_mulai" class="form-control" id="datepicker1" placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Sampai</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                <input type="text" name="tanggal_sampai" class="form-control" id="datepicker2" placeholder="Tanggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Alasan Cuti</label>
                            <textarea name="name" class="form-control" rows="4" style="width:100%;"></textarea>
                        </div>
                        <div class="form-group">
                            <label>Lampiran</label>
                            <input type="file"  name="file" accept="png.jpg.jpeg.gif" class="form-control">
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

@push('datepicker')
<script>
    @foreach(cuti_karyawan() as $no=>$data)
        $('#datepickeredit{{$data['id']}}').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        })
    @endforeach
    $('#datepicker1').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    })
    $('#datepicker2').datepicker({
      format: 'yyyy-mm-dd',
      autoclose: true
    })
</script>
@endpush
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
            url: "{{url('/cuti/hapus')}}/"+a,
            data: "id="+a,
            success: function(msg){
                $('#modalnotif').modal({backdrop: 'static', keyboard: false});
                $('#notifikasinya').html('Sukses Dihapus');
            }
        });
    }

    function validasi_all(){
        //$('#modalnotif').modal({backdrop: 'static', keyboard: false});
        $.ajax({
            type: 'GET',
            url: "{{url('/cuti/validasi_all')}}/",
            data: "id=all",
            beforeSend: function(){
                $('#validasi_all').hide();
                $('#tolak_validasi_all').hide();
                $('#to_pdf').hide();
                $('#proses_loading').html('Proses Data ....................');
            },
            success: function(msg){
                location.reload();
            }
        });
    }

    function tolak_validasi_all(){
        //$('#modalnotif').modal({backdrop: 'static', keyboard: false});
        $.ajax({
            type: 'GET',
            url: "{{url('/cuti/tolak_validasi_all')}}/",
            data: "id=all",
            beforeSend: function(){
                $('#validasi_all').hide();
                $('#tolak_validasi_all').hide();
                $('#to_pdf').hide();
                $('#proses_loading').html('Proses Data ....................');
            },
            success: function(msg){
                location.reload();
            }
        });
    }

    function simpan_data(){
        var form=document.getElementById('mysimpan_data');
        var a="{{$id}}";
            $.ajax({
                type: 'POST',
                url: "{{url('/cuti/simpan')}}",
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
                url: "{{url('/cuti/validasi_data')}}/"+a,
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
