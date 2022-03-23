<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelCategory extends Model
{
    use SoftDeletes;
    protected $table = 'hotel_category';
    public $timestamps = true;

    /*
    public function hotels() {
        return $this->hasMany(Hotel::class);
    }
    **/

    


    /*
    * Mr Optimist 22 March 2022
    */

    public function hotelCategories()
    {
        //return $this->hasOne(HotelCategories::class);
        return $this->hasOne(HotelCategories::class, 'id', 'hotel_category_id');
    }

  




  
}
