<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountRequest extends Model
{
    
    public function booking()
    {
        return $this->belongsTo(Booking::class, 'booking_id', 'id' );
    }

    public function requester()
    {
        return $this->belongsTo(User::class, 'requester_id', 'id');
    }
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id', 'id');
    }
    // public $timestamps = false;
}
