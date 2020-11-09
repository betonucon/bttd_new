<?php

namespace App\Imports;
use App\Pph;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class PphImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek=Pph::where('DOCNO',$row[1])->where('LIFNR',$row[0])->count();
        if($cek>0){
            $data         = Pph::where('DOCNO',$row[1])->where('LIFNR',$row[0])->update([
                'BUDAT'         => $row[2], 
                'XBLNR'         => $row[3],
                'DMBTR'         => $row[4],
                'BKTXT'         => $row[5],
                'WRBTR'         => $row[6]
            ]);
            
        }else{
            return new Pph([
                'LIFNR'      => $row[0],
                'DOCNO'     => $row[1],
                'BUDAT'         => $row[2], 
                'XBLNR'         => $row[3],
                'DMBTR'         => $row[4],
                'BKTXT'         => $row[5],
                'WRBTR'         => $row[6],
                'tgl_import'    => date('Y-m-d')
                
                
            ]);
        }
        
    }

    /**
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}
