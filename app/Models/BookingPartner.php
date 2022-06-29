<?php

namespace App\Models;

// use App\Customer; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Sms;
use Illuminate\Support\Facades\URL;

class BookingPartner extends Model
{
    
    use SoftDeletes;
    protected $connection = 'mysql2';
    protected $table = 'bookings';

   
}
