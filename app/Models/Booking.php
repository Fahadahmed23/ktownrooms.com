<?php

namespace App\Models;

// use App\Customer; 
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Libraries\Sms;
use Illuminate\Support\Facades\URL;

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

    public function agent()
    {
        return $this->belongsTo(BookingAgent::class)->select(['id', 'name', 'phone']);
    }

    public function customer() {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }

    public function booking_occupants() {
        return $this->hasMany(BookingOccupant::class);
    }

    // Mr Optimist | 17 Dec 2021
    public function booking_miscellaneous_amount() {
        return $this->hasMany(BookingMiscellaneousAmount::class);
    }

    public function rooms() {
        return $this->belongsToMany(Room::class)->where('booking_room.transferred', 0)->whereNull('booking_room.deleted_at')->withPivot('room_charges_onbooking','room_charges', 'allowed_occupants', 'occupants', 'max_allowed_occupants', 'room_title', 'additional_occupants', 'additional_guest_charges', 'additional_guest_rate');
    }

    public function services()
    {
        return $this->hasMany(BookingService::class)
        ->where('booking_service.excludes','!=', 0)->where('booking_service.status','completed');
    }

    public function booking_services_btc()
    {
        return $this->hasMany(BookingServiceBtc::class);
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
    
    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Mr Optimist 18-02-2022
    public function created_by_user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function discount_request() {
        return $this->hasOne(DiscountRequest::class, 'booking_id', 'id');
    }

    public function status_history () {
        return $this->hasMany(BookingStatusHistory::class, 'booking_id', 'id')->orderBy('status_date', 'asc');
    }

    public function smsMapping($key)
    {
        try {
            //code...
            
            $data['customer_name'] = $this->customer->FirstName . ' '.  $this->customer->LastName;
            
            $data['booking_no'] = $this->booking_no;
            $url = URL::to('/cportal/'.$this->booking_code);
            $remove_http = preg_replace ('/https:|http:/','',$url,1);
            $data['portal_link'] = ltrim($remove_http,"//");
            $data['checkin_date'] = date_format(date_create($this->BookingFrom), 'd/m/Y');
            $data['checkout_date'] = date_format(date_create($this->BookingTo), 'd/m/Y');

            $data['hotel_name'] = $this->hotel->HotelName;
            $data['hotel_code'] = $this->hotel->HotelCode;
            $data['hotel_lat'] = $this->hotel->Latitude;
            $data['hotel_lng'] = $this->hotel->Longitude;

            $default_setting = DefaultRule::first();
            $data['default_name'] = $default_setting->name;
            $data['default_email'] = $default_setting->email;
            $data['default_phone'] = $default_setting->phone;

            if($this->hotel->use_default_messages == '1')
                $data["$key"] = $default_setting->$key; 
            else 
                $data["$key"] = $this->hotel->$key;
            // dd($data);

            $search = ['<<booking_no>>','<<portal_link>>','<<checkin_date>>','<<checkout_date>>','<<hotel_name>>','<<hotel_code>>','<<hotel_latitude>>','<<hotel_longitude>>','<<name>>','<<email>>','<<phone>>','<<customer_name>>'];
            $replace = [$data['booking_no'],$data['portal_link'],$data['checkin_date'],$data['checkout_date'],$data['hotel_name'],$data['hotel_code'],$data['hotel_lat'],$data['hotel_lng'],$data['default_name'],$data['default_email'],$data['default_phone'],$data['customer_name']];
            $msg_text = str_replace($search,$replace,$data["$key"]);
            return $msg_text;
        } catch (\Throwable $th) {
            return null;
            //throw $th;
        }
    }

    public function sendPortalLink()
    {
        // $code = encrypt($this->booking_no);
        // $msg_text = "Welcome to KTown Rooms & Homes. Kindly follow the below mentioned link for room services and complaints. Please Call our help line at 03 111 222 418 in case of any queries. " . url('customerservices') . '/' . \urlencode($code);
        // $msg_text = "Welcome to KTown Rooms & Homes. Kindly follow the below mentioned link for room services and complaints. Please Call our help line at 03 111 222 418 in case of any queries. " . url('cportal') . '/' . \urlencode($this->booking_code);

        $contact_no = $this->customer->Phone;
        /****** Pass key which exist in database for message ******/
        /* confirm_message, cancel_message, amendment_message, checkin_message, checkout_message */
        $message = $this->smsMapping('checkin_message');
        if($message & $contact_no)
            Sms::send($contact_no, $message);
    }

    public function sendConfirmationSms() {
        // $map_link = "http://www.google.com/maps/place/".$this->hotel->Latitude.",".$this->hotel->Longitude;
        // $msg_text = "Thank you for choosing KTown Rooms & Homes. Your booking number is ".$booking_no.". Your expected check in date is ".$checkin_date." at our ".$hotel_name." ( ".$map_link." ). Awaiting to welcome you. Please Call our help line at 03 111 222 418 in case of any queries";
        // $msg_text = "Ktown is happy to confirm your booking No. ".$booking_no.". An invoice with booking details has been emailed to you. kindly call 03 111 222 418 for any queries";
        
        $contact_no = $this->customer->Phone;
        /****** Pass key which exist in database for message ******/
        /* confirm_message, cancel_message, amendment_message, checkin_message, checkout_message */
        $message = $this->smsMapping('confirm_message');
        if($message && $contact_no)
            Sms::send($contact_no, $message);
    }

    public function sendCancellationSms() {
        // $msg_text = "Ktown has received your request for booking Cancellation. Your revised booking details have been emailed to you. Please Call 03111222418 for any queries";

        $contact_no = $this->customer->Phone;
        /****** Pass key which exist in database for message ******/
        /* confirm_message, cancel_message, amendment_message, checkin_message, checkout_message */
        $message = $this->smsMapping('cancel_message');
        if($message){
            Sms::send($contact_no, $message);
        }

    }

    public function sendAmendmentSms() { 
        $contact_no = $this->customer->Phone;
        /****** Pass key which exist in database for message ******/
        /* confirm_message, cancel_message, amendment_message, checkin_message, checkout_message */
        $message = $this->smsMapping('amendment_message');
        if($message && $contact_no)
            Sms::send($contact_no, $message);
    }


    public function sendCheckoutSms() {
        $contact_no = $this->customer->Phone;
        /****** Pass key which exist in database for message ******/
        /* confirm_message, cancel_message, amendment_message, checkin_message, checkout_message */
        $message = $this->smsMapping('checkout_message');
        if($message && $contact_no)
            Sms::send($contact_no, $message);
    }

    public function sendReminderSms() {
        $contact_no = $this->customer->Phone;
        /****** Pass key which exist in database for message ******/
        /* confirm_message, cancel_message, amendment_message, checkin_message, checkout_message */
        $message = $this->smsMapping('reminder_message');
        if($message && $contact_no)
            Sms::send($contact_no, $message);
    }


    public function sendCustomSms($phone, $message) {
        // dd('in');
        $contact_no = $phone;
        $msg_text = $message;
        Sms::send($contact_no, $msg_text);
    }

    public function getCheckinTimeAttribute($value){
        return viewDateTime($value);
    }

    public function getCreatedAtAttribute($value){
        return viewDateTime($value);
    }
}
