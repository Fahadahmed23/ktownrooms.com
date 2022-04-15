<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingMiscellaneousAmount extends Model
{
    use SoftDeletes;
    protected $table = "booking_miscellaneous_amount";
}
