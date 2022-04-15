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
use App\Models\InvoiceDetail;
use App\Models\RoomService;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class HouseKeepingController extends Controller
{
    protected $module_name = "HouseKeeping";
    protected $user_authenticated;

    public function order_confirmation($invoice_number, Request $request){	
        $blinq_log = \DB::table('blinq_logs')
        ->where('InvoiceNumber', $invoice_number)
        ->update(['PaymentResponse'=>json_encode($request->all())]);	
        $invoice_detail = InvoiceDetail::where('invoice_no', $request->ordId)->first();	
        $booking = Booking::where('id', $invoice_detail->booking_id)->first();	
        $booking_code = $booking->booking_code;	
        try {	
            	
            if($request->status == 'success'){	
                $invoice_detail->update(['is_archive'=> 0]);	
                $invoice_detail->where('type', 'payment')->sum('amount');	
                	
                $invoice = BookingInvoice::where('booking_id', $booking->id)->first();	
                $old_payment = $invoice->payment_amount;	
                $blinq_log = \DB::table('blinq_logs')->where('invoice_detail_id', $invoice_detail->id)->first();	
                $new_payment = $old_payment + $blinq_log->InvoiceAmount;	
                $invoice->update(['payment_amount'=>$new_payment]);	
                	
                return redirect('/cportal/'.$booking_code.'?success');	
            } else {	
                return redirect('/cportal/'.$booking_code.'?failure');	
            }	
        } catch (\Exception $e) {	
            // dd($e);	
            $invoice_detail->delete();	
            return redirect('/cportal/'.$booking_code.'?failure');	
        }	
    }
    
    /**
     * Display base page for services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($code)
    {
        // $booking_code = decrypt($code);
        $booking_code = $code;
        $booking = Booking::with(['customer','rooms'])->where('booking_code', $booking_code)->first();
        // $status = array("Cancelled", "CheckedOut", "Pending" , "Confirmed");
        $status = array("Cancelled", "CheckedOut", "Pending" ,"Confirmed");

        if (in_array($booking->status, $status))
        {
            if($booking->status == 'Confirmed' && $booking->BookingFrom>date('Y-m-d')){
                    // dd("yesss");
                    return view('housekeeping.index', compact('code'));
            }
            else{
                return view('housekeeping.after_check_out', compact('booking'));
            }
        }
        else{
            return view('housekeeping.index', compact('code'));
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
            }
        }
        if(isset($token)){
            return response()->json(['success'=>true, 'token'=>$token] );
            // dd($token, 'create Invoice');
        } else {
            $message = 'Authentication Failed';
            return response()->json(['success'=>false, 'message'=>$message] );

            return false;
        }
            
            
    }

    public function createBlinqInvoice($token, $invoiceDetail, $customer){
        $data = '[{"InvoiceNumber":"'.$invoiceDetail->invoice_no.'", "InvoiceAmount": "'.intval($invoiceDetail->amount).'", "InvoiceDueDate":"'.date('Y-m-d').'", "InvoiceType":"Booking", "IssueDate":"'.date('Y-m-d').'", "CustomerName":"'.$customer->FirstName.'"}]';
        // dd($data);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api.blinq.pk/invoice/create/");
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER,array(
                            "Content-Type:application/json",
                            "token:".$token)
                );
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt ($ch, CURLOPT_SSL_VERIFYPEER, 0);  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
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
                    
                    $blinq_logs = [
                      'invoice_detail_id' => $invoiceDetail->id,
                      'InvoiceNumber' => $response[0]->InvoiceNumber,
                      'PaymentCode' => $response[0]->PaymentCode,
                      'InvoiceAmount' => $response[0]->InvoiceAmount,
                      'TranFee' => $response[0]->TranFee,
                      'ResponseDetail' => json_encode($response[0]),
                    ];
                    // dd(json_encode($response[0]), $blinqIntegrationData);
                    \DB::table('blinq_logs')->insert($blinq_logs);
                    // return true;
                    return response()->json([
                                    'success' => true,
                                    'data' => $response[0]
                                ]);
                }
                else {
                    return response()->json([
                                    'success' => false,
                                    'message' => isset($result->ResponseDetail) ? $result->ResponseDetail[0]->Description: $result->Message
                                ]);
                }
            } else{
                 return response()->json([
                                    'success' => false,
                                    'message' => 'Invoice creation failed due to something went wrong'
                                ]);
                // return false;
            }
        }
    }

    public function blinqPayment(Request $request)
    {
        $booking = Booking::find($request->booking_id);
        $booking_no = $booking->booking_no;

        DB::beginTransaction();
        $createInvoiceDetail = InvoiceDetail::create([
            'title' => 'partial_payment',
            'type' => 'payment',
            'payment_type_id' => '3',
            'payment_detail' => 'Via blinq payment',
            'booking_id' => $request->booking_id,
            'booking_no' => $booking_no,
            'amount' => $request->balance_payable,
            'is_archive' => 1,
        ]);

        
        $createInvoiceDetail->refresh(); 

        $token = $this->makeAuthentication();
        $content = $token->getContent();
        $array = json_decode($content, true);
        if(!$array['success']){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => [$array['message']],
                'msgtype' => 'danger',
            ]);
        } else {
          $token = $array['token'];
        }

        $blinqInvoice = $this->createBlinqInvoice($token, $createInvoiceDetail, $booking->customer);
        
        $content = $blinqInvoice->getContent();
        $array = json_decode($content, true);
        if(!$array['success']){
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => [$array['message']],
                'msgtype' => 'danger',
            ]);
        } else {
            // dd($array['data']->PaymentCode);
            $ClientID = 'ligqexD4gC2oCqR';
            $PaymentCode = $array['data']['PaymentCode'];
            $OrderID = $array['data']['InvoiceNumber'];
            $ReturnURL = 'https://partners.ktownrooms.com/order-confirmation/'.$OrderID;
            $ClientSecret = 'LIbudKrmkN8oQNl';
            
            // $userDataPattern = 'ligqexD4gC2oCqR00582125600006RGP0010821831https://www.staging.ktownrooms.com/order-confirmationLIbudKrmkN8oQNl';
            $userDataPattern = $ClientID . $PaymentCode. $OrderID. $ReturnURL. $ClientSecret;
            $sha = hash('sha256', $userDataPattern);
            $encrypted_form_data = md5($sha);
            DB::commit();
            return response()->json([
                'success' => true,
                'blinq_data' => $array['data'],
                'encrypted_form_data' => $encrypted_form_data,
            ]);
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
        // $booking_code = decrypt($code);
        $booking_code = $code;
        $booking = Booking::with(['customer', 'rooms', 'rooms.services','hotel:id,HotelName','invoice'])->where('booking_code', $booking_code)->first();
        $hotel_id = $booking->hotel_id;

        $department_ids = Service::
        // join('room_services','services.id','room_services.service_id')
        where('services.hotel_id', $hotel_id)
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

        if($booking->status == 'Confirmed' && $booking->BookingFrom>date('Y-m-d')){
            $services = [];
            $cutomers_complains=[];
            $booking_service=[];
            $departments =[];
        }

        // date conversion
        // dd($booking->checkin_date );
        $checkInTime = date('d/m/Y h:i a',  strtotime($booking->checkin_time));
        return response()->json([
            'cutomers_complains'=>$cutomers_complains,
            'services'=>$services,
            'departments'=>$departments,
            'booking'=>$booking,
            'booking_service'=>$booking_service,
            'checkInTime'=>$checkInTime,
            
        ]);
    }


    public function saveComplain(Request $request)
    {
        $booking = Booking::where('id',$request->booking_id)->first(['status','BookingFrom']);

        if($booking->status == 'Confirmed' && $booking->BookingFrom>date('Y-m-d')){
            return response()->json([
                'success' => false,
                'message' => ["You are not allowed to perform this action before checkin!"],
                'msgtype' => 'danger',
            ]);
           
        }

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
            $customer_complain->ComplainTime =  date('Y-m-d H:i:s');
            // $customer_complain->ResolveTime =  date('Y-m-d 23:23:59');
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
        $booking = Booking::where('id',request()->booking_id)->first(['status','BookingFrom']);
        if($booking->status == 'Confirmed' && $booking->BookingFrom > date('Y-m-d')){
            return response()->json([
                'success' => false,
            ]);
        }
        else{
            $department_services= Service::
            // join('room_services','services.id','room_services.service_id')
            where('services.hotel_id', $request->hotel_id)
            // ->where('room_services.room_id',$request->room_id)
            ->where('services.department_id', $id)
            ->orderBy('services.id', 'asc')
            ->distinct()
            ->get([
                'Charges', 'IconPath', 'IsQuantitative', 'IsShowDelayAlert', 'Service', 'ServingTime', 'department_id', 'services.id','is_24hrs', 'service_start_time', 'service_end_time', 'service_type_id', \DB::raw('0 as availed')
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
                'success' => true,
                'department_services' => $department_services
            ]);

        }
       
    }

    public function saveRequest(Request $request)
    {
        //  dd($request->all());

        $booking = Booking::find($request->service_request['booking_id']);
        if($booking->status == 'Confirmed' && $booking->BookingFrom > date('Y-m-d')){
            return response()->json([
                'success' => false,
                'message' => ["You are not allowed to perform this action before checkin!"],
                'msgtype' => 'danger',
            ]);
           
        }
        
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
        $user = Auth::user();
        $bs = BookingService::find($request->service_id);
        if ($bs->status == 'awaiting') {
            $bs->status = $request->action;
            $bs->apr_rej_by = $user->id;
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


