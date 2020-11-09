@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
@media only screen and (min-width: 650px) {
        th{
            padding:5px;
            font-size: 12px;
            font-family: sans-serif;
        }
        .form-control{
            font-size:12px;
            padding:5px;
        }
        label{
            font-size:12px;
        }
        td{
            padding:5px;
            border:solid 1px #bf9898;
            color: #575282;
            font-size: 12px;
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
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <div style="display:flex;width:100%;background:aqua;padding:5px;margin-bottom:20px">
                            <span id="simpan_data" style="margin-right:2%" onclick="simpan_data()" class="btn btn-primary pull-left">Diterima</span>
                            <select id="tahun" class="form-control" style="width: 20%;display: inline;">
                                @for($x=2019;$x<2030;$x++)
                                    <option value="{{$x}}" @if($x==$tahun) selected @endif>{{$x}}</option>
                                @endfor
                            </select>
                            <select id="bulan" class="form-control" style="width: 20%;display: inline;">
                                @for($x=1;$x<13;$x++)
                                    <?php
                                        if($x>9){$bul=$x;}else{$bul='0'.$x;}
                                    ?>
                                    <option value="{{$x}}" @if($x==$bulan) selected @endif>{{bulan($bul)}}</option>
                                @endfor
                            </select>
                            <span   class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;" ><i class="fa fa-search"></i> Cari</span>
                            <div style="width:100%;text-align:center" id="proses_loading_simpan_data">
                            
                            </div>
                        </div>
                        <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                            @csrf
                            <table  id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="5%">No</th>
                                        <th>Nama Vendor</th>
                                        <th>No Faktur</th>
                                        <th width="20%">No Kwitansi</th>
                                        <th>Nilai Faktur</th>
                                        <th>Nilai Kwitansi</th>
                                        <th>Posisi</th>
                                        <th width="5%"></th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach(bttd_baru($bulan,$tahun) as $no=>$data)
                                    <tr>
                                    
                                        @if(cek_position_bttd($data['id'],$data['status'])==1)
                                            <td><input type="checkbox" name="id[]" value="{{$data['id']}}"></td>
                                        @else
                                            <td>{{$no+1}}</td>
                                        @endif
                                        <td><b>[{{$data->nik}}]</b> {{cek_user($data->nik)['name']}}</td>
                                        <td>{{$data->no_faktur}}</td>
                                        <td>{{$data->no_kwitansi}}</td>
                                        <td><b>{{$data->mata_uang}}</b> {{number($data->nilai_faktur)}}</td>
                                        <td><b>{{$data->mata_uang}}</b> {{number($data->nilai_kwitansi)}}</td>
                                        <td>{{posisi($data['status'])}}</td>
                                        <td><span class="btn btn-default btn-sm" data-toggle="modal" data-target="#modalview{{$data->id}}"><i class="fa fa-clone"></i></td>
                                        
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </form>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>
@foreach(bttd_baru($bulan,$tahun) as $no=>$data)

    <div class="modal fade" id="modalview{{$data['id']}}" >
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span></button>
                    <h4 class="modal-title">Form Aplikasi </h4>
                </div>
                <div class="modal-body">
                    
                    
                    <div style="width:100%;display:flex;">
                        <span  style="margin-right:2%" onclick="tutup()" class="btn btn-primary pull-left">OK</span>
                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>

@endforeach
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
        $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
        })
    </script>
@endpush
@push('simpan')
<script>
    function cari(){
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
        if(bulan=='' || tahun==''){
            alert('Pilih bulan dan tahun');
        }else{
            window.location.assign("{{url('/bttd')}}?bulan="+bulan+"&tahun="+tahun);
        }
         
        
    }
    function cek_nilai_kwitansi(a){
        $('#kwitansi').val(a);
    }
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
            url: "{{url('/aplikasi/hapus')}}/"+a,
            data: "id="+a,
            success: function(msg){
                $('#modalnotif').modal({backdrop: 'static', keyboard: false});
                $('#notifikasinya').html('Sukses Dihapus');
            }
        });
    }
    function cek_tagihan(a){
        //$('#modalnotif').modal({backdrop: 'static', keyboard: false});
        
        $.ajax({
            type: 'GET',
            url: "{{url('/bttd/cek_tagihan')}}/"+a,
            data: "id="+a,
            success: function(msg){
                alert(msg);
                $('#tagihandetail').html(msg);
            }
        });
    }

    function simpan_data(){
        var form=document.getElementById('mysimpan_data');
        
            $.ajax({
                type: 'POST',
                url: "{{url('/bttd/diterima')}}",
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
                    location.reload();
                }
            });

    } 

    function edit_simpan_data(a){
        var form=document.getElementById('myedit_simpan_data'+a);
        
            $.ajax({
                type: 'POST',
                url: "{{url('/aplikasi/edit')}}/"+a,
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
