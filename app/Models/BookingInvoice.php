<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BookingInvoice extends Model
{
    use SoftDeletes;
    
    public function payment_mode() {
        return $this->belongsTo(PaymentType::class, 'payment_mode_id', 'id');
    }
}
