<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceDetail extends Model
{
    public $timestamps = false;
    
    protected $guarded = [];
    
    public static function fromThirdPartyBooking($booking_id, $amount, $created_by, $payment_type){
        $payment_type_id = 3;
        if($payment_type == 'Account')
            $payment_type_id = 4;
        InvoiceDetail::create([
            'title'=> 'partial_payment',    
            'type'=> 'payment',    
            'payment_type_id'=> $payment_type_id,    
            'payment_detail'=> 'Via BlinQ Payment',    
            'booking_id'=> $booking_id,    
            'amount'=> $amount,    
            'created_by'=> $created_by,    
        ]);
    }

    // Mr Optimist 18-05-2022
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
