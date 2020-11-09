@extends('layouts.app_admin')
<?php error_reporting(0); ?>

@section('content')
<style>
.merk{
    background:aqua;
    font-weight:bold;
    border:solid 1px aqua;
}
.tdtd{
    border:solid 1px aqua;
}
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
<section class="head">
    <div class="judul">
        <i class="fa fa-clone"></i> Berita Acara
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <div style="display:flex;width:100%;background:aqua;padding:5px;margin-bottom:5px">
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                <input type="text" name="mulai" id="mulai" class="form-control" value="{{$mulai}}" style="width: 100%;display: inline;" placeholder="Mulai">
                            </div>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-calendar-o"></i></span>
                                <input type="text" name="sampai" id="sampai" class="form-control" value="{{$sampai}}" style="width: 100%;display: inline;" placeholder="Sampai">
                            </div>
                            <select id="group" class="form-control" style="width: 20%;display: inline;">
                                @foreach(group() as $group)
                                    <option value="{{$group['id']}}" @if($group['id']==$groupnya) selected @endif >{{$group['name']}}</option>
                                @endforeach
                            </select>
                            
                            <span   class="btn btn-primary btn-sm"   onclick="cari()" style="margin-left:5px;" ><i class="fa fa-search"></i> Cari</span>
                            <span  style="margin-right:5px" onclick="berita_acara()" class="btn btn-success pull-left">Download Excel</span>
                            <span  style="margin-right:5px" onclick="pdf_berita_acara()" class="btn btn-warning pull-left">Download PDF</span>
                        </div>
                        <div style="width:100%;background:#f7f7f6;border-radius:5px;padding:10px;margin-bottom:20px">
                            <table width="100%">
                                <tr>
                                    <td class="merk" width="18%">Total Nilai Faktur</td>
                                    <td class="tdtd" width="30%">{{number(ba_total_nilai_faktur($mulai,$sampai,$groupnya))}}</td>
                                    <td  class="merk" width="18%">Total Dokumen Faktur</td>
                                    <td class="tdtd">{{ba_total_dok_faktur($mulai,$sampai,$groupnya)}}</td>
                                </tr>
                                <tr>
                                    <td  class="merk">Total Nilai Kwitansi</td>
                                    <td class="tdtd">{{number(ba_total_nilai_kwitansi($mulai,$sampai,$groupnya))}}</td>
                                    <td  class="merk">Total Dokumen Non Faktur</td>
                                    <td class="tdtd">{{ba_total_dok_non_faktur($mulai,$sampai,$groupnya)}}</td>
                                </tr>
                            </table>
                        </div>
                        <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                            @csrf
                            <table   class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal Faktur</th>
                                        <th>Nama Vendor</th>
                                        <th>No Faktur</th>
                                        <th width="20%">No Kwitansi</th>
                                        <th>Nilai Faktur</th>
                                        <th>Nilai Kwitansi</th>
                                        <th>Posisi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach(bttd_laporan($mulai,$sampai,$groupnya) as $no=>$data)
                                    <tr>
                                        <td>{{($no+1)}}</td>
                                        <td>{{$data->tgl_create}}</td>
                                        <td><b>[{{$data->nik}}]</b> {{cek_user($data->nik)['name']}}</td>
                                        <td>{{$data->no_faktur}}</td>
                                        <td>{{$data->no_kwitansi}}</td>
                                        <td><b>{{$data->mata_uang}}</b> {{number($data->nilai_faktur)}}</td>
                                        <td><b>{{$data->mata_uang}}</b> {{number($data->nilai_kwitansi)}}</td>
                                        <td>{{posisi($data['status'])}}</td>
                                        
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


<div class="modal fade" id="modalkirim" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Pengiriman BTTD </h4>
            </div>
            <div class="modal-body">
                    <div id="notifikasi"></div>
                    
                    <div class="form-group">
                        <label>Kirim Kepada</label>
                        <select name="role_id" id="role_id" class="form-control">
                            <option value="">Pilih Kepada------</option>
                            @foreach(role_kirim() as $rolekirim)
                                <option value="{{$rolekirim->id}}">{{$rolekirim->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    
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

@endsection

@push('datepicker')
    <script>
        $('#mulai').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        })
        $('#sampai').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true
        })
    </script>
@endpush
@push('simpan')
<script>

    function cek_nilai_kwitansi(a){
        $('#kwitansi').val(a);
    }

    function cari(){
        var mulai=$('#mulai').val();
        var sampai=$('#sampai').val();
        var group=$('#group').val();
        if(mulai=='' || sampai==''){
            alert('Pilih tanggal mulai dan sampai');
        }else{
            window.location.assign("{{url('/bttd/laporan')}}?mulai="+mulai+"&sampai="+sampai+"&group="+group);
        }
         
        
    }
    function berita_acara(){
        var mulai=$('#mulai').val();
        var sampai=$('#sampai').val();
        var group=$('#group').val();
        if(mulai=='' || sampai==''){
            alert('Pilih tanggal mulai dan sampai');
        }else{
            window.location.assign("{{url('/bttd/berita_acara')}}/"+mulai+"/"+sampai+"/"+group);
        }
         
        
    }
    function pdf_berita_acara(){
        var mulai=$('#mulai').val();
        var sampai=$('#sampai').val();
        var group=$('#group').val();
        if(mulai=='' || sampai==''){
            alert('Pilih tanggal mulai dan sampai');
        }else{
            window.location.assign("{{url('/bttd/pdf_berita_acara')}}/"+mulai+"/"+sampai+"/"+group);
        }
         
        
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
        var role_id=$('#role_id').val();
            if(role_id==''){
                $('#notifikasi').html('<p style="background:yellow;padding:5px">Pilih Tujuan Pengiriman</p>');
            }else{
                    $.ajax({
                        type: 'POST',
                        url: "{{url('/bttd/dikirim')}}/"+role_id,
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
