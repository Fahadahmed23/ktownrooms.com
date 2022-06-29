<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Sms;
use Illuminate\Support\Facades\URL;

class BookingKtown extends Model
{

    //use SoftDeletes;
    protected $connection = 'mysql3';
    protected $table = 'bookings';

    
}
