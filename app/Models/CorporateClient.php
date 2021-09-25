<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CorporateClient extends Model
{
    protected $fillable = [
        'FullName','EmailAddress','ContactNo', 'Status'
    ];
}
