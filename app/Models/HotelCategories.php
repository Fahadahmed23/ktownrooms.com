<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelCategories extends Model
{
    use SoftDeletes;
    protected $table = 'hotel_categories';

    public function hotels() {
       
        return $this->belongsToMany(Hotel::class, 'hotel_category','hotel_category_id','hotel_id');
    }

    

    /*
    * Mr Optimist 22 March 2022
    */


    public function hotelCategory()
    {
        //return $this->hasOne(HotelCategories::class);
        return $this->belongsTo(HotelCategory::class, 'hotel_category_id');
    }


}
