<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\AddUserProfile;
use App\Models\Leave;
use App\Models\User;
class ProfileController extends Controller
{
 
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
    */
    public function index()
    { 
        return view('profile.index');
    }

    public function getProfile()
    {
        return  Auth::user(); 
    }

    public function updateProfile(AddUserProfile $request)
    {
        $user = User::find(auth()->id());
        $input = $request->all();
        $input['dob'] = date('Y-m-d', strtotime($input['dob']));
        $user->fill($input)->save();

        $response = [
            'success' => true,
            'message' => ['Profile Updated Successfully'],
            'msgtype' => 'success'
        ];
        return json_encode($response);

    }

    public function changePassword(Request $request)
    {
        if($request->redirectToHome != "true"){
            $validator1 = Validator::make($request->all(), [
                'old_password' => 'required|different:password',
            ]);
            if($validator1->fails()){
                return $response = [
                    'success' => false,
                    'errors' =>[$validator1->messages()->all() ],
                    'msgtype' => 'danger'
                ];
            }
        }
        $validator = Validator::make($request->all(), [
            'password' => 'required|confirmed',
        ]);
        if($validator->fails()){
            return $response = [
                'success' => false,
                'errors' =>[$validator->messages()->all() ],
                'msgtype' => 'danger'
            ];
        }
        $user = User::find(auth()->id());
        if($request->redirectToHome != "true"){
        
            if (!Hash::check($request->old_password, $user->password)) { 
                return $response = [
                    'success' => false,
                    'errors' =>[ ["Your old password did not matched"] ],
                    'msgtype' => 'danger'
                ];
            }
        }
        $user->fill([
            'password' => Hash::make($request->password),
            'first_login' => 0,
        ])->save();

        
        $response = [
            'success' => true,
            'message' => ['Password Changed Successfully'],
            'msgtype' => 'success'
        ];

            
        return json_encode($response);
    }
    public function getLeaves()
    {
        $user = User::find(auth()->id());
        $leaves = Leave::where('user_id',$user->id)->get();
        return response()->json([
            'leaves' => $leaves,
            ]);
    }

    public function saveLeaveRequest(Request $request)
    { 
        $user = User::find(auth()->id());
        $leave = new Leave();
        $leave->user_id = $user->id;
        $leave->type = $request->leave['leave_type'];
        $leave->reason = $request->leave['reason'];
        $leave->LeaveRequestFrom = $request->leave['LeaveRequestFrom'];
        $leave->LeaveRequestTo = $request->leave['LeaveRequestTo'];
        $leave->status = 'pending';
        $leave->save();

        return response()->json([
            'success' => true,
            'message' => ["Leave Requested successfully"],
            'msgtype' => 'success',
            'leave' => $leave
        ]);

    }

    
    
}