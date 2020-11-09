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
                            <span  style="margin-right:5px" data-toggle="modal"  data-target="#modalkirim"class="btn btn-success pull-left">Kirim</span>
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
                            
                        </div>
                        <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                            @csrf
                            <table  id="tabel_id" class="table table-bordered table-striped">
                                
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
        $('#datepicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true
        })
    </script>
@endpush
@push('simpan')
<script>
$(document).ready(function() {
    
    var table = $('#tabel_id').DataTable({
        responsive: true,
        "ajax": {
            "type": "GET",
            "url": "{{url('api/bttd_admin_diterima/'.$bulan.'/'.$tahun)}}",
            "timeout": 120000,
            "dataSrc": function (json) {
                if(json != null){
                    return json
                } else {
                    return "No Data";
                }
            }
        },
        "sAjaxDataProp": "",
        "width": "100%",
        "order": [[ 0, "asc" ]],
        "aoColumns": [
            {
                "mData": null,
                "width":"5%",
                "title": "No",
                render: function (data, type, row, meta) {
                    if(data.status==1){
                        inpt='<input type="checkbox" name="id[]" value="'+data.id+'">';
                        return inpt;
                    }else{
                        return meta.row + meta.settings._iDisplayStart + 1;
                    }
                    
                }
            },
            {
                "mData": null,
                "title": "Diterima",
                "render": function (data, row, type, meta) {
                    if(data.status==1){
                        return data.diterima;
                    }else{
                        return data.diterima;
                    }
                }
            },
            {
                "mData": null,
                "title": "Nama Vendor",
                "render": function (data, row, type, meta) {
                    return '<b>['+data.nik+']</b> '+data.name;
                }
            },
            {
                "mData": null,
                "title": "No Faktur",
                "render": function (data, row, type, meta) {
                    return data.no_faktur;
                }
            },
            {
                "mData": null,
                "title": "No Kwitansi",
                "render": function (data, row, type, meta) {
                    return data.no_kwitansi;
                }
            },
            {
                "mData": null,
                "title": "Nilai Faktur",
                "render": function (data, row, type, meta) {
                    return '<b>'+data.mata_uang+'</b> '+data.nilai_faktur;
                }
            },
            {
                "mData": null,
                "title": "Nilai Kwitansi",
                "render": function (data, row, type, meta) {
                    return '<b>'+data.mata_uang+'</b> '+data.nilai_kwitansi;
                }
            },
            {
                "mData": null,
                "title": "Posisi",
                "render": function (data, row, type, meta) {
                    return data.posisi;
                }
            },
            {
                "mData": null,
                "title": "View",
                "width":"5%",
                "sortable": false,
                "render": function (data, row, type, meta) {
                    let tom = '';

                    
                        tom += "<span style='font-size: 11px;' class='btn btn-primary' id='edit' name='edit' title='Lihat Detail'><i class='fa fa-search'></i></span>";
                    

                    return tom;
                }
            }
        ]
    });

    
    $('#tabel_id tbody').on( 'click', '#edit', function () {
        var url="{{url('/bttd/laporan_bttd/')}}";
        var current_row = $(this).parents('tr');
        if (current_row.hasClass('child')) {
            current_row = current_row.prev();
        }
        var data = table.row( current_row ).data();

        $("#file").html('<iframe width="100%" height="100%" src="'+url+'/'+data['id']+'" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>');
        $("#EditModal").modal("show");
    });

});
</script>
<script>

    function cek_nilai_kwitansi(a){
        $('#kwitansi').val(a);
    }

    function cari(){
        var bulan=$('#bulan').val();
        var tahun=$('#tahun').val();
        if(bulan=='' || tahun==''){
            alert('Pilih bulan dan tahun');
        }else{
            window.location.assign("{{url('/bttd/terima')}}?bulan="+bulan+"&tahun="+tahun);
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
