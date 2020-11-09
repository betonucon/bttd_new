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
            font-size:13px;
            padding:5px;
        }
        label{
            font-size:13px;
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
        <i class="fa fa-pencil"></i> Ubah BTTD  (Bukti Tanda Terima Dokumen) - Non Faktur
    </div>
</section>
<section class="content">
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                
                <div class="box-body">
                    <div id="notifikasi"></div>
                    <form method="post" id="mysimpan_data" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6" style="padding-top:20px;min-height:320px"> 
                            <div class="form-group">
                                <label>Vendor / Rekanan</label><br>
                                <input type="text" disabled style="width:20%;display:inline" value="{{Auth::user()['nik']}}" class="form-control">
                                <input type="text" disabled style="width:77%;display:inline" value="{{Auth::user()['name']}}" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>No. Kwitansi / Memo Dinas</label>
                                <input type="text"  name="no_kwitansi" placeholder="No. Kwitansi / Memo Dinas"  class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nomor : PO/Kontrak/Ket.Pembayaran</label>
                                <input type="text"  name="no_po" placeholder="Nomor : PO/Kontrak/Ket.Pembayaran"  class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Nilai Invoice / Memo Dinas</label><br>
                                <select name="mata_uang" style="width:20%;display:inline" class="form-control">
                                    <option value="">Pilih--</option>
                                    @foreach(matauang() as $matauang)
                                        <option value="{{$matauang['name']}}">{{$matauang['name']}}</option>
                                    @endforeach
                                </select>
                                <input type="text" placeholder="Nilai Invoice / Memo Dinas" onkeyup="cek_nilai_kwitansi(this.value)" onkeypress="return hanyaAngka(event)" name="nilai_kwitansi" style="width:77%;display:inline" value="" class="form-control">
                            </div>
                            
                            
                            
                        </div> 
                        <div class="col-md-6" style="border-left:solid 1px #d0bfbf;padding-top:20px;min-height:320px">   
                            <div class="form-group">
                                <label>No Rekening dan Nama Bank</label><br>
                                <select name="norek" style="width:20%;display:inline" class="form-control">
                                    <option value="">Pilih Rek--</option>
                                    @foreach(bank() as $bank)
                                        <option value="{{$bank['norek']}}">{{$bank['norek']}}</option>
                                    @endforeach
                                </select>
                                <input type="text" name="nama_bank" placeholder="Nama Bank" style="width:77%;display:inline" value="" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Email / Telp / Fax Vendor</label>
                                <input type="text"  name="email" placeholder="Email / Telp / Fax Vendor" onkeypress="return hanyaAngka(event)" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Jenis Dokumen Tagihan</label><br>
                                <select name="tagihan_id"  onchange="cek_tagihan(this.value)" class="form-control select2" style="width:100%;font-size:12px">
                                    <option value="">Pilih Jenis Dokumen Tagihan</option>
                                    @foreach(tagihan() as $tagihan)
                                        <option value="{{$tagihan['id']}}">{{$tagihan['name']}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div> <br>
                        <div class="col-md-12" style="padding-top:20px">  
                            <div id="tagihandetail"></div>  
                        </div>    
                    </form><br><br>
                    <div style="width:100%;display:inline-table;margin-top:20px;text-align:center">
                        <span id="simpan_data" style="margin-right:2%" onclick="simpan_data()" class="btn btn-primary pull-left">Simpan</span>
                        <span id="tutup_simpan_data" data-dismiss="modal" class="btn btn-default pull-right">Tutup</span>
                        <div style="width:100%;text-align:center" id="proses_loading_simpan_data">
                        
                        </div>
                    </div>
                </div>
                
            </div>
       </div>
    </div>
</section>

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
                $('#tagihandetail').html(msg);
            }
        });
    }

    function simpan_data(){
        var form=document.getElementById('mysimpan_data');
        var a="{{$id}}";
            $.ajax({
                type: 'POST',
                url: "{{url('/bttd/simpan/non_faktur')}}",
                data: new FormData(form),
                contentType: false,
                cache: false,
                processData:false,
                beforeSend: function(){
                    // $('#simpan_data').hide();
                    $('#tutup_simpan_data').hide();
                    $('#proses_loading_simpan_data').html('Proses Data ....................');
                },
                success: function(msg){
                    
                    if(msg=='ok'){
                        window.location.assign("{{url('bttd/non_faktur')}}");
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
                        window.location.assign("{{url('bttd/non_faktur')}}");
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
