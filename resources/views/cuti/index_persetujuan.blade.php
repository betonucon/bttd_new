@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
.alert{
    background:#fff;
    border:solid 1px #dac7c7;
    font-size: 3vw;
}
    @media only screen and (min-width: 650px) {
        .mobile{
            display:none;
        }
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
    }
    @media only screen and (max-width: 649px) {
        .pc{
            display:none;
        }
        .btn{
            font-size:2.5vw;
        }
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
    }
</style>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <div class="input-group " style="background:#eaeaea;width:100%;padding:5px;margin-bottom:2%">
                        @if(total_cuti_karyawan_persetujuan()>0)
                            <span  id="validasi_all" class="btn btn-primary btn-sm"   onclick="validasi_all()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-check"></i> Validasi Semua </span>
                            <span  id="tolak_validasi_all" class="btn btn-danger btn-sm"   onclick="tolak_validasi_all()" style="margin-left:5px;margin-top:2px" ><i class="fa fa-remove"></i> Tolak Semua Cuti </span>
                        @else
                            <span  id="validasi_all" class="btn btn-default btn-sm"    style="margin-left:5px;margin-top:2px" ><i class="fa fa-check"></i> Validasi Semua </span>
                            <span  id="tolak_validasi_all" class="btn btn-default btn-sm"   style="margin-left:5px;margin-top:2px" ><i class="fa fa-remove"></i> Tolak Semua Cuti </span>
                        @endif
                            <span  class="btn btn-default btn-sm" id="to_pdf" onclick="reload()"  style="margin-left:5px;margin-top:2px" ><i class="fa fa-refresh"></i> PDF</span>
                            <div id="proses_loading"></div>
                        </div>

                        <div class="pc">
                            <table  id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Unit Kerja</th>
                                        <th>Tgl Cuti</th>
                                        <th>Tgl Pengajuan</th>
                                        <th width="5%">Attach</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach(cuti_karyawan_persetujuan() as $no=>$data)
                                    <tr>
                                        <td>{{$no+1}}</td>
                                        <td>{{$data->nik}}</td>
                                        <td>{{cek_user($data->nik)['name']}}</td>
                                        <td>
                                            <b>Unit Kerja : </b>{{cek_unitkerja(cek_user($data->nik)['unit_kerja_id'])['name']}}<br>
                                            <b>Manager : </b>{{cek_user(cek_unitkerja(cek_user($data->nik)['unit_kerja_id'])['nik_atasan'])['name']}}
                                        </td>
                                        <td>{{$data->tanggal_cuti}}</td>
                                        <td>{{$data->tanggal}}</td>
                                        <td>
                                            @if($data['file']=='')

                                            @else
                                                <a href="{{url('_file_cuti/'.$data['file'])}}" target="_blank"><span class="btn btn-default btn-sm" ><i class="fa fa-clone"></i></a>
                                            @endif
                                            
                                        </td>
                                        <td><span class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaledit{{$data->id}}"><i class="fa fa-check-circle-o"></i></span></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="mobile">
                            <table  id="example2" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>Daftar Cuti</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach(cuti_karyawan_persetujuan() as $no=>$data)
                                    <tr>
                                        <td>
                                            <div class="alert alert-dismissible" @if($no%2==0) style="background:#fff9f9" @endif>
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                                                <i class="fa fa-check-circle-o"></i><b>Nama :</b> {{cek_user($data['nik'])['name']}}<br>
                                                <i class="fa fa-check-circle-o"></i><b>NIK :</b> {{$data['nik']}}<br>
                                                <i class="fa fa-check-circle-o"></i><b>Unit Kerja : </b>{{cek_unitkerja(cek_user($data->nik)['unit_kerja_id'])['name']}}<br>
                                                <i class="fa fa-check-circle-o"></i><b>Tanggal Cuti :</b> {{$data['tanggal_cuti']}}<br>
                                                <i class="fa fa-check-circle-o"></i><b>Alasan :</b> {{$data['name']}}<br><br>
                                                <span class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaledit{{$data->id}}"><i class="fa fa-check-circle-o"></i> Proses</span>
                                            </div>
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
@foreach(cuti_karyawan_persetujuan() as $no=>$data)
<div class="modal fade" id="modaledit{{$data->id}}" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Form Pengajuan Cuti </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi_edit{{$data->id}}"></div>
                <form method="post" id="myedit_simpan_data{{$data->id}}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="tanggal_sebelumnya" value="{{$data['tanggal_cuti']}}">
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="text" disabled value="{{$data['nik']}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" disabled value="{{cek_user($data['nik'])['name']}}" class="form-control">
                        </div>
                        <div class="form-group">
                            <label>Tanggal Cuti</label>
                            <input type="text" disabled value="{{$data['tanggal_cuti']}}" class="form-control">
                        </div>
                        
                        <div class="form-group">
                            <label>Alasan Cuti</label>
                            <textarea name="name" disabled class="form-control" rows="4" style="width:100%;">{{$data['name']}}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Kategori Validasi</label>
                            <select name="sts" class="form-control">
                                <option value="">Pilih Kategori</option>
                                {!!kategori_validasi()!!}}
                            </select>
                        </div>
                        
                </form>
                <div style="width:100%;display:flex;">
                     <span id="edit_simpan_data{{$data->id}}" style="margin-right:2%" onclick="edit_simpan_data({{$data->id}})" class="btn btn-primary pull-left">Simpan</span>
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
        $('#example2').DataTable({
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
