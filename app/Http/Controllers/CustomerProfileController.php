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

class CustomerProfileController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
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
        if(!empty($user_email)) {

            
            //$user_email = 'abc@yokmail.com';
            $bookings = Booking::whereHas('customer', function ($q1) use ($user_email) {
                
                $q1->where('Email', $user_email);

            })->with(['rooms', 'rooms.category', 'invoice', 'promotion','tax_rate', 'invoice.payment_mode'])
            ->orderBy('created_at', 'desc')->get();

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
    
}
