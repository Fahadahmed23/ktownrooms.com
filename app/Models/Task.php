<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $appends = 
    [
    'HotelName',
    'RoomNumber'
    ];
    public function task_history () {
        return $this->hasMany(TaskHistory::class, 'task_id', 'id')->orderBy('time', 'asc');
    }
    public function hotel() {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
    public function getHotelNameAttribute() {
        return $this->hotel->HotelName ?? null;
    }
    public function room() {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
    public function getRoomNumberAttribute() {
        return $this->room->RoomNumber?? null ;
    }

    public function booking_service() {
        return $this->belongsTo(BookingService::class, 'service_id', 'id');
    }


}
