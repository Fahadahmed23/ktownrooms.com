<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateClient extends Model
{
    protected $fillable = [
        'hotel_id','FullName','EmailAddress','ContactNo', 'Status'
    ];
}
