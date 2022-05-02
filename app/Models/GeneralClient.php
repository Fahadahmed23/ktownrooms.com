<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GeneralClient extends Model
{

    //use SoftDeletes;
    protected $table = 'general_clients';

    protected $fillable = [
        'hotel_id','name','poc','email', 'phone','status','action'
    ];
}
