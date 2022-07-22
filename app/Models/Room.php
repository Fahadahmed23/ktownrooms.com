<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;
    
    protected $appends = ['HotelName',
    'RoomCategory',
    'RoomType',
    'PendingBookingCount',
    'ConfirmBookingCount',
    'CancelledBookingCount',
    ];

  
    public function getHotelNameAttribute() {
        return $this->hotel->HotelName ?? null;
    }

    public function getRoomCategoryAttribute() {
        return $this->category->RoomCategory ?? null;
    }

    public function getRoomTypeAttribute() {
        return $this->room_type->RoomType ?? null;
    }
    public function images()
    {
        return $this->hasMany(RoomImage::class);
    }
    public function room_type()
    {
        return $this->belongsTo(RoomType::class,'room_type_id','id');
    }

    // Mr Optimist 22 July 2022
    public function room_types()
    {
        return $this->belongsTo(RoomType::class,'room_type_id','id');
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }

    public function category() {
        return $this->belongsTo(RoomCategory::class, 'room_category_id', 'id');
    }

    public function hotel_room_category() {
        return $this->belongsTo(HotelRoomCategory::class, 'room_category_id', 'room_category_id')->where('hotel_id', $this->hotel->id);
    }

    public function facilities() {
        return $this->belongsToMany(Facility::class);
    }
    public function services() {
        return $this->belongsToMany(Service::class, 'room_services')->withPivot('limit');
    }

    public function tax_rate() {
        return $this->belongsTo(TaxRate::class, 'tax_rate_id', 'id');
    }

    public function room_status() {
        return $this->belongsTo(RoomStatus::class, 'room_status_id', 'id');
    }

    public function bookings()
    {
        return $this->belongsToMany(Booking::class);
    }
    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function getPendingBookingCountAttribute() {
        return $this->bookings()->where("bookings.status",'Cancelled')->count();
    }
    public function getConfirmBookingCountAttribute() {
        return $this->bookings()->where("bookings.status",'Confirmed')->count();
    }
    public function getCancelledBookingCountAttribute() {
        return $this->bookings()->where("bookings.status",'Cancelled')->count();
    }

    protected $fillable = [
        'hotel_id','room_title','room_type_id','room_category_id','RoomNumber',
        'FloorNo','RoomCharges','tax_rate_id', 'deleted_at', 'created_at', 
        'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
        'UpdationIP', 'updated_by', 'UpdatedByModule'
    ];

}