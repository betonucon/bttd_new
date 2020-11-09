<?php
header("Content-type: application/vnd-ms-excel");
header("Content-Disposition: attachment; filename=Berita Acara-".$mulai."-".$sampai.".xls");
?>
<table width="100%" border="1">
    <tr>
        <td class="merk">Total Nilai Faktur</td>
        <td class="tdtd">{{number(ba_total_nilai_faktur($mulai,$sampai,$groupnya))}}</td>
        <td  class="merk">Total Dokumen Faktur</td>
        <td class="tdtd">{{ba_total_dok_faktur($mulai,$sampai,$groupnya)}}</td>
    </tr>
    <tr>
        <td  class="merk">Total Nilai Kwitansi</td>
        <td class="tdtd">{{number(ba_total_nilai_kwitansi($mulai,$sampai,$groupnya))}}</td>
        <td  class="merk">Total Dokumen Non Faktur</td>
        <td class="tdtd">{{ba_total_dok_non_faktur($mulai,$sampai,$groupnya)}}</td>
    </tr>
</table><br>
<table   border="1" class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>No</th>
            <th>Tanggal Faktur</th>
            <th>Nama Vendor</th>
            <th>No Faktur</th>
            <th >No Kwitansi</th>
            <th>Nilai Faktur</th>
            <th>Nilai Kwitansi</th>
            <th>Posisi</th>
        </tr>
    </thead>
    <tbody>
    @foreach(bttd_laporan($mulai,$sampai,$groupnya) as $no=>$data)
        <tr>
            <td width="5%">{{($no+1)}}</td>
            <td>{{$data->tgl_create}}</td>
            <td><b>[{{$data->nik}}]</b> {{cek_user($data->nik)['name']}}</td>
            <td>{{$data->no_faktur}}</td>
            <td>{{$data->no_kwitansi}}</td>
            <td>&nbsp;<b>{{$data->mata_uang}}</b> {{number($data->nilai_faktur)}}</td>
            <td>&nbsp;<b>{{$data->mata_uang}}</b> {{number($data->nilai_kwitansi)}}</td>
            <td>{{posisi($data['status'])}}</td>
            
        </tr>
    @endforeach
    </tbody>
</table>