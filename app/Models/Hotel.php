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
    'BlockedRoomCount',
    'KtownCommission'
    ];

    // protected $fillable = [
    //     'company_id','city_id','Address', 'ZipCode','Longitude',
    //     'Longitude','Latitude','deleted_at', 'created_at', 
    //     'CreationIP', 'created_by', 'CreatedByModule', 'updated_at', 
    //     'UpdationIP', 'updated_by', 'UpdatedByModule' ,'HotelName'
    // ];

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

    
    /*
    public function hotel_category () {
        return $this->belongsTo(HotelCategory::class, 'hotel_category_id', 'id');
    }
    **/

    
    public function hotel_cobrandings() {
        return $this->hasMany(HotelCobranding::class, 'hotel_id','id');   
    }
    

    public function hotel_categories()
    {

        return $this->belongsToMany(HotelCategories::class, 'hotel_category','hotel_id','hotel_category_id');
    }

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

    public function getKtownCommissionAttribute()
    {
        $bookingsRevenue = $this->bookings()
        ->join('booking_invoices', 'bookings.id','=','booking_invoices.booking_id')
        ->leftJoin('customers', 'customers.id', 'bookings.customer_id')
        ->leftJoin('users', 'users.id', 'customers.created_by')
        ->where('users.hotel_id', '!=', 'bookings.hotel_id')
        ->where('bookings.status', 'Confirmed')
        ->sum('booking_invoices.net_total');

        $applicationRevenue = $this->bookings()
        ->join('booking_invoices', 'bookings.id','=','booking_invoices.booking_id')
        ->leftJoin('customers', 'customers.id', 'bookings.customer_id')
        ->leftJoin('users', 'users.id', 'customers.created_by')
        ->where('users.hotel_id', '=', 'bookings.hotel_id')
        ->where('bookings.status', 'Confirmed')
        ->sum('booking_invoices.net_total');

        $ktownCommission = ((20 / 100) * $bookingsRevenue) + ((1.85 / 100) * $applicationRevenue);

        return $ktownCommission;
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
