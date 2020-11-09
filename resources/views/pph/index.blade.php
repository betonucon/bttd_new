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
        <i class="fa fa-clone"></i> Bukti Potong PPH
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <div style="display:flex;width:100%;background:aqua;padding:5px;margin-bottom:20px">
                            <span  class="btn btn-primary btn-sm" style="margin-right:5px;" onclick="tambah()" ><i class="fa fa-plus"></i> Tambah</span>
                        </div>
                        <table  id="tabel_id" class="table table-bordered table-striped">
                            
                        </table>
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
$(document).ready(function() {
    
    var table = $('#tabel_id').DataTable({
        responsive: true,
        "ajax": {
            "type": "GET",
            "url": "{{url('bukti/api')}}",
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
                    return meta.row + meta.settings._iDisplayStart + 1;
                }
            },
            {
                "mData": null,
                "title": "Kode ",
                "render": function (data, row, type, meta) {
                    return data.nik;
                }
            },
            {
                "mData": null,
                "title": "Nama Vendor",
                "render": function (data, row, type, meta) {
                    return data.name;
                }
            },
            {
                "mData": null,
                "title": "Total Dokumen",
                "render": function (data, row, type, meta) {
                    return data.total;
                }
            },
            {
                "mData": null,
                "title": "Pengambilan",
                "render": function (data, row, type, meta) {
                    return data.total_ok;
                }
            },
            
            {
                "mData": null,
                "title": "Act",
                "width":"5%",
                "render": function (data, row, type, meta) {
                    let btn = '';

                        
                        btn +='<span class="btn btn-primary btn-xs" onclick="view('+data.nik+')"><i class="fa fa-search"></i></span>';
                    return btn;
                }
            }
            
        ]
    });

    
    

});
</script>
<script>
    
    function tutup(){
        location.reload();
    }

    function view(a){
        window.location.assign("{{url('bukti/pph_view/')}}/"+a)
    }
    function tambah(){
        window.location.assign("{{url('bukti/import_pph/')}}")
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

    
</script>
@endpush
