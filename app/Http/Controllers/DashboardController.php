<?php
namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\City;
use App\Models\Hotel;
use App\Models\Room;
use App\Models\Service;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    protected $module_name = "Department";

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
     * Display base page for services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRecords()
    {     
        // for box counts 
        $userCount = User::count();
        $bookingCount= Booking::count();
        $bookingApprovedCount= Booking::where('status', '=','Confirmed');
        $bookingPendingCount=Booking::where('status','=','Pending');
        $bookingCancelledCount=Booking::where('status','=','Cancelled');
    
        $citiesCount= City::count();
        $hotelsCount= Hotel::count();
        $roomsCount=Room::count();
        // for box counts 
        // $services = Service::get();  
        
        //********************* For Cities Chart **************************//
        $cities= City::with('hotels','cityhotelrooms')->get();


        //***************************For Hotels Chart*************************************//
        // \DB::enableQueryLog();
        $hotels=Hotel::get();
        // dd(\DB::getQueryLog());


        //***************************For Rooms Chart*************************************//
        $query ="SELECT rooms.room_title ,booking_room.room_id,
        COUNT(CASE WHEN bookings.status='Confirmed' THEN 1 ELSE NULL END) AS confirmed,
        COUNT(CASE WHEN bookings.status='Cancelled' THEN 1 ELSE NULL END) AS cancelled,
        COUNT(CASE WHEN bookings.status='Pending' THEN 1 ELSE NULL END) AS pending,
        SUBSTRING(MONTH(bookings.BookingDate),1,3) AS month_name
        FROM booking_room
        JOIN bookings ON (booking_room.booking_id = bookings.id)
        JOIN rooms ON (booking_room.room_id = rooms.id)
        GROUP BY booking_room.room_id, month_name";

        $rooms = DB::select($query);
      

  











        if (auth()->user()->hasRole('Admin')) {
            $is_admin = true;
        }
        else{
            $is_admin = false;
        }
        $user = User::where('id', Auth::user()->id)->with('hotel')->first();
            
        if(!$is_admin)  {
            $bookingCount = Booking::where('hotel_id', $user->hotel_id)->count();
            $bookingApprovedCount->where('hotel_id', $user->hotel_id);
            $bookingPendingCount->where('hotel_id', $user->hotel_id);
            $bookingCancelledCount->where('hotel_id', $user->hotel_id);
        }
        
      

            // dd($bookingApprovedCount->count());



      return response()->json([
          'userCount'=> $userCount,
          'user'=> $user,
          'is_admin'=> $is_admin,
          'bookingCount'=>$bookingCount,
          'bookingApprovedCount'=>$bookingApprovedCount->count(),
          'bookingPendingCount'=>$bookingPendingCount->count(),
          'bookingCancelledCount' => $bookingCancelledCount->count(),
          'citiesCount'=>$citiesCount,
          'hotelsCount'=>$hotelsCount,
          'roomsCount'=>$roomsCount,
        //   'services'=>$services,
          'cities'=>$cities,
          'hotels'=>$hotels,
          'rooms'=>$rooms,
      ]);

      
       
    }


}
