<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;


// Models
use App\Models\Booking;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Customer;
use App\Models\Promotion;
use App\Models\PaymentType;
use App\Models\TaxRate;
use App\Models\BookingInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\AddBookingRequest;
use App\Models\RoomSchedule;
use App\Mail\BookingInvoiceEmail;
use App\Models\BookingOccupant;
use App\Models\BookingRoom;
use App\Models\DiscountRequest;
use App\Models\CorporateClient;
use App\Models\TransactionLog;

use Illuminate\Support\Facades\Mail;
use App\Mail\BookingEmail;
use App\Mail\BookingCancellationEmail;
use App\Mail\BookingCheckoutEmail;
use App\Libraries\Notifications\BookingNotification;

use App\Helpers\CurrencyHelper;
use App\Models\BookingMapping;
use App\Models\BookingAgent;
use App\Models\BookingMappingStatus;
use App\Models\BookingThirdParty;
use App\Models\BookingThirdPartyDetail;
use App\Models\Channel;
use App\Models\CorporateType;
use App\Models\HotelRoomCategory;
use App\Models\InvoiceDetail;
use App\Models\RoomCategory;
use App\Models\HotelCinCoutRule;
use App\Models\BookingService;
use App\Models\CronLog;
use App\Models\DefaultRule;
use App\Models\SmsLog;
use App\Models\Role;

use App\Models\User;
use stdClass;
class CustomerProfileController extends Controller
{
    protected $lockdown = false;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        return 'sadasdsa';
        $this->middleware('auth')->except(['customer_bookings','external_customer_bookings']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomerBookings()
    {

        $hotels = auth()->user()->user_hotels();
        $c_ids= $hotels->get()->pluck(['city_id']);
        $city_ids= $c_ids->unique();
        $cities = DB::table('cities')->whereIn('id',$city_ids);
        $paymenttypes = PaymentType::get(['id', 'PaymentMode']);
        $taxrates = TaxRate::where('IsActive', '=', 1)->get(['id', 'Tax', 'TaxValue', 'IsDefault']);
        $clients = CorporateClient::get(['id', 'FullName']);
        // $channels = Channel::get(['Channel']);
        $channels = Channel::get();
        // Mr Optimist | 29 Oct 2021
        $corporate_types = CorporateType::get();
        $path = public_path('/json/nationalities.json');
        $nationalities = json_decode(file_get_contents($path), true);

        //echo "<pre>";
        $user = Auth::user();
        $user_email = $user->email;
        //$user_email = 'fahadahmedoptimist@gmail.com';
        if(!empty($user_email)) {

            
            //$user_email = 'abc@yokmail.com';
            $bookings = Booking::whereHas('customer', function ($q1) use ($user_email) {
                
                $q1->where('Email', $user_email);

            })->with(['hotel','rooms', 'rooms.category', 'invoice', 'promotion','tax_rate', 'invoice.payment_mode'])
            ->orderBy('created_at', 'desc')->get();

           

            if(!empty($bookings)){

                $count = $bookings->count();
                if($count > 0){

                    $bookings_map = $bookings->map(function ($ex) {

                        $obj = new stdClass();
                        $obj->id = $ex->id;
                        $obj->booking_no = $ex->booking_no ?? "";
                        $obj->customer_first_name = $ex->invoice->customer_first_name ?? "";
                        $obj->customer_last_name = $ex->invoice->customer_last_name ?? "";
                        $obj->HotelName = $ex->hotel->HotelName ?? "";
                        $obj->rooms = $ex->rooms->map(function ($room) {
                            $obj['room_title'] = $room->room_title;
                            $obj['RoomNumber'] = $room->RoomNumber;
                            return $obj;
                        });
                       
                        $obj->status = $ex->status ?? "";
                        $obj->BookingDate = $ex->BookingDate ?? "";
                        $obj->BookingFrom = $ex->BookingFrom ?? "";
                        $obj->BookingTo = $ex->BookingTo ?? "";
                        $obj->created_by = $ex->created_by ?? "";
                        
                        return $obj;
                    });

                    return response()->json([
                        'success' => true,
                        'totalRecords' => $count,
                        'bookings' => $bookings_map,
                    ])->setEncodingOptions(JSON_NUMERIC_CHECK);

                }
                else {

                    return response()->json([
                        'success' => false,
                        'message' => ['No Bookings Found!'],
                        'msgtype' => 'danger',
                    ]);

                } 

            }
            else {
                 return response()->json([
                        'success' => false,
                        'message' => ['No Bookings Found!'],
                        'msgtype' => 'danger',
                    ]);

            }

             
        }
        else {
             return '/';
        }
        
    }

    public function getCustomerBookingsAll(Request $request){
        
        //$user_email = 'fahadahmedoptimist@gmail.com';
        $user_email = $request->email ?? null;
        
        if(!empty($user_email)) {

            
            $bookings = Booking::whereHas('customer', function ($q1) use ($user_email) {
                
                $q1->where('Email', $user_email);
    
            })->with(['hotel','rooms', 'rooms.category', 'invoice', 'promotion','tax_rate', 'invoice.payment_mode'])
            ->orderBy('created_at', 'desc')->get();

           

            if(!empty($bookings)){

                $count = $bookings->count();
                if($count > 0){

                    $bookings_map = $bookings->map(function ($ex) {

                        $obj = new stdClass();
                        $obj->id = $ex->id;
                        $obj->booking_no = $ex->booking_no ?? "";
                        $obj->customer_first_name = $ex->invoice->customer_first_name ?? "";
                        $obj->customer_last_name = $ex->invoice->customer_last_name ?? "";
                        $obj->HotelName = $ex->hotel->HotelName ?? "";
                        $obj->rooms = $ex->rooms->map(function ($room) {
                            $obj['room_title'] = $room->room_title;
                            $obj['RoomNumber'] = $room->RoomNumber;
                            return $obj;
                        });
                       
                        $obj->status = $ex->status ?? "";
                        $obj->BookingDate = $ex->BookingDate ?? "";
                        $obj->BookingFrom = $ex->BookingFrom ?? "";
                        $obj->BookingTo = $ex->BookingTo ?? "";
                        $obj->created_by = $ex->created_by ?? "";
                        
                        return $obj;
                    });

                    return response()->json([
                        'success' => true,
                        'totalRecords' => $count,
                        'bookings' => $bookings_map,
                    ])->setEncodingOptions(JSON_NUMERIC_CHECK);

                }
                else {

                    return response()->json([
                        'success' => false,
                        'totalRecords' => 0,
                        'message' => ['No Bookings Found!'],
                        'msgtype' => 'danger',
                    ]);

                } 

            }
            else {
                 return response()->json([
                        'success' => false,
                        'totalRecords' => 0,
                        'message' => ['No Bookings Found!'],
                        'msgtype' => 'danger',
                    ]);

            }

             
        }
        else {
             return response()->json([
                        'success' => false,
                        'totalRecords' => 0,
                        'message' => ['No Bookings Found!'],
                        'msgtype' => 'danger',
                    ]);
        }

        //return response()->json(['success'=> true, 'message'=>'Booking created successfully']);
        //return 'partners ktwoe zindabad';

    }
     


    /**
     * Display single profile page for booking.
     *
     * @return \Illuminate\Http\Response
     */
    public function customerSingleProfileBooking($id)
    {
        
        $hotels = auth()->user()->user_hotels();
        $c_ids= $hotels->get()->pluck(['city_id']);
        $city_ids= $c_ids->unique();
        $cities = DB::table('cities')->whereIn('id',$city_ids);
        $paymenttypes = PaymentType::get(['id', 'PaymentMode']);
        $taxrates = TaxRate::where('IsActive', '=', 1)->get(['id', 'Tax', 'TaxValue', 'IsDefault']);
        $clients = CorporateClient::get(['id', 'FullName']);
        // $channels = Channel::get(['Channel']);
        $channels = Channel::get();
        // Mr Optimist | 29 Oct 2021
        $corporate_types = CorporateType::get();
        $path = public_path('/json/nationalities.json');
        $nationalities = json_decode(file_get_contents($path), true);

        // $booking_code = decrypt($code);
        $booking_id = $id;

        $user = Auth::user();
        $user_email = $user->email;
        if(!empty($user_email)) {

            
            //$user_email = 'abc@yokmail.com';
            $bookings = Booking::whereHas('customer', function ($q1) use ($user_email) {
                
                $q1->where('Email', $user_email);

            })->with(['rooms', 'rooms.category', 'invoice', 'promotion','tax_rate', 'invoice.payment_mode'])
            ->where('id',$booking_id)
            ->latest('updated_at')
            ->first();
            
            if(!empty($bookings)){
                $count = $bookings->count();
                if($count > 0){
                 
                    return response()->json([
                        'success' => true,
                        'nationalities'=>$nationalities,
                        'cities' => $cities->get(['id', 'CityName']),
                        'hotels' => $hotels->whereNull('deleted_at')->get(['id', 'HotelName', 'city_id', 'has_tax', 'tax_rate_id']),
                        'clients' => $clients,
                        'channels'=> $channels,
                        'totalRecords' => $count,
                        'bookings' => $bookings,
                        'paymenttypes'=> $paymenttypes,
                        'taxrates'=> $taxrates,
                        'corporate_types' => $corporate_types,
                        'user' => $user
                    ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    
                }
                else {
    
                    return response()->json([
                        'success' => false,
                        'message' => ['No Bookings Found!'],
                        'msgtype' => 'danger',
                    ]);
    
                }
            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => ['No Bookings Found!'],
                    'msgtype' => 'danger',
                ]);
            }    
        }
        else {
             return '/';
        }

    }

    // External Booking
    public function getCustomerBooking(Request $request)
    {

        $booking_id = $request->id ?? null;
        $user_email = $request->email ?? null;
    
        if(!empty($user_email) && !empty($booking_id)) {

            //$booking = $this->getBooking($id,$user_email);
            $booking = Booking::whereHas('customer', function ($q1) use ($user_email) {
                $q1->where('Email', $user_email);
            })->with(['booking_occupants', 'agent', 'booking_third_party.details', 'booking_third_party.mapping_statuses', 'discount_request','discount_request.supervisor','services','hotel', 'hotel.checkin', 'hotel.checkout','customer' => function($q){
                $q->withCount('bookings');
            }, 'rooms', 'rooms.category','rooms.hotel', 'invoice', 'invoice_details', 'promotion','tax_rate','invoice.payment_mode', 'status_history'])->find($booking_id);
            

            if(!empty($booking)){

                foreach ($booking->rooms as $r) {
                    $r->hotel_room_category = $r->hotel_room_category;
                }
                $invoice_details = InvoiceDetail::where('booking_id',$booking->id)->get();
                $default_rule_img = DefaultRule::first()->picture;
                $default_rule = DefaultRule::first();
                $msg = "";

                if ($booking->discount_request) {
                    if ($booking->discount_request->status == 'Pending') {
                        $this->lockdown = true;
                        $msg = "Discount request has not been approved yet";
                    }
        
                    if ($booking->discount_request->status == 'Declined') {
                        $msg = "Discount request was declined";
                        $this->lockdown = false;
                    }
                }

                return response()->json([
                    'success' => true,
                    'booking' => $booking,
                    'default_rule_img'=>$default_rule_img,
                    'default_rule'=>$default_rule,
                    'lockdown' => $this->lockdown && false,
                    'invoice_details'=>$invoice_details,
                    'msg' => $msg
                ])->setEncodingOptions(JSON_NUMERIC_CHECK);

            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => ["Booking Not Found"],
                    'msgtype' => 'error',
                ])->setEncodingOptions(JSON_NUMERIC_CHECK);

            }
        }
        else {
            return response()->json([
                'success' => false,
                'message' => ["Booking Not Found"],
                'msgtype' => 'error',
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        }
    }

   

    public function show($id)
    {

        $user = Auth::user();
        $user_email = $user->email;
        if(!empty($user_email)) {

            //$booking = $this->getBooking($id,$user_email);
            $booking = Booking::whereHas('customer', function ($q1) use ($user_email) {
                $q1->where('Email', $user_email);
            })->with(['booking_occupants', 'agent', 'booking_third_party.details', 'booking_third_party.mapping_statuses', 'discount_request','discount_request.supervisor','services','hotel', 'hotel.checkin', 'hotel.checkout','customer' => function($q){
                $q->withCount('bookings');
            }, 'rooms', 'rooms.category','rooms.hotel', 'invoice', 'invoice_details', 'promotion','tax_rate','invoice.payment_mode', 'status_history'])->find($id);
            

            if(!empty($booking)){

                foreach ($booking->rooms as $r) {
                    $r->hotel_room_category = $r->hotel_room_category;
                }
                $invoice_details = InvoiceDetail::where('booking_id',$booking->id)->get();
                $default_rule_img = DefaultRule::first()->picture;
                $default_rule = DefaultRule::first();
                $msg = "";

                if ($booking->discount_request) {
                    if ($booking->discount_request->status == 'Pending') {
                        $this->lockdown = true;
                        $msg = "Discount request has not been approved yet";
                    }
        
                    if ($booking->discount_request->status == 'Declined') {
                        $msg = "Discount request was declined";
                        $this->lockdown = false;
                    }
                }

                return response()->json([
                    'success' => true,
                    'booking' => $booking,
                    'user' => [
                        'name' => Auth::user()->name
                    ],
                    'default_rule_img'=>$default_rule_img,
                    'default_rule'=>$default_rule,
                    'lockdown' => $this->lockdown && false,
                    'invoice_details'=>$invoice_details,
                    'msg' => $msg
                ])->setEncodingOptions(JSON_NUMERIC_CHECK);

            }
            else {
                return response()->json([
                    'success' => false,
                    'message' => ["Booking Not Found"],
                    'msgtype' => 'error',
                ])->setEncodingOptions(JSON_NUMERIC_CHECK);

            }
        }
        else {
            return '/';
        }
    }

    private function getBooking($id,$user_email) {
        $booking = Booking::whereHas('customer', function ($q1) use ($user_email) {
                
            $q1->where('Email', $user_email);

        })->with(['booking_occupants', 'agent', 'booking_third_party.details', 'booking_third_party.mapping_statuses', 'discount_request','discount_request.supervisor','services','hotel', 'hotel.checkin', 'hotel.checkout','customer' => function($q){
            $q->withCount('bookings');
        }, 'rooms', 'rooms.category','rooms.hotel', 'invoice', 'invoice_details', 'promotion','tax_rate','invoice.payment_mode', 'status_history'])->find($id);
        
        echo "<pre>";
        var_dump($booking);
        echo "</pre>";
        die;

        foreach ($booking->rooms as $r) {
            $r->hotel_room_category = $r->hotel_room_category;
        }

        // $invoice_detail = InvoiceDetail::all();
        
        return $booking;
    }
    
}
