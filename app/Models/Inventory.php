<?php

namespace App\Models;

class Inventory extends Base
{

    protected $appends = 
    [
    'HotelName',
    ];
    public function hotel()
    {
        return $this->belongsTo(Hotel::class);
    }

    public function getHotelNameAttribute() {
        return $this->hotel->HotelName ?? '';
    }
}
