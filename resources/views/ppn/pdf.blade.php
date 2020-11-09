<html>
    <head>
        <title></title>
        <style>
            html{
                margin:10px 50px 10px 50px;
            }
            body {  
                font-family: 'Helvetica'; 
                font-size:14px; 
            }
            .boddy{
                height:700px;
                border:solid 1px #fff;
                margin:5px;
            }
            th{
                font-weight:bold;
            }
            table{
                border-collapse:collapse;
                
            }
            .garisth{
                border:solid 1px #000;
                padding:4px;
                font-size:12px; 
                background:aqua;
            }
            .garis{
                border:solid 1px #000;
                padding:4px;
                font-size:12px; 
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
                font-size:15px;
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
    @for($urt=1;$urt<=$ulang;$urt++)
    <?php
        $mulai=($urt*10)-9;
        $sampai=($urt*10);

    ?>
    <div class="boddy">
        <table width="100%" border="0">
            <tr>
                <td class="nogaris" width="20%"><img src="{{url('icon/ks.png')}}" style="width:150px"></td>
                <td class="nogaris">
                    <table width="100%" border="0">
                        <tr>
                            <td class="td1">PT. KRAKATAU STEEL (Persero) Tbk. {{$ulang}}</td>
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
                    {!!barcoderider(cek_user($id)['name'].'-'.$id,3,3)!!}
                </td>
            </tr>
        </table><hr>
        <br>
        <table width="100%" border="0">
            <tr>
                <td class="tdhead1">KUPON<br>PENGAMBILAN BUKTI POTONG <br></td>
            </tr>
            <tr>
                <td class="tdhead2">( {{$id}} )</td>
            </tr>
        </table>
        <table width="100%" border="0">
            <tr>
                <td width="15%"> Nama Pemungut</td>
                <td> : PT KRAKATAU STEEL (Persero) Tbk</td>
            </tr>
            <tr>
                <td> NPWP</td>
                <td> : 01.000.054.5-417.001</td>
            </tr>
            <tr>
                <td> Alamat</td>
                <td> : JALAN INDUSTRI NO. 5 RAMANUJU PURWAKARTA KOTA CILEGON BANTEN 42431</td>
            </tr>
        </table>
        <table width="100%" border="0">
            <tr>
                <th class="garisth" width="3%">No</th>
                <th class="garisth" width="15%">Tgl Faktur</th>
                <th class="garisth" width="15%">No Invoice</th>
                <th class="garisth" width="15%">No Faktur Pajak</th>
                <th class="garisth" width="15%">Nilai DPP (Rp)</th>
                <th class="garisth" width="15%">Nilai PPH (Rp)</th>
            </tr>
            @foreach(get_ppn($id,$mulai,$sampai) as $xx=>$get)
                <tr>
                    <td class="garis" align="center">{{$get['urut']}}</td>
                    <td class="garis" >{{$get['BLDAT']}}</td>
                    <td class="garis">{{$get['BKTXT']}}</td>
                    <td class="garis">{{$get['XBLNR']}}</td>
                    <td class="garis" align="right">{{number($get['DMBTR'])}}</td>
                    <td class="garis" align="right">{{number($get['WRBTR'])}}</td>
                </tr>
            @endforeach
           
        </table>
        <br><br>
        <table width="100%" border="0">
            <tr>
                <td width="25%" align="center"><b>Penerima Bukti Potong,</b><br><br><br><br>(................................)</td>
                <td></td>
                <td width="25%" align="center"><b>Petugas Loket,</b><br><br><br><br>( {{Auth::user()['name']}} )</td>
            </tr>
        </table>
    </div>
    @endfor
    </body>
</html>