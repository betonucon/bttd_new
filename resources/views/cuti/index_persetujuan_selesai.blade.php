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
                
                    <div class="box-body" >
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
                                        <th width="8%">Satatus</th>
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
                                        <td><a class="btn btn-{{status_izin($data['sts'])['color']}} btn-flat btn-xs">{{status_izin($data['sts'])['name']}}</a></td>
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
                                                <i class="fa fa-check-circle-o"></i><b>Alasan :</b> {{$data['name']}}<br>
                                                <i class="fa fa-check-circle-o"></i><b>Disetujui Oleh :</b> {{cek_user($data['nik_atasan'])['name']}}<br><br>
                                                <a class="btn btn-{{status_izin($data['sts'])['color']}} btn-flat btn-xs">{{status_izin($data['sts'])['name']}}</a>
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
    
</script>
@endpush
