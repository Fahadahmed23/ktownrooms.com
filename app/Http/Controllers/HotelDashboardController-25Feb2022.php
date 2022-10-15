<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\CustomerComplain;
use App\Models\DiscountRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\Hotel;
use DateTime;

class HotelDashboardController extends Controller
{
    protected $module_name = "Hotel Dashboard";

    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display base page for services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hotel_dashboard.index', [
            'breadcrumb' => $this->module_name,
        ]);
    }

    public function getCheckins(Request $request)
    {
        $dt = date("Y-m-d");
        $timespan = strtolower($request['period']);
        if ($timespan == "this month" || $timespan == "next month") {
            $keywordStart = 'first day of';
            $keywordEnd = 'last day of';
        } else if ($timespan == "this week" || $timespan == "next week") {
            $keywordStart = 'monday';
            $keywordEnd = 'sunday';
        }
        if ($timespan == 'today') {
            $start_date = $dt;
            $end_date = $dt;
        } else if ($timespan == 'as of today') {
            $start_date = '1970-01-01';
            $end_date = date('Y-m-d', strtotime('-1 day'));
        } else {
            $start_date = date("Y-m-d", strtotime($dt . ' ' . $keywordStart . ' ' . $timespan));
            $end_date = date("Y-m-d", strtotime($dt . ' ' . $keywordEnd . ' ' . $timespan));
        }
        // DB::enableQueryLog(); 
        $todayCheckinCount = Booking::whereBetween('BookingFrom', [$start_date, $end_date])->where('status', 'CheckedIn');
        // $todayCheckinCount->get();
        $expectedCheckinCount = Booking::whereBetween('BookingFrom', [$start_date, $end_date])->where(function ($query) {
            $query->where('status', 'Pending')
            ->orWhere('status', 'Confirmed');
        });
        
        $todayCheckinCount->where('hotel_id', $request['hotel_id']);
        $expectedCheckinCount->where('hotel_id', $request['hotel_id']);

        // dd(DB::getQueryLog());
        $completedCheckinCount = $todayCheckinCount->count() + $expectedCheckinCount->count();
        return response()->json([
            'todayCheckinCount' => $todayCheckinCount->count(),
            'expectedCheckinCount' => $expectedCheckinCount->count(),
            'completedCheckinCount' => $completedCheckinCount,
        ]);
    }
    public function getCheckouts(Request $request)
    {
        $dt = date("Y-m-d");
        $timespan = strtolower($request['period']);
        if ($timespan == "this month" || $timespan == "next month") {
            $keywordStart = 'first day of';
            $keywordEnd = 'last day of';
        } else if ($timespan == "this week" || $timespan == "next week") {
            $keywordStart = 'monday';
            $keywordEnd = 'sunday';
        }
        if ($timespan == 'today') {
            $start_date = $dt;
            $end_date = $dt;
        } else if ($timespan == 'as of today') {
            $start_date = '1970-01-01';
            $end_date = date('Y-m-d', strtotime('-1 day'));
        } else {
            $start_date = date("Y-m-d", strtotime($dt . ' ' . $keywordStart . ' ' . $timespan));
            $end_date = date("Y-m-d", strtotime($dt . ' ' . $keywordEnd . ' ' . $timespan));
        }

        $todayCheckoutCount = Booking::whereBetween('BookingTo', [$start_date, $end_date])->where('status', 'CheckedOut');

        $expectedCheckoutCount = Booking::whereBetween('BookingTo', [$start_date, $end_date])->where('status', 'CheckedIn');
        $todayCheckoutCount->where('hotel_id', $request['hotel_id']);
        $expectedCheckoutCount->where('hotel_id', $request['hotel_id']);
        $completedCheckoutCount = $todayCheckoutCount->count() + $expectedCheckoutCount->count();
        return response()->json([
            'todayCheckoutCount' => $todayCheckoutCount->count(),
            'expectedCheckoutCount' => $expectedCheckoutCount->count(),
            'completedCheckoutCount' => $completedCheckoutCount,
        ]);
    }

    public function getRecords(Request $request)
    {
        
        $user = User::find(Auth::user()->id);
        $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
        $hotel_id = $hotels[0]->id;
        $hotelName = $hotels[0]->HotelName;
        if(!empty($request['hotel_id'])){
            $hotel_id = $request['hotel_id'];
            $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
        }

        date_default_timezone_set("Asia/Karachi");
        
        // Get Room Stats
        $today = date('Y-m-d');
        $todays_date = date('Y-m-d');


       //$todays_date_time =  date("Y-m-d H:i:s");
        $todays_date_time =  date("Y-m-d H:i");

        //$todays_date_time = '2021-12-15 13:00';
        
        //$data_parameter = '2021-12-14 24:59:00';
        //$data_parameter_two = '2021-12-05 08:39:45';

        //var_dump('Todays date & time');
        //var_dump($todays_date_time);

       
        $newDateTime = date('h:i:s A', strtotime($todays_date_time));
        //var_dump('Todays date & time Am/Pm');
        
        //var_dump($newDateTime);
        //var_dump('Check AM or PM');

        
        $total_checkedins_today = 0;
        $total_checkedouts_today = 0;
        
        if(preg_match('/am$/i', $newDateTime)){

            $previous_date =  date('Y-m-d', strtotime(' -1 day'));

            $current_date_time = new DateTime($todays_date_time);
            // G means 0 through 23
            if(($current_date_time->format('G') < 6)){

                $previous_date_new = $previous_date.' 06:01'; // from

                $total_checkedins_today =   Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time', [$previous_date_new,$todays_date_time])->get()->sum('rooms_count'); 
                $total_checkedouts_today =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time', [$previous_date_new,$todays_date_time])->get()->sum('rooms_count'); 
         
            }
            else {

                //var_dump('Greater than 6');

                $previous_date_one = $previous_date.' 06:01';
                //$previous_date_two = $previous_date.' 11:59';
                $previous_date_two = $previous_date.' 23:59';

                $total_checkedins_today =   Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time', [$previous_date_one,$previous_date_two])->get()->sum('rooms_count'); 
                $total_checkedouts_today =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time', [$previous_date_one,$previous_date_two])->get()->sum('rooms_count'); 

                
                $today_date_one = $todays_date.' 00:00';
                $today_date_two = $todays_date.' 06:00';

                $total_checkedins_todayy = 0;
                $total_checkedouts_todayy = 0;

                $total_checkedins_todayy =   Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time', [$today_date_one,$today_date_two])->get()->sum('rooms_count');    
                $total_checkedouts_todayy =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time', [$today_date_one,$today_date_two])->get()->sum('rooms_count'); 

                
                $total_checkedins_today = $total_checkedins_today+$total_checkedins_todayy;
                $total_checkedouts_today = $total_checkedouts_today+$total_checkedouts_todayy;
  
            }
        
        }
        else {


            $today_date_one = $todays_date.' 06:01';
            $today_date_two = $todays_date_time;

            
            $total_checkedins_today =   Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time', [$today_date_one,$today_date_two])->get()->sum('rooms_count'); 
            $total_checkedouts_today =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time', [$today_date_one,$today_date_two])->get()->sum('rooms_count'); 

        }

        
        //var_dump($total_checkedins_today);
        //var_dump($total_checkedouts_today);
     
        // $deliverytime = new DateTime($todays_date_time);
        // $hour = $deliverytime->format('H:i:s');

        // var_dump('Todays time ');
        // var_dump($hour);

        // var_dump('Todays date');
        // var_dump($todays_date);
       
        //die;

    
        $rooms_count = Room::where('hotel_id', $hotel_id)->count();
        $rooms_occupied =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->where('status', 'CheckedIn')->where('BookingFrom', '<=', $today)->where('BookingTo', '>=', $today)->get()->sum('rooms_count'); 
        $rooms_reserved =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['Pending', 'Confirmed'])->where('BookingFrom', '<=', $today)->where('BookingTo', '>=', $today)->get()->sum('rooms_count');
        $rooms_blocked = Room::where('hotel_id', $hotel_id)->where('is_available', 0)->count();
        $rooms_available = $rooms_count - $rooms_occupied - $rooms_reserved - $rooms_blocked;

        if (auth()->user()->hasRole('Admin')) {
            $is_admin = true;
        } else {
            $is_admin = false;
        }
        $user = User::where('id', Auth::user()->id)->with('hotel')->first();

        /************ Welcome Message Section **********/
        // $Hour = date('G');
        $timezone  = +5;
        $Hour = gmdate("G", time() + 3600*($timezone+date("I")));
        $greeting_message = 'Good Night';
        if ($Hour >= 5 && $Hour <= 11) {
            $greeting_message = "Good Morning";
        } else if ($Hour >= 12 && $Hour <= 16) {
            $greeting_message = "Good Afternoon";
        } else if ($Hour >= 17 || $Hour <= 20) {
            $greeting_message = "Good Evening";
        }
        if(is_object($hotelName))
            $hotelName = $hotelName[0];
        $greeting_message = $greeting_message . ', ' . $user->first_name . ' ' . $user->last_name . '!';
        $greeting_description = 'Welcome to <strong>' .$hotelName. '</strong> dashboard';
        /************ Welcome Message Section **********/

        // dd($user);
        // $userCount = User::count();
        /************ Stats Section **********/

        $bookingCount = Booking::count();

        //1st Box
        $bookingApprovedCount = Booking::where('status', '=', 'Confirmed');
        $bookingPendingCount = Booking::where('status', '=', 'Pending');
        $bookingCancelledCount = Booking::where('status', '=', 'Cancelled');

        //2nd Box
        $todayCheckoutCount = Booking::whereDate('BookingTo', '<', date('Y-m-d'))->where('status', 'CheckedOut');
        $expectedCheckoutCount = Booking::whereDate('BookingTo', '<',  date('Y-m-d'))->where('status', 'CheckedIn');
        // DB::enableQueryLog(); 

        // $todayCheckinCount->get();
        // dd(DB::getQueryLog());
        DB::enableQueryLog(); 
        
        $todayCheckinCount = Booking::whereDate('BookingFrom', '<', date('Y-m-d'))->where('status', 'CheckedIn');
        $expectedCheckinCount = Booking::whereDate('BookingFrom', '<', date('Y-m-d'))->where(function ($query) {
            $query->where('status', 'Pending')
                ->orWhere('status', 'Confirmed');
        });
        // dd(DB::getQueryLog());
        
        $currentFrom = date('Y-m-d', strtotime('first day of this month'));
        $currentTo = date('Y-m-d', strtotime('last day of this month'));
        // dd($currentFrom, $currentTo);
        $currentMonthBookings = Booking::where('status', 'CheckedOut')
        ->whereBetween('BookingFrom', [$currentFrom, $currentTo])
        ->orWhereBetween('BookingTo', [$currentFrom, $currentTo])
            ->with(['invoice' => function ($query) {
                $query->groupBy('booking_id')->orderBy('id', 'DESC')->select('booking_id','payment_date', DB::raw('SUM(net_total) AS amount_sum'));
            }])->get();

        $currentMonthData = [];
        $today_earning = 0;

        foreach ($currentMonthBookings as $key => $value) {
            if(isset($value->invoice)){
                if (($value->invoice->payment_date >= $currentFrom) && ($value->invoice->payment_date <= $currentTo)){
                    $currentMonthData['date'][] = date('Y-m-d',strtotime($value->invoice->payment_date));
                    $currentMonthData['value'][] = $value->invoice->amount_sum ?? 0;
                }
                if($value->invoice->payment_date == date('Y-m-d')){
                    $today_earning +=$value->invoice->amount_sum;
                }
            }
        }
        $today_earning = round($today_earning,0);

        $temp = [];
        
        // Mr Optimist 02 Dec 2021
        if(isset($currentMonthData['date'])) {
            foreach($currentMonthData['date'] as $key => $value) {
                if(!array_key_exists($value, $temp)) {
                    $temp[$value] = 0;
                }
                $temp[$value] += $currentMonthData['value'][$key];
            }
        }
        
        $revenueMonthly = [];
        $revenueMonthly['date'] = array_keys($temp);
        $revenueMonthly['value'] = array_values($temp);
        
        $monthly_earning = 0;
        $monthly_earning = round(array_sum($revenueMonthly['value']), 0);
        // dd($monthly_earning);


        // $revenueMonthly = json_encode($revenueMonthly);


        // $overallBooking = Booking::where('status', 'CheckedOut')
        //     ->with(['invoice' => function ($query) {
        //         $query->groupBy('booking_id')->select('booking_id', DB::raw('SUM(net_total) AS amount_sum'));
        //     }])->get();
        // $overall_earning = 0;

        // foreach ($overallBooking as $key => $value) {
        //     $overall_earning += $value->invoice->amount_sum ?? 0;
        // }



        // dd($overall_earning, $today_earning);
        // $allCheckout = Booking::where('status', 'CheckedOut')->withCount([
        //     'invoice as invoice' => function ($query) {
        //         $query->select(DB::raw("sum(net_total)"));
        //     },
        // ])->first();
        // $today_earning = 50;
        // $overall_earning = 15000;
        // dd($allCheckout->sum('invoice_sum'));

        if (!$is_admin) {
            $bookingCount = Booking::where('hotel_id', $hotel_id)->count();
            $bookingApprovedCount->where('hotel_id', $hotel_id);
            $bookingPendingCount->where('hotel_id', $hotel_id);
            $bookingCancelledCount->where('hotel_id', $hotel_id);
            $todayCheckoutCount->where('hotel_id', $hotel_id);
            $todayCheckinCount->where('hotel_id', $hotel_id);
            $expectedCheckoutCount->where('hotel_id', $hotel_id);
            $expectedCheckinCount->where('hotel_id', $hotel_id);
        }
        $completedCheckinCount = $todayCheckinCount->count() + $expectedCheckinCount->count();
        $completedCheckoutCount = $todayCheckoutCount->count() + $expectedCheckoutCount->count();
        /************ Stats Section **********/

        /*********** Chart Section **********/
        // get customer id of bookings
        $customerBookings = Booking::where('hotel_id', $hotel_id)
            ->select(
                ['customers.id',
                    'customers.FirstName',
                    'customers.LastName',
                    'customers.Email',
                    DB::raw('count(customer_id) as total_bookings'),
                    DB::raw('count(case when status = "Cancelled" then 1 else null end) as cancel_bookings'),
                    DB::raw('count(case when status != "Cancelled" then 1 else null end) as progress_bookings'),
                    DB::raw('round(((count(case when status != "Cancelled" then 1 else null end))*100)/count(customer_id)) as progress_percentage'),
                    DB::raw('round(((count(case when status = "Cancelled" then 1 else null end))*100)/count(customer_id)) as cancel_percentage'),
                ])
            ->groupBy('customer_id')
            ->orderBy('total_bookings', 'DESC')
            ->take(5)
            ->leftjoin('customers', 'bookings.customer_id', 'customers.id')
            ->get();

        $channel_bookings = Booking::where('hotel_id', $hotel_id)
            ->whereNotNull('channel')
            ->select(DB::raw('count(channel) as count, channel as label'))
            ->groupBy('channel')
            ->get();

        $previousFrom = date('Y-m-d', strtotime('first day of january previous year'));
        $previousTo = date('Y-m-d', strtotime('last day of december previous year'));
        $currentFrom = date('Y-m-d', strtotime('first day of january this year'));
        $currentTo = date('Y-m-d', strtotime('last day of december this year'));
        $iterator = 12;

        //Current Year Booking for Bar Chart
        $current_year_bookings = Booking::whereBetween('BookingFrom', [$currentFrom, $currentTo])
            ->orWhereBetween('BookingTo', [$currentFrom, $currentTo])
            ->select(DB::raw('count(*) as data'))
            ->selectRaw("MONTH(created_at) as label")
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        if (count($current_year_bookings) > 0) {
            $current_year_bookings = array_column($current_year_bookings->toArray(), 'data', 'label');
        }
        $currBooking = [];
        for ($i = 1; $i <= $iterator; $i++) {
            $currBooking[] = isset($current_year_bookings[$i]) ? $current_year_bookings[$i] : 0;
        }

        //Previous Year Booking for Bar Chart
        $previous_year_bookings = Booking::whereBetween('BookingFrom', [$previousFrom, $previousTo])
            ->orWhereBetween('BookingTo', [$previousFrom, $previousTo])
            ->select(DB::raw('count(*) as data'))
            ->selectRaw("MONTH(created_at) as label")
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();
        if (count($previous_year_bookings) > 0) {
            $previous_year_bookings = array_column($previous_year_bookings->toArray(), 'data', 'label');
        }
        $prevBooking = [];
        for ($i = 1; $i <= $iterator; $i++) {
            $prevBooking[] = isset($previous_year_bookings[$i]) ? $previous_year_bookings[$i] : 0;
        }
        /*********** Chart Section **********/

        /*********** Request Section **********/
        $discount_requests = DiscountRequest::with([
            'booking:id,booking_no',
            'booking.invoice',
            'requester:id,name',
            'supervisor:id,name',
        ]);

        if (Auth::user()->roles()->where('name', 'Frontdesk')->count() > 0) {
            $discount_requests = $discount_requests->where('requester_id', Auth::id());
        } else if (!auth()->user()->hasRole('Admin')) {
            // dd(Auth::user()->hotel_id);
            $discount_requests = $discount_requests->where('hotel_id', $hotel_id);
        } else {
            $discount_requests = $discount_requests->where('status', 'Pending');
        }

        $discount_requests_count = $discount_requests->count();
        // $hotel_booking_ids = [];
        $collection = Booking::where('hotel_id', $hotel_id)->get(['id']);
        $hotel_booking_array = json_decode($collection, true);
        $hotel_booking_array = array_column($hotel_booking_array, 'id');
        // $hotel_booking_array = $collection->toArray();
        $hotel_booking_ids = implode(',', $hotel_booking_array);
        $idsArr = explode(',', $hotel_booking_ids);
        // dd($hotel_booking_ids);
        $hotelbookingservices = BookingService::whereIn('booking_id', $idsArr);

        /*********** Request Section **********/

        /*********** Complain Section **********/
        $open_complains = CustomerComplain::with('customer')->where('complain_status_id', 1)->whereDate('created_at', date('Y-m-d'));
        $complain_count = CustomerComplain::count();
        $open_complain_count = CustomerComplain::where('complain_status_id', 1);
        $resolved_complain_count = CustomerComplain::where('complain_status_id', 3);
        $closed_complain_count = CustomerComplain::where('complain_status_id', 4);
        if (!$is_admin) {
            $open_complains->where('hotel_id', $hotel_id);
            $complain_count = CustomerComplain::where('hotel_id', $hotel_id)->count();
            $open_complain_count->where('hotel_id', $hotel_id);
            $resolved_complain_count->where('hotel_id', $hotel_id);
            $closed_complain_count->where('hotel_id', $hotel_id);
        }
        /*********** Complain Section **********/

        /*********** Dump & Die Section **********/

        // dd($current_year_bookings, $previous_year_bookings);
        // dd($channel_bookings);

        // dd($todayCheckoutCount->count(), $expectedCheckoutCount->count());
        // dd($expectedCheckinCount->count(), $expectedCheckoutCount->count());

        // dd($bookingApprovedCount->count());

        /*********** Dump & Die Section **********/

        return response()->json([
            'greeting_message' => $greeting_message,
            'greeting_description' => $greeting_description,
            'today_earning' => $today_earning,
            'monthly_earning' => $monthly_earning,
            'user' => $user,
            'is_admin' => $is_admin,
            'bookingCount' => $bookingCount,
            'bookingApprovedCount' => $bookingApprovedCount->count(),
            'bookingPendingCount' => $bookingPendingCount->count(),
            'bookingCancelledCount' => $bookingCancelledCount->count(),
            'todayCheckoutCount' => $todayCheckoutCount->count(),
            'todayCheckinCount' => $todayCheckinCount->count(),
            'expectedCheckoutCount' => $expectedCheckoutCount->count(),
            'expectedCheckinCount' => $expectedCheckinCount->count(),
            'completedCheckinCount' => $completedCheckinCount,
            'completedCheckoutCount' => $completedCheckoutCount,
            'customerBookings' => $customerBookings,
            'channel_bookings' => $channel_bookings,
            'currBooking' => $currBooking,
            'prevBooking' => $prevBooking,
            'complain_count' => $complain_count,
            'open_complain_count' => $open_complain_count->count(),
            'resolved_complain_count' => $resolved_complain_count->count(),
            'closed_complain_count' => $closed_complain_count->count(),
            'open_complains' => $open_complains->get(),
            'discount_requests' => $discount_requests->take(5)->get(),
            'discount_requests_count' => $discount_requests_count,
            'hotelbookingservices' => $hotelbookingservices->take(5)->get(),
            'hotelbookingservices_count' => $hotelbookingservices->count(),
            'revenueMonthly' => $revenueMonthly,

            // rooms
            'rooms_count' => $rooms_count,
            'rooms_occupied' => $rooms_occupied,
            'rooms_reserved' => $rooms_reserved,
            'rooms_available' => $rooms_available,
            'rooms_blocked' => $rooms_blocked,
            'hotels'=>$hotels,
            'todays_date'=>$todays_date,
            'total_checkedins_today'=>$total_checkedins_today,
            'total_checkedouts_today'=>$total_checkedouts_today,
            // 'hotel_id'=>$hotel_id
            //   'services'=>$services,

        ]);

    }
}