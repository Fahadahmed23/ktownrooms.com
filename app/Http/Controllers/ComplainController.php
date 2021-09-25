<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CustomerComplain;
use App\Models\TaskPriority;
use App\Models\ComplainStatus;
use App\Models\Department;

class ComplainController extends Controller
{
    protected $module_name = 'Complain View';

    public function index()
    {
        return view ('complains.index', [
            'breadcrumb' => $this->module_name
        ]);
    }

    public function getData() {
        $task_priorities = TaskPriority::get(['id', 'TaskPriority']);
        $complain_statuses = ComplainStatus::get(['id', 'ComplainStatus']);
        $departments = Department::get(['id', 'Department']);

        return response()->json([
            'task_priorities' => $task_priorities,
            'complain_statuses' => $complain_statuses,
            'departments' => $departments
        ]);
    }

    public function getComplains(Request $request)
    {
        $inputs = $request->all();

        $filters = json_decode($request->filters);

        $complains = CustomerComplain::with([
            'customer:id,FirstName,LastName',
            'room:id,room_title,hotel_id',
            'room.hotel:id,HotelName,city_id',
            'status:id,ComplainStatus,style_class',
            'booking:id,booking_no',
            'priority:id,TaskPriority,style_class',
            'department:id,Department'
        ]);

        if ($filters->status_filter != '') {
            $complains = $complains->where('complain_status_id', $filters->status_filter);
        }

        if ($filters->priority_filter != '') {
            $complains = $complains->where('priority_id', $filters->priority_filter);
        }

        if ($filters->date_filter != '') {
            $complains = $complains->where('created_at', '>=', $filters->date_filter . ' 00:00:00');
        }

        if(!auth()->user()->hasRole('Admin')) { 
            $complains->where('hotel_id',auth()->user()->hotel_id);
        }

        $count = $complains->count();

        $complains = $complains->skip($inputs['page'] * $inputs['perPage'] - $inputs['perPage'])->take($inputs['page'] * $inputs['perPage'])->orderBy('created_at', $request->sorting);

        return response()->json([
            'success' => true,
            'complains' => $complains->get(),
            'totalRecords' => $count
        ]);
    }

    public function setPriority(Request $request)
    {
        $complain = CustomerComplain::find($request->complain_id);

        $complain->priority_id = $request->priority_id;
        $complain->save();

        return response()->json([
            'success' => true,
            'message' => ['Priority Changed Successfully'],
            'msgtype' => 'success',
        ]);
    }

    public function setDepartment(Request $request) {
        $complain = CustomerComplain::find($request->complain_id);

        $complain->department_id = $request->department_id;
        $complain->save();

        return response()->json([
            'success' => true,
            'message' => ['Department Changed Successfully'],
            'msgtype' => 'success'
        ]);
    }

    public function setStatus(Request $request)
    {
        $complain = CustomerComplain::find($request->complain_id);

        $complain->complain_status_id = $request->status_id;
        $complain->save();

        return response()->json([
            'success' => true,
            'message' => ['Status Changed Successfully'],
            'msgtype' => 'success'
        ]);
    }
}
