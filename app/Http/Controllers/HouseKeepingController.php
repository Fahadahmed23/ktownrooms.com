<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Customer;
use App\Models\Department;
use App\Models\Service;
use App\Models\CustomerComplain;
use App\Models\BookingService;
use App\Models\BookingInvoice;
use App\Models\RoomService;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HouseKeepingController extends Controller
{
    protected $module_name = "HouseKeeping";
    protected $user_authenticated;

    /**
     * Display base page for services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code)
    {
        $booking_code = decrypt($code);
        $booking = Booking::with(['customer','rooms'])->where('booking_no', $booking_code)->first();
        $status = array("Cancelled", "CheckedOut", "Pending" , "Confirmed");
        if (in_array($booking->status, $status))
        {
            return view('housekeeping.after_check_out', compact('booking'));
        }
        else{
            return view('housekeeping.index', compact('code'));
        }
    }

    public function getBookingServices()
    {
        
        if (Auth::check()) {
            $user = Auth::user();
            $hotel_id = $user->hotel_id;
            $booking_services = BookingService::where('status', 'awaiting')->with(['booking'  => function($query) use ($hotel_id) {
                $query->where('hotel_id', '=', $hotel_id);}])
                ->select(['booking_service.id','booking_service.icon_class','booking_service.service_name','booking_service.serving_time' ,'booking_service.department_name'])->get();
                // dd($booking_services);
            return response()->json([
                'booking_services' => $booking_services,
            ]);
        }
       
    }

    public function getBooKingServiceCount()
    {
        if (Auth::check()) {
        $user = Auth::user();
        $hotel_id = $user->hotel_id;
        $booking_services_count = BookingService::where('status', 'awaiting')->with(['booking'  => function($query) use ($hotel_id) {
            $query->where('hotel_id', '=', $hotel_id);}])->get()->count();

        return response()->json([
            'booking_services_count' => $booking_services_count,
        ]);
    }
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getCustomer($code)
    {
        $booking_code = decrypt($code);
        $booking = Booking::with(['customer', 'rooms', 'rooms.services'])->where('booking_no', $booking_code)->first();
        $hotel_id = $booking->hotel_id;

        $department_ids = Service::join('room_services','services.id','room_services.service_id')
        ->where('services.hotel_id', $hotel_id)
        // ->where('room_services.room_id',$booking->rooms[0]->id)
        ->orderBy('services.id', 'asc')->distinct()->pluck('department_id');

        if (Auth::check()) {
            // $departments = Department::get();
            $departments = Department::whereIn('id', $department_ids)->get();
        } else {
            // $departments = Department::where('IsClientService',1)->get();
            $departments = Department::where('IsClientService',1)->whereIn('id', $department_ids)->get();
        }

        $services= Service::get();
        $cutomers_complains= CustomerComplain::with('status')->where('booking_id', $booking->id)->orderBy('ComplainTime', 'DESC')->get();
        $booking_service = BookingService::with(['room'])->where('booking_id', $booking->id)->orderBy('id', 'DESC')->get();

        return response()->json([
            'cutomers_complains'=>$cutomers_complains,
            'services'=>$services,
            'departments'=>$departments,
            'booking'=>$booking,
            'booking_service'=>$booking_service,
            
        ]);
    }


    public function saveComplain(Request $request)
    {
        $complainExist =CustomerComplain::where('subject',$request['housekeeping']['subject'])->where('subject','!=','Other')->where('booking_id', $request->booking_id)
        ->first();
        if (empty($complainExist)) 
        { 
            //    dd(Booking::where('id', $request->booking_id)->pluck('hotel_id')[0]);
            $customer_complain= new CustomerComplain();
            $customer_complain->customer_id = $request->customer_id;
            $customer_complain->booking_id = $request->booking_id;
            $customer_complain->hotel_id = Booking::where('id', $request->booking_id)->pluck('hotel_id')[0]; 
            $customer_complain->room_id = $request['housekeeping']['room_id'];
            $customer_complain->subject = $request['housekeeping']['subject'];
            if (!empty($request['housekeeping']['complain'])) {
                $customer_complain->message = $request['housekeeping']['complain'];
            }
            $customer_complain->ComplainTime =  date('Y-m-d H:i:s a');
            $customer_complain->ResolveTime =  date('Y-m-d 23:23:59');
            $customer_complain->save();
            $customer_complain = CustomerComplain::with(['status'])->find($customer_complain->id);
        
            return response()->json([
                'success' => true,
                'message' => ["Dear, '$request->customerName' complain '$customer_complain->complain_code' has been recieved to concern department"],
                'msgtype' => 'success',
                'complain'=>$customer_complain,
            ]);
        }
        else{
        return response()->json([
            'success' => false,
            'message' => ["Dear, '$request->customerName' complain '".$complainExist['complain_code']."' already recieved to concern department"],
            'msgtype' => 'danger',
            'complain'=>$complainExist,
        ]);
    }


    }


    public function getDeptServices(Request $request, $id)
    {

        $department_services= Service::join('room_services','services.id','room_services.service_id')
        ->where('services.hotel_id', $request->hotel_id)
        // ->where('room_services.room_id',$request->room_id)
        ->where('services.department_id', $id)
        ->orderBy('services.id', 'asc')
        ->distinct()
        ->get([
            'Charges', 'IconPath', 'IsQuantitative', 'IsShowDelayAlert', 'Service', 'ServingTime', 'department_id', 'services.id', 'service_start_time', 'service_end_time', 'service_type_id', \DB::raw('0 as availed')
        ]);

        // $department_services= Service::where('department_id', $id)->where('hotel_id', $request->hotel_id)->orderBy('id', 'asc')->get([
        //     'Charges', 'IconPath', 'IsQuantitative', 'IsShowDelayAlert', 'Service', 'ServingTime', 'department_id', 'id', 'service_start_time', 'service_end_time', 'service_type_id', \DB::raw('0 as availed')
        // ]);
        // dd($department_services);

        $booking_services = BookingService::where([
            ['booking_id', '=', request()->booking_id],
            ['room_id', '=', request()->room_id],
            ['department_id', '=', $id],
            ['created_at', '>=', date('Y-m-d') . ' 00:00:00'],
            ['created_at', '<=', date('Y-m-d') . ' 23:59:00']
        ])->orderBy('service_id', 'asc')
        ->groupBy('service_id')->get(['service_id', \DB::raw('SUM(times) as availed')]);

        $i = $j = 0;

        for (;$i < count($department_services) && $j < count($booking_services);) {
            if ($department_services[$i]->id == $booking_services[$j]->service_id) {
                $department_services[$i++]->availed = $booking_services[$j++]->availed;
            } else {
                $i++;
            }
        }

        return response()->json([
            'department_services' => $department_services
        ]);
    }

    public function saveRequest(Request $request)
    {
        //  dd($request->all());

        $booking = Booking::find($request->service_request['booking_id']);
        
        // $invoice = BookingInvoice::where('booking_id', $request->service_request['booking_id'])->first();
        
        \DB::beginTransaction();
        if (!empty($request->service_request['services'])) 
        {
            //  dd($request->service_request['services']);
            try {
                foreach ($request->service_request['services'] as $service) {
                    
                    $bs = new BookingService();
                    // DB::rollback();
                    // dd(!empty($service['is_other']));
                    if (!empty($service['is_other'])) {
                        $bs->booking_id = $request->service_request['booking_id'];
                        $bs->room_id = $request->service_request['room_id'];
                        $bs->service_name = $service['Service'];
                        $bs->amount = $service['amount'];
                        $bs->excludes = 1;
                    } else {
                        $bs->booking_id = $request->service_request['booking_id'];
                        $bs->service_id = $service['id'];
                        $bs->department_id = $service['department_id'];
                        $bs->department_name = Department::where('id', $service['department_id'])->pluck('Department')[0];
                        $bs->status = 'awaiting';
                        $bs->service_name = $service['Service'];
                        $bs->service_charges = $service['Charges'];
                        $bs->start_time = $service['service_start_time'];
                        $bs->end_time = $service['service_end_time'];
                        $bs->serving_time = $service['ServingTime'];
                        $bs->times = $service['times'];
                        $bs->includes = $service['includes'];
                        $bs->excludes = $service['excludes'];
                        $bs->amount = $service['amount'];
                        $bs->icon_class = $service['IconPath'];
                        $bs->room_id = $request->service_request['room_id'];
                    }

                    $bs->save();

                    // $invoice->total += $bs->amount;
                    // $invoice->net_total += $bs->amount;

                    $bs = BookingService::with(['room'])->find($bs->id);
                }

                // $invoice->save();

                \DB::commit();
            } catch (\Exception $e) {
                dd($e);
                DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => ['Internal Server Error'],
                    'msgtype' => 'error'
                ]);
            }

            $n = count($request->service_request['services']);
            return response()->json([
                'success' => true,
                'message' => [$n . ' Services requested successfully for Booking (' . $booking->booking_no . ')'],
                'msgtype' => 'success',
                'booking_service' => $bs
            ]);
        } 
       else{
        return response()->json([
        'success' => false,
        'message' => ['Please add services before launching request'],
        'msgtype' => 'danger',
        ]);

       }  
        

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
        // dd($bs->status =='reject');
        $bs->cancel_reason = $request->cancel_reason;
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


