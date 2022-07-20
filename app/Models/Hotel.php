<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Hotel extends Model
{
    use SoftDeletes;

    protected $table = "hotels";
    
    public $timestamps = true;

    protected $appends = 
    [
    'RoomCount',
    'CityName',
    'BookingCount',
    'BookingRevenueSum',
    'CancelBookingCount',
    'ConfirmBookingCount',
    'PendingBookingCount',
    'TodayConfirmBookingCount',
    'TodayOccupiedBookingCount',
    'TodayPendingBookingCount',
    'TodayCancelBookingCount',
    'AvailableRoomCount',
    'BlockedRoomCount'
    ];

    // protected $fillable = [
    //     'company_id','city_id','Address', 'ZipCode','Longitude',
    //     'Longitude','Latitude','deleted_at', 'created_at', 
    //     'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
    //     'UpdationIP', 'updated_by', 'UpdatedByModule' ,'HotelName'
    // ];
    
    // Mr Optimist 6 July 2022
    public function images()
    {
        return $this->hasMany(HotelImage::class);
    }

    public function allUsers(){
        return $this->belongsToMany(User::class,'user_hotels');
    }
    
    public function hotel_gl_accounts()
    {
        return $this->hasMany(AccountGeneralLedgerMapping::class, 'hotel_id','id');
    }

    public function checkin()
    {
        return $this->hasMany(HotelCinCoutRule::class)->where('rule_type', 'early_check_in');
    }

    public function checkout()
    {
        return $this->hasMany(HotelCinCoutRule::class)->where('rule_type', 'late_check_out');
    }

    public function contacts()
    {
        return $this->hasMany(HotelContact::class);
    }

    public function city() {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }

    // Mr Optimist 15 Nov 201 start
    public function hotel_cobrandings() {
        //return $this->hasMany(HotelCobranding::class, 'hotel_id','id');   
        return $this->hasMany(HotelCobranding::class);   
    }
    public function hotel_categories()
    {
        return $this->belongsToMany(HotelCategories::class, 'hotel_category','hotel_id','hotel_category_id')->withPivot('created_at as pcreated_at')->withTimestamps();
    }
     // Mr Optimist 15 Nov 201 ends
    

    public function hotelroomcategories()
    {
        return $this->hasMany(HotelRoomCategory::class, 'hotel_id','id');
    }

    public function rooms()
    {
        return $this->hasMany(Room::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function getBookingCountAttribute() {
        return $this->bookings()->count();
    }

    public function getCancelBookingCountAttribute() {
        return $this->bookings()->where("bookings.status",'Cancelled')->count();
    }

    public function getConfirmBookingCountAttribute() {
        return $this->bookings()->where("bookings.status",'Confirmed')->count();
    }

    public function getPendingBookingCountAttribute() {
        return $this->bookings()->where("bookings.status",'Pending')->count();
    }

    public function getTodayCancelBookingCountAttribute()
    {
        return $this->bookings()->where("bookings.status",'Cancelled')->where('bookings.BookingDate',  date('Y-m-d').' 00:00:00')->count();
    }
    public function getTodayConfirmBookingCountAttribute()
    {
        return $this->bookings()->where("bookings.status",'Confirmed')->where('bookings.BookingDate',  date('Y-m-d').' 00:00:00')->count();
    }
    public function getTodayOccupiedBookingCountAttribute()
    {
        return $this->bookings()->where("bookings.status",'CheckedIn')->where('bookings.BookingDate',  date('Y-m-d').' 00:00:00')->count();
    }
    public function getTodayPendingBookingCountAttribute()
    {
        return $this->bookings()->where("bookings.status",'Pending')->where('bookings.BookingDate',  date('Y-m-d').' 00:00:00')->count();
    }
    public function getBookingRevenueSumAttribute()
    {
        return $this->bookings()->join('booking_invoices', 'bookings.id','=','booking_invoices.booking_id')
        ->where("bookings.status",'=','Confirmed')->sum('booking_invoices.net_total');
    }

    public function getRoomCountAttribute() {
        return $this->rooms()->count();
    }

    public function getBlockedRoomCountAttribute() {
        return $this->rooms()->where('is_available' , 0)->count();
    }

    public function getAvailableRoomCountAttribute() {
        return $this->rooms()->where('is_available' , 1)->count();
    }

    public function getCityNameAttribute() {
        return $this->city->CityName??null;
    }

    public function tax() {
        return $this->belongsTo(TaxRate::class, 'tax_rate_id', 'id');
    }
}
