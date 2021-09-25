<?php

namespace App\Models;

// use App\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Sms;

class Booking extends Model
{
    use SoftDeletes;

    protected $table = 'bookings';

    // public function getCheckinTimeAttribute($value) {
    //     return viewDateTime($value);
    // }

    public function invoice_details() {
        return $this->hasMany(InvoiceDetail::class, 'booking_id', 'id');
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function booking_occupants() {
        return $this->hasMany(BookingOccupant::class);
    }
    public function rooms() {
        return $this->belongsToMany(Room::class)->where('booking_room.transferred', 0)->whereNull('booking_room.deleted_at')->withPivot('room_charges_onbooking','room_charges', 'allowed_occupants', 'occupants', 'max_allowed_occupants', 'room_title', 'additional_occupants', 'additional_guest_charges', 'additional_guest_rate');
    }

    public function services()
    {
        return $this->hasMany(BookingService::class)
        ->where('booking_service.excludes','!=', 0)->where('booking_service.status','completed');
    }

    public function invoice() {
        return $this->hasOne(BookingInvoice::class, 'booking_id', 'id');
    }

    public function promotion() {
        return $this->belongsTo(Promotion::class);
    }

    public function tax_rate()
    {
        return $this->belongsTo(TaxRate::class, 'tax_rate_id', 'id');
    }

    public function booking_third_party()
    {
        return $this->belongsTo(BookingThirdParty::class, 'booking_third_party_id');
    }

    public function hotel()
    {
        return $this->belongsTo(Hotel::class, 'hotel_id','id');
    }

    public function discount_request() {
        return $this->hasOne(DiscountRequest::class, 'booking_id', 'id');
    }

    public function status_history () {
        return $this->hasMany(BookingStatusHistory::class, 'booking_id', 'id')->orderBy('status_date', 'asc');
    }

    public function sendPortalLink()
    {
        $contact_no = $this->customer->Phone;
        $code = encrypt($this->booking_no);
        $msg_text = "Welcome to KTown Rooms & Homes. Kindly follow the below mentioned link for room services and complaints. Please Call our help line at 03 111 222 418 in case of any queries. " . url('customerservices') . '/' . \urlencode($code);

        Sms::send($contact_no, $msg_text);
    }

    public function sendConfirmationSms() {
        $contact_no = $this->customer->Phone;
        $booking_no = $this->booking_no;
        $checkin_date = date_format(date_create($this->BookingFrom), 'd/m/Y');
        $hotel_name = $this->hotel->HotelName;
        $map_link = "http://www.google.com/maps/place/".$this->hotel->Latitude.",".$this->hotel->Longitude;
        $msg_text = "Thank you for choosing KTown Rooms & Homes. Your booking number is ".$booking_no.". Your expected check in date is ".$checkin_date." at our ".$hotel_name." ( ".$map_link." ). Awaiting to welcome you. Please Call our help line at 03 111 222 418 in case of any queries";

        Sms::send($contact_no, $msg_text);
    }
}
