<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Room;
use App\Models\Task;
use App\Models\BookingService;
use App\Models\BookingServiceBtc;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TaskManagementController extends Controller
{
    protected $module_name = 'Tasks Management';

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
        return view ('tasks.index', [
            'breadcrumb' => 'Tasks Management'
        ]);
    }

    public function getTasks(Request $request)
    {
        // dd($request->all());
        $user = Auth::user();
        $taskDate= Carbon::now()->format('Y-m-d');
        $timespan= 'today';
        if (!empty($request['date'])) {
            $timespan = $request['date'];
        }
        $tasks = Task::whereNull('deleted_at');
      
        if(auth()->user()->hasRole('Admin')){
            $isSelectHotel = true;
            $isSelectDepartment = true;
        }
        else{
            $isSelectHotel = false;
            if(empty(auth()->user()->department_id)){
                $isSelectDepartment = true;
                $tasks = $tasks->whereIn('hotel_id', $user->HotelIds);
            }
            else{
                $isSelectDepartment = false;
                $tasks = $tasks->whereIn('hotel_id', $user->HotelIds)->where('department_id',$user->department_id);
            }
        }
        if(!empty($request['filters']) )
        {
            if (!empty($request['filters']['hotel_id']) && $isSelectHotel) {
                $tasks = $tasks->where('hotel_id',$request['filters']['hotel_id']);
            }
            if (!empty($request['filters']['department_id']) && $isSelectDepartment) {
                $tasks = $tasks->where('department_id',$request['filters']['department_id']);
            }
            if (!empty($request['filters']['service_title'])) {
                $tasks = $tasks->where('service','like',$request['filters']['service_title'].'%');
            }
        }
        if($timespan == 'today'){
            $tasks = $tasks->where('created_at', 'like' , $taskDate.'%');
        }
        else if($timespan == 'previous') {
            $tasks->whereDate('created_at', '<', $taskDate);
        }
        
        $tasks = $tasks->with(['task_history' ,'booking_service:id,times,icon_class,created_at'])->get();

        // for counts a/c to task status
        $counts['todo'] = $tasks->filter(
            function($request){ 
               return  $request->status == 'todo';
        })->count();
        $counts['inprogress'] = $tasks->filter(
            function($request){ 
               return  $request->status == 'inprogress';
        })->count();

        $counts['completed'] = $tasks->filter(
            function($request){ 
               return  $request->status == 'completed';
        })->count();


        return response()->json([
            'tasks' => $tasks,
            'counts'=>$counts,
            'isSelectHotel'=>$isSelectHotel,
            'isSelectDepartment'=>$isSelectDepartment
            // 'user_is_admin'=>$user_is_admin,
        ]);
    }

    public function getddData()
    {
        $departments = Department::all();
        $hotels = auth()->user()->user_hotels()->get();
        // dd($hotels->toArray(['id']));
        // $rooms = Room::get(['id','room_title','hotel_id']);
        return response()->json([
            'departments'=> $departments,
            'hotels'=>$hotels,
            // 'rooms'=>$rooms
        ]);
    }

    public function updateStatus(Request $request)
    {
        // dd($request->all());
        $task_status = Task::find($request->task['id']);
        $task_status->status = $request->target_status;
        $task_status->save();

        return response()->json([
            'success' => true,
            'message' => ["Task Status has been updated to '$task_status->status' from '$request->source_status' Successfully"],
            'msgtype' => 'success'
        ]);
    }


    // Mr Optimist 9 May 2022
    public function updateStatusBtc(Request $request)
    {


    

        $booking_service_id = $request->task['service_id'];
        $booking_id =  $request->task['booking_id'];
        $is_btc_status = $request->is_btc;

        //return response()->json([
        //    $booking_service_id,
        //    $booking_id,
        //    $is_btc_status
        //]);

        //DB::table('booking_service')->where('id',$booking_service_id)->update(array('is_btc' => $is_btc_status));  

        //$booking_service = BookingService::find($booking_service_id);
        //$booking_service->is_btc = $is_btc_status;
        //$booking_service->save();

        $BookingServiceBtcExist = BookingServiceBtc::where('booking_service_id',$booking_service_id)->count();


        if ($BookingServiceBtcExist==0) {
            $booking_service_btc = new BookingServiceBtc();
        }

        else {
            $booking_service_btc = BookingServiceBtc::where('booking_service_id',$booking_service_id)->first();
  
        }
        
        $booking_service_btc->booking_service_id = $booking_service_id; 
        $booking_service_btc->booking_id = $booking_id; 
        $booking_service_btc->is_btc = $is_btc_status;
        $booking_service_btc->save();
        

        return response()->json([
            'success' => true,
            'message' => ["BTC Status has been updated successfully"],
            'msgtype' => 'success'
        ]);
    }


 
}
