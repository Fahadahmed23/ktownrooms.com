<?php

namespace App\Http\Controllers;

use App\Models\BookingService;
use App\Models\Department;
use App\Models\Room;
use App\Models\Service;
use App\Models\Task;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BookingServicesController extends Controller
{
    protected $module_name = 'Booking Services Management';

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
        return view ('booking_services.index', [
            'breadcrumb' => 'Booking Services Management'
        ]);
    }

    public function getHotelRooms()
    {

        // $hotelrooms = User::with(['hotel.rooms.services.department','hotel.rooms.tasks'])->where('id', Auth::id())->first();
        // $hotelrooms = User::with(['hotel.rooms.services.department'])->where('id', Auth::id());

        if (!empty(request()->selected_date)) {
            $request = request()->selected_date;

            $hotelrooms = User::with(['hotel.rooms.tasks'=> function($qry)
            use ($request){
                $qry->where('created_at',$request);
            }
            ])->where('id', Auth::id());
        }
        $hotelrooms = $hotelrooms->first();

        //  dd(response()->json([
        //     'hotelrooms' => $hotelrooms
        // ]));


        return response()->json([
            'hotelrooms' => $hotelrooms
        ]); 
    }

    public function saveTask(Request $request)
    {
        // dd($request->all());
        $ntask = new Task();
        $ntask->room_id= $request->task['room_id'];
        $ntask->room_title = Room::where('id',$request->task['room_id'])->pluck('room_title')[0];
        $ntask->service_id= $request->task['service_id'];
        $ntask->service = Service::where('id',$request->task['service_id'])->pluck('Service')[0];
        $ntask->description= $request->task['description'];
        $ntask->performing_time= $request->task['performing_time'];
        $ntask->department_id= $request->task['department_id'];
        $ntask->department = Department::where('id',$request->task['department_id'])->pluck('Department')[0];
        $ntask->status = "todo";
        $ntask->save();

        $task=Task::where('id','=',$ntask->id)->first();
        return response()->json([
            'success' => true,
            'message' => ["Task for  '$task->service' hase been created successfully."],
            'msgtype' => 'success',
            'task' => $task
        ]);
    }  
}
