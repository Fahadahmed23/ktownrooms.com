<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Task;
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
        
        $user = Auth::user();
        $taskDate= Carbon::now()->format('Y-m-d');
        $timespan= 'today';
        $operator = '=';
        if (!empty($request['date'])) {
            $timespan = $request['date'];
        }
        if ($timespan == 'today') {
            $operator = '=';
        } else if ($timespan == 'previous') {
            $operator = '<';
        }
        // dd($timespan, $user);
        $tasks = Task::where('hotel_id', $user->hotel_id);
        if($user->name == 'Super Admin' || $user->name == 'Supervisor' ){
            $user_is_admin = true;
            if (!empty($request['department_id'])) {
                $tasks= $tasks->where('department_id',$request['department_id']);
            }
            else{
                $tasks = $tasks->where('created_at', 'like', $taskDate.'%');
            }
        } 
        else{
            // if(empty($user->department_id)) {
            //     $tasks = $tasks;
            // } else {
            //     $tasks = $tasks->where('department_id', $user->department_id);
            // }
            $user_is_admin = false;
        }
        // dd($tasks->get(), $user, $timespan, $request->all());
       $tasks=  $tasks->with(['task_history' ,'booking_service:id,times,icon_class,created_at'])->whereDate('created_at', $operator, $taskDate)->get();
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
            'user_is_admin'=>$user_is_admin,
        ]);

        // dd($request->all());
        // $tasks = User::with(['department.tasks'])->where('id', Auth::id())->first();
        
    }

    public function getDepartments()
    {
        $departments = Department::all();
        return response()->json([
            'departments'=> $departments
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
 
}
