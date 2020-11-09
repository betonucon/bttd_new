<?php

function barcoderider($id,$w,$h){
    $d = new Milon\Barcode\DNS2D();
    $d->setStorPath(__DIR__.'/cache/');
    return $d->getBarcodeHTML($id, 'QRCODE',$w,$h);
}
function barcode($id){
    $d = new Milon\Barcode\DNS2D();
    $d->setStorPath(__DIR__.'/cache/');
    return $d->getBarcodePNGPath($id, 'PDF417');
}

function foto(){
    $data=App\Pengaturan::where('nik',Auth::user()['nik'])->where('name','foto')->first();
    if($data['value']==''){
        $value="icon/akun.png";
    }else{
        $value="_file_upload/".$data['value'];
    }
    return $value;
}

function bulan($bulan)
{
   Switch ($bulan){
      case '01' : $bulan="Januari";
         Break;
      case '02' : $bulan="Februari";
         Break;
      case '03' : $bulan="Maret";
         Break;
      case '04' : $bulan="April";
         Break;
      case '05' : $bulan="Mei";
         Break;
      case '06' : $bulan="Juni";
         Break;
      case '07' : $bulan="Juli";
         Break;
      case '08' : $bulan="Agustus";
         Break;
      case '09' : $bulan="September";
         Break;
      case 10 : $bulan="Oktober";
         Break;
      case 11 : $bulan="November";
         Break;
      case 12 : $bulan="Desember";
         Break;
      }
   return $bulan;
}

function bln($id){
    if($id>9){
        $data=$id;
    }else{
        $data='0'.$id;
    }

    return $data;
}

function encode($b) {
   $awalnya = array("1","2","3","4","5","6","7","8","9","0");
   $gantinya =   array("W","a","r","D","s","x","C","z","q","H");
   $hasilnya = str_replace($awalnya, $gantinya, $b);
   return $hasilnya;
}

function decode($t) {
   $kodenya =  array("W","a","r","D","s","x","C","z","q","H");
   $terjemahanya = array("1","2","3","4","5","6","7","8","9","0");
   $hasilterjemahan = str_replace($kodenya, $terjemahanya, $t);
   return $hasilterjemahan;
}

function selisih_hari($mulai,$sampai){
   $tglLibur = Array("2013-01-04", "2013-01-05", "2013-01-17");
   
   $pecah1 = explode("-", $mulai);
   $date1 = $pecah1[2];
   $month1 = $pecah1[1];
   $year1 = $pecah1[0];

   $pecah2 = explode("-", $sampai);
   $date2 = $pecah2[2];
   $month2 = $pecah2[1];
   $year2 =  $pecah2[0];

   // mencari selisih hari dari tanggal awal dan akhir
   $jd1 = GregorianToJD($month1, $date1, $year1);
   $jd2 = GregorianToJD($month2, $date2, $year2);

   $selisih = $jd2 - $jd1;
   
   // proses menghitung tanggal merah dan hari minggu
   // di antara tanggal awal dan akhir
   for($i=1; $i<=$selisih; $i++)
   {
      // menentukan tanggal pada hari ke-i dari tanggal awal
      $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
      $tglstr = date("Y-m-d", $tanggal);
         
      
      // yang merupakan hari sabtu
      if ((date("N", $tanggal) == 6))
      {
         $sabtu++;
      }

      // yang merupakan hari minggu
      if ((date("N", $tanggal) == 7))
      {
         $minggu++;
      }
   }
   
   return $selisih-($sabtu+$minggu);  
}

function selisih_hari_shift($mulai,$sampai){
   $tglLibur = Array("2013-01-04", "2013-01-05", "2013-01-17");
   
   $pecah1 = explode("-", $mulai);
   $date1 = $pecah1[2];
   $month1 = $pecah1[1];
   $year1 = $pecah1[0];

   $pecah2 = explode("-", $sampai);
   $date2 = $pecah2[2];
   $month2 = $pecah2[1];
   $year2 =  $pecah2[0];

   // mencari selisih hari dari tanggal awal dan akhir
   $jd1 = GregorianToJD($month1, $date1, $year1);
   $jd2 = GregorianToJD($month2, $date2, $year2);

   $selisih = $jd2 - $jd1;
   
   // proses menghitung tanggal merah dan hari minggu
   // di antara tanggal awal dan akhir
   for($i=1; $i<=$selisih; $i++)
   {
      // menentukan tanggal pada hari ke-i dari tanggal awal
      $tanggal = mktime(0, 0, 0, $month1, $date1+$i, $year1);
      $tglstr = date("Y-m-d", $tanggal);
         
      // menghitung jumlah tanggal pada hari ke-i
      // yang masuk dalam daftar tanggal merah selain minggu
      if (in_array($tglstr, $tglLibur)) 
      {
         $libur1++;
      }
      
   }
   
   // menghitung selisih hari yang bukan tanggal merah dan hari minggu
   return $selisih-$libur1;      
   // return $data;
}

function number($id){
   $data=number_format($id,0);

   return $data;
}

function sts_user($id){
   if($id==1){
      $data='<span class="btn btn-warning btn-xs">Actif</span>';
   }else{
      $data='<span class="btn btn-default btn-xs">Off</span>';
   }

   return $data;
}
?>