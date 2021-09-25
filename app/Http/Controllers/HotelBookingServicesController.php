<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingService;
use App\Models\Hotel;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HotelBookingServicesController extends Controller
{
    protected $module_name = 'Hotel Booking Services Management';

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
        return view ('hotel_booking_services.index', [
            'breadcrumb' => 'Hotel Booking Services Management'
        ]);
    }
    public function getData(Request $request)
    {
        $is_admin = true;
        if (!auth()->user()->hasRole('Admin')) {
            $is_admin = false;
            $hotel_id = auth()->user()->hotel_id;
        }
        if (empty($request->status) && $is_admin) {
            $hotelbookingservices = BookingService::all();
        } else if (empty($request->status) && !$is_admin) {
            $hotelbookingservices = BookingService::whereHas('booking', function($q) use ($hotel_id){
                $q->where('hotel_id', $hotel_id);
            })->get();
        } else {  
            if(!$is_admin){
                $hotelbookingservices = BookingService::whereHas('booking', function($q) use ($hotel_id){
                    $q->where('hotel_id', $hotel_id);
                })
                ->where('status', $request->status)->get();
            } else {

                $hotelbookingservices = BookingService::where('status', $request->status)->get();
            }
        }
        $user = Auth::user();
        return response()->json([
            'hotelbookingservices' => $hotelbookingservices,
            'user'=>$user,
        ]);
    }
    public function getHotels()
    {
        $hotels = Hotel::all();
        return response()->json([ 
            'hotels' => $hotels,
        ]);
    }

    public function getFilterData(Request $request)
    {
        $hotel_id = $request->hotel_id;
        $query ="SELECT booking_service.* , bookings.booking_no as BookingNo
        FROM
        `booking_service` 
            INNER JOIN `bookings` 
            ON `booking_service`.`booking_id` = `bookings`.`id` 
            WHERE `bookings`.`status` = 'CheckedIn'
            AND `bookings`.`hotel_id` = $hotel_id";

        $data = DB::select($query);

        return response()->json([
            'hotelbookingservices' => $data,
        ]);
    }

    public function acceptRejectBookingService(Request $request)
    {   
        $bs = BookingService::find($request->service_id);

        if ($bs->status == 'awaiting') {
            $bs->status = $request->action;
            $bs->save();
            return response()->json([
                'success' => true,
                'message' => [$bs->service_name.' '.$request->action.' successfully of your booking'],
                'msgtype' => 'success',
                'booking_service' => $bs
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ['Your'.$bs->service_name .' cannot be '.$request->action],
                'msgtype' => 'error',
               
                ]);
        }
       
    }

    public function cancelBookingService(Request $request)
    {   
        // dd($request->all());
        $bs = BookingService::find($request->service_id);
        // dd($bs);
        $bs->cancel_reason = $request->reason;
        $bs->status = 'cancelled';
        $bs->save();

        return response()->json([
            'success' => true,
            'message' => [$bs->service_name.' cancelled successfully of your booking'],
            'msgtype' => 'success',
            'booking_service' => $bs
        ]);

    }

}
