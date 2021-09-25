<?php

namespace App\Imports;

use App\Models\CorporateClient;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;


class ClientsImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
            // dd($row['emailaddress']);
           $a = CorporateClient::where('EmailAddress', $row['emailaddress'])->exists();
            dd($a);
           if (CorporateClient::where('EmailAddress', $row['emailaddress'])->exists()) {
            return response()->json([
                'success' => true,
                'message' => ["Already Exist"],
                'msgtype' => 'error',
            ]);
        }
        else{
            return new CorporateClient([
                'FullName'     => $row['fullname'],
                'EmailAddress'    => $row['emailaddress'], 
                'ContactNo' => $row['contactno'],
                'Status' => $row['status'],
            ]);
        }
        
    }
}
