<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class City extends Model
{
    use SoftDeletes;
    
    public $timestamps = false;

    protected $appends = ['HotelCount','CityRoomCount',];

    public function hotels() {
        return $this->hasMany(Hotel::class);
    }

    public function getHotelCountAttribute() {
        return $this->hotels()->count();
    }

    public function cityhotelrooms()
    {
        return $this->hasManyThrough(Room::class, Hotel::class, 'city_id' , 'hotel_id','id');
    }

    public function getCityRoomCountAttribute() {
        return $this->cityhotelrooms()->count();
    }
 
    protected $fillable = [
        'CityName','country_id','state_id','Abbreviation','IsActive',
        'deleted_at','created_at','CreationIP','created_by','CreatedByModule',
        'updated_at','UpdationIP','updated_by','UpdatedByModule'
    ];


}
