<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RoomSchedule extends Model
{
    use SoftDeletes;
    
    protected $table = "room_schedule";

    public function booking () {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }
}
