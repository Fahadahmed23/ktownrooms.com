<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    
    protected $appends = [
        'LatestBooking',
        'ConfirmedBookingsCount',
        'CancelledBookingsCount',
        'Revenue'
    ];

    public function bookings () {
        return $this->hasMany(Booking::class, 'customer_id', 'id');
    }

    public function getConfirmedBookingsCountAttribute() {
        return $this->bookings()->where("bookings.status",'Confirmed')->count();
    }

    public function getCancelledBookingsCountAttribute() {
        return $this->bookings()->where("bookings.status",'Cancelled')->count();
    }

    public function getLatestBookingAttribute() {
        return $this->bookings()->orderBy('BookingDate', 'desc')->first()->BookingDate ?? '';
    }

    public function getName() {
        return $this->FirstName.' '.$this->LastName;
    }

    public function getRevenueAttribute() {
        return BookingInvoice::where('customer_id', $this->id)->sum('payment_amount');
    }
}
