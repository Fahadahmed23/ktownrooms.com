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
}
