<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\City;
use App\Models\Hotel;
use Carbon\Carbon;

use App\Models\CinCoutRule;
use DateInterval;
use DatePeriod;
use DateTime;
use Illuminate\Support\Facades\DB;

class BookingsCalendarController extends Controller
{
    protected $module_name = 'Bookings Calendar';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('bookingscalendar.index', [
            'breadcrumb' => 'Bookings Calendar Management'
        ]);
    }

    public function getData(Request $request)
    {
        // dd($request['filters']['hotel_id']);
        
        $user = Auth::user();
      
        $request_date = $request['date'];
     
        $current_sd = Carbon::now()->firstOfMonth()->format('Y-m-d');
        $current_ed =Carbon::now()->endOfMonth()->format('Y-m-d');
        
        if(!empty($request_date)){
            $current_sd =Carbon::parse($request->date)->firstOfMonth()->format('Y-m-d');
            $current_ed =Carbon::parse($request->date)->endOfMonth()->format('Y-m-d');
        }
        $bookingFromDate = isset($request_date) ? $request_date : Carbon::now()->format('Y-m-d');
        $bookings=Booking::whereNull('deleted_at');
        // dd($request->all());

        if(!empty($request['filters'])){
            // dd($request['filters']);
            if(!empty($request['filters']['booking_status'])){
                $bookings->whereIn('status',$request['filters']['booking_status']);
            }
            if(!empty($request['filters']['hotel_id'])){
                $bookings->whereIn('hotel_id',$request['filters']['hotel_id']);
            }
        }
        
        if (!Auth::user()->hasRole('Admin')) {
            $bookings = $bookings->whereIn('hotel_id', $user->HotelIds)
            ->select('id','hotel_id','booking_no', 'status', 'BookingFrom AS start',  'BookingTo AS end', DB::raw('COUNT(*) as count'))
            ->whereRaw('MONTH(BookingFrom) = MONTH("'.$bookingFromDate.'")')
            ->groupBy('id')->with(['hotel:id,HotelName'])->get();
        }
        else{
            $bookings = $bookings->select('id','hotel_id','booking_no', 'status', 'BookingFrom AS start',  'BookingTo AS end', DB::raw('COUNT(*) as count'))
            ->whereRaw('MONTH(BookingFrom) = MONTH("'.$bookingFromDate.'")')
            ->groupBy('id')->with(['hotel:id,HotelName'])->get();
            
        }
      
        
        //  $bookings->get();

        $getRangeDates = [];
        $bookingObject = [];
        $interval = new DateInterval('P1D');
        $realEnd = new DateTime($current_ed);
        $realEnd->add($interval);
        $period = new DatePeriod(new DateTime($current_sd), $interval, $realEnd);

        foreach ($bookings as $key => $booking) {
            foreach ($period as $date) {
                if(isset($request_date)){
                    if($request_date == $date->format("Y-m-d")){
                        if ($date->format("Y-m-d") >= $booking->start && $date->format("Y-m-d") <= $booking->end ) {
                            // $getRangeDates[] = $date->format("Y-m-d");
                            $bookingObject[] =  $booking;
                        }
                    }
                } 
                if ($date->format("Y-m-d") >= $booking->start && $date->format("Y-m-d") <= $booking->end ) {
                    $getRangeDates[] = $date->format("Y-m-d");
                }
                
            }
        }
        if(array_count_values($getRangeDates)){
            $max_count = max(array_count_values($getRangeDates));
        }
        else{
            $max_count = 0;
        }

        $hotels = auth()->user()->user_hotels();
        // dd($hotels->get(['id','HotelName']));
        return response()->json([
            'max_count'=>$max_count,
            'booking_counts'=>array_count_values($getRangeDates),
            'bookings'=>$bookingObject,
            'hotels'=>$hotels->get(['id','HotelName']),
            'hotel_count'=>$hotels->count()
        ]);
    }
     public function getEventData(Request $request)
     {

         $event_bookings = Booking::with(['hotel'])->where('hotel_id', $request->hotel_id)
         ->where('status', $request->status)
         ->where('BookingFrom', $request->start)->get();

         return response()->json([
            'event_bookings'=>$event_bookings,
        ]);

     }
}