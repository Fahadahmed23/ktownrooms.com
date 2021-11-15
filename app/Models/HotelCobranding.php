<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelCobranding extends Model
{
    use SoftDeletes;
    protected $table = "hotel_cobranding";

    public function hotel() {
    
        return $this->belongsTo(Hotel::class,'hotel_id','id');
    }

}
