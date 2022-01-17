<?php
// Mr Optimist 14 Jan 2022
namespace App\Http\Controllers;

use App\Models\AdminDefaultSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Donation;
use App\Models\Module;
use App\Models\ModuleReport;
use App\Models\Role;
use App\Models\TourInvoice;
use App\Models\User;
use App\Models\UserReport;


use App\Models\Booking;
use App\Models\BookingService;
use App\Models\CustomerComplain;
use App\Models\DiscountRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\Hotel;
use DateTime;
use Illuminate\Support\Facades\Validator;
use PDF;
use stdClass;


class ReportControllerTwo extends Controller
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

  public function get_guest_detail(Request $request) {

      $user = User::find(Auth::user()->id);
      $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
      $hotel_id = $hotels[0]->id;
      $hotelName = $hotels[0]->HotelName;
      if(!empty($request['hotel_id'])) {
          $hotel_id = $request['hotel_id'];
          $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
      }
      date_default_timezone_set("Asia/Karachi");

      // Get Room Stats
      $today = date('Y-m-d');
      $todays_date = date('Y-m-d');


      $todays_date_time =  date("Y-m-d H:i");
      $newDateTime = date('h:i:s A', strtotime($todays_date_time));

      // $receiving_date = $request->receiving_date;
      $receiving_date = '2022-01-14 06:01:00';
      $receiving_date_two = '2022-01-14 23:59:00';

      $next_date = date('Y-m-d', strtotime($receiving_date .' +1 day'));

      $next_date_one = $next_date.' 00:00:00';
      $next_date_two = $next_date.' 06:00:00';
      
      
      $total_checkedins_today = 0;
      $total_checkedouts_today = 0;

      $guest_detail_report =  Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])
          ->whereBetween('checkin_time', [$receiving_date,$receiving_date_two])
          //->whereBetween('checkin_time', [$receiving_date,$receiving_date_two])->get();
          ->orwherebetween('checkin_time', [$next_date_one,$next_date_two])->get();
          
      $guest_detail_report = $guest_detail_report->map(function ($item) {
          $obj = new stdClass();
          $obj->booking_no = $item->booking_no;
          $obj->customer_name = $item->customer['FirstName'].' '.$item->customer['LastName'];
          $obj->rooms = $item->rooms->map(function ($room) {
            return [
              'RoomNumber' => $room->RoomNumber
            ];
          });
          $obj->no_occupants = $item->no_occupants;
          $obj->checkin_time = $item->checkin_time;
          $obj->checkout_time = $item->checkout_time;
          
          return $obj;
      });

      
      /*

      $abcd = array(
        'guest_detail_report' =>$guest_detail_report,
        'hotelName' => $hotelName
      );
      
      $abcd = array(
        'rooms_occupiedd' =>$users_skills_points,
        'rooms_occupied' =>$rooms_occupied,
        'todays_date_time' => $todays_date_time,
        'newDateTime' => $newDateTime,
        'todays_date' => $todays_date,
        'receiving_date' => $receiving_date,
        'receiving_date_two' => $receiving_date_two,
        'next_date_one' => $next_date_one,
        'next_date_two' => $next_date_two
      );
      **/

      //echo "<pre>";
      //var_dump($abcd);
      //echo "</pre>";

   
      
      return response()->json([
        'guest_detail_report' =>$guest_detail_report,
        'hotelName' => $hotelName
      
    ]);


  
  
  }
 

  public function get_checkout_list(Request $request) {

    $user = User::find(Auth::user()->id);
    $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
    $hotel_id = $hotels[0]->id;
    $hotelName = $hotels[0]->HotelName;
    if(!empty($request['hotel_id'])) {
        $hotel_id = $request['hotel_id'];
        $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
    }
    date_default_timezone_set("Asia/Karachi");

    // Get Room Stats
    $today = date('Y-m-d');
    $todays_date = date('Y-m-d');



    // $receiving_date = $request->receiving_date;
    $receiving_date = '2022-01-14';
    $next_date = date('Y-m-d', strtotime($receiving_date .' +1 day'));

    $total_checkedins_today = 0;
    $total_checkedouts_today = 0;


    $get_checkout_list =  Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])
        // ->where('BookingTo', '=', $receiving_date)
        ->whereIn('BookingTo', [$receiving_date,$next_date])
        ->get();
        
    $get_checkout_list = $get_checkout_list->map(function ($item) {
        $obj = new stdClass();
        $obj->booking_no = $item->booking_no;
        $obj->customer_name = $item->customer['FirstName'].' '.$item->customer['LastName'];
        $obj->rooms = $item->rooms->map(function ($room) {
          return [
            'RoomNumber' => $room->RoomNumber
          ];
        });
        $obj->no_occupants = $item->no_occupants;
        $obj->BookingFrom = $item->BookingFrom;
        $obj->BookingTo = $item->BookingTo;
        
        //$obj->checkin_time = $item->checkin_time;
        //$obj->checkout_time = $item->checkout_time;
        
        return $obj;
    });

    /*
    $abcd = array(
      'get_checkout_list' =>$get_checkout_list,
      'hotelName' => $hotelName
    );
    
    echo "<pre>";
    var_dump($abcd);
    echo "</pre>";
    
    **/

    return response()->json([
      'get_checkout_list' =>$get_checkout_list,
      'hotelName' => $hotelName
    
    ]);

  }

  public function get_inquirydetail_report(Request $request)
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
    
    //2022-01-18 03:01:15.000000
    //$todays_date = date('Y-m-d');

    $todays_date = date('Y-m-d',strtotime('2022-01-18'));


    //$todays_date_time =  date("Y-m-d H:i");

    $todays_date_time = date('Y-m-d H:i',strtotime('2022-01-18 07:30'));

    
    $newDateTime = date('h:i:s A', strtotime($todays_date_time));        
    $total_checkedins_today = 0;
    $total_checkedouts_today = 0;
    
    if(preg_match('/am$/i', $newDateTime)){

      //$previous_date =  date('Y-m-d', strtotime(' -1 day'));

      $previous_date = date('Y-m-d', strtotime('2022-01-18 -1 day'));

      $current_date_time = new DateTime($todays_date_time);
      // G means 0 through 23
      if(($current_date_time->format('G') < 6)){

        
        $previous_date_new = $previous_date.' 06:01'; // from

        $total_checkedins_today =   Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time',[$previous_date_new,$todays_date_time])->get(); 
        $total_checkedouts_today =  Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time',[$previous_date_new,$todays_date_time])->get(); 
    
      
      }
      else {

        var_dump('Greater than 6');

       
        $previous_date_one = $previous_date.' 06:01';
        $previous_date_two = $previous_date.' 23:59';

    
        $total_checkedins_today =   Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time',[$previous_date_one,$previous_date_two])->get(); 
        $total_checkedouts_today =  Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time',[$previous_date_one,$previous_date_two])->get(); 
    
        
          
        $today_date_one = $todays_date.' 00:00';
        $today_date_two = $todays_date.' 06:00';

        $total_checkedins_todayy = 0;
        $total_checkedouts_todayy = 0;

       
        $total_checkedins_todayy =   Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time',[$today_date_one,$today_date_two])->get(); 
        $total_checkedouts_todayy =  Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time',[$today_date_one,$today_date_two])->get(); 
    
        
        $total_checkedins_today = $total_checkedins_today->merge($total_checkedins_todayy);
        $total_checkedouts_today = $total_checkedouts_today->merge($total_checkedouts_todayy);
        
      }
    
    }
    else {


      $today_date_one = $todays_date.' 06:01';
      $today_date_two = $todays_date_time;

      $total_checkedins_today =   Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time',[$today_date_one,$today_date_two])->get(); 
      $total_checkedouts_today =  Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkout_time',[$today_date_one,$today_date_two])->get(); 
    
    }

    $total_checkedins_today = $total_checkedins_today->map(function ($item) {
      $obj = new stdClass();
      $obj->booking_no = $item->booking_no;
      $obj->customer_name = $item->customer['FirstName'].' '.$item->customer['LastName'];
      $obj->CNIC = $item->customer['CNIC'];
      $obj->rooms = $item->rooms->map(function ($room) {
        return [
          'RoomNumber' => $room->RoomNumber
        ];
      });
      $obj->no_occupants = $item->no_occupants;
      $obj->BookingFrom = $item->BookingFrom;
      $obj->BookingTo = $item->BookingTo;
      $obj->checkin_time = $item->checkin_time;
      $obj->checkout_time = $item->checkout_time;
      
      return $obj;
    });

    $total_checkedouts_today = $total_checkedouts_today->map(function ($item) {
      $obj = new stdClass();
      $obj->booking_no = $item->booking_no;
      $obj->customer_name = $item->customer['FirstName'].' '.$item->customer['LastName'];
      $obj->CNIC = $item->customer['CNIC'];
      $obj->rooms = $item->rooms->map(function ($room) {
        return [
          'RoomNumber' => $room->RoomNumber
        ];
      });
      $obj->no_occupants = $item->no_occupants;
      $obj->BookingFrom = $item->BookingFrom;
      $obj->BookingTo = $item->BookingTo;
      $obj->checkin_time = $item->checkin_time;
      $obj->checkout_time = $item->checkout_time;
      
      return $obj;
    });


    
    $abcd = array(
      'get_checkedins_today' => $total_checkedins_today,
      'get_checkedouts_today' => $total_checkedouts_today,
      'hotelName' => $hotelName
    );
    
    echo "<pre>";
    var_dump($abcd);
    echo "</pre>";

    return;
    return response()->json([
        
        'hotels'=>$hotels,
        'todays_date'=>$todays_date,
        'total_checkedins_today'=>$total_checkedins_today,
        'total_checkedouts_today'=>$total_checkedouts_today,
        // 'hotel_id'=>$hotel_id
        //   'services'=>$services,

    ]);

  }




  

}