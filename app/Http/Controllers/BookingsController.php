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
use App\Models\BookingMiscellaneousAmount;

class BookingsController extends Controller
{
    protected $booking;
    protected $module_name = "Bookings";
    protected $hotel_id = 0;
    protected $is_frontdesk = false;
    protected $new_booking;
    protected $requested_discount = false;
    protected $lockdown = false;
    protected $p = "";
    protected $invoice;
    protected $invoice_detail;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth')->except(['third_party_booking','blinq_archive','getBookingsMiscellaneousAmount','deleteBookingsMiscellaneousAmount','saveBookingsMiscellaneousAmount']);
    }
    /**
     * Display base page for companies.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        if ($this->userIsFrontDesk()) {
            abort(403);
        }
        
        return view('bookings.index', [
            'breadcrumb' => $this->module_name
        ]);
    }

    public function frontdesk() {
        return view ('bookings.frontdesk', [
            'breadcrumb' => 'Front Desk'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBookings(Request $request)
    {
        // dd(request()->all());
        // dd(json_decode(request()->status));
        // Get Cities
        $inputs = $request->all();
        // dd($inputs);
        // $cities = DB::table('cities');
        // $hotels = Hotel::with(['tax']);
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
        // dd($nationalities);
        $bookings = Booking::leftJoin('customers', 'bookings.customer_id', '=', 'customers.id')
                            ->leftJoin('hotels', 'bookings.hotel_id', '=', 'hotels.id')
                            ->leftJoin('users', 'bookings.created_by', '=', 'users.id')
                            ->leftJoin('booking_invoices', 'bookings.id', '=', 'booking_invoices.booking_id')
                            ->leftJoin('promotions', 'bookings.promotion_id', '=', 'promotions.id')
                            ->leftJoin('tax_rates', 'bookings.tax_rate_id', '=', 'tax_rates.id')
                            ->leftJoin('booking_status_history', 'bookings.id', '=', 'booking_status_history.booking_id')
                            ->leftJoin('discount_requests', 'bookings.id', '=', 'discount_requests.booking_id')
                            ->leftJoin('booking_third_parties', 'bookings.booking_third_party_id', '=', 'booking_third_parties.id')
                            ->leftJoin('booking_room','bookings.id','booking_room.booking_id')
                            ->leftJoin('rooms','booking_room.room_id','rooms.id');
                            // dd(count($bookings->get()));

        // if filter then add where clauses
        if (!empty(request()->booking_no)) {
            $bookings->where('bookings.booking_no', request()->booking_no);
        }

        if (!empty(request()->customer_name)) {
            $c = request()->customer_name;
            $bookings->where(function($query) use ($c) {
                return $query->whereRaw("CONCAT(ifnull(FirstName,''),' ',ifnull(LastName,'')) like ?", ['%'.$c.'%']);
                // return $query->where('FirstName', 'LIKE', $c)
                // ->orWhere('LastName', 'LIKE', $c);
            });
        }

        if (!empty(request()->hotel_name)) {
            $bookings->where('bookings.hotel_id', request()->hotel_name);
        }

        if (!empty(request()->phone_no)) {
            $bookings->where('Phone', request()->phone_no);
        }
        // dd(request()->status);
        if (!empty(request()->status)) {
            if(request()->status != '[]'){
                $statuses = json_decode(request()->status);
                $bookings->whereIn('bookings.status',$statuses);
            }
        }

        if (!empty(request()->booking_date)) {
            $bookings->where(\DB::raw('DATE(BookingDate)'), request()->booking_date);
        }

        if (!empty(request()->checkin_date)) {
            $bookings->where(\DB::raw('DATE(BookingFrom)'), request()->checkin_date);
        }

        if (!empty(request()->checkout_date)) {
            $bookings->where(\DB::raw('DATE(BookingTo)'), request()->checkout_date);
        }

        if (!empty(request()->booked_from)) {
            $bookings->where(\DB::raw('DATE(BookingFrom)'), '>=', request()->booked_from);
        }

        if (!empty(request()->booked_to)) {
            $bookings->where(\DB::raw('DATE(BookingFrom)'), '<=', request()->booked_to);
        }

        if (!empty(request()->occupants)) {
            $bookings->where('num_occupants', request()->occupants);
        }

        // if ($this->userIsFrontDesk()) {
        //     // get current user
        //     $user = Auth::user();

        //     $bookings->where('bookings.hotel_id', '=', $user['hotel_id']);
        //     $cities->where('id', '=', $user['city_id']);
        //     $hotels->where('id', '=', $user['hotel_id']);
        // }
        if (!auth()->user()->hasRole('Admin')) {
            $user = Auth::user();
            if($user->self_manipulated()){
                $bookings = $bookings->where('bookings.created_by',$user->id);
            }else{
                $bookings->whereIn('bookings.hotel_id',$user->hotelIds);
            }
            // $cities->where('id', '=', $user['city_id']);
            $hotels->whereIn('id', $user->hotelIds);
        }

        $user = [
            'can_give_discount' => Auth::user()->roles()->where('has_discount_priviledge',1)->count() > 0 ? true : false,
            'max_allowed_discount' => Auth::user()->max_allowed_discount ? Auth::user()->max_allowed_discount : 0,
            'is_frontdesk' => $this->userIsFrontDesk(),
            'is_supervisor' => $this->userIsSupervisor()
        ];
        $bookings = $bookings->groupBy('bookings.id');
        // dd(count($bookings->get()));
        $count = count($bookings->get());

        // DB::enableQueryLog();
        if (isset($inputs['pageSort'])) {
            // dd('in');
            $sortingPagination = json_decode($inputs['pageSort']);
            // dd($sortingPagination);
            $bookings = $bookings->skip($sortingPagination->page * 10 - 10)->take($sortingPagination->page * 10);
            if (isset($sortingPagination->colName))
                $bookings = $bookings->orderBy($sortingPagination->colName, $sortingPagination->direction);
        }
        // $bookings->get();
        // dd(DB::getQueryLog());
        // dd($count);

        // $bookings = $bookings->skip($inputs['page'] * $inputs['perPage'] - $inputs['perPage'])->take($inputs['page'] * $inputs['perPage'])->orderBy('bookings.created_at', $request->sorting);

        return response()->json([
            'success' => true,
            'nationalities'=>$nationalities,
            'cities' => $cities->get(['id', 'CityName']),
            'hotels' => $hotels->whereNull('deleted_at')->get(['id', 'HotelName', 'city_id', 'has_tax', 'tax_rate_id']),
            'clients' => $clients,
            'channels'=> $channels,
            'totalRecords' => $count,
            'bookings' => $bookings->get([
                'bookings.id', 'bookings.status', 'bookings.BookingDate', 'bookings.created_at', 'users.name as created_by', 'bookings.BookingFrom', 'bookings.BookingTo', 'bookings.booking_no', 'bookings.is_third_party',
                'hotels.HotelName','rooms.RoomNumber',
                'booking_third_parties.total_cost',
                'booking_third_parties.booking_no as third_party_booking_no',
                \DB::raw("CONCAT(customers.FirstName, ' ', customers.LastName) as FullName"), 'customers.Email', 'customers.Phone',
                'booking_invoices.net_total', 'booking_invoices.discount_amount', 'booking_invoices.total', 'booking_invoices.tax_charges', \DB::raw("IFNULL(booking_invoices.num_occupants, bookings.no_occupants) as num_occupants"),
                'promotions.Code', 'promotions.DiscountValue', 'promotions.IsPercentage',
                'discount_requests.status as DiscountStatus',
                'tax_rates.Tax', 'tax_rates.TaxValue',
                \DB::raw("GROUP_CONCAT(CONCAT(booking_status_history.status, '.', DATE_FORMAT(booking_status_history.status_date, '%m/%d/%Y %h:%i %p')) ORDER BY status_date ASC) as status_history")
            ]),
            'paymenttypes'=> $paymenttypes,
            'taxrates'=> $taxrates,
            'is_frontdesk' => $this->is_frontdesk,
            'corporate_types' => $corporate_types,
            'user' => $user
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }


    /**
     * Mr Optimist
     * Get Miscellaneous Amount
     */
    public function getBookingsMiscellaneousAmount(Request $request)
    {

        
        $booking_id = !empty($request->booking_id) ? $request->booking_id : ''; 
        $get_booking_miscellaneous_amounts = BookingMiscellaneousAmount::where('booking_id','=',$booking_id)->get();
        return response()->json([
            'success' => true,
            'booking_miscellaneous_amounts' => $get_booking_miscellaneous_amounts,
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    
    
    }
    
    public function deleteBookingsMiscellaneousAmount(Request $request) {

        $booking_miscellaneous_amount = BookingMiscellaneousAmount::find($request->id);
        if(isset($booking_miscellaneous_amount)) {
            $message = ["'$booking_miscellaneous_amount->name' is deleted successfully!"];
            $booking_miscellaneous_amount->delete();
    
            return response()->json([
                'success' => true,
                'message' => $message,
                'msgtype' => 'success',
                'id' => $request->id
            ]);
        }
        else {
            $message = ["'$booking_miscellaneous_amount->name' is not deleted"];
            return response()->json([
                'success' => false,
                'message' => $message,
                'msgtype' => 'danger',
                'id' => $request->id
            ]);
        }

       
    }
    
    public function saveBookingsMiscellaneousAmount(Request $request)
    {
        
        // $miscellaneousamount_id = $request->miscellaneousamount['id'] ?? null;
        $miscellaneousamount_id = $request->id ?? null;

        $miscellaneous_amount = BookingMiscellaneousAmount::find($miscellaneousamount_id);
        
        if(!isset($miscellaneous_amount)) {
            $miscellaneous_amount = new BookingMiscellaneousAmount();  
        }
        $miscellaneous_amount->booking_id = $request->booking_id;
        $miscellaneous_amount->name = $request->Name;
        $miscellaneous_amount->amount = $request->payment_amount;
        $miscellaneous_amount->is_complementary = $request->is_complementary;
        $miscellaneous_amount->status = $request->status;
        $miscellaneous_amount->save();
        return response()->json([
            'success' => true,
            'message' => ["$miscellaneous_amount->name added successfully"],
            'msgtype' => 'success',
            'miscellaneous_amount' => $miscellaneous_amount
        ]);
        
    }
    

    public function getData() {
        // Get Cities
        // $cities = DB::table('cities');
        // $hotels = Hotel::with(['tax']);
        $hotels = auth()->user()->user_hotels();
        $c_ids= $hotels->get()->pluck(['city_id']);
        $city_ids= $c_ids->unique();
        $cities = DB::table('cities')->whereIn('id',$city_ids);

        $paymenttypes = PaymentType::get(['id', 'PaymentMode']);
        $taxrates = TaxRate::where('IsActive', '=', 1)->get(['id', 'Tax', 'TaxValue', 'IsDefault']);
        $clients = CorporateClient::get(['id', 'FullName']);
        // $channels = Channel::get(['Channel']);
        $channels = Channel::get();
        
        // Mr Optimist | 28 Oct 2021
        $corporate_types = CorporateType::get();

        $path = public_path('/json/nationalities.json');
        $nationalities = json_decode(file_get_contents($path), true);
     
        // temp coment
        // if (!Auth::user()->hasRole('Admin')) {
        //     // get current user
        //     $user = Auth::user();
        //     $hotels->whereIn('id',$user->HotelIds);
        //     // $cities->where('id', '=', $user['city_id']);
        //     // $hotels->where('id', '=', $user['hotel_id']);
        // }

        $user = [
            'can_give_discount' => Auth::user()->roles()->where('has_discount_priviledge',1)->count() > 0 ? true : false,
            'max_allowed_discount' => Auth::user()->max_allowed_discount ? Auth::user()->max_allowed_discount : 0,
            'is_frontdesk' => $this->userIsFrontDesk(),
            'is_supervisor' => $this->userIsSupervisor(),
            'name' => Auth::user()->name
        ];

       
    
        /************ Welcome Message Section **********/
        // $Hour = date('G');
        $timezone  = +5;
        $Hour = gmdate("G", time() + 3600*($timezone+date("I")));
        $greeting_message = 'Good Night';
        if ($Hour >= 5 && $Hour <= 11) {
            $greeting_message = "Good Morning";
        } else if ($Hour >= 12 && $Hour <= 16) {
            $greeting_message = "Good Afternoon";
        } else if ($Hour >= 17 || $Hour <= 4) {
            $greeting_message = "Good Evening";
        }
        $greeting_message = $greeting_message . ', ' . Auth::user()->name .'!';
        $greeting_description = 'Welcome to <strong>' . implode (", ",Auth::user()->HotelNames) . '</strong> dashboard';
        /************ Welcome Message Section **********/
        return response()->json([
            'success' => true,
            'cities' => $cities->get(['id', 'CityName']),
            'hotels' => $hotels->whereNull('deleted_at')->get(['id', 'HotelName', 'city_id', 'has_tax', 'tax_rate_id']),
            'paymenttypes'=> $paymenttypes,
            'clients' => $clients,
            'channels'=> $channels,
            'nationalities' => $nationalities,
            'taxrates'=> $taxrates,
            'is_frontdesk' => $this->userIsFrontDesk(),
            'user' => $user,
            'greeting_message' => $greeting_message,
            'greeting_description' => $greeting_description,
            'corporate_types' => $corporate_types,
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function searchPromo(Request $request)
    {
        $promotion = Promotion::where('Code', '=', $request->code)
            ->where(\DB::raw("ValidFrom"),'<=',date('Y-m-d'))
            ->where(\DB::raw("ValidTo"),'>=',date('Y-m-d'))
            ->limit(1)->get();

        if (count($promotion) > 0) {
            $success = true;
            $msgtype = 'success';
            $message = ['Promo Applied'];   
        } else {
            $success = false;
            $msgtype = 'error';
            $message = ['Promo Not Found'];   
        }

        return response()->json([
            'success' => $success,
            'message' => $message,
            'msgtype' => $msgtype,
            'promotion' => $promotion
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function searchRooms(Request $request)
    {
        // dd($request->all());
        $h = $request->hotel;
        if($request->searchByBooking != "true"){

            if ($request->formType=='create') {
                $data = $request->validate([
                    'hotel' => 'required',
                    'city_id' => 'required',
                    'start_date' => 'required|date|after_or_equal:' . date('Y-m-d'),
                    'end_date' => 'required|date|after_or_equal:start_date'
                ], [
                    'hotel.required' => 'Please select a Hotel',
                    'city_id.required' => 'Please select a City',
                    'start_date.required' => 'Please select a Check-In Date',
                    'end_date.required' => 'Please select a Check-Out Date',
                    'start_date.after_or_equal' => 'Check-in Date cannot be before current date',
                    'end_date.after_or_equal' => 'Check-out Date must be equal or greater than Check-in Date'
                ]);
            } else {
                $data = $request->validate([
                    'hotel' => 'required',
                    'city_id' => 'required',
                    'start_date' => 'required|date',
                    'end_date' => 'required|date|after_or_equal:start_date'
                ], [
                    'hotel.required' => 'Please select a Hotel',
                    'city_id.required' => 'Please select a City',
                    'start_date.required' => 'Please select a Check-In Date',
                    'end_date.required' => 'Please select a Check-Out Date',
                    'end_date.after_or_equal' => 'Check-out Date must be equal or greater than Check-in Date'
                ]);
            } 

            $rooms = Room::with(['hotel', 'category', 'facilities', 'tax_rate', 'room_status'])->where('hotel_id', '=', $request->hotel)->orderBy('id', 'asc')->get();

            $room_ids = [];

            $is_checkedout =false;
            foreach($rooms as $i => $room) {
                $room['hotel_room_category'] = $room->hotel_room_category;
                $room_ids[] = $room->id;
                $show_menu =false;
                if ($room->is_available == 0) {
                    $rooms[$i]->st = [
                        'name' => 'Not Available',
                        'card_style' => 'bg-danger-400',
                        'text_style' => 'text-light',
                        'cursor'=>'no-cursor',
                        'show_menu' => $show_menu,
                        'is_checkedout' => $is_checkedout,
                    ];
                } else {
                    $room->st = [
                        'name' => 'Open',
                        'card_style' => 'bg',
                        'text_style' => 'text-dark book-room',
                        'show_menu' => $show_menu,
                        'is_checkedout' => $is_checkedout,
                    ];
                }
            }

            // dd($rooms);
            // if($request->searchByBooking != "true"){
            $room_schedule = RoomSchedule::with(['booking'])->where('status', '=', 1)
                        ->whereNull('deleted_at')
                        ->whereIn('room_id', $room_ids)
                        ->where(function($query) use ($data) {
                            $query->where([
                                ['start_date', '>=', $data['start_date']],
                                ['start_date', '<=', $data['end_date']]
                            ]);

                            $query->orWhere([
                                ['end_date', '>=', $data['start_date']],
                                ['start_date', '<=', $data['end_date']]
                            ]);
                        })
                        ->orderBy('room_id', 'asc')
                        ->distinct()
                        ->get();

            // $j = 0;
            for ($i=0; $i<count($rooms); $i++) {
                // find rs
                $rs = $room_schedule->first(function($r, $k) use ($rooms, $i) {
                    return $r->room_id == $rooms[$i]->id;
                });

                // Mr Optimist
                if(isset($room_schedule[$i]->booking->customer_id) && $room_schedule[$i]->booking->customer_id > 0 ){
                    $customer_book_count = Customer::withCount('bookings')->where('id', '=',$room_schedule[$i]->booking->customer_id)->first();
                    if (!empty($customer_book_count)) {

                        if(isset($customer_book_count->bookings_count) && $customer_book_count->bookings_count > 1 ){
                            $is_klc = 'yes';
                        }
                        else{
                            $is_klc = 'no';
                        }
                    }
                    else{
                        $is_klc = 'no';
                    }
                }

                if ($rooms[$i]->is_available == '0') {
                    $rooms[$i]->st = [
                        'name' => 'Not Available',
                        'card_style' => 'bg-danger-400',
                        'text_style' => 'text-light',
                        'cursor'=>'no-cursor',
                        'show_menu' => $show_menu,
                        'is_checkedout' => $is_checkedout,
                        'is_klc' => $is_klc,
                    ];
                }

                else if (!empty($rs)) {
                    $show_menu = true;
    
                    // if ($room_schedule[$j]->booking->status == 'CheckedIn') {
                    if ($rs->booking->status == 'CheckedIn') {
                        $rooms[$i]->st = [
                            'name' => 'Booked',
                            'card_style' => 'bg-success',
                            'text_style' => 'text-light',
                            'cursor'=>'no-cursor',
                            'show_menu' => $show_menu,
                            'is_checkedout' => $is_checkedout,
                            'is_klc' => $is_klc,
                        ];
    
                    } else {
                        // if($room_schedule[$j]->booking->status == 'Pending' && $room_schedule[$j]->booking->is_central_booking == '1'){
                        if($rs->booking->status == 'Pending' && $rs->booking->is_central_booking == '1'){
                            $show_menu = false;
                        }
                        $rooms[$i]->st = [
                            'name' => 'Reserved',
                            'card_style' => 'bg-warning',
                            'text_style' => 'text-light',
                            'cursor'=>'no-cursor',
                            'show_menu' => $show_menu,
                            'is_checkedout' => $is_checkedout,
                            // 'is_confirmed' => $room_schedule[$j]->booking->status == 'Confirmed' ? '1' : '0'
                            'is_confirmed' => $rs->booking->status == 'Confirmed' ? '1' : '0',
                            'is_klc' => $is_klc,
                        ];
                    }
                    // $booking_no = $room_schedule[$j]->booking->booking_no;
                    $booking_no = $rs->booking->booking_no;

                    if($rs->booking->is_third_party){
                        if(!$rs->booking->booking_no){
                            if($rs->booking->booking_third_party){
                                $booking_no = $rs->booking->booking_third_party->booking_no;
                            }
                        }
                    }
                    $rooms[$i]->booking_no = $booking_no;
                    $rooms[$i]->booking_status = $rs->booking->status;
                    $rooms[$i]->is_central_booking = $rs->booking->is_central_booking;
                    $rooms[$i]->is_third_party = $rs->booking->is_third_party;
                    $rooms[$i]->customer_name = $rs->booking->customer->getName();
                    $rooms[$i]->outstanding_balance = (isset($rs->booking->invoice) ? $rs->booking->invoice->net_total : 0) - (isset($rs->booking->invoice) ? $rs->booking->invoice->payment_amount : 0) ;
                    $rooms[$i]->booking_id = $rs->booking_id;
                    $rooms[$i]->booking_code = $rs->booking->booking_code ?? null;
    
                    // if ($room_schedule[$j]->booking->status == 'CheckedIn') {
                    //     $rooms[$i]->checkin_date =date('d/m/Y H:i a', strtotime('+12 hours', strtotime($room_schedule[$j]->booking->checkin_time)));
                    // } else {
                    //     $rooms[$i]->checkin_date = date_format(date_create($room_schedule[$j]->booking->BookingFrom), 'd/m/Y H:i a');
                    // }
    
                    // $rooms[$i]->checkout_date = date_format(date_create($room_schedule[$j]->booking->BookingTo), 'd/m/Y');

                    // dd($room_schedule[$j]->booking->checkin_time);
                    if ($rs->booking->status == 'CheckedIn') {
                        $rooms[$i]->checkin_date =date('d/m/Y h:i a',  strtotime($rs->booking->checkin_time));
                    } else {
                        $rooms[$i]->checkin_date =date('d/m/Y',  strtotime($rs->booking->BookingFrom));
                    }
                    $rooms[$i]->checkout_date =date('d/m/Y',  strtotime($rs->booking->BookingTo));
    
                    $room_booking = BookingRoom::where('booking_id', $rs->booking_id)->where('room_id', $rs->room_id)->first();
    
                    // dd($room_booking);
    
                    $rooms[$i]->onbooking_rate = $room_booking->room_charges_onbooking;
                    
                    $rooms[$i]->num_occupants = $rs->booking->no_occupants;
                }
            }
            // dd($rooms);
        } else {
            $hotel_id = $h;
            if($hotel_id){
                $searchBookings = Booking::where('hotel_id', $hotel_id)
                ->leftJoin('customers', 'bookings.customer_id', '=', 'customers.id')
                ->leftJoin('hotels', 'bookings.hotel_id', '=', 'hotels.id')
                ->leftJoin('booking_room', 'bookings.id', '=', 'booking_room.booking_id');
            } else {
                $searchBookings = Booking::leftJoin('customers', 'bookings.customer_id', '=', 'customers.id')
                ->leftJoin('hotels', 'bookings.hotel_id', '=', 'hotels.id')
                ->leftJoin('booking_room', 'bookings.id', '=', 'booking_room.booking_id');
            }

           
            if (!empty(request()->bookingNo)) {
                $searchBookings->where('bookings.booking_no', strtoupper(request()->bookingNo));
            }

            
            if (!empty(request()->bookingStatus)) {
                if(request()->bookingStatus != 'All')
                    $searchBookings->where('bookings.status', request()->bookingStatus);
            }
    
            if (!empty(request()->customerName)) {
                $c = request()->customerName;
                // DB::enableQueryLog();
                $searchBookings->where(function($query) use ($c) {
                    return $query->whereRaw("CONCAT(ifnull(FirstName,''),' ',ifnull(LastName,'')) like ?", ['%'.$c.'%']);
                    // return $query->where('FirstName', 'LIKE', $c);
                    // ->orWhere('LastName', 'LIKE', $c);
                });
                // $searchBookings->get();
                // dd(DB::getQueryLog());
            }
            if (!empty(request()->customerCnic)) {
                $c = request()->customerCnic;
                $searchBookings->where(function($query) use ($c) {
                    return $query->where('CNIC', 'LIKE', '%'.$c.'%');
                });
            }

            // for multiple hotel filter
            if (!auth()->user()->hasRole('Admin')) 
            {
                $user = Auth::user();
                if($user->self_manipulated()){
                    $searchBookings = $searchBookings->where('bookings.created_by',$user->id);
                }else{
                    $searchBookings = $searchBookings->whereIn('bookings.hotel_id', $user->HotelIds);
                }
            }

            $getBookings = $searchBookings->get(['booking_room.room_id', 'bookings.id', 'customers.FirstName']);
            //  dd($getBookings->toArray());
            $booking_ids = [];

            foreach($getBookings as $value){
                $booking_room_ids[] = $value['room_id'];
                $booking_ids[] = $value['id'];
            }

            $room_schedule = RoomSchedule::whereIn('booking_id', $booking_ids)
                        // ->where('status', '=', 1)
                        // ->whereNull('deleted_at')
                        ->orderBy('room_id', 'asc')
                        ->distinct()
                        ->get(['booking_id', 'room_id', 'id']);

            
            // dd($room_schedule);
            if(count($room_schedule) < 1){
                return response()->json([
                    'success' => false,
                    'message' => ['No Bookings Found!'],
                    'msgtype' => 'danger',
                ]);
            }

            $rooms = [];

            for ($i=0;  $i<count($room_schedule); $i++) {

                // dd($room_schedule[3]->booking);
                $room = Room::find($room_schedule[$i]->room_id);

                $rooms[] = $room;

                
                // dd($room_schedule[$i]->booking->status);
                $show_menu = true;
                $is_checkedout = false;
                if ($room_schedule[$i]->booking->status == 'CheckedIn') {
                    $room->st = [
                        'name' => 'Booked',
                        'card_style' => 'bg-success',
                        'text_style' => 'text-light',
                        'cursor'=>'no-cursor',
                        'show_menu' => $show_menu,
                        'is_checkedout' => $is_checkedout,
                    ];

                } 
                else if ($room_schedule[$i]->booking->status == 'CheckedOut') {
                    $room->st = [
                        'name' => 'Checked Out',
                        'card_style' => 'bg-info',
                        'text_style' => 'text-light',
                        'cursor'=>'no-cursor',
                        'show_menu' => true,
                        'is_checkedout' => true,
                    ];

                } else {
                    // dd($room_schedule[$j]->booking->status, $room_schedule[$j]->booking->is_central_booking);
                    if($room_schedule[$i]->booking->status == 'Pending' && $room_schedule[$i]->booking->is_central_booking == '1'){
                        $show_menu = false;
                    }
                    $room->st = [
                        'name' => 'Reserved',
                        'card_style' => 'bg-warning',
                        'text_style' => 'text-light',
                        'cursor'=>'no-cursor',
                        'show_menu' => $show_menu,
                        'is_checkedout' => $is_checkedout,
                        'is_confirmed' => $room_schedule[$i]->booking->status == 'Confirmed' ? '1' : '0'
                    ];
                }

                $bookingNo = $room_schedule[$i]->booking->booking_no;
                if(!$bookingNo){
                    if($room_schedule[$i]->booking->booking_third_party){
                        $bookingNo = $room_schedule[$i]->booking->booking_third_party ? $room_schedule[$i]->booking->booking_third_party->booking_no : null;
                    }
                }

                $room->booking_no = $bookingNo;
                $room->booking_status = $room_schedule[$i]->booking->status;
                $room->is_central_booking = $room_schedule[$i]->booking->is_central_booking;
                $room->is_third_party = $room_schedule[$i]->booking->is_third_party;
                $room->customer_name = $room_schedule[$i]->booking->customer ? $room_schedule[$i]->booking->customer->getName() : '';
                $room->outstanding_balance = (isset($room_schedule[$i]->booking->invoice) ? $room_schedule[$i]->booking->invoice->net_total : 0) - (isset($room_schedule[$i]->booking->invoice) ? $room_schedule[$i]->booking->invoice->payment_amount : 0) ;
                $room->booking_id = $room_schedule[$i]->booking_id;
                $room->booking_code = $room_schedule[$i]->booking->booking_code ?? null;

                // if ($room_schedule[$i]->booking->status == 'CheckedIn') {
                //     $room->checkin_date =date('d/m/Y H:i a', strtotime('+12 hours', strtotime($room_schedule[$i]->booking->checkin_time)));
                // } else {
                //     $room->checkin_date = date_format(date_create($room_schedule[$i]->booking->BookingFrom), 'd/m/Y');
                // }

                // $room->checkout_date = date_format(date_create($room_schedule[$i]->booking->BookingTo), 'd/m/Y');

                if ($room_schedule[$i]->booking->status == 'CheckedIn') {
                    $room->checkin_date =date('d/m/Y h:i a',  strtotime($room_schedule[$i]->booking->checkin_time));
                } else {
                    $room->checkin_date =date('d/m/Y',  strtotime($room_schedule[$i]->booking->BookingFrom));
                }
                
                $room->checkout_date =date('d/m/Y',  strtotime($room_schedule[$i]->booking->BookingTo));

                $room_booking = BookingRoom::where('booking_id', $room_schedule[$i]->booking_id)->where('room_id', $room_schedule[$i]->room_id)->first();

                // dd($room_booking);

                $room->onbooking_rate = $room_booking->room_charges_onbooking ?? 0;
                
                $room->num_occupants = $room_schedule[$i]->booking->no_occupants;
                // dd($room);


                
            }
            $room_ids = [];
            foreach($rooms as $i => $room) {
                $room_ids[] = $room->id;
            }

        }

        
        // dd($rooms);
        if ($this->userIsFrontDesk()) {
            $reserved = RoomSchedule::whereIn('room_id', $room_ids)->whereNull('deleted_at')->where(function($query) {
                $query->where([
                    ['start_date', '>=', date('Y-m-d')],
                    ['start_date', '<=', date('Y-m-d')]
                ]);

                $query->orWhere([
                    ['end_date', '>=', date('Y-m-d')],
                    ['start_date', '<=', date('Y-m-d')]
                ]);
            })->where('booking_status', 'Confirmed')->where('status', 1)->count();

            $booked = RoomSchedule::whereIn('room_id', $room_ids)->whereNull('deleted_at')->where(function($query) {
                $query->where([
                    ['start_date', '>=', date('Y-m-d')],
                    ['start_date', '<=', date('Y-m-d')]
                ]);

                $query->orWhere([
                    ['end_date', '>=', date('Y-m-d')],
                    ['start_date', '<=', date('Y-m-d')]
                ]);
            })->where('booking_status', 'CheckedIn')->where('status', 1)->count();
        }
        $cancelled = 'NAN';
        if($request->start_date && $request->end_date){
            $cancelled = $this->getCancelledBookingsCount($request->start_date, $request->end_date);   
        }
        
        // get hotel cin_cout rules
        $hotel = Hotel::with(['checkin', 'checkout'])->find($request->hotel);

        return response()->json([
            'success' => true,
            'message' => [],
            'msgtype' => 'success',
            'rooms' => $rooms,
            'checkin_rules' => $hotel->checkin ?? null,
            'checkout_rules' => $hotel->checkout ?? null,
            'breakdown' => ['reserved' => !empty($reserved) ? $reserved : 0, 'booked' => !empty($booked) ? $booked : 0, 'cancelled' => !empty($cancelled) ? $cancelled : 0],
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

   public function findCustomer(Request $request)
   {
        $customer = Customer::withCount('bookings')->where('Email', '=',$request->Email)->orWhere('CNIC', '=', $request->CNIC)->first();

        if (!empty($customer)) {
            $msg = 'Customer Found';
            $msgtype = 'success';
            
            return response()->json([
                'success' => true,
                'message' => $msg,
                'msgtype' => $msgtype,
                'customer' => $customer
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } /* else {
            $msg = 'Customer Not Found';
            $msgtype = 'error';
        }*/

        
   }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddBookingRequest $request)
    {
        // dd($request->all());
        $this->booking = $request->booking;
        
        $this->new_booking = $request->formType == "create";
        
        if (empty($this->booking['status'])) {
            return response()->json([
                'success' => false,
                'message' => ['Status is required.'],
                'msgtype' => 'danger'
            ]);
        }

        // dd($this->new_booking);
        if (!$this->roomsAreAvailable()) {
            if ($this->new_booking){
                return response()->json([
                    'success' => false,
                    'message' => ['Selected rooms are not available please search again.'],
                    'msgtype' => 'danger'
                ]);
            }
            
            $this->p = Booking::find($this->booking['id'])->status;

            if ($this->p == 'Pending' && ($this->booking['status'] == 'Confirmed' || $this->booking['status'] == 'CheckedIn')) {
                return response()->json([
                    'success' => false,
                    'message' => ['Selected rooms are not available please search again.'],
                    'msgtype' => 'danger'
                ]);
            }
        }

        if (!$this->statusIsOk() && !$request->status) {
            return response()->json([
                'success' => false,
                'message' => ["Only today's bookings could be checked in."],
                'msgtype' => 'danger'
            ]);
        }

        if(!auth()->user()->can('can-add-checkout-discount') && !auth()->user()->can('can-add-frontdesk-checkout-discount') && $request->status){
            if($this->booking['invoice']['checkout_discount']>0){
                return response()->json([
                    'success' => false,
                    'message' => ["You're not allowed to give discount on checkout. Please contact your admin"],
                    'msgtype' => 'danger'
                ]);
            }
        }

        $isAgent = Channel::where('Channel', $this->booking['channel'])->first(['additionalInfo']);

        if(isset($isAgent) && $isAgent['additionalInfo'] == '1'){
            $message = null;

            if (!empty($this->booking['agent'])) {
                if (empty($this->booking['agent']['name']) || empty($this->booking['agent']['phone'])) {
                    $message = "Agent's additional info is required";
                }
            } else {
                $message = 'Agent is required';
            }

            if (!empty($message)) {
                return response()->json([
                    'success' => false,
                    'message' => [$message],
                    'msgtype' => 'danger'
                ]);
            }
        }
        // dd(request()->all());

        DB::beginTransaction();
            
        // try {
            $booking_ids = $this->createBooking();
            
            $this->createInvoice($booking_ids);
            $this->allocateRooms($booking_ids);
            $this->addOccupants($booking_ids);

            $booking = Booking::find($booking_ids[0]);

            if ($this->p != $booking->status && $booking->status == 'CheckedIn') {
                $early_checkin_charges = $this->earlyCheckIn($booking->hotel_id);

                if ($early_checkin_charges) {
                    $this->createEarlyCheckIn($booking, $early_checkin_charges);
                }
            }
            
            
            $this->invoice->save();

            if ($this->p != $booking->status && $booking->status == 'CheckedIn') {
                $booking = $booking->fresh();
                $booking->sendPortalLink();
            }

            $booking = Booking::where('id', '=', $booking_ids[0])->first();

            if (!empty($this->invoice_detail)) {
                $this->invoice_detail->booking_no = $booking->booking_no;
                $this->invoice_detail->save();
            }
            
            if ($this->p != $booking->status && $booking->status == 'Confirmed') {
                $booking->sendConfirmationSms();
            }

            // Send Email
            $booking = Booking::with(['customer', 'rooms', 'rooms.category', 'invoice', 'promotion','tax_rate', 'invoice.payment_mode'])->where('id', '=', $booking_ids[0])->first();
            
            $subject = "Booking Email";
            // dd($booking->customer->Email);
            
            if (!empty($booking->customer->Email)) {
                if ($booking->status == 'Confirmed' || $booking->status == 'CheckedIn'){
                    Mail::to($booking->customer->Email)->send(new BookingEmail($booking,$subject));
                }
            }

            $booking = Booking::join('customers', 'bookings.customer_id', '=', 'customers.id')
                            ->join('hotels', 'bookings.hotel_id', '=', 'hotels.id')
                            ->join('booking_invoices', 'bookings.id', '=', 'booking_invoices.booking_id')
                            ->leftJoin('promotions', 'bookings.promotion_id', '=', 'promotions.id')
                            ->leftJoin('tax_rates', 'bookings.tax_rate_id', '=', 'tax_rates.id')
                            ->where('bookings.id', $booking_ids[0])
                            ->first([
                                'bookings.id', 'bookings.status', 'bookings.BookingDate', 'bookings.BookingFrom', 'bookings.BookingTo', 'bookings.booking_no',
                                'hotels.HotelName',
                                \DB::raw("CONCAT(customers.FirstName, ' ', customers.LastName) as FullName"), 'customers.Email', 'customers.Phone',
                                'booking_invoices.net_total', 'booking_invoices.discount_amount', 'booking_invoices.total', 'booking_invoices.tax_charges', 'booking_invoices.num_occupants',
                                'promotions.Code', 'promotions.DiscountValue', 'promotions.IsPercentage',
                                'tax_rates.Tax', 'tax_rates.TaxValue'
                            ]);

            
            // new booking notification
            // $booking_notification = new BookingNotification();
            // $booking_notification->send();

            // TODO: sms notification to both customer and admin
            DB::commit();

            // Mr Optimist 14 Dec 2021

            $data_to_ktown = array(
                'FirstName' => $request->booking['customer']['FirstName'],
                'LastName' => $request->booking['customer']['LastName'],
                'Phone' => $request->booking['customer']['Phone'],
                'Email' => $request->booking['customer']['Email']
            );       
            
            $data_string = json_encode($data_to_ktown); 
            $ch3 = curl_init('https://ktownrooms.com/inner-user-creation');                                                               
            curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch3, CURLOPT_POSTFIELDS,$data_string);                                                                  
            curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch3, CURLOPT_HTTPHEADER, array(                                                                          
                'Content-Type: application/json',                                                                            
                // 'Content-Length: ' . strlen($data_string)
                )                                                                       
            );

            $resultt = curl_exec($ch3);           
            curl_close($ch3);

            // Mr Optimist 14 Dec 2021 Ends



            return response()->json([
                'success' => true,
                'message' => ["Booking ($booking->booking_no) has been confirmed. An email has been sent to the customer."],
                'msgtype' => 'success',
                'booking' => $booking,
                'lockdown' => $this->lockdown && false
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        // } catch (\Exception $e) {
        //     DB::rollback();

        //     return response()->json([
        //         'success' => false,
        //         // 'message' => ['Internal Server Error', $e->getMessage()],
        //         'message'=>["Something went wrong booking cannot be created, please try later"],
        //         'exception'=>$e->getMessage(),
        //         'msgtype' => 'danger',
        //         'lockdown' => $this->lockdown
        //     ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        // }
        
    }

    private function adjustAccounts() {
        $invoice = BookingInvoice::where('booking_id', $this->booking['id'])->first();
        
        $on_booking_nights = $invoice->nights;

        $start_date = new \DateTime($this->booking['start_date']);
        $end_date = new \DateTime(date('Y/m/d'));

        $nights = $end_date->diff($start_date)->format("%d");

        $nights = $nights > 0 ? $nights : 1;
        if ((int) $on_booking_nights > $nights) {
            $extra_nights = $on_booking_nights - $nights;
            // $params = array($this->booking['id'],auth()->id(), $extra_nights);
            $id = auth()->id();    
            $result = DB::select("call AutoPostCheckout(" . $this->booking['id'] . "," . $id . "," . $extra_nights . ")");
        }

    }

    // private function statusIsOk() {
    //     if ($this->booking['status'] == 'CheckedIn') {
    //         if ($this->booking['start_date'] != date('Y/m/d')) {
    //             return false;
    //         }
    //     }
    //     return true;
    // }

    private function statusIsOk() {
        if ($this->booking['status'] == 'CheckedIn') {
            $timezone = env('APP_TIMEZONE', 'Asia/Karachi');
            $start_date = Carbon::createFromFormat('Y/m/d', $this->booking['start_date'], $timezone);
            $now = (new Carbon())->setTimezone($timezone);
            if (Carbon::parse($start_date)->ne(Carbon::parse($now))) {
                return false;
            }
        }
        return true;
    }

    private function createEarlyCheckIn($booking, $charges) {
        $invoice_detail = new InvoiceDetail();

        $invoice_detail->title = "Early CheckIn";
        $invoice_detail->type = "early checkin";
        $invoice_detail->booking_id = $booking->id;
        $invoice_detail->amount = $charges;
        $invoice_detail->created_by = Auth::id();

        $invoice = $this->invoice;

        if (!empty($this->invoice->id)) {
            $invoice_detail->booking_no = $booking->booking_no;
            $invoice_detail->save();
        } else {
            $this->invoice_detail = $invoice_detail;
        }

        $invoice->net_total += $charges;
    }

    private function earlyCheckIn($hotel_id) {
        $charges = 0;

        $checkin_rules = HotelCinCoutRule::where('rule_type', 'early_check_in')->where('hotel_id', $hotel_id)->get();

        if (!empty($checkin_rules)) {
            foreach ($checkin_rules as $cin) {
                if ($this->liesBetween($cin->start_time, $cin->end_time)) {
                    $charges = $cin->charges;
                    break;
                }
            }
        }

        return $charges;
    }

    private function lateCheckout($hotel_id) {
        $charges = 0;
        
        $checkout_rules = HotelCinCoutRule::where('rule_type', 'late_check_out')->where('hotel_id', $hotel_id)->get();

        if (!empty($checkout_rules)) {
            

            foreach ($checkout_rules as $cout) {
                if ($this->liesBetween($cout->start_time, $cout->end_time)) {
                    $charges = $cout->charges;
                    break;
                }
            }
        }

        return $charges;
    }

    private function liesBetween($start_time, $end_time) {
        $timezone = env('APP_TIMEZONE', 'Asia/Karachi');
        $start_time = Carbon::createFromFormat('H:i:s', $start_time, $timezone);
        $end_time = Carbon::createFromFormat('H:i:s', $end_time, $timezone);
        
        if (Carbon::parse($start_time)->gt(Carbon::parse($end_time))) {
            $end_time->addDays(1);
        }

        $now = (new Carbon())->setTimezone($timezone);

        return $now->between($start_time, $end_time);
    }

    private function createLateCheckout($booking, $charges) {
        $invoice_detail = new InvoiceDetail();

        $invoice_detail->title = "Late Checkout";
        $invoice_detail->type = "late checkout";
        $invoice_detail->booking_id = $booking->id;
        $invoice_detail->booking_no = $booking->booking_no;
        $invoice_detail->amount = $charges;
        $invoice_detail->created_by = Auth::id();

        $invoice_detail->save();
        
        $invoice = BookingInvoice::where('booking_id', $booking->id)->first();
        $invoice->updated_by = Auth::id();
        $invoice->net_total += $charges;
        $invoice->save();
    }

    private function createChekoutDiscount($booking, $charges) {
        $invoice_detail = new InvoiceDetail();
        $invoice_detail->title = request()->remarks;
        $invoice_detail->type = "checkout discount";
        $invoice_detail->booking_id = $booking->id;
        $invoice_detail->booking_no = $booking->booking_no;
        $invoice_detail->amount = $charges;
        $invoice_detail->created_by = Auth::id();
        $invoice_detail->save();
        
        // for discount approval entry
        $da = new DiscountRequest();
        $da->booking_id = $booking->id;
        $da->hotel_id = $booking->hotel_id;
        $da->reason = request()->remarks;
        $da->discount_type = 'CheckOut';
        $da->requester_id = Auth::id();
        $da->requested_amount = $charges;
        $da->status = "Pending";
        $da->save();
        
    }

    private function createRefundDetail($booking, $charges) {
        $invoice_detail = new InvoiceDetail();

        $invoice_detail->title = "Refund";
        $invoice_detail->type = "refund";
        $invoice_detail->booking_id = $booking->id;
        $invoice_detail->booking_no = $booking->booking_no;
        $invoice_detail->amount = $charges;
        $invoice_detail->created_by = Auth::id();
        $invoice_detail->save();
        
    }

    private function addOccupants($booking_ids)
    { 
        if ($this->new_booking) {
            $data = $this->booking['customer'];
            $b =new BookingOccupant();
            $b->booking_id = $booking_ids[0];
            $b->FirstName = $data['FirstName'];
            $b->LastName = isset($data['LastName']) ? $data['LastName'] : "";
            $b->CNIC = isset($data['CNIC']) ? $data['CNIC'] : "";
            $b->save();
        } else {
            BookingOccupant::where('booking_id', $this->booking['id'])->delete();
        }
        

        if(!empty($this->booking['booking_occupants'])){
            foreach ($this->booking['booking_occupants'] as $bo) {
                $b = new BookingOccupant();
                $b->booking_id = $booking_ids[0];
                $b->FirstName = $bo['FirstName'];
                $b->LastName = isset($bo['LastName']) ? $bo['LastName'] : "";
                $b->Over18 = $bo['Over18'];
                if ($bo['Over18'] == 1) {
                    $b->Passport = empty($bo['Passport']) ? "" : $bo['Passport'];
                    $b->CNIC = isset($bo['CNIC']) ? $bo['CNIC'] : "";
                }
                $b->save();
            }
        }
    }
    
    private function allocateRooms($booking_ids) {
        // if rooms are available
        $rooms = $this->booking['rooms'];

        $booking = Booking::find($booking_ids[0]);

        if (!$this->new_booking) {
            BookingRoom::where('booking_id', $this->booking['id'])->delete();
            RoomSchedule::where('booking_id', $this->booking['id'])->delete();
        }

        foreach ($rooms as $room) {
            $br = new BookingRoom();

            $br->booking_id = $booking->id;
            $br->room_id = $room['id'];
            $br->room_charges = $room['RoomCharges'];
            $br->room_charges_onbooking = $room['room_charges_onbooking'];
            $br->room_title = $room['room_title'];
            $br->occupants = $room['occupants'];
            $br->allowed_occupants = $room['hotel_room_category']['allowed'];
            $br->max_allowed_occupants = $room['hotel_room_category']['max_allowed'];

            if ($room['occupants'] > $room['hotel_room_category']['allowed']) {
                $br->additional_occupants = $room['occupants']- $room['hotel_room_category']['allowed'];
                $br->additional_guest_charges = $br->additional_occupants * $room['hotel_room_category']['additional_guest_charges'];
            }

            $br->additional_guest_rate = $room['hotel_room_category']['additional_guest_charges'];

            $br->save();

            if ($_SERVER['REQUEST_URI'] == '/bookings' && $booking->status == 'Pending') return;

            $r = new RoomSchedule();
            $r->room_id = $room['id'];
            $r->start_date = $this->booking['start_date'];
            $r->end_date = $this->booking['end_date'];
            $r->booking_id = $booking_ids[0];
            $r->booking_status = $booking->status;
            $r->status = 1;
            $r->save();
        }
    }

    private function createInvoice($booking_ids) {
        if (request()->status) {
            $this->adjustAccounts();
        }

        // check whether there is a discount request
        if ($this->booking['invoice']['discount_amount'] > 0 || !Auth::user()->can('can-edit-discount-request')) {
            $user_can_discount = Auth::user()->roles()->where('has_discount_priviledge', 1)->count() > 0 ? true : false;

            if ($user_can_discount) {
                // check allowed amount
                $allowed_amount = Auth::user()->max_allowed_discount;

                if ($allowed_amount < $this->booking['invoice']['discount_amount']) {
                    // create discount request
                    // dd($this->booking['hotel_id']);
                    $this->createDiscountRequest($booking_ids[0]);
                }
            } else {
                $this->booking['invoice']['discount_amount'] = 0;
            }
        }

        $invoiceData = $this->booking['invoice'];

        $this->calculateTotalAmount();

        if (!$this->new_booking) {
            $invoice = BookingInvoice::where('booking_id', $this->booking['id'])->first();

            if (!empty($invoice)) {
                $invoice->updated_by = Auth::id();
            }
        }

        if (!isset($invoice)) {
            $invoice = new BookingInvoice();
            $invoice->created_by = Auth::id();
        }

        // previous code
        // if (empty($invoice)) {
        //     $invoice = new BookingInvoice();
        //     $invoice->created_by = Auth::id();
        // } else {
        //     $invoice = BookingInvoice::find($this->booking['invoice']['id']);
        //     $invoice->updated_by = Auth::id();

        //     // if(isset($this->booking['is_third_party']) && $this->booking['is_third_party']){
        //     //     $invoice = new BookingInvoice();
        //     //     $invoice->created_by = Auth::id();

        //     // } else {
        //     // }
        // }
        
        $invoice->booking_id = $booking_ids[0];
        $invoice->customer_id = $booking_ids[1];
        $invoice->total = $this->booking['invoice']['total'];
        $invoice->discount_amount = $this->booking['invoice']['discount_amount'];
        
        $invoice->net_total = $this->booking['invoice']['net_total'];

        // dd($invoice);
        // $invoice->payment_mode_id = $this->booking['payTyp']['id'];
        // $invoice->payment_mode_name = $this->booking['payTyp']['PaymentMode'];

        // customer details
        // dd($this->booking['nationality']);
        $invoice->customer_first_name = $this->booking['customer']['FirstName'];
        $invoice->customer_last_name = isset($this->booking['customer']['LastName']) ? $this->booking['customer']['LastName'] : "";
        $invoice->customer_email = isset($this->booking['customer']['Email']) ? $this->booking['customer']['Email'] : "";
        $invoice->customer_phone = $this->booking['customer']['Phone'];
        $invoice->customer_cnic = isset($this->booking['customer']['CNIC']) ? $this->booking['customer']['CNIC'] : "";
        $invoice->customer_nationality = isset($this->booking['nationality'])? $this->booking['nationality'] : "";
        // $invoice->customer_nationality = isset($this->booking['nationality'])? $this->booking['nationality'] : "";


        // tax details
        if ($this->new_booking){
            if ($this->booking['tax_rate_id'] == 0) {
                $invoice->tax_rate = 0;
                $invoice->tax_charges = 0;
                $invoice->tax_rate_id = 0;
                $invoice->tax_name = '';
            } else {
                $invoice->tax_rate = $invoiceData['tax_rate'];
                $invoice->tax_charges = $invoiceData['tax_charges'];
                $invoice->tax_rate_id = $this->booking['tax_rate_id'];
                $invoice->tax_name = $this->booking['tax']['Tax'];
            }
        } else {
            $invoice->tax_charges = $invoiceData['tax_charges'];
        }

        // dd($invoiceData);
        if (!empty($invoiceData['per_night'])){
            if ($invoiceData['per_night'] == 1) {
                $invoice->per_night = 1;
                $invoice->discount_per_night = $invoiceData['discount_per_night'];
            }
        }
        
        // promo details
        // if (!empty($this->booking['promo']['id'])) {
        //     $invoice->promo_id = $this->booking['promo']['id'];
        //     $invoice->promo_is_percentage = $this->booking['promo']['IsPercentage'];
        //     $invoice->promo_value = $this->booking['promo']['DiscountValue'];
        //     $invoice->promo_code = $this->booking['promo']['Code'];
        // }

        // occupants
        $o = 0;
        foreach ($this->booking['rooms'] as $r) {
            $o += $r['occupants'];
        }

        $invoice->num_occupants = $o;
        $invoice->num_rooms = count($this->booking['rooms']);
        
        // hotel
        $invoice->hotel_name = Hotel::where('id', $this->booking['hotel_id'])->value('HotelName');
        $invoice->hotel_id = $this->booking['hotel_id'];
        // DB::rollback();dd('here');
        // city
        $invoice->city_id = $this->booking['city_id'];
        $invoice->city_name = City::where('id', $this->booking['city_id'])->value('CityName');

        // dates
        $invoice->checkin_date = $this->booking['start_date'];
        $invoice->checkout_date = $this->booking['end_date'];

        // nights
        $start_date = new \DateTime($this->booking['start_date']);
        $end_date = new \DateTime($this->booking['end_date']);

        $nights = $end_date->diff($start_date)->format("%d");

        $nights = $nights > 0 ? $nights : 1;
        $invoice->nights = $nights;

        // if ($invoiceData['paid'] == 1 && ($invoice->payment_mode_id == 2)) {
        //     $invoice->payment_mode_details = $this->booking['cheque_no'];
        // } 
        
        $invoice->payment_date = date('Y-m-d');
        // if ($this->booking['status'] == 'CheckedIn') {
        //     $invoiceData['paid'] == 1;
        // }
        if(isset($this->booking['is_third_party']) && $this->booking['is_third_party']){
            $invoiceData['is_corporate'] = 0;
            $invoiceData['paid'] = 0;
        }

        $invoice->paid = $invoiceData['paid'];
        
        if ($invoiceData['paid'] == 1 && $this->new_booking) {
            // create transaction log entry
            $invoice->paid = 1;
            $invoice->payment_amount = $invoiceData['payment_amount'];

            $transaction_log = new TransactionLog();
            $transaction_log->booking_id = $booking_ids[0];
            $transaction_log->amount = $invoiceData['payment_amount'];
            $transaction_log->payment_type_id = $invoiceData['payment_type_id'];
            $transaction_log->payment_type_name = $invoiceData['payment_type_name'];
            if ($invoiceData['payment_type_name'] == 'Cheque') {
                $transaction_log->payment_details = $invoiceData['payment_details'];
            }

            $transaction_log->created_by = Auth::id();
            $transaction_log->save();
        }

        // $invoice->payment_amount = $invoiceData['paid'] == 1 ? $invoiceData['net_total'] : 0;

        $invoice->is_corporate = $invoiceData['is_corporate'];

        // Mr Optimist | 28 Oct 2021
        if($invoice->is_corporate == 1) {
            $invoice->corporate_type = $invoiceData['corporate_type'];
        }
        
        if ($invoiceData['is_corporate'] == 1) {
            // find the corporate client by name
            $client = CorporateClient::where('FullName', 'LIKE', "%".$invoiceData['corporate_client_name']."%")->first();

            if (empty($client)){
                $client = new CorporateClient();

                $client->FullName = $invoiceData['corporate_client_name'];
                $client->Status = 1;

                $client->save();
            }

            $invoice->corporate_client_id = $client->id;
            $invoice->corporate_client_name = $client->FullName;
        }
        
        if ($this->new_booking) {
            $invoice->per_night_charges = $this->booking['invoice']['per_night_charges'];
        }

        if(!empty($this->booking['invoice']['checkout_discount'])){
            $invoice->checkout_discount = $this->booking['invoice']['checkout_discount'];
        }
        
        // dd($invoice);
        $this->invoice = $invoice;
        // $invoice->save();
    }

    private function calculateTotalAmount () {
        // dd($this->booking);
        $a = 0;

        $start_date = new \DateTime($this->booking['start_date']);
        $end_date = new \DateTime($this->booking['end_date']);

        $nights = $end_date->diff($start_date)->days;

        $nights = $nights > 0 ? $nights : 1;

        $i = 0;
        $this->booking['invoice']['total'] = 0;

        foreach ($this->booking['rooms'] as $room) {
            $a = 0;
            $a += $nights * ($room['RoomCharges'] != $room['room_charges_onbooking'] ? $room['room_charges_onbooking'] : $room['RoomCharges']);
            // dd($a);
            if ($room['occupants'] > $room['hotel_room_category']['allowed']) {
                $a += $nights * ($room['hotel_room_category']['additional_guest_charges'] * ($room['occupants'] - $room['hotel_room_category']['allowed']));
            }

            $this->booking['rooms'][$i]['sub_total'] = $a;
            $this->booking['invoice']['total'] += $a;
        }

        if ($this->new_booking){
            $this->booking['invoice']['per_night_charges'] = $this->booking['invoice']['total'];
        }
        

        // Invoice Charges
        // $this->booking['invoice']['total'] = $a;
        $this->booking['invoice']['net_total'] = $this->booking['invoice']['total'];

        // dd($this->booking['invoice']);

        // apply discount
        // if ($room['RoomCharges'] != $room['room_charges_onbooking']) {
        //     $this->booking['invoice']['net_total'] -= 0;
        // } else {

        // }

        // if ($this->booking['invoice']['per_night'] == 1) {
            
        // }
        // $this->booking['invoice']['net_total'] -= $this->booking['invoice']['discount_amount'];
        
        // dd($this->booking['invoice']);

        // condition for flat discount
        if ($this->booking['invoice']['per_night'] == 0) {
            $this->booking['invoice']['net_total'] -= $this->booking['invoice']['discount_amount'];
        } else {
            $this->booking['invoice']['net_total'] -=  $room['RoomCharges'] != $room['room_charges_onbooking'] ? 0 : $this->booking['invoice']['discount_amount'];
        }

        // apply tax
        $this->booking['invoice']['tax_charges'] = $this->booking['invoice']['net_total'] * ($this->booking['invoice']['tax_rate'] / 100.0);
        
        if ($this->new_booking){
            // $this->booking['invoice']['per_night_charges'] += $this->booking['invoice']['tax_charges'];
            $this->booking['invoice']['per_night_charges'] = $this->booking['invoice']['per_night_charges'] / $nights;
            $this->booking['invoice']['per_night_charges'] += $this->booking['invoice']['per_night_charges'] * ($this->booking['invoice']['tax_rate'] / 100);
        }
        
        else{
            $bs = BookingService::where('status', 'completed')->where('booking_id',$this->booking['id'])->get(['amount']);
            foreach ($bs as $service) {
                $this->booking['invoice']['net_total'] += $service['amount'];
                $this->booking['invoice']['total'] += $service['amount'];
            }
        }

        // dd($this->booking['invoice']);
        // dd($this->booking['invoice']);
        
        
        // add service charges
        // if (!empty($this->booking['services'])) {
            //     foreach ($this->booking['services'] as $service) {
                //         $this->booking['invoice']['net_total'] += $service['amount'];
                //         $this->booking['invoice']['total'] += $service['amount'];
                //     }
                // }
                
                // early checkin charges
        if (!empty($this->booking['invoice']['early_checkin_charges']) && !empty($this->invoice->id)) {
            $this->booking['invoice']['net_total'] += $this->booking['invoice']['early_checkin_charges'];
        }
        
        $this->booking['invoice']['net_total'] += $this->booking['invoice']['tax_charges'];

        $this->booking['invoice']['net_total'] = round($this->booking['invoice']['net_total'], 0);

        if(!empty($this->booking['invoice']['checkout_discount'])){
           
            $payable = $this->booking['invoice']['net_total'] - $this->booking['invoice']['payment_amount'];
            if($this->booking['invoice']['checkout_discount'] > $payable){
                $this->booking['invoice']['checkout_discount'] =$payable;
            }
            $this->booking['invoice']['net_total'] -= $this->booking['invoice']['checkout_discount'];

        }

        // dd($this->booking['invoice']);
       

        // apply promo
        // if (!empty($this->booking['promo']['id'])) {
        //     if ($this->booking['promo']['IsPercentage'] == 1) {
        //         $this->booking['invoice']['discount_amount'] = $this->booking['invoice']['total'] * ($this->booking['promo']['DiscountValue'] / 100.0);
        //     } else {
        //         $this->booking['invoice']['discount_amount'] = $this->booking['promo']['DiscountValue'];
        //     }

        //     $this->booking['invoice']['net_total'] -= $this->booking['invoice']['discount_amount'];
        // }
    }
    private function createAgent() {
        $agent = null;
        $isAgent = Channel::where('Channel', $this->booking['channel'])->first(['additionalInfo']);

        if(isset($isAgent) && $isAgent['additionalInfo'] == '1'){
            $data = $this->booking['agent'];
            if (empty($data['id'])) {
                $agent = new BookingAgent();
                $agent->name = $data['name'];
                $agent->phone = $data['phone'];
                $agent->hotel_id = $this->booking['hotel_id'];
                $agent->save();
                return $agent->id;
            } else {
                $agent = BookingAgent::find($data['id']);
                // dd("Saad");
                $agent->name = $data['name'];
                $agent->phone = $data['phone'];
                $agent->hotel_id = $this->booking['hotel_id'];
                $agent->save();
                return $this->booking['agent']['id'];
            }
        }
      
    }

    private function createCustomer() {
        
        $customer = null;

        $data = $this->booking['customer'];
        // dd($data);
        // dd(empty($data['id']));
        if (empty($data['id'])) {
            $customer = new Customer();
            $customer->FirstName = $data['FirstName'];
            $customer->LastName = isset($data['LastName']) ? $data['LastName'] : "";
            $customer->Email = isset($data['Email']) ? $data['Email'] : "";
            $customer->Phone = $data['Phone'];
            $customer->is_cnic = isset($data['is_cnic'])? $data['is_cnic']:"";
            $customer->CNIC = isset($data['CNIC'])? $data['CNIC'] : "";
            $customer->iso = isset($data['iso'])? $data['iso'] : "";
            $customer->nationality = isset($data['nationality'])? $data['nationality'] : "";

            // if($data['is_cnic'] == 1){
            //     $customer->CNIC = isset($data['CNIC'])? $data['CNIC'] : "";
            // }
            // if($data['is_cnic'] == 0){
            //     $customer->CNIC = isset($data['Passport'])? $data['Passport'] : "";
            // }
            $customer->created_by = Auth::id() ?? 1;
            $customer->CreationIP = request()->ip();
            $customer->CreatedByModule = $this->module_name;

            $customer->save();

            return $customer->id;
        } else {
            $customer = Customer::find($data['id']);
            $customer->FirstName = $data['FirstName'];
            $customer->LastName = isset($data['LastName']) ? $data['LastName'] : "";
            $customer->Email = isset($data['Email'])? $data['Email'] : "";
            $customer->Phone = $data['Phone'];
            $customer->is_cnic = isset($data['is_cnic'])? $data['is_cnic']:"";
            $customer->CNIC = isset($data['CNIC'])? $data['CNIC'] : "";
            $customer->iso = isset($data['iso'])? $data['iso'] : "";
            $customer->nationality = isset($data['nationality'])? $data['nationality'] : "";
            // if($data['is_cnic'] == 1){
            //     $customer->CNIC = isset($data['CNIC'])? $data['CNIC'] : "";
            // }
            // if($data['is_cnic'] == 0){
            //     $customer->CNIC = isset($data['Passport'])? $data['Passport'] : "";
            // }
            $customer->created_by = Auth::id() ?? 1;
            $customer->CreationIP = request()->ip();
            $customer->CreatedByModule = $this->module_name;

            $customer->save();

            return $this->booking['customer']['id'];
        }
    }

    private function createDiscountRequest ($id) {
        // dd($id);
        $d = DiscountRequest::where('booking_id', $id)->first();
        if ($d) {
            if ($d->status == 'Pending') {
                $this->lockdown = true;
            } else {
                $this->lockdown = false;
            }
        } else {
            $discount_request = new DiscountRequest();
            $discount_request->booking_id = $id;
            $discount_request->hotel_id = $this->booking['hotel_id'];
            $discount_request->reason = empty($this->booking['discount_reason']) ? "" : $this->booking['discount_reason'];
            $discount_request->requester_id = Auth::id();
            $discount_request->requested_amount = $this->booking['invoice']['discount_amount'];
            $discount_request->allowed_discount = Auth::user()->max_allowed_discount;
            $discount_request->status = "Pending";
    
            $discount_request->save();

            // make status pending && disabled lockdown
            // $b = Booking::find($id);
            // $b->status = "Pending";
            // $b->save();

            $this->booking['invoice']['paid'] = 0;

            $this->lockdown = true;
        }
    }

    private function createBooking() {
        //  dd($this->booking['agent']);
        if ($this->new_booking) {
            $booking = new Booking();
        } else {
            $booking = Booking::find($this->booking['id']);
            $this->p = $booking->status;
        }

        // dd($this->booking['special_request']);
        // $booking->booking_no = date('Y-m-d');
        $booking->booking_title = "";
        $booking->status = $this->booking['status'];

        $booking->customer_id = $this->createCustomer();
        $booking->agent_id = $this->createAgent() ?? null;
        $booking->tax_rate_id = $this->booking['tax_rate_id'];
        $booking->hotel_id = $this->booking['hotel_id'];
        $booking->BookingDate = date('Y-m-d');
        // $booking->BookingFrom = date_format(date_create($this->booking['start_date']), 'Y-d-m');
        // $booking->BookingTo = date_format(date_create($this->booking['end_date']), 'Y-d-m');
        $is_central_booking = 0;
        if(Auth::user()){
            if (auth()->user()->hasRole('Admin')) {
                $is_central_booking = 1;
            }
        }
        $booking->is_central_booking = $is_central_booking ?? 0;

        $booking->is_third_party = $this->booking['is_third_party'] ?? '';
        $booking->booking_third_party_id = $this->booking['booking_third_party_id'] ?? null;
        $booking->BookingFrom = $this->booking['start_date'];
        $booking->BookingTo = $this->booking['end_date'];
        $booking->no_occupants = $this->booking['occupants'];
        // promotion
        if (!empty($this->booking['promo'])) {
            $booking->promotion_id = $this->booking['promo']['id'];
        }

        $booking->is_corporate = $this->booking['invoice']['is_corporate'] ?? 0;
        $booking->channel = $this->booking['channel'];
        $booking->discount_reason =  empty($this->booking['discount_reason']) ? "" : $this->booking['discount_reason'];
        $booking->additional_comments = empty($this->booking['additional_comments']) ? "" : $this->booking['additional_comments'];
        $booking->origin = empty($this->booking['origin']) ? "" : $this->booking['origin'];
        $booking->purpose_of_stay = empty($this->booking['purpose_of_stay']) ? "" : $this->booking['purpose_of_stay'];
        $booking->special_request = !empty($this->booking['special_request']) ? $this->booking['special_request'] : "";

        if ($this->new_booking) {
            $booking->created_by = Auth::id() ?? 1;
            $booking->CreatedByModule = $this->module_name;
            $booking->CreationIP = request()->ip();
        } else {
            $booking->updated_by = Auth::id();
            $booking->UpdatedByModule = $this->module_name;
            $booking->UpdationIP = request()->ip();
        }
        // dd($booking);
        $booking->save();

        
        // save booking no
        // $last_booking = Booking::orderBy('id', 'desc')->first();

        // if (substr($last_booking->booking_no, 0, 4) == date('ym')) {
        //     $booking->booking_no = date('ym') . substr(++$last_booking->booking_no, 4);
        // } else {
        //     $booking->booking_no = date('ym') . '001';
        // }

        // $booking->save();
        
        return [$booking->id, $booking->customer_id];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $booking = $this->getBooking($id);
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

        if (empty($booking)) {
            return response()->json([
                'success' => false,
                'message' => ["Booking Not Found"],
                'msgtype' => 'error',
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } else {
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request->booking);
        // dd('in edit');
        // update Booking
        $this->booking = $request->booking;
        DB::beginTransaction();

        try {
            $booking = Booking::find($this->booking['id']);

            $booking->booking_title = "";
            $booking->status = "Confirmed";

            $booking->customer_id = $this->createCustomer();
            $booking->tax_rate_id = $this->booking['tax_rate_id'];
            $booking->hotel_id = $this->booking['hotel_id'];

            // $start_date = date_create($this->booking['start_date']);
            // $end_date = date_create($this->booking['end_date']);

            // $booking->BookingFrom = date_format($start_date, 'Y-d-m');
            // $booking->BookingTo = date_format($end_date, 'Y-d-m');
            $booking->BookingFrom = $this->booking['start_date'];
            $booking->BookingTo = $this->booking['end_date'];

            $booking->no_occupants = $this->booking['occupants'];

            // promotion
            if (!empty($this->booking['promo'])) {
                $booking->promotion_id = $this->booking['promo']['id'];
            }

            $booking->updated_by = Auth::id();

            // dd($booking);

            $booking->save();

            // return [$booking->id, $booking->customer_id];

            // update invoice
            $invoice = BookingInvoice::where('booking_id', '=', $this->booking['id'])->first();
            $invoiceData = $this->booking['invoice'];

            $invoice->booking_id = $booking->id;
            $invoice->customer_id = $booking->customer->id;
            $invoice->total = $invoiceData['total'];
            $invoice->discount_amount = $invoiceData['discount_amount'];
            $invoice->tax_rate = $invoiceData['tax_rate'];
            $invoice->tax_charges = $invoiceData['tax_charges'];
            $invoice->net_total = $invoiceData['net_total'];
            $invoice->payment_mode_id = $this->booking['payTyp']['id'];
            $invoice->payment_mode_name = $this->booking['payTyp']['PaymentMode'];

            if ($invoice->payment_mode_id == 2 || $invoice->payment_mode_id ==3) {
                $invoice->payment_mode_details = $this->booking['cheque_no'];
            } 

            $invoice->payment_date = date('Y-m-d');
            $invoice->payment_amount = $invoiceData['net_total'];
            $invoice->updated_by = Auth::id();
            $invoice->save();

            // delete from booking_rooms
            $rooms = $this->booking['rooms'];

            // delete from room_schedule
            RoomSchedule::where('booking_id', '=', $booking->id)->delete();
            
            // add to room schedule
            foreach ($rooms as $room) {
                $r = new RoomSchedule();
                $r->room_id = $room['id'];
                $r->start_date = $this->booking['start_date'];
                $r->end_date = $this->booking['end_date'];
                $r->booking_id = $booking->id;
                $r->status = 1;
                $r->save();
            }

            $rooms = array_map(function($room){
                return $room['id'];
            }, $rooms);

            $booking->rooms()->sync($rooms);


            // $booking->booking_occupants()->sync([]);
            BookingOccupant::where('booking_id', '=', $booking->id)->delete();

            $this->addOccupants([$booking->id]);
            

            DB::commit();
            $booking  = Booking::with(['booking_occupants','hotel','customer', 'rooms', 'rooms.category','rooms.hotel', 'invoice', 'promotion','tax_rate','invoice.payment_mode'])->where('id', '=', $booking->id)->first();

            return response()->json([
                'success' => true,
                'message' => ['Booking Edited Succesfully'],
                'msgtype' => 'success',
                'booking' => $booking
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => [$e->getMessage()],
                'msgtype' => 'error',
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        }
    }

    public function resendInvoice(Request $request)
    {
        $id = $request->id;

        $this->sendInvoice($id);

        return response()->json([
            'success' => true,
            'message' => ['Invoice Sent Successfully'],
            'msgtype' => 'success'
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    private function sendInvoice($id)
    {
        $booking = Booking::with(['hotel','customer', 'rooms', 'rooms.hotel_room_category', 'rooms.category','rooms.hotel', 'invoice', 'promotion','tax_rate','invoice.payment_mode'])->where('id', '=', $id)->first();
    //  dd($booking);
        $subject = "Thank You for booking at KTown Rooms & Homes (Booking No. ".$booking->booking_no.")";

        // return view('mails.invoice', ['booking' => $booking, 'in_words' => CurrencyHelper::numberTowords($booking->invoice->net_total)]);
        Mail::to($booking->customer->Email)->send(new BookingEmail($booking,$subject));
    }

    public function cancelBooking(Request $request, $id) {
        
        // deallocate rooms
        $booking = Booking::where('id', '=', $id)->first();

        if ($booking->IsCheckedIn == 1) {
            return response()->json([
                'success' => false,
                'message' => ['Booking Cannot be Cancelled after Checked-in'],
                'msgtype' => 'error'
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        }

        // $booking->rooms()->sync([]);

        // Deallocate RoomSchedule
        RoomSchedule::where('booking_id', '=', $id)->update([
            'status' => 0
        ]);

        $booking->status = "Cancelled";
        $booking->CancelReason = $request->reason;
        $booking->updated_by = Auth::id();
        $booking->save();

        // delete requests
        DiscountRequest::where('booking_id', $booking->id)->delete();

        if (!empty($booking->customer->email)) {
            $subject = "Booking Cancelled for KTown Rooms & Homes (Booking No. " . $booking->booking_no . ")";
            Mail::to($booking->customer->Email)->send(new BookingCancellationEmail($booking, $subject));
        }

        $booking->sendCancellationSms();

        return response()->json([
            'success' => true,
            'message' => ['Booking Cancelled Successfully'],
            'msgtype' => 'success',
            'id' => $id
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function userIsFrontDesk()
    {
        if (Auth::user()->hasRole('Frontdesk')) {
            // $this->hotel_id = Auth::user()['hotel_id'];
            $this->is_frontdesk = true;

            return true;
        }

        return false;
    }

    public function userIsSupervisor() {
        if (Auth::user()->hasRole('Frontdesk') || Auth::user()->hasRole('Admin')) {
            return false;
        } else {
            return true;
        }
    }

    public function findOccupant(Request $request)
    {
        $occupant = BookingOccupant::where('CNIC', $request->cnic)->first();

        if ($occupant) {
            return response()->json([
                'success' => true,
                'message' => ['Occupant Found'],
                'msgtype' => 'success',
                'occupant' => $occupant
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } else {
            return response()->json([
                'success' => false,
                'message' => ['Occupant Not Found'],
                'msgtype' => 'info'
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        }
    }

    public function checkout(Request $request)
    {
        DB::beginTransaction();
        try {
            // dd($request->booking['invoice']);
            // $pInfo = $request->booking['payment_info'];
            
            $booking = Booking::find($request->booking['id']);
    
            $booking->status = 'CheckedOut';
            
            $rooms = RoomSchedule::where('booking_id', $booking->id)->update([
                'status' => 0
            ]);

            $invoice = BookingInvoice::where('booking_id', $booking->id)->first();
// dd($invoice);
            if ($invoice->net_total > $invoice->payment_amount) {
                if ($invoice->is_corporate == 0) {
                    // check bed dead
                    // if ($pInfo['bed_dead'] == 1) {
                    //     $booking->is_bed_dead = 1;
                        // create new transaction log
                        // $transaction_log = new TransactionLog();
                
                        // $transaction_log->booking_id = $request->booking['id'];
                        
                        // $transaction_log->amount = $pInfo['amount'];
                        // $transaction_log->payment_type_id = $pInfo['payment_mode']['id'];
                        // $transaction_log->payment_type_name = $pInfo['payment_mode']['PaymentMode'];
                        // if ($pInfo['payment_mode']['PaymentMode'] == 'Cheque') {
                        //     $transaction_log->payment_details = $pInfo['payment_details'];
                        // }
    
                        // $transaction_log->created_by = Auth::id();
                        // $transaction_log->save();
    
                        // $invoice->payment_amount += $pInfo['amount'];
                    // }
                }
            }
            
            $booking->BookingTo = date('Y-m-d');
            $booking->save();
            $invoice->save();
            $booking->sendCheckoutSms();
            $late_checkout_charges = 0;
            if($booking->BookingFrom != $booking->BookingTo)
                $late_checkout_charges = $this->lateCheckout($booking->hotel_id);

            if ($late_checkout_charges) {
                $this->createLateCheckout($booking, $late_checkout_charges);
            }
            
            // refund
            if (!empty($request->booking['invoice']['refund'])) {
                $this->createRefundDetail($booking, $request->booking['invoice']['refund']);
                $invoice->payment_amount -= $request->booking['invoice']['refund'];
                $invoice->save();
            }

            // send email
            if (!empty($booking->customer->Email)) {
                $subject = "Booking Checked-Out for KTown Rooms & Homes (Booking No. " . $booking->booking_no . ")";
                Mail::to($booking->customer->Email)->send(new BookingCheckoutEmail($booking, $subject));
            }

            // there should be a function to create refund entry in payment details table
            // TODO refund entry in database

            if($invoice->checkout_discount>0){
                    $this->createChekoutDiscount($booking,$invoice->checkout_discount);
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => ['Internal Server Error', $e->getMessage()],
                'msgtype' => 'danger'
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        }

        $booking = Booking::join('customers', 'bookings.customer_id', '=', 'customers.id')
                            ->join('hotels', 'bookings.hotel_id', '=', 'hotels.id')
                            ->join('booking_invoices', 'bookings.id', '=', 'booking_invoices.booking_id')
                            ->leftJoin('promotions', 'bookings.promotion_id', '=', 'promotions.id')
                            ->leftJoin('tax_rates', 'bookings.tax_rate_id', '=', 'tax_rates.id')
                            ->where('bookings.id', $booking->id)
                            ->first([
                                'bookings.id', 'bookings.status', 'bookings.BookingDate', 'bookings.BookingFrom', 'bookings.BookingTo', 'bookings.booking_no',
                                'hotels.HotelName',
                                \DB::raw("CONCAT(customers.FirstName, ' ', customers.LastName) as FullName"), 'customers.Email', 'customers.Phone',
                                'booking_invoices.net_total', 'booking_invoices.discount_amount', 'booking_invoices.total', 'booking_invoices.tax_charges', 'booking_invoices.num_occupants',
                                'promotions.Code', 'promotions.DiscountValue', 'promotions.IsPercentage',
                                'tax_rates.Tax', 'tax_rates.TaxValue'
                            ]);

        return response()->json([
            'success' => true,
            'message' => ['Booking checked out successfully'],
            'msgtype' => 'success',
            'booking' => $booking
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);
    }

    public function changeStatus (Request $request)
    {
        $booking = Booking::find($request->id);

        $p = $booking->status;
        $n = $request->status;

        $booking->status = $request->status;
        
        // set params for roomsAreAvailable
        $this->booking = $booking->toArray();
        $this->booking['rooms'] = $booking->rooms->toArray();
        $this->booking['start_date'] = $booking->BookingFrom;
        $this->booking['end_date'] = $booking->BookingTo;
        
        if (!$this->roomsAreAvailable()) {
            if ($p == 'Pending' && ($n == 'Confirmed' || $n == 'CheckedIn')) {
                return response()->json([
                    'success' => false,
                    'message' => ['Selected rooms are not available please search again.'],
                    'msgtype' => 'danger'
                ]);
            }
        }

        if ($booking->status == 'CheckedIn') {
            $booking->sendPortalLink();

            $early_checkin_charges = $this->earlyCheckIn($booking->hotel_id);

            if ($early_checkin_charges) {
                $this->invoice = $booking->invoice;
                $this->createEarlyCheckIn($booking, $early_checkin_charges);
                $this->invoice->save();
            }
        }

        $booking->save();

        if($booking->status == 'Confirmed' || $booking->status == 'Cancelled') {
            $this->sendInvoice($request->id);
        }

        if ($booking->status == 'Confirmed') {
            $booking->sendConfirmationSms();
        }

        return response()->json([
            'success' => true,
            'message' => ["Status of Booking ($booking->booking_no) Changed from '$p' to '$n' successfully"],
            'msgtype' => 'success'
        ]);
    }

    public function findRoomBooking(Request $request)
    {
        $data = $request->all();

        $booking_id = $this->bookingFromRoom($data);

        if ($booking_id > 0) {
            $booking = $this->getBooking($booking_id);
        }

        return response()->json([
            'success' => true,
            'booking' => $booking
        ]);
    }



    public function bookingReceipt($id)
    {
        return view('bookings.receipt_main', [
            'booking_id' => $id
        ]);
    }

    private function bookingFromRoom($data) {
        $id = RoomSchedule::where('status', '=', 1)
        ->where('room_id', $data['room_id'])
        ->where(function($query) use ($data) {
            $query->where([
                ['start_date', '>=', $data['start_date']],
                ['start_date', '<=', $data['end_date']]
            ]);

            $query->orWhere([
                ['end_date', '>=', $data['start_date']],
                ['start_date', '<=', $data['end_date']]
            ]);
            // $query->whereBetween('start_date', [$data['start_date'], $data['end_date']]);
            // $query->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
        })
        ->first(['booking_id']);

        if ($id) {
            return $id->booking_id;
        } else {
            return 0;
        }
    }

    private function getBooking($id) {
        $booking = Booking::with(['booking_occupants', 'agent', 'booking_third_party.details', 'booking_third_party.mapping_statuses', 'discount_request','discount_request.supervisor','services','hotel', 'hotel.checkin', 'hotel.checkout','customer' => function($q){
            $q->withCount('bookings');
        }, 'rooms', 'rooms.category','rooms.hotel', 'invoice', 'invoice_details', 'promotion','tax_rate','invoice.payment_mode', 'status_history'])->find($id);
        
        foreach ($booking->rooms as $r) {
            $r->hotel_room_category = $r->hotel_room_category;
        }

        // $invoice_detail = InvoiceDetail::all();
        
        return $booking;
    }

    public function resendRoomEmail(Request $request)
    {
        $data = $request->all();

        $id = $this->bookingFromRoom($data);

        $this->sendInvoice($id);

        return response()->json([
            'success' => true,
            'message' => ['Invoice resent successfully'],
            'msgtype' => 'success'
        ]);
    }

    public function requestServiceComplain(Request $request) {
        $data = $request->all();

        $id = $this->bookingFromRoom($data);

        $booking = Booking::find($id);

        return response()->json([
            'success' => true,
            'redirect_url' => $booking->booking_code
        ]);
    }

    public function extendBooking(Request $request)
    {
        $data = $request->all();

        $booking = Booking::find($data['id']);
        
        // TODO: get booking_rooms from server for confirmation

        $bookdate = date_create(date('Y-m-d', strtotime($booking->BookingTo)));
        $extdate = date_create(date('Y-m-d', strtotime($data['extended_date'])));
        $diff = date_diff($bookdate , $extdate);

        $t_extend = $extdate > $bookdate;
        $data['extend'] = $t_extend ? $diff->days : $diff->days * -1;

        $start_date = date('Y-m-d', strtotime($booking->BookingTo . '+ 1 day'));
        $end_date = $extdate->format('Y-m-d'); #date('Y-m-d', strtotime($booking->BookingTo . '+ ' . $data['extend'] . ' day'));

        if ($booking->status != "CheckedOut" || $booking->status != "Cancelled") {
            // check from room availability whether the rooms are available or not
            $possible = true;

            if ($t_extend) {
                $room_schedule = RoomSchedule::where('status', '=', 1)
                        ->whereIn('room_id', $data['rooms'])
                        ->whereNull('deleted_at')
                        ->where(function($query) use ($start_date, $end_date) {
                            $query->where([
                                ['start_date', '>=', $start_date],
                                ['start_date', '<=', $end_date]
                            ]);

                            $query->orWhere([
                                ['end_date', '>=', $start_date],
                                ['start_date', '<=', $end_date]
                            ]);
                            // $query->whereBetween('start_date', [$start_date, $end_date]);
                            // $query->orWhereBetween('end_date', [$start_date, $end_date]);
                        })
                        ->orderBy('room_id', 'asc')
                        ->distinct()
                        ->get();

                foreach ($room_schedule as $r) {
                    if (in_array($r->room_id, $data['rooms'])) {
                        $possible = false;
                        break;
                    }
                }
            }

            if (!$possible) {
                // return error
                return response()->json([
                    'success' => false,
                    'message' => ['Room(s) are not available, already booked for ' . $data['extend'] . ' days'],
                    'msgtype' => 'danger'
                ]);
            } else {
                DB::beginTransaction();

                try {
                    // increase date in booking_rooms
                    $booking_rooms = BookingRoom::whereIn('room_id', $data['rooms'])->where('booking_id', $data['id'])->get();

                    // increase date in room_schedule
                    $room_schedule = RoomSchedule::whereIn('room_id', $data['rooms'])->where('booking_id', $booking->id)->where('status', 1)->update([
                        'end_date' => $end_date
                    ]);

                    $booking->BookingTo = $end_date;

                    $booking->save();

                    $invoice = BookingInvoice::where('booking_id', $booking->id)->first();

                    // dd($invoice);
                    // extend nights should be dynamic
                    $eStart_date = new \DateTime($booking->BookingFrom);
                    $eEnd_date = new \DateTime($end_date);

                    $nights = $eEnd_date->diff($eStart_date)->days;

                    $nights = $nights > 0 ? $nights : 1;

                    // $new_nights = abs($invoice->nights - $nights);

                    $new_nights = $data['extend'];

                    $rooms_charges = 0;
                    $o_room_charges = 0;
                    foreach ($booking_rooms as $r) {
                        // additional guests present or not
                        $additional_guests = $r->additional_occupants;

                        $r->additional_guest_charges = $r->additional_guest_charges + ($r->additional_guest_rate * $data['extend'] * $additional_guests);
                        // $r->save();

                        $rooms_charges += ($r->room_charges_onbooking * $new_nights + $r->additional_guest_charges);
                        $o_room_charges += ($r->room_charges * $new_nights + $r->additional_guest_charges);
                    }

                    $per_night_tax_charges = $invoice->tax_charges / $invoice->nights;
                    $invoice->tax_charges += $per_night_tax_charges * $new_nights;


                    // dd($invoice->tax_charges * $new_nights);
                    $invoice->nights = $nights;
                    // $invoice->nights += $data['extend'];

                    
                    // $invoice->total += ($rooms_charges * $new_nights);  // room charges already multiplied with extend nights. why again here?
                    $invoice->total += $rooms_charges;
                    // dd($invoice->total);
                    // if ($invoice->tax_rate_id > 0) {
                    //     $invoice->tax_charges += $o_room_charges * ($invoice->tax_rate / 100);
                    // }

                    if ($invoice->per_night == 1) {
                        $add_discount = $invoice->discount_per_night * $new_nights;
                        $invoice->discount_amount += $add_discount;
                    }

                    // $net_total = $invoice->total - $invoice->discount_amount;


                    // if ($invoice->tax_rate_id > 0) {
                    //     $invoice->tax_charges = $net_total * ($invoice->tax_rate / 100);
                        
                    //     $invoice->net_total = $net_total;
                        
                    //     $invoice->net_total += $invoice->tax_charges; // dd($invoice->net_total);
                    // } else {
                    //     $invoice->net_total = $net_total;
                    // }

                    

                    $invoice->net_total += $invoice->per_night_charges * $new_nights;
                    $invoice->net_total = round($invoice->net_total, 0);

                    $invoice->checkout_date = $end_date;
                    $invoice->updated_by = Auth::id();
                    $invoice->save();
                    $booking->sendAmendmentSms();
                    DB::commit();
                } catch (\Exception $e) {
                    DB::rollback();

                    return response()->json([
                        'success' => false,
                        'message' => ['Internal Server Error', $e->getMessage()],
                        'msgtype' => 'danger'
                    ]);
                }

                return response()->json([
                    'success' => true,
                    'message' => ['Booking stay extended sucessfully'],
                    'msgtype' => 'success'
                ]);
            }
        }
    }

    private function roomsAreAvailable () {
        $room_ids = array_map(function ($r) {
            return $r['id'];
        }, $this->booking['rooms']);

        $rooms = Room::whereIn('id', $room_ids)->orderBy('id', 'asc')->get();

        // dd($room_ids);
        $room_ids = [];
        foreach($rooms as $i => $room) {
            $room_ids[] = $room->id;
            if ($room->is_available == 0) {
                return false;
            } 
        }

        $data = [];
        $data['start_date'] = $this->booking['start_date'];
        $data['end_date'] = $this->booking['end_date'];

        \DB::enableQueryLog();
        $room_schedule = RoomSchedule::with(['booking'])->where('status', '=', 1)
                        ->whereNull('deleted_at')
                        ->whereIn('room_id', $room_ids)
                        ->where(function($query) use ($data) {
                            $query->where([
                                ['start_date', '>=', $data['start_date']],
                                ['start_date', '<=', $data['end_date']]
                            ]);

                            $query->orWhere([
                                ['end_date', '>=', $data['start_date']],
                                ['start_date', '<=', $data['end_date']]
                            ]);
                            // $query->whereBetween('start_date', [$data['start_date'], $data['end_date']]);
                            // $query->orWhereBetween('end_date', [$data['start_date'], $data['end_date']]);
                        })
                        ->orderBy('room_id', 'asc')
                        ->distinct()
                        ->get(['room_id', 'booking_id']);
        
        
        if (!$this->new_booking) {
            foreach ($room_schedule as $index => $rs) {
                if ($rs->booking_id == $this->booking["id"]) {
                    unset($room_schedule[$index]);
                }
            }
        }

        if(count($room_schedule) > 0) {
            return false;
        }

        return true;
    }

    public function addTransaction(Request $request) {
        DB::beginTransaction();

        try {
            $transaction_log = new TransactionLog();
            
            $transaction_log->booking_id = $request->booking_id;
            $transaction_log->amount = $request->payment_amount;
            $transaction_log->payment_type_id = $request->payment_type_id;
            $transaction_log->payment_type_name = $request->payment_type_name;
            if ($request->payment_type_name == 'Cheque') {
                $transaction_log->payment_details = $request->payment_details;
            }

            $transaction_log->created_by = Auth::id();
            $transaction_log->save();

            $invoice = BookingInvoice::where('booking_id', $request->booking_id)->first();

            $invoice->paid = 1;
            $invoice->payment_amount += $request->payment_amount;
            $invoice->updated_by = Auth::id();

            $invoice->save();

            $invoice_no = null;
            $inv_detail = InvoiceDetail::where('booking_id', $request->booking_id)->orderBy('created_at', 'desc')->first();
            if($inv_detail){
                $invoice_no = $inv_detail->invoice_no;
                $added_amount =$inv_detail->amount;
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => ['Internal Server Error', $e->getMessage()],
                'msgtype' => 'danger',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => ['Amount added to the booking'],
            'msgtype' => 'success',
            'invoice_no'=>$invoice_no,
            'added_amount'=>$added_amount
        ]);
    }

    public function searchForTransfer (Request $request) {
        $booking = Booking::find($request->booking_id);

        $data = [
            'start_date' => date('Y-m-d'),
            'end_date' => $booking->BookingTo,
            'excludes' => $booking->rooms()->pluck('room_id'),
            'hotel_id' => $booking->hotel_id
        ];

        $rooms = $this->searchAvailableRooms($data);

        return response()->json([
            'success' =>true,
            'message' => [],
            'msgtype' => 'success',
            'checkout_date' => $booking->BookingTo,
            'rooms' => $rooms
        ]);
    }

    private function searchAvailableRooms($data)
    {
        // Step 1: search for available rooms in the same hotel
        $hotel_rooms = Room::where('hotel_id', $data['hotel_id']);

        if (!empty($data['excludes'])) {
            $hotel_rooms = $hotel_rooms->whereNotIn('id', $data['excludes']);
        }

        $hotel_rooms = $hotel_rooms->orderBy('id', 'asc')->where('is_available', 1)->get();

        if (count($hotel_rooms) == 0) {
            return $hotel_rooms;
        }

        // Step 2: isolate ids for RoomSchedule
        $room_ids = array_map(function ($r) {
            return $r->id;
        }, json_decode($hotel_rooms));
        
        // Step 3: get room schedule of the rooms
        $room_schedule = RoomSchedule::with(['booking'])->where('status', '=', 1)
                        ->whereNull('deleted_at')
                        ->whereIn('room_id', $room_ids)
                        ->where(function($query) use ($data) {
                            $query->where([
                                ['start_date', '>=', $data['start_date']],
                                ['start_date', '<=', $data['end_date']]
                            ]);

                            $query->orWhere([
                                ['end_date', '>=', $data['start_date']],
                                ['start_date', '<=', $data['end_date']]
                            ]);
                        })
                        ->orderBy('room_id', 'asc')
                        ->distinct()
                        ->get(['room_id', 'booking_id']);
        
        if (count($room_schedule) == 0) {
            return $hotel_rooms;
        }
        
        // Step 4: exclude these rooms
        $i=0; $j=0; 
        for (; $i < count($hotel_rooms) && $j < count($hotel_rooms);) {
            if ($hotel_rooms[$i]->id == $room_schedule[$j]->id) {
                unset($hotel_rooms[$i]);
                $i++; $j++;
            } else {
                $i++;
            }
        }

        return $hotel_rooms;
    }

    public function requestForTransfer(Request $request)
    {
        $data = $request->all();
        $this->booking['rooms'] = [
            [ 'id' => $data['new_room']]
        ];
        
        $this->booking['start_date'] = date('Y-m-d');
        $this->booking['end_date'] = $request->end_date;
        $this->booking['id'] = $request->booking_id;
        
        $booking = Booking::find($request->booking_id);

        $r = $booking->rooms->first(function($r) use ($data) {
            return $r->id == $data['new_room'];
        });

        if(!$this->roomsAreAvailable() || !empty($r)) {
            return response()->json([
                'success' => false,
                'message' => ['Selected room is not available, please search again.'],
                'msgtype' => 'danger'
            ]);
        }

        DB::beginTransaction();

        try {
            // transfer room

            // Step 1: checkout previous room
            RoomSchedule::where('booking_id', $request->booking_id)->where('room_id', $request->room_id)->where('status', 1)->update([
                'status' => 0,
                'end_date' => date('Y-m-d'),
                'updated_by' => Auth::id()
            ]);

            // Step 2: checkin to new room
            $nrs = new RoomSchedule();
            $nrs->booking_id = $request->booking_id;
            $nrs->room_id = $request->new_room;
            $nrs->start_date = date('Y-m-d');
            $nrs->end_date = $request->end_date;
            $nrs->status = 1;
            $nrs->created_by = Auth::id();

            $nrs->save();

            // Step 3: transfer from booking_room
            $pr = BookingRoom::where('booking_id', $request->booking_id)->where('room_id', $request->room_id)->first();

            $pr->transferred = 1;
            $pr->transferred_to = $request->new_room;
            $pr->updated_by = Auth::id();
            $pr->UpdationIP = request()->ip();

            $pr->save();

            // Step 4: create new booking_room
            $r = Room::find($request->new_room);

            $nr = new BookingRoom();

            $nr->booking_id = $request->booking_id;
            $nr->room_id = $request->new_room;
            $nr->room_charges = $pr->room_charges;
            $nr->room_charges_onbooking = $pr->room_charges_onbooking;
            $nr->allowed_occupants = $pr->allowed_occupants;
            $nr->occupants = $pr->occupants;
            $nr->max_allowed_occupants = $pr->max_allowed_occupants;
            $nr->room_title = $r->room_title;
            $nr->additional_occupants = $pr->additional_occupants;
            $nr->additional_guest_charges = $pr->additional_guest_charges;
            $nr->additional_guest_rate = $pr->additional_guest_rate;
            $nr->created_by = Auth::id();

            $nr->save();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ['Room transferred successfully'],
                'msgtype' => 'success'
            ]);
        } catch (\Exception $e) {
            DB::rollback();

            return response()->json([
                'success' => false,
                'message' => ['Internal Server Error', $e->getMessage()],
                'msgtype' => 'danger'
            ]);
        }
    }

    public function checkRoomAvailability(Request $request) {
        $this->booking['start_date'] = $request->start_date;
        $this->booking['end_date'] = $request->end_date;
        $this->booking['id'] = $request->id;
        $this->booking['rooms'] = $request->rooms;

        if (!$this->roomsAreAvailable()) {
            return response()->json([
                'success' => false,
                'message' => ['Selected rooms are not available on these dates.'],
                'msgtype' => 'danger'
            ]);
        } else {
            return response()->json([
                'success' => true,
                'message' => ['Selected rooms are available'],
                'msgtype' => 'success'
            ]);
        }
    }

    public function test()
    {
        return $this->sendInvoice(418);
    }

    public function getRoomDashboard()
    {
        return view ('room_dashboard.dashboard', [
            'breadcrumb' => 'Booking Dashboard'
        ]);
    }

    public function getCancelledBookingsCount($start_date,$end_date)
    {   
        return Booking::where(function($query) use ($start_date, $end_date) {
            $query->where([
                ['BookingFrom', '>=', $start_date],
                ['BookingFrom', '<=', $end_date]
            ]);

            $query->orWhere([
                ['BookingTo', '>=', $start_date],
                ['BookingTo', '<=', $end_date]
            ]);
        })->where('status', 'Cancelled')->count();
    }

    public function bookingMapStatus($btpId, $type, $slug = null, $statusId = null)
    {
        $status = 0;
        $bmp = null;
        $bm = null;
        // dd($slugId);
        if($slug){

            $bm = BookingMapping::where('type', $type)->where('source',$slug)->first();
            // $booking_mapping_id = 
            // dd($bm);
            
        }

        if($bm || $statusId){
            $status = 1;
        }
        $booking_mapping_type = $type;
        if($type == 'roomcategory')
            $booking_mapping_type = 'Room category';
        else if ($type == 'hotel')
            $booking_mapping_type = 'Hotel';


        $bmp = BookingMappingStatus::create([
            'booking_third_party_id'=>$btpId,
            'booking_mapping_id'=>$bm->id ?? null,
            // 'customer_id'=>$customer_id,
            'booking_mapping_type'=>$booking_mapping_type,
            'status'=> $status,
        ]);
        return $bmp ? $bm : null;
        
        // $bookingId;
    }

    // public function categoryMapStatus($bookingId, $category_name)
    // {
    //     $status = 0;
    //     $bmp = null;
    //     // dd($slugId);
    //     if($category_name){

    //         $bm = BookingMapping::where('type', 'roomcategory')->where('source',$category_name)->first();
    //         // $booking_mapping_id = 
    //         // dd($bm);
    //         if($bm){
    //             $status = 1;
    //         }
    //         $bmp = BookingMappingStatus::create([
    //             'booking_id'=>$bookingId,
    //             'booking_mapping_id'=>$bm->id,
    //             'booking_mapping_type'=>$bm->type,
    //             'status'=> $status,
    //         ]);
    //     }
    //     return $bmp ? $bm : null;
        
    //     // $bookingId;
    // }


    public function cron_logs($message)
    {
        # create logs if success or error comes
        $data = [
            'message' => $message,
        ]; 
        // \DB::table('cron_logs')->insert($data);
        CronLog::create($data);
    }
    
    public function blinq_archive()
    {
        try{
            
            $archive_invoice_details = InvoiceDetail::where('is_archive', 1)->get();
            if(count($archive_invoice_details)){
                foreach($archive_invoice_details as $aid){
                    $parsed = Carbon::parse($aid->created_at);
                    $passed_second = $parsed->diffInSeconds(Carbon::now());
                    // dd($aid->BookingID);
                    $BookingID = $aid->booking_id;
                    if($passed_second > 3600){
                        $aid->delete();
                        $this->cron_logs('Cron runs successfully for booking id: '.$BookingID);
                    } else {
                        $this->cron_logs('Cron runs but not deleted archive because data is not older than 1 hour - for booking id '.$BookingID);
                    }
                }
            } else {
                
                $this->cron_logs('No cron to run');
            }
            return response()->json(['success'=> true, 'message'=>'Blinq Archived successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            $this->cron_logs($th->getMessage());
            return response()->json(['success'=> false, 'message'=>$th->getMessage()]);
        }
    }

    public function third_party_booking(Request $request)
    {

        // $data = json_decode($request->all());
        // return true;
        
        //entry in third_party_booking table
        
        // dd($request->all());
        $bookingRequest = $request->bookingRequest ?? null;
        $sessionRequest = $request->sessionRequest ?? null;
        $bookingData = $request->bookingData ?? null;
        $hotelData = $request->hotelData ?? null;
        $invoiceDetail = $request->invoiceData ?? null;
        // return response()->json(['hotelData' =>$hotelData, 'bookingRequest'=> $bookingRequest]);
        $this->booking = $bookingRequest;                
        $this->new_booking = true;
        $this->booking['rooms'] = [];
        $this->booking['start_date'] = isset($sessionRequest['HotelCheckInDate']) ? $sessionRequest['HotelCheckInDate'] : null;
        $this->booking['end_date'] = isset($sessionRequest['HotelCheckOutDate']) ? $sessionRequest['HotelCheckOutDate'] : null;
        $this->booking['is_corporate'] = 0;
        $this->booking['channel'] = 'Ktown Website';
        $this->booking['is_third_party'] = 1;
        $this->booking['is_central_booking'] = 1;
        $this->booking['purpose_of_stay'] = null;
        $this->booking['special_request'] = null;
        $this->booking['additional_comments'] = null;
        $this->booking['origin'] = null;
        

        $no_of_occupants = 0;
        
        $a = $this->bookingMapStatus($bookingData['BookingID'], 'hotel', $hotelData['SlugId']);
        // return response()->json($a);
        if(isset($bookingRequest['NoOfRooms'])){
            $arr = explode("\r", $bookingRequest['room_type_name'][0], 2);
            $room_type_name = $arr[0];
            foreach ($bookingRequest['NoOfRooms'] as $key => $value) {
                if($value != '0'){
                    if(isset($bookingRequest['occupants'])){
                        $no_of_occupants += $bookingRequest['occupants'][$key];
                    }
                    $hotel_id = $sessionRequest['HotelID'][$key] ?? null;
                    $this->booking['tax_rate_id'] = null;
                    $this->booking['hotel_id'] = null;
                    if($a){

                        $room = Room::where('hotel_id', $a->destination)->first();
                        
                        $this->booking['tax_rate_id'] = $room->tax_rate_id;
                        $this->booking['hotel_id'] = $a->destination;   
                    }
                }
            }
        }

        $payment_mode = 'Cash';
        $payment_status = 0;
        if($invoiceDetail['paymentMode'] != 'Cash'){
            $payment_mode = $invoiceDetail['paymentMode'];
            $payment_status = 1;
            
        }
        // dd($bookingRequest);
        $btp = BookingThirdParty::create([
            'id' => isset($bookingData['BookingID']) ? $bookingData['BookingID'] : null,
            'booking_no' => isset($bookingData['BookingCode']) ? $bookingData['BookingCode'] : null,
            'first_name' => isset($bookingRequest['FirstName']) ? $bookingRequest['FirstName'] : null,
            'last_name' => isset($bookingRequest['LastName']) ? $bookingRequest['LastName'] : null,
            'phone' => isset($bookingRequest['Cell']) ? $bookingRequest['Cell'] : null,
            'email' => isset($bookingRequest['EmailAddress']) ? $bookingRequest['EmailAddress'] : null,
            'total_rooms' => isset($bookingRequest['hdnTotalCost']) ? $bookingRequest['hdnTotalCost'] : null,
            'total_cost' => isset($bookingRequest['hdnTotalRoom']) ? $bookingRequest['hdnTotalRoom'] : null,
            'payment_mode' => $payment_mode,
            'payment_status' => $payment_status,
            'no_occupants' => $no_of_occupants,
            'hotel_id' => isset($hotelData['SlugId']) ? $hotelData['SlugId'] : null,
            'hotel_name' => isset($sessionRequest['HotelName']) ? $sessionRequest['HotelName'] : null,
            'booking_date' => Carbon::now()->toDateTimeString(),
            'booking_from' => isset($sessionRequest['HotelCheckInDate']) ? $sessionRequest['HotelCheckInDate'] : null,
            'booking_to' => isset($sessionRequest['HotelCheckOutDate']) ? $sessionRequest['HotelCheckOutDate'] : null,
            // 'total_cost' => $request->hdnTotalRoom,
        ]);
        if($a)
            $room_category = $this->bookingMapStatus($bookingData['BookingID'], 'roomcategory', $room_type_name);
        $findCustomer = Customer::where('Email', $bookingRequest['EmailAddress'])->first();
        $customer_id = null;
        $customer_msg = 'Customer Added';
        if($findCustomer){
            $customer_id = $findCustomer->id;
            $customer_msg = 'Customer Found';
        }
        $customer_match = $this->bookingMapStatus($bookingData['BookingID'], $customer_msg, null, 1);
        $this->booking['customer'] = [
            'id' => $customer_id,
            'FirstName' => $bookingRequest['FirstName'],
            'LastName' => $bookingRequest['LastName'],
            'Email' => $bookingRequest['EmailAddress'],
            'Phone' => $bookingRequest['Cell'],
        ];
        $this->booking['status'] = 'Pending';
        $this->booking['occupants'] = $no_of_occupants;
        $this->booking['booking_third_party_id'] = $bookingData['BookingID'];
        $booking_ids = $this->createBooking();
        $partialExist = 0;
        if(isset($bookingRequest['NoOfRooms'])){
            foreach ($bookingRequest['NoOfRooms'] as $key => $value) {
                if($value != '0'){
                    $arr = explode("/", $bookingRequest['room_type_name'][$key], 2);
                    $room_type_name = $arr[0];
                    $hotel_id = $sessionRequest['HotelID'][$key] ?? null;
                    BookingThirdPartyDetail::create([
                        'booking_third_party_id' => $bookingData['BookingID'],
                        'partner_price' => $bookingRequest['PartnerPrice'][$key],
                        'selling_price' => $bookingRequest['SellingPrice'][$key],
                        'hotel_id' => $hotel_id,
                        'hotel_name' => $bookingRequest['HotelName'][$key] ?? '',
                        'room_type_name' => $room_type_name,
                        'no_of_rooms' => $value,
                        'cost_of_rooms' => $bookingRequest['SellingPrice'][$key]*$value,
                        'occupants' => $bookingRequest['occupants'][$key],
                    ]);
                    $this->booking['rooms'] = [];
                    if($a){

                        $room = Room::where('hotel_id', $a->destination)->first();
                        $room['room_charges_onbooking'] = $bookingRequest['SellingPrice'][$key];
                        $room['occupants'] = $bookingRequest['occupants'][$key];
                        // dd($room);
                        $room_category = RoomCategory::where('id', $room->room_category_id)->first();
                        // return response()->json($room);
                        $this->booking['rooms'] = [
                            $room
                        ];
                    }



                    $raa = $this->roomsAreAvailable();
                    // return response()->json($raa);
                    // dd($raa);
                    
                    if($raa){
                        // $this->bookingMapStatus($bookingData['BookingID'], 'roomavailability', null, 1);

                        // dd($this);
                        $this->allocateRooms($booking_ids);
                        $partialExist++;
                    } 

                    // if()
                    // check if hotel map completes
                    
                    // dd($a);
                    // if($a){
                    // }
            
                }
            }
        }
        $mappingStatus = 1;
        $roomAvailability = 'Rooms Full matched';

        if(isset($bookingRequest['NoOfRooms']) && $a){
            if($partialExist == 0){
                $mappingStatus = 0;
            } else if(count($bookingRequest['NoOfRooms']) > $partialExist){
                $roomAvailability = 'Rooms Partial matched';
            }
        } else {
            $mappingStatus = 0;
        }

        $this->bookingMapStatus($bookingData['BookingID'], $roomAvailability, null, $mappingStatus);

        if($invoiceDetail['paymentMode'] != 'Cash'){
            $invoiceStatus = $this->checkInvoiceStatus($invoiceDetail['paymentCode']);
            if($invoiceStatus){
                $role = Role::where('name', 'Admin')->with('users')->first();
                // dd($role->users[0]->id);
                $makeInvoiceDetail = InvoiceDetail::fromThirdPartyBooking($booking_ids[0], $invoiceDetail['booking']['TotalAmount'], $role->users[0]->id, $invoiceDetail['paymentMode']);
                // dd('make invoice detail');
            }
        }

        return response()->json(['success'=> true, 'message'=>'Booking created successfully']);


    }

    public function checkInvoiceStatus($paymentCode){
        $authenticate = $this->makeAuthentication();
        if(!$authenticate){
            return false;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.blinq.pk/invoice/getstatus/$paymentCode");
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
                            "Content-Type:application/json",
                            "token:".$this->token)
                );
        curl_setopt($ch, CURLOPT_POST, false);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        // curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);
        curl_close($ch);
        if(empty($output)) return false;
        else
        {
            $result = json_decode($output);
            // dd($result);
            if(isset($result->Status)){
                if($result->Status == '00'){
                    $response = $result->ResponseDetail;
                    if($response[0]->InvoiceStatus == 'PAID'){
                        return true;
                    }
                }
            }
            return false;
        }
    }
    
    public function makeAuthentication(){
        
        $client_id = 'ligqexD4gC2oCqR';

        $secret_id = 'LIbudKrmkN8oQNl';
        
        $data = '{"ClientID": "'.$client_id.'","ClientSecret": "'.$secret_id.'"}';
        // dd($data);
            
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.blinq.pk/api/Auth/");
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        //get only headers
        curl_setopt($ch, CURLOPT_HEADER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
                            "Content-Type:application/json" )
                );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $output = curl_exec($ch);

        curl_close($ch);
        $headers = [];
        $output = rtrim($output);
        $data = explode("\n",$output);
        $headers['status'] = $data[0];
        array_shift($data);
        foreach($data as $part){
        
            //some headers will contain ":" character (Location for example), and the part after ":" will be lost, Thanks to @Emanuele
            $middle = explode(":",$part,2);
            if($middle[0] == 'token'){
                $middle[1] = str_replace("\r", '', $middle[1]);
                $middle[1] = str_replace(" ", '', $middle[1]);
                $token = $middle[1];
                // dd($middle[1] = str_replace("\r", '', $middle[1]));
            }
        }
            // dd($token);
        if(isset($token)){
            $this->token = $token;
            return true;
            // dd($token, 'create Invoice');
        } else {
            return false;
        }
            
            
    }

    
    
    public function get_third_party_bookings()
    {
        $third_party_bookings = Booking::where('is_third_party', 1)->get();
        return response()->json([
            'third_party_bookings' => $third_party_bookings,
        ]);
    }
    public function get_third_party_booking_count()
    {
        // $third_party_booking_count = Booking::where('is_third_party', 1)->count();
        // return response()->json([
        //     'third_party_booking_count' => $third_party_booking_count,
        // ]);
        $hotel_ids = auth()->user()->getHotelIdsAttribute();

        // $hotel_ids = auth()->user()->user_hotels()->get(['id']);
        $third_party_booking_count = Booking::where('is_third_party', 1)->whereIn('hotel_id', $hotel_ids)->count();
        
        return response()->json([
            'third_party_booking_count' => $third_party_booking_count,
        ]);
       
    }




    public function getBookingServices()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // $hotel_id = $user->hotel_id;
            $hotel_ids = auth()->user()->getHotelIdsAttribute();
            $booking_services = BookingService::where('booking_service.status', 'awaiting')
                ->whereHas('booking', function($query) use ($hotel_ids){
                    $query->whereIn('bookings.hotel_id', $hotel_ids)->where('bookings.status', 'CheckedIn');
                })->get();
            // $booking_services = BookingService::where('status', 'awaiting')->with(['booking'  => function($query) use ($hotel_ids) {
            //     $query->whereIn('hotel_id', '=', $hotel_ids);
            // }])->select(['booking_service.id','booking_service.icon_class','booking_service.service_name','booking_service.serving_time' ,'booking_service.department_name','booking_service.times', 'booking_service.room_id'])
            // ->with(['room:id,room_title,RoomNumber'])
            // ->get();


            return response()->json([
                'booking_services' => $booking_services,
            ]);
        }
       
    }


    public function getBooKingServiceCount()
    {
        if (Auth::check()) {
            $user = Auth::user();
            // $hotel_id = $user->hotel_id;
            $hotel_ids = auth()->user()->getHotelIdsAttribute();
            // $booking_services_count = BookingService::where('status', 'awaiting')->with(['booking'  => function($query) use ($hotel_ids) {
            //     $query->whereIn('hotel_id', $hotel_ids);}])->count();

            $booking_services_count = BookingService::where('booking_service.status', 'awaiting')
                ->whereHas('booking', function($query) use ($hotel_ids){
                    $query->whereIn('hotel_id', $hotel_ids)->where('bookings.status', 'CheckedIn');
                })->count();
            

            return response()->json([
                'booking_services_count' => $booking_services_count,
            ]);
        }
    }
    protected function searchCustomers(Request $request)
    {
        try
        {
            $customers = Customer::select("id", "FirstName", "LastName", "Email", "CNIC", "Phone")
            ->where("IsActive", 1);

            if (!empty($request->email))
            {
                $customers->where("email", "like", "%$request->email%");
            }
            else if (!empty($request->cnic))
            {
                $customers->where("CNIC", "like", "%$request->cnic%");
            }
            else if (!empty($request->phoneNo))
            {
                $customers->where("Phone", "like", "%$request->phoneNo%");
            }
            else
            {
                $customers->where("email", "like", "time()");
            }

            $customers->orderBy("created_at", "desc");

            $totalCustomers = $customers->count();
            $customers = $customers->get();

            if ($totalCustomers > 0)
            {
                $statusCode = 200;

                $message[] = "Customers found successfully!";
                $msgType = "success";

                $result = [
                    "totalCustomers" => $totalCustomers,
                    "customers" => $customers
                ];
            }
            else
            {
                $statusCode = 404;

                $message[] = "Customer not found!";
                $msgType = "failure";

                $result = [
                    "totalCustomers" => 0,
                    "customers" => []
                ];
            }
        }
        catch (Exception $ex)
        {
            $statusCode = 500;

            $message[] = "Something wen't wrong";
            $msgType = "failure";

            $result = [
                "totalCustomers" => 0,
                "customers" => []
            ];
        }

        return response()->json([
            "statusCode" => $statusCode,
            "message" => $message,
            "msgtype" => $msgType,
            "result" => $result
        ]);
    }
    protected function formatCellNumber($no) {
        return str_replace(['-', '(', ')', '+'], '', $no);
    }
    public function sendSms(Request $request)
    {
        // dd($request->all());

        $user = Auth::user();
        $contact_no =$this->formatCellNumber($request['sms']['customer_num']);
        $booking = Booking::find($request['sms']['booking_id']);
        $booking->sendCustomSms($contact_no, $request['sms']['message']);

        $smslog = new SmsLog();
        $smslog->booking_id = $request['sms']['booking_id'];
        $smslog->sender_id = $user->id;
        $smslog->receiver_id = $request['sms']['customer_id'];
        $smslog->receiver_phone = $contact_no;
        $smslog->sent_message = $request['sms']['message'];
        $smslog->save();

        return response()->json([
            'success' => true,
            'message' => 'Message send successfully',
        ]);
      
    }
}
