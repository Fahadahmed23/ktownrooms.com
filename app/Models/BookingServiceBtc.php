<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingServiceBtc extends Model
{
  
    // Mr Optiist 10 May 2022
    protected $table = 'booking_service_btc';

    public function bookingservice()
    {
        return $this->belongsTo(BookingService::class,'booking_service_id');
    }

  

}
