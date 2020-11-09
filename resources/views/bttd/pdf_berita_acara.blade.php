<html>
    <head>
        <title></title>
        <style>
            body {  
                font-family: 'Helvetica'; 
                font-size:14px; 
            }
            th{
                font-weight:bold;
                font-size:10px;
            }
            td{
                font-size:10px;
            }
            table{
                border-collapse:collapse;
                
            }
            .garis{
                border:solid 1px #000;
                padding:5px;
            }
            .nogaris{
                border:solid 0px #fff;
                padding:5px;
            }
            .td1{
                color:red;
                font-weight:bold;
            }
            .td2{
                color:#000;
                font-weight:bold;
            }
            .tdhead1{
                color:#000;
                font-weight:bold;
                font-size:18px;
                text-align:center;
            }
            .tdhead2{
                color:#000;
                font-size:15px;
                text-align:center;
            }
            .td3{
                color:#000;
            }
            .merk{
                background:aqua;
                font-weight:bold;
                font-size:10px;
                border:solid 1px aqua;
            }
            .tdtd{
                border:solid 1px aqua;
                font-size:10px;
            }
        </style>
    </head>
    <body>
        <table width="100%" border="0">
            <tr>
                <td class="nogaris" width="20%"><img src="{{url('icon/logo.gif')}}" style="width:150px"></td>
                <td class="nogaris">
                    <table width="100%" border="0">
                        <tr>
                            <td class="td1">PT. KRAKATAU STEEL (Persero) Tbk.</td>
                        </tr>
                        <tr>
                            <td class="td2">DIVISI TAX & VERIFICATION</td>
                        </tr>
                        <tr>
                            <td class="td3">TELP : (0254)372203, FAX : 372342</td>
                        </tr>
                        <tr>
                            <td class="td3">JL AUSTRALIA II NO 1 KAWASAN INDUSTRI KIEC -CILEGON</td>
                        </tr>
                    </table>
                </td>
                
            </tr>
        </table>
        <br>
        <table width="100%" border="0">
            <tr>
                <td class="tdhead1">(BERITA ACARA)</td>
            </tr>
            <tr>
                <td class="tdhead2">(BUKTI TANDA TERIMA DOKUMEN)</td>
            </tr>
        </table>
        
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
    </body>
</html>