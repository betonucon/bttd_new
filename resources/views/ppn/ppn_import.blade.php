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
        <i class="fa fa-clone"></i> Import PPN 
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                    <div class="box-body">
                        <div style="display:-webkit-inline-box;width:100%;background:aqua;padding:5px;margin-bottom:20px">
                            <span  class="btn btn-success btn-sm" data-toggle="modal" data-target="#modaltambah"   ><i class="fa fa-cloud-upload"></i> Import</span>
                        </div>
                       
                            <table  id="tabel_id" class="table table-bordered table-striped">
                                
                            </table>
                        </form>
                     </div>
                   
                    
                
            </div>
       </div>
    </div>
</section>

<div class="modal fade" id="modaltambah" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span></button>
                <h4 class="modal-title">Form Import PPH </h4>
            </div>
            <div class="modal-body">
                <div id="notifikasi"></div>
                <form method="post" id="mysimpan_data" action="{{url('/bukti/proses_import_pph/')}}" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Excel PPH </label>
                        <input type="file"  name="file" class="form-control">
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
        scrollY: "450px",
        scrollCollapse: true,
        ordering   : false,
        paging   : false,
        info   : false,
        oLanguage: {"sSearch": "<span class='btn btn-default btn sm'><i class='fa fa-search'></i></span>" },
        "ajax": {
            "type": "GET",
            "url": "{{url('bukti/api_import_ppn/')}}",
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
                    return data.nomor;
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
                "title": "No Invoice",
                "render": function (data, row, type, meta) {
                    return data.invoice;
                }
            },
            {
                "mData": null,
                "title": "No Faktur Pajak",
                "render": function (data, row, type, meta) {
                    return data.faktur;
                }
            },
            {
                "mData": null,
                "title": "Tgl Faktur Pajak",
                "render": function (data, row, type, meta) {
                    return data.tgl_faktur;
                }
            },
            {
                "mData": null,
                "title": "Nilai DPP (Rp)",
                "render": function (data, row, type, meta) {
                    return data.dpp;
                }
            },
            {
                "mData": null,
                "title": "Nilai PPN (Rp)",
                "render": function (data, row, type, meta) {
                    return data.ppn;
                }
            }
            
        ]
    });

    $('#pilihsemua').click(function(){
        var rows = table.rows({ 'search': 'applied' }).nodes();
        $('input[type="checkbox"]').not(this).prop('checked', this.checked);
        // $('input[type="checkbox"]', rows).prop('checked', this.checked);
    });
    

});
</script>
<script>
    
    function tutup(){
        location.reload();
    }

    function view(a){
        window.location.assign("{{url('bukti/ppn_view/')}}/"+a)
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
        
            $.ajax({
                type: 'POST',
                url: "{{url('/bukti/proses_import_ppn/')}}",
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
                    not=msg.split('-');
                   
                    if(not[0]=='Error'){
                        $('#simpan_data').show();
                        $('#tutup_simpan_data').show();
                        $('#modalloading').modal('hide');
                        $('#notifikasi').html(msg);
                        
                    }else{
                        location.reload();
                    }
                    
                    
                }
            });

    }
</script>
@endpush
