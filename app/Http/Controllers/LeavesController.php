<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AddUserProfile;
use App\Models\Leave;
use App\Models\User;
use Carbon\Carbon;
class LeavesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    { 
        return view('leaves.index');
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json([
            'users' => $users,
        ]);
    }

    public function getAllLeaves(Request $request)
    {
        if(!empty($request->date)){
            $from =Carbon::parse($request->date)->firstOfMonth()->format('Y-m-d');
            $to =Carbon::parse($request->date)->endOfMonth()->format('Y-m-d');
        }
        else{
            $from = Carbon::now()->firstOfMonth()->format('Y-m-d');
            $to =Carbon::now()->endOfMonth()->format('Y-m-d');
        }
        if (empty($request->user_id)) {
            $leaves = Leave::with(['user.department'])->whereBetween('LeaveRequestFrom',[$from, $to])->get();
        }
        else{   
            $leaves = Leave::with(['user.department'])->where('user_id',$request->user_id)->whereBetween('LeaveRequestFrom',[$from, $to])->get();
        }

       return response()->json([
        'leaves' => $leaves,
        ]);
    }

    public function approvedLeave(Request $request)
    {
        $approved =Leave::where('user_id', $request->user_id)->where('status','approved')->orderBy('id', 'desc')->first();       
        return response()->json([
            'approved' => $approved,
            ]);
    }

    public function approveRejectLeave(Request $request)
    {
      $leave = Leave::find($request->leave_id);
      $leave->status = $request->leave_status;
      $leave->rejected_reason = $request->rejected_reason;
      $leave->rejected_reason = isset($request->rejected_reason) ? $request->rejected_reason : '';
      $leave->save();


      return response()->json([
        'success' => true,
        'message' => ["$leave->type $leave->status successfully."],
        'msgtype' => 'success',
        'leave' => $leave
    ]);
    }
}