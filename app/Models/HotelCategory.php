<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelCategory extends Model
{
    use SoftDeletes;
    protected $table = 'hotel_category';

    /*
    public function hotels() {
        return $this->hasMany(Hotel::class);
    }
    **/
  
}
