<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingRoom extends Model
{
    use SoftDeletes;
    
    protected $table= 'booking_room';

    public function booking() {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
