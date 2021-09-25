<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingThirdParty extends Model
{
    protected $guarded =[];

    public function details () {
        return $this->hasMany(BookingThirdPartyDetail::class, 'booking_third_party_id', 'id');
    }

    public function mapping_statuses () {
        return $this->hasMany(BookingMappingStatus::class, 'booking_third_party_id', 'id');
    }
    
}
