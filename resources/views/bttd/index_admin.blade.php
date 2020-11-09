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
                            <table  id="tabel_id" class="table table-bordered table-striped">
                                
                            </table>
                        </form>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>

<div id="EditModal" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg" style="width:90%">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Modal Header</h4>
                <button type="button" class="close" data-dismiss="modal" >
                    <span aria-hidden="true">&times;</span>
                    <span class="sr-only">Close</span>
                </button>
            </div>
            <div class="modal-body">
            <div id="file"></div>
                
            </div>  
            <div class="modal-footer">
                <button class="btn btn-default" data-dismiss="modal">
                Close
                </button>
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
            "url": "{{url('api/bttd_admin/'.$bulan.'/'.$tahun)}}",
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
                "title": "<input type='checkbox'  id='pilihsemua'>",
                "width":"3%",
                "sortable": false,
                "render": function (data, row, type, meta) {
                    let btn = '';

                    
                            btn += '<input type="checkbox" id="pilih" name="id[]" value="'+data.id+'"><input type="hidden"  name="tahun_angkatan[]" value="'+data.tahun_angkatan+'">';
                        

                    return btn;
                }
            },
            {
                "mData": null,
                "title": "Diterima",
                "render": function (data, row, type, meta) {
                    return data.tgl_of_terima;
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

                    
                        tom += "<span style='font-size: 11px;' class='btn btn-primary btn-sm' id='edit' name='edit' title='Lihat Detail'><i class='fa fa-search'></i></span>";
                    

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

    $('#pilihsemua').click(function(){
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]').not(this).prop('checked', this.checked);
        // $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });

});
</script>
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
