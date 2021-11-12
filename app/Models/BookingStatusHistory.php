<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingStatusHistory extends Model
{
    protected $table = "booking_status_history";

    public function getStatusDateAttribute($value){
        return viewDateTime($value);
    }
}
