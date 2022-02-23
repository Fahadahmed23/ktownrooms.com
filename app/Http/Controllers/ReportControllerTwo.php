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

use App\Models\InvoiceDetail;
use App\Models\DefaultRule;

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


  protected $lockdown = false;

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

  public function get_inquirydetail_report(Request $request) {
        
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

    return response()->json([
        
        'get_checkedins_today'=>$total_checkedins_today,
        'get_checkedouts_today'=>$total_checkedouts_today,
        'hotelName'=>$hotelName
      

    ]);

  }

  public function get_individual_guest_ledger(Request $request)
  {

    date_default_timezone_set("Asia/Karachi");
    
    $user_email = 'fahadahmedoptimist@gmail.com';
    //$user_email = $request->email ?? null;
    $user_cnic = $request->cnic ?? null;

    $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
    $hotel_id = $hotels[0]->id;
    $hotelName = $hotels[0]->HotelName;
  
    if(!empty($request['hotel_id'])){
        $hotel_id = $request['hotel_id'];
        $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
    }

    if(!empty($user_email)) {

        
      $bookings = Booking::whereHas('customer', function ($q1) use ($user_email) {
          
          $q1->where('Email', $user_email);

      })->with(['hotel','rooms', 'rooms.category','services','invoice', 'promotion','tax_rate', 'invoice.payment_mode'])
      ->where('hotel_id',$hotel_id)
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
                      $obj['RoomRent'] = $room->RoomCharges;
                      return $obj;
                  });
                  $obj->no_occupants = $ex->no_occupants ?? "";
                  $obj->checkin_time = $ex->checkin_time ?? "";
                  $obj->checkout_time = $ex->checkout_time ?? "";
                  
                  $obj->BookingDate = $ex->BookingDate ?? "";
                  $obj->BookingFrom = $ex->BookingFrom ?? "";
                  $obj->BookingTo = $ex->BookingTo ?? "";
                  $obj->net_total = $ex->invoice->net_total ?? "";
                  $obj->payment_amount = $ex->invoice->payment_amount ?? "";

                  if($ex->invoice->corporate_type != null){
                      if($ex->invoice->corporate_type == 1 ){
                        $obj->corporate_type = "Full Board";
                        $obj->corporate_type_total = 0;
                      }
                      elseif($ex->invoice->corporate_type == 2){
                        $obj->corporate_type = "Half Board";
                        $obj->corporate_type_total = $ex->invoice->net_total/2;
                      }
                      elseif($ex->invoice->corporate_type == 3){
                        $obj->corporate_type = "Room Only";
                        $obj->corporate_type_total = 0;
                        if( count($ex->services) > 0){
                          for ($i = 0; $i < count($ex->services); $i++) {
                            
                            $obj->corporate_type_total += $ex->services[$i]->amount;
                          }

                        }
                        
                      }
                      
                  }
                  else {
                    $obj->corporate_type = $ex->invoice->corporate_type ?? "";
                    $obj->corporate_type_total = 0;
                    
                  }
                  
                  $obj->status = $ex->status ?? "";
                  return $obj;
              });


              /*
              $abcd = array(
                'success' => true,
                'totalRecords' => $count,
                'bookings' => $bookings_map,
              );

              echo "<pre>";
              var_dump($abcd);
              echo "</pre>";
              return;
              **/

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

  }

 
  public function get_average_daily_rate_report(Request $request)
  {
    date_default_timezone_set("Asia/Karachi");
    
    //$user_email = 'fahadahmedoptimist@gmail.com';
    //$user_email = $request->email ?? null;
    $user_cnic = $request->cnic ?? null;
        
    $user = User::find(Auth::user()->id);
    $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
    $hotel_id = $hotels[0]->id;
    $hotelName = $hotels[0]->HotelName;
    if(!empty($request['hotel_id'])) {
        $hotel_id = $request['hotel_id'];
        $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
    }



    //$date_from = $request['date_from'];
    //$date_to = $request['date_to'];
    
    $date_from = '2022-02-16';
    $date_to = '2022-02-17';

    
    
    $date_from = strtotime($date_from);
    $date_to = strtotime($date_to); // or your date as well
    
    $datediff = $date_to - $date_from;

    var_dump('Date Diff : '.round($datediff / (60 * 60 * 24)));
    //echo round($datediff / (60 * 60 * 24));
    
    //$previous_date = date('Y-m-d', strtotime($date_from.' -1 day'));
    //$previous_date_one = $previous_date.' 06:01';
    //$previous_date_two = $previous_date.' 23:59';

    echo $previous_date_one = $date_from.' 06:01';
    echo $previous_date_two = $date_from.' 23:59';



    $next_date = date('Y-m-d', strtotime($date_to .' +1 day'));
    $next_date_one = $next_date.' 00:00:00';
    $next_date_two = $next_date.' 06:00:00';

    //$get_average_daily_rate_report =   Booking::with('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])->whereBetween('checkin_time', [$today_date_one,$today_date_two])->get(); 

    $get_average_daily_rate_report =  Booking::with('customer','rooms','hotel')->where('hotel_id', $hotel_id)->whereIn('status', ['CheckedIn','CheckedOut'])
    //->whereBetween('checkin_time', [$previous_date_one,$previous_date_two])
    //->orwherebetween('checkin_time', [$next_date_one,$next_date_two])->get();
    ->whereBetween('checkin_time', [$previous_date_one,$previous_date_two])->get();
    //->orwherebetween('checkin_time', [$next_date_one,$next_date_two])->get();

    echo "<pre>";
    var_dump( $get_average_daily_rate_report);
    echo "</pre>";

    die;

    $rooms_count = Room::where('hotel_id', $hotel_id)->count();
    $rooms_occupied =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->where('status', 'CheckedIn')->where('BookingFrom', '<=', $today)->where('BookingTo', '>=', $today)->get()->sum('rooms_count'); 
    $rooms_reserved =  Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['Pending', 'Confirmed'])->where('BookingFrom', '<=', $today)->where('BookingTo', '>=', $today)->get()->sum('rooms_count');
    $rooms_blocked = Room::where('hotel_id', $hotel_id)->where('is_available', 0)->count();
    $rooms_available = $rooms_count - $rooms_occupied - $rooms_reserved - $rooms_blocked;

   
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

    
    

    return response()->json([
        
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


  public function get_receivable_report(Request $request)
  {

    date_default_timezone_set("Asia/Karachi");
    
    //$user_email = 'fahadahmedoptimist@gmail.com';
    //$user_email = $request->email ?? null;
    $user_cnic = $request->cnic ?? null;
        
    $user = User::find(Auth::user()->id);
    $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
    $hotel_id = $hotels[0]->id;
    $hotelName = $hotels[0]->HotelName;
    if(!empty($request['hotel_id'])) {
        $hotel_id = $request['hotel_id'];
        $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
    }

    //$date_from = $request['date_from'];
    //$date_to = $request['date_to'];
    
    $date_from = '2022-02-16';
    $date_to = '2022-02-18';

    // $date_from = strtotime($date_from);
    // $date_to = strtotime($date_to); // or your date as well
         
    $previous_date_one = $date_from.' 06:01';
    $previous_date_two = $date_from.' 23:59';

    $next_date = date('Y-m-d', strtotime($date_to .' +1 day'));
    $next_date_one = $next_date.' 00:00:00';
    $next_date_two = $next_date.' 06:00:00';

    
    $bookings = Booking::with(['hotel','rooms', 'rooms.category','services','invoice', 'promotion','tax_rate', 'invoice.payment_mode'])
    ->where('hotel_id',$hotel_id)
    ->whereIn('status', ['CheckedIn','CheckedOut'])
    ->whereBetween('checkin_time', [$previous_date_one,$next_date_two])  
    ->orderBy('created_at', 'desc')->get();

    if(!empty($bookings)){

      $count = $bookings->count();
      if($count > 0) {

        $bookings_map = $bookings->map(function ($ex) {

          $obj = new stdClass();
          $obj->id = $ex->id;
          $obj->booking_no = $ex->booking_no ?? "";
          $obj->booking_date = $ex->BookingDate ?? "";
          $obj->customer_first_name = $ex->invoice->customer_first_name ?? "";
          $obj->customer_last_name = $ex->invoice->customer_last_name ?? "";
          $obj->HotelName = $ex->hotel->HotelName ?? "";
          $obj->rooms = $ex->rooms->map(function ($room) {
              
              $obj['room_title'] = $room->room_title;
              $obj['RoomNumber'] = $room->RoomNumber;
              $obj['RoomRent'] = $room->RoomCharges;
              return $obj;
          });
          $obj->no_occupants = $ex->no_occupants ?? "";
          $obj->checkin_time = $ex->checkin_time ?? "";
          $obj->checkout_time = $ex->checkout_time ?? "";
          
          $obj->BookingDate = $ex->BookingDate ?? "";
          $obj->BookingFrom = $ex->BookingFrom ?? "";
          $obj->BookingTo = $ex->BookingTo ?? "";
          $obj->net_total = $ex->invoice->net_total ?? "";
          $obj->payment_amount = $ex->invoice->payment_amount ?? "";

          
          
          $obj->status = $ex->status ?? "";
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
  

  
  
  public function get_btc_pending_list(Request $request)
  {

    date_default_timezone_set("Asia/Karachi");
        
    $user = User::find(Auth::user()->id);
    $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
    $hotel_id = $hotels[0]->id;
    $hotelName = $hotels[0]->HotelName;
    if(!empty($request['hotel_id'])) {
        $hotel_id = $request['hotel_id'];
        $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
    }

    //$date_from = $request['date_from'];
    //$date_to = $request['date_to'];
    
    $date_from = '2022-02-16';
    $date_to = '2022-02-18';
         
    $previous_date_one = $date_from.' 06:01';
    $previous_date_two = $date_from.' 23:59';

    $next_date = date('Y-m-d', strtotime($date_to .' +1 day'));
    $next_date_one = $next_date.' 00:00:00';
    $next_date_two = $next_date.' 06:00:00';

    
    $bookings = Booking::whereHas('invoice', function ($q1) {    
      $q1->whereNotNull('corporate_type');
    })->with(['hotel','rooms', 'rooms.category','services','invoice','tax_rate','created_by_user'])
    ->where('hotel_id',$hotel_id)
    ->whereIn('status', ['CheckedIn','CheckedOut'])
    ->whereBetween('checkin_time', [$previous_date_one,$next_date_two])  
    ->orderBy('created_at', 'desc')->get();

  
    if(!empty($bookings)){

      $count = $bookings->count();
      if($count > 0) {

        $bookings_map = $bookings->map(function ($ex) {

          $obj = new stdClass();
          $obj->id = $ex->id;
          $obj->booking_no = $ex->booking_no ?? "";
          $obj->booking_date = $ex->BookingDate ?? "";
          $obj->corporate_client_name = $ex->invoice->corporate_client_name ?? "";
          $obj->customer_first_name = $ex->invoice->customer_first_name ?? "";
          $obj->customer_last_name = $ex->invoice->customer_last_name ?? "";
          $obj->HotelName = $ex->hotel->HotelName ?? "";
          $obj->rooms = $ex->rooms->map(function ($room) {
              
              $obj['room_title'] = $room->room_title;
              $obj['RoomNumber'] = $room->RoomNumber;
              $obj['RoomRent'] = $room->RoomCharges;
              return $obj;
          });
          $obj->no_occupants = $ex->no_occupants ?? "";
          $obj->checkin_time = $ex->checkin_time ?? "";
          $obj->checkout_time = $ex->checkout_time ?? "";
          
          $obj->BookingDate = $ex->BookingDate ?? "";
          $obj->BookingFrom = $ex->BookingFrom ?? "";
          $obj->BookingTo = $ex->BookingTo ?? "";
          $obj->net_total = $ex->invoice->net_total ?? "";
          $obj->payment_amount = $ex->invoice->payment_amount ?? "";


          if($ex->invoice->corporate_type != null){
            if($ex->invoice->corporate_type == 1 ){
              $obj->btc_type = "Full Board";
             
            }
            elseif($ex->invoice->corporate_type == 2){
              $obj->btc_type = "Half Board";
              
            }
            elseif($ex->invoice->corporate_type == 3){
              $obj->btc_type = "Room Only";

            }
            
          }
          else {
            $obj->btc_type = null;  
          }

          $obj->user_name = $ex->created_by_user->name ?? "";
          $obj->status = $ex->status ?? "";
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



  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */

  public function get_invoice_search($id) {

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


  


}