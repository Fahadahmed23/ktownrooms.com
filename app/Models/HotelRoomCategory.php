<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelRoomCategory extends Model
{
    use SoftDeletes;

    protected $table = 'hotel_room_category';
    protected $appends = ['CategoryName'];

    public function hotel() {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function room_category() {
        return $this->belongsTo(RoomCategory::class, 'room_category_id', 'id');
    }

    public function getCategoryNameAttribute() {
        return $this->room_category->RoomCategory ?? null;
    }
    
    public function rooms() {
        return $this->hasMany(Room::class, 'hotel_id', 'hotel_id');
    }
}
