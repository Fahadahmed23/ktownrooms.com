<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Service;
use App\Models\Department;
use App\Models\ServiceType;
// use Validator;
use App\Http\Requests\AddServiceRequest;
use App\Models\Hotel;
use App\Models\Inventory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use DateTime;

class ServicesController extends Controller
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
    /**
     * Display base page for services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('services.index',['breadcrumb' => 'Services']);
    }

    // public function getIcons()
    // {
    //     $path = public_path('/json/icons.json');
    //     $content = json_decode(file_get_contents($path), true);
    //      return json_encode($content);
    //     // dd($content);
    // }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getServices(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $services = Service::join('service_types', 'services.service_type_id', '=', 'service_types.id')
                            ->join('departments', 'services.department_id', '=', 'departments.id')
                            ->where('services.deleted_at',Null)
                            ->select('services.*' , 'departments.Department' , 'service_types.ServiceType');
            if (!auth()->user()->hasRole('Admin')) {
                if($user->self_manipulated()){
                    $services = $services->where('services.created_by',$user->id);
                }else{
                    $services = $services->whereIn('services.hotel_id',$user->HotelIds);
                }
                $is_admin = false;
            }
            else{
                $is_admin = true;
            }
            // service filter code
            if(!empty($request['filters']))
            {
                if (!empty($request['filters']['title'])) {
                    $services = $services->where('Service','like',$request['filters']['title'].'%');
                }
                if (!empty($request['filters']['hotel_id'])) {
                    $services = $services->where('hotel_id',$request['filters']['hotel_id']);
                }
                if (!empty($request['filters']['department_id'])) {
                    $services = $services->where('department_id',$request['filters']['department_id']);
                }
                if (!empty($request['filters']['service_type_id'])) {
                    $services = $services->where('service_type_id',$request['filters']['service_type_id']);
                }
                // if (!empty($request['filters']['title'])) {
                //     $general_ledgers = $general_ledgers->where('title','like',$request['filters']['title'].'%');
                // }
    
                // if (!empty($request['filters']['account_gl_code'])) {
                //     $general_ledgers = $general_ledgers->where('account_gl_code','like',$request['filters']['account_gl_code'].'%');
                // }
            }




        $services = $services->get();
        //for dropdown
        // $hotels = Hotel::all();
        $hotels = auth()->user()->user_hotels()->get();
        $departments = Department::all();
        $servicetypes = ServiceType::all();
        $inventories = Inventory::all();
        
       return response()->json([
        'user'=>$user,
        'is_admin'=>$is_admin,
        'services'=>$services,
        'departments' => $departments,
        'hotels'=>$hotels,
        'servicetypes' => $servicetypes,
        'inventories'=>$inventories
       ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddServiceRequest $request)
    {

        //  dd($request->all());
        if ($request->is_24hrs == 1) {
            $start_time = Null;
            $end_time =Null;
        }else{
            $start_time = date('H:i:s', strtotime( $request->service_start_time));
            $end_time = date('H:i:s', strtotime( $request->service_end_time));
        }
        $serviceExists = Service::where('Service', $request->Service)->where('hotel_id', $request->hotel_id)->get();
        
        $service = new Service();
        $service->service_type_id = $request->service_type_id;
        $service->department_id = $request->department_id;
        $service->inventory_id = $request->inventory_id;
        $service->hotel_id = $request->hotel_id;
        $service->Service = $request->Service;
        $service->Charges = $request->Charges;
        $service->ServingTime = $request->ServingTime;
        $service->is_24hrs = $request->is_24hrs;
        if ($request->is_24hrs == 1) {
            $service->service_start_time = Null;
            $service->service_end_time =Null;
        }
        $service->service_start_time = $start_time;
        $service->service_end_time = $end_time;
        $service->IsShowDelayAlert = $request->IsShowDelayAlert;
        $service->IsQuantitative = $request->IsQuantitative;
        $service->IsInventory = $request->IsInventory;
        $service->IconPath= $request->IconPath;
        $service->CreationIP =  request()->ip();
        $service->created_by = Auth::id();
        $service->CreatedByModule = "model";
        if(count($serviceExists) == 0)
        {
        $service->save();
        return response()->json([
            'success' => true,
            'message' => ["Service '$request->Service' created successfully."],
            'msgtype' => 'success',
            'service' => $service
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Service '$request->Service' already exists."],
            'msgtype' => 'error',
            'service' => $service
            ]);
       }
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
        if ($request->is_24hrs == 1) {
            $start_time = Null;
            $end_time =Null;
        }else{
            $start_time = date('H:i:s', strtotime( $request->service_start_time));
            $end_time = date('H:i:s', strtotime( $request->service_end_time));
        }
        $service = Service::find($request->id);
        
        $service->service_type_id = $request->service_type_id;
        $service->department_id = $request->department_id;
        $service->inventory_id = $request->inventory_id;
        $service->hotel_id = $request->hotel_id;
        $service->Service = $request->Service;
        $service->Charges = $request->Charges;
        $service->ServingTime = $request->ServingTime;
        $service->is_24hrs = $request->is_24hrs;
        $service->service_start_time = $start_time;
        $service->service_end_time = $end_time;
        $service->IsShowDelayAlert = $request->IsShowDelayAlert;
        $service->IsQuantitative = $request->IsQuantitative;
        $service->IsInventory = $request->IsInventory;
        $service->IconPath= $request->IconPath;
        $service->UpdationIP = request()->ip();
        $service->created_by = Auth::id();
        $service->save();

        return response()->json([
            'success' => true,
            'message' => ["Service '$request->Service' updated successfully."],
            'msgtype' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        Service::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Service '$request->Service' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
