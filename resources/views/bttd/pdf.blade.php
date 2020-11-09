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
                <td class="nogaris" width="15%">
                    {!!barcoderider(cek_user($data['nik'])['name'].'- No Invoice:'.$data['no_kwitansi'],3,3)!!}
                </td>
            </tr>
        </table>
        <br>
        <table width="100%" border="0">
            <tr>
                <td class="tdhead1">(BTTD)</td>
            </tr>
            <tr>
                <td class="tdhead2">(BUKTI TANDA TERIMA DOKUMEN)</td>
            </tr>
        </table>
        <table width="100%" border="0">
            <tr>
                <th class="garis" width="7%">No</th>
                <th class="garis" width="35%">Keterangan</th>
                <th class="garis"></th>
            </tr>
            <tr>
                <td class="garis">1.</td>
                <td class="garis">Kode Vendor / Rekanan</td>
                <td class="garis">{{$data['nik']}}</td>
            </tr>
            <tr>
                <td class="garis">2.</td>
                <td class="garis">Nama Vendor / Rekanan</td>
                <td class="garis">{{cek_user($data['nik'])['name']}}</td>
            </tr>
            <tr>
                <td class="garis">3.</td>
                <td class="garis">Nilai Faktur Pajak (PPn 10%)</td>
                <td class="garis">{{$data['mata_uang']}} {{$data['nilai_kwitansi']}} => IDR {{$data['konv_idr']}}</td>
            </tr>
            <tr>
                <td class="garis">4.</td>
                <td class="garis">Nilai Kwitansi / Invoice (DPP + PPN)</td>
                <td class="garis">{{$data['mata_uang']}} {{$data['nilai_kwitansi']}}</td>
            </tr>
            <tr>
                <td class="garis">5.</td>
                <td class="garis">No. Faktur Pajak </td>
                <td class="garis">{{$data['no_faktur']}}</td>
            </tr>
            <tr>
                <td class="garis">6.</td>
                <td class="garis">Tanggal Faktur Pajak </td>
                <td class="garis">{{$data['tgl_create']}}</td>
            </tr>
            <tr>
                <td class="garis">7.</td>
                <td class="garis">No. Kwitansi & No.PO/Kontrak </td>
                <td class="garis">{{$data['no_kwitansi']}}</td>
            </tr>
            <tr>
                <td class="garis">8.</td>
                <td class="garis">Email / Telp / Fax Vendor</td>
                <td class="garis">{{$data['ket']}}</td>
            </tr>
            <tr>
                <td class="garis">9.</td>
                <td class="garis">No Rekening</td>
                <td class="garis">{{$data['norek']}}</td>
            </tr>
            <tr>
                <td class="garis">10.</td>
                <td class="garis">Nama Bank</td>
                <td class="garis">{{$data['nama_bank']}}</td>
            </tr>
        </table>
    </body>
</html>