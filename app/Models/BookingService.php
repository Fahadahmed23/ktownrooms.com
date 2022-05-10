<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingService extends Model
{
    protected $appends = 
    [
        'BookingNo',
        'RoomTitle',
        'RoomNumber',

    ];

    protected $table = 'booking_service';

    // Mr Optimist 9 May 2022
    public function bookingservicebtc()
    {
        return $this->hasOne(BookingServiceBtc::class,'booking_service_id');
    }

    public function room () {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function booking() {
        return $this->belongsTo(Booking::class, 'booking_id', 'id');
    }

    public function getBookingNoAttribute() {
        return $this->booking->booking_no ?? '';
    }
    public function getRoomTitleAttribute() {
        return $this->room->room_title ?? '';
    }

    public function getRoomNumberAttribute()
    {
        return $this->room->RoomNumber ?? '';
    }


}
