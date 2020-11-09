<?php

namespace App\Imports;

use App\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

use Illuminate\Support\Facades\Hash;

class UserImport implements ToModel, WithStartRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $cek=User::where('email',$row[1])->orWhere('nik',$row[0])->count();
        if($cek>0){
            $data=User::where('nik',$row[0])->update([
                
                'name'=>$row[2],
                'password'=>Hash::make($row[0]),
                'role_id'=>5,
            ]);
        }else{
            return new User([
                
                'name'=>$row[2],
                'email'=>$row[1],
                'password'=>Hash::make($row[0]),
                'nik'=>$row[0],
                'role_id'=>5,
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
