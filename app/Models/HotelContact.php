<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HotelContact extends Model
{
    use SoftDeletes;
    // public function hotel()
    // {
    //     return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    // }

    public function contact_type()
    {
        return $this->belongsTo(ContactType::class, 'contact_type_id', 'id');
    }

    // public function types()
    // {
    //     return $this->hasOne(ContactType::class, 'contact_type_id', 'id');
    // }
}
