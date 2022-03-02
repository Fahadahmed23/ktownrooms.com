<?php
// Mr Optimist 14 Jan 2022
namespace App\Http\Controllers;

use App\Models\AccountGeneralLedger;
use App\Models\OpeningShiftHandover;
use App\Models\Permission;
use App\Models\ShiftHandover;
use App\Models\VoucherDetail;
use App\Models\VoucherMaster;
use App\Models\UserHotel;



// use Illuminate\Support\Facades\Storage;

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
    $user = User::find(Auth::user()->id);
    $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
    $hotel_id = $hotels[0]->id;
    $hotelName = $hotels[0]->HotelName;
    if(!empty($request['hotel_id'])) {
        $hotel_id = $request['hotel_id'];
        $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
    }

    $get_cash_flow_arr = array();

    $date_from = "2022-03-01";
    $date_to = "2022-03-02";

    $date_from_dt = new DateTime($date_from);
    $date_to_dt = new DateTime($date_to);

    //$date_from = $request['date_from'];
    //$date_to = $request['date_to'];

    $user_ids_hotels = UserHotel::where('hotel_id',$hotel_id)->pluck('user_id');
     
    for($date = $date_from_dt; $date <= $date_to_dt; $date->modify('+1 day')) {
      
      //echo $date->format(DateTime::ATOM);
      //date("Y-m-d H:i");
      $loop_date = date_format($date,"Y-m-d");

      
      // $receiving_date = $request->receiving_date;
      $date_one = $loop_date.' 06:01:00';
      $date_two = $loop_date.' 23:59:00';

      $next_date = date('Y-m-d', strtotime($loop_date .' +1 day'));

      $date_one_next = $next_date.' 00:00';
      $date_two_next = $next_date.' 06:00';

      

      $rooms_occupied_total = 0;
      $rooms_total_revenue = 0;
      $rooms_adr = 0;
   

      $bookings = Booking::with(['hotel','rooms', 'rooms.category','services','invoice','tax_rate','created_by_user'])
      ->where('hotel_id',$hotel_id)
      ->whereIn('status', ['CheckedIn','CheckedOut'])
      ->whereBetween('checkin_time', [$date_one,$date_two_next])  
      ->orderBy('created_at', 'desc')->get();

      $rooms_occupied =  Booking::with(['rooms'])->where('hotel_id', $hotel_id)
                        ->whereIn('status', ['CheckedIn','CheckedOut'])
                        ->whereBetween('checkin_time',[$date_one,$date_two_next])
                        ->get();


      // Bookings Mapping
      if(!empty($rooms_occupied)){

        $count = $rooms_occupied->count();
        $rooms_occupied_total = $count;
        
        if($count > 0) {

          $bookings_map = $rooms_occupied->map(function ($ex) {

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
        
            $obj->checkin_time = $ex->checkin_time ?? "";
            $obj->checkout_time = $ex->checkout_time ?? "";
            
            $obj->BookingDate = $ex->BookingDate ?? "";
            $obj->BookingFrom = $ex->BookingFrom ?? "";
            $obj->BookingTo = $ex->BookingTo ?? "";
            $obj->net_total = $ex->invoice->net_total ?? "";
            $obj->payment_amount = $ex->invoice->payment_amount ?? "";

            $obj->user_name = $ex->created_by_user->name ?? "";
            $obj->status = $ex->status ?? "";
            return $obj;
          
          });

          $bookings_exec = $bookings_map;


      
        }
        else {

          $rooms_occupied_total = 0;
          $rooms_total_revenue = 0;
          $rooms_adr = 0;

          $bookings_exec = [];

        } 

      }
      else {
        $rooms_occupied_total = 0;
        $rooms_total_revenue = 0;
        $rooms_adr = 0;

        $bookings_exec = [];

      }

      if(count($bookings_exec) > 0){
        foreach($bookings_exec as $booking_exec){

          if(isset($booking_exec->rooms)){  
            $rooms_total_revenue += $booking_exec->rooms[0]["RoomRent"];
          }  
        }
      }


      $rooms_adr = $rooms_total_revenue/$rooms_occupied_total;
      $get_cash_flow_arr[] = array(
        'Date' => $loop_date,
        'Rooms Occupied' => $rooms_occupied_total,
        'Total Revenue' => $rooms_total_revenue,
        'Average Daily Report (ADR)' => $rooms_adr
      );  
    }

    $get_average_daily_rate_report = array(
      $get_cash_flow_arr
    );


    /*
    $get_average_daily_rate_report = response()->json([
      'Opening Balance' => $user_opening_balance,
      'bookings' => $bookings_exec,
      'Expense Details' => $vouchers_exec,
      'Closing Balance' => $closing_balance
    ])->setEncodingOptions(JSON_NUMERIC_CHECK);

    **/
    
 
    echo "<pre>";
    var_dump( $get_average_daily_rate_report);
    echo "</pre>";
    die;


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


 


  public function get_cash_flow_report(Request $request) {
    
    date_default_timezone_set("Asia/Karachi");

    $user = User::find(Auth::user()->id);
    $hotels = auth()->user()->user_hotels()->get(['id','HotelName']);
    $hotel_id = $hotels[0]->id;
    $hotelName = $hotels[0]->HotelName;
    if(!empty($request['hotel_id'])) {
        $hotel_id = $request['hotel_id'];
        $hotelName = Hotel::where('id',$request['hotel_id'])->pluck('HotelName');
    }

    $get_cash_flow_arr = array();

    $date_from = "2022-03-01";
    $date_to = "2022-03-02";

    $date_from_dt = new DateTime($date_from);
    $date_to_dt = new DateTime($date_to);

    //$date_from = $request['date_from'];
    //$date_to = $request['date_to'];

    $user_ids_hotels = UserHotel::where('hotel_id',$hotel_id)->pluck('user_id');
     
    for($date = $date_from_dt; $date <= $date_to_dt; $date->modify('+1 day')) {
      
      //echo $date->format(DateTime::ATOM);
      //date("Y-m-d H:i");
      $loop_date = date_format($date,"Y-m-d");

      
      // $receiving_date = $request->receiving_date;
      $date_one = $loop_date.' 06:01:00';
      $date_two = $loop_date.' 23:59:00';

      $next_date = date('Y-m-d', strtotime($loop_date .' +1 day'));

      $date_one_next = $next_date.' 00:00';
      $date_two_next = $next_date.' 06:00';

      
      // Opening Balance
      $user_opening_balance = 0;

      // Cashout Balance
      $cashout = 0;

      // Cashout Work    
      $created_by_ids = $this->getIncludedVouchers();

      // closing balance
      $closing_balance = 0;

      $u = OpeningShiftHandover::whereIn('user_id',$user_ids_hotels)
      ->whereBetween('created_at',[$date_one,$date_two_next])
      ->orderBy('id','desc')->get();

      $user_opening_balance = count($u)>0 ? $u[0]['opening_balance'] : 0;

      $bookings = Booking::with(['hotel','rooms', 'rooms.category','services','invoice','tax_rate','created_by_user'])
      ->where('hotel_id',$hotel_id)
      ->whereIn('status', ['CheckedIn','CheckedOut'])
      ->whereBetween('checkin_time', [$date_one,$date_two_next])  
      ->orderBy('created_at', 'desc')->get();

      // Cashout Work
      $voucher_master = VoucherMaster::where('hotel_id', $hotel_id)
      ->with(['voucher_details' => function($q) {
          // $q->where('account_gl_id', $receive_account_id)->where('is_concile',0);

            $q->where('cr_amount', '>',  0);
            $q->orderBy('id','desc');
            $q->get();
            
            //$q->orderBy('id','desc')->limit(1);
        
          }])      
        ->with(['post_user'])
        //->whereIn('CreatedBy', $created_by_ids)
        ->whereBetween('created_at', [$date_one,$date_two_next]) 
        ->get();

      // Bookings Mapping
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
        
            $obj->checkin_time = $ex->checkin_time ?? "";
            $obj->checkout_time = $ex->checkout_time ?? "";
            
            $obj->BookingDate = $ex->BookingDate ?? "";
            $obj->BookingFrom = $ex->BookingFrom ?? "";
            $obj->BookingTo = $ex->BookingTo ?? "";
            $obj->net_total = $ex->invoice->net_total ?? "";
            $obj->payment_amount = $ex->invoice->payment_amount ?? "";

            $obj->user_name = $ex->created_by_user->name ?? "";
            $obj->status = $ex->status ?? "";
            return $obj;
          
          });

          $bookings_exec = $bookings_map;
          //$bookings_exec = [];

      
        }
        else {

          $bookings_exec = [];

        

        } 

      }
      else {
        $bookings_exec = [];

      }

      // Vouchers Mappings
      if(!empty($voucher_master)){
        $count = $voucher_master->count();
        if($count > 0) {

          $vouchers_map = $voucher_master->map(function ($ex) {

            $obj = new stdClass();
            $obj->id = $ex->id;
            $obj->voucher_type_id = $ex->voucher_type_id ?? "";
            $obj->description = $ex->description ?? "";
            $obj->created_at = $ex->created_at ?? "";
            $obj->voucher_details = $ex->voucher_details->map(function($voucher_detail) {

              $obj['cr_amount'] = ($voucher_detail->cr_amount > 0) ? $voucher_detail->cr_amount:0;
              return $obj;
            
            });
            $obj->post_user = $ex->post_user->name ?? "";
            return $obj;
          
          });

          $vouchers_exec = $vouchers_map;
          
        }
        else {
          $vouchers_exec = [];
        } 
      }
      else {
        $vouchers_exec = [];
      }


      if(count($vouchers_exec) > 0){
          foreach($vouchers_exec as $voucher_exec){

            if(isset($voucher_exec->voucher_details)){
              //var_dump($voucher_exec->voucher_details[0]["cr_amount"]);
              $cashout += $voucher_exec->voucher_details[0]["cr_amount"];
          
            }  
          }
      }

    
      // closing balance
      $closing_balance = $user_opening_balance-$cashout;


      $get_cash_flow_arr[] = array(
        'Date' => $loop_date,
        'Opening Balance' => $user_opening_balance,
        'bookings' => $bookings_exec,
        'Expense Details' => $vouchers_exec,
        'Closing Balance' => $closing_balance,
      );

  
    }


    
    
    $whole_response = array(
      $get_cash_flow_arr
    );


    /*
    $whole_response = response()->json([
      'Opening Balance' => $user_opening_balance,
      'bookings' => $bookings_exec,
      'Expense Details' => $vouchers_exec,
      'Closing Balance' => $closing_balance
    ])->setEncodingOptions(JSON_NUMERIC_CHECK);

    **/
    
 
    echo "<pre>";
    var_dump($whole_response);
    echo "</pre>";
    die();

  }


  public function get_revenue_par_report(Request $request)
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

    $get_cash_flow_arr = array();

    $date_from = "2022-03-01";
    $date_to = "2022-03-02";

    $date_from_dt = new DateTime($date_from);
    $date_to_dt = new DateTime($date_to);

    //$date_from = $request['date_from'];
    //$date_to = $request['date_to'];


     
    for($date = $date_from_dt; $date <= $date_to_dt; $date->modify('+1 day')) {
      
      $loop_date = date_format($date,"Y-m-d");

      
      // $receiving_date = $request->receiving_date;
      $date_one = $loop_date.' 06:01:00';
      $date_two = $loop_date.' 23:59:00';

      $next_date = date('Y-m-d', strtotime($loop_date .' +1 day'));

      $date_one_next = $next_date.' 00:00';
      $date_two_next = $next_date.' 06:00';

      

      $rooms_occupied_total = 0;
      $rooms_total_revenue = 0;
      $rooms_adr = 0;
   

      $rooms_occupied =  Booking::with(['rooms'])
                         ->where('hotel_id', $hotel_id)
                        ->whereIn('status', ['CheckedIn','CheckedOut'])
                        ->whereBetween('checkin_time',[$date_one,$date_two_next])
                        ->get();


      $rooms_count =      Room::where('hotel_id', $hotel_id)->count();
      $rooms_occupiedd =  $rooms_occupied->count(); 
      $rooms_reserved =   Booking::withCount('rooms')->where('hotel_id', $hotel_id)->whereIn('status', ['Pending', 'Confirmed'])->where('BookingFrom', '<=', $date_one)->where('BookingTo', '>=', $date_two_next)->get()->sum('rooms_count');
      $rooms_blocked =    Room::where('hotel_id', $hotel_id)->where('is_available', 0)->count();
      $rooms_available = $rooms_count - $rooms_occupiedd - $rooms_reserved - $rooms_blocked;

      


      // Bookings Mapping
      if(!empty($rooms_occupied)){

        $count = $rooms_occupied->count();
        $rooms_occupied_total = $count;
        
        if($count > 0) {

          $bookings_map = $rooms_occupied->map(function ($ex) {

            $obj = new stdClass();
            $obj->id = $ex->id;
            $obj->booking_no = $ex->booking_no ?? "";
            $obj->booking_date = $ex->BookingDate ?? "";
            $obj->rooms = $ex->rooms->map(function ($room) {
                
                $obj['room_title'] = $room->room_title;
                $obj['RoomNumber'] = $room->RoomNumber;
                $obj['RoomRent'] = $room->RoomCharges;
                return $obj;
            });
      
            return $obj;
          
          });

          $bookings_exec = $bookings_map;


      
        }
        else {

          $rooms_occupied_total = 0;
          $rooms_total_revenue = 0;
          $rooms_adr = 0;

          $bookings_exec = [];

        } 

      }
      else {
        $rooms_occupied_total = 0;
        $rooms_total_revenue = 0;
        $rooms_adr = 0;

        $bookings_exec = [];

      }

      if(count($bookings_exec) > 0){
        foreach($bookings_exec as $booking_exec){

          if(isset($booking_exec->rooms)){  
            $rooms_total_revenue += $booking_exec->rooms[0]["RoomRent"];
          }  
        }
      }


      $rooms_rpr = $rooms_total_revenue/$rooms_available;
      $get_cash_flow_arr[] = array(
        'Date' => $loop_date,
        'Rooms Available' => $rooms_available,
        'Total Revenue' => $rooms_total_revenue,
        'Revenue Par Report' => $rooms_rpr
      );  
    }

    $get_revenue_par_report = array(
      $get_cash_flow_arr
    );


    /*
    $get_average_daily_rate_report = response()->json([
      'Opening Balance' => $user_opening_balance,
      'bookings' => $bookings_exec,
      'Expense Details' => $vouchers_exec,
      'Closing Balance' => $closing_balance
    ])->setEncodingOptions(JSON_NUMERIC_CHECK);

    **/
    
 
    echo "<pre>";
    var_dump($get_revenue_par_report);
    echo "</pre>";
    die;


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


  public function getIncludedVouchers(){
    $user = auth()->user();
    $v =  VoucherMaster::select('CreatedBy')->distinct('CreatedBy')->get();
        $created_by_ids = [];
        foreach ($v as $key => $value) {
            $userHasRole = User::where('id', $value->CreatedBy)
            ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', '=', 'Frontdesk');
                })
                ->first();
                if($userHasRole){
                    $created_by_ids[] = $userHasRole['id'];
                }
        }
        $created_by_ids[] = $user->id;
        return $created_by_ids;
  }
  

}