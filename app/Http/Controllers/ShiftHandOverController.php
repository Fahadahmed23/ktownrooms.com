<?php

namespace App\Http\Controllers;

use App\Models\AccountGeneralLedger;
use App\Models\OpeningShiftHandover;
use App\Models\Permission;
use App\Models\ShiftHandover;
use App\Models\User;
use App\Models\VoucherDetail;
use App\Models\VoucherMaster;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;


class ShiftHandOverController extends Controller
{
    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('shift_handover.index',['breadcrumb' => 'Shift Handover']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $user = auth()->user();
        $u =  OpeningShiftHandover::where('user_id',$user->id)->where('is_closed' , 0)->orderBy('created_at','desc')->first(['opening_balance']);
        $user_opening_balance = $u?$u['opening_balance']:0;
        // for droddown
        //  $users = User::where('id','!=',$user->id);
        // ->where('hotel_id',$user->hotel_id)->get();

        $hotel_ids = auth()->user()->getHotelIdsAttribute();
        $permission_id = Permission::where('name', 'can-view-shift-handover')->first(['id'])->toArray();

        $users = User::whereHas('hotels', function($query) use ($hotel_ids) {
            $query->whereIn('hotel_id', $hotel_ids);
        })->join('role_user', 'users.id','=' ,'role_user.user_id')
        ->join('permission_role', 'role_user.role_id','=','permission_role.role_id')
        ->where('permission_role.permission_id', $permission_id)
        ->get(['users.id','users.name', 'users.hotel_id']);

        //  $users = auth()->user()->hotel->allUsers()->where('users.id', '!=', auth()->id());
        
        // dd($users);
        //permission id for shift handover
        // dd($permission_id);
        // $users =  $users->Join('role_user', 'users.id','=' ,'role_user.user_id')
        // ->Join('permission_role', 'role_user.role_id','=','permission_role.role_id')
        // ->where('permission_role.permission_id', $permission_id)->get(['users.id','users.name', 'users.hotel_id']);
        // ->get(['users.id','users.name', 'users.hotel_id']);
        // dd($users);

        $receive_account_id = AccountGeneralLedger::where('account_level_id' , 5)->where('is_active' , 1)
        ->where('account_type_id', 1)->where('title', 'Cash In Hand')->first(['id']);
         
            $created_by_ids = $this->getIncludedVouchers();
            //  dd($created_by_ids);
            $receive_account_id = $receive_account_id->id;
            $vm = VoucherMaster::whereIn('hotel_id', $hotel_ids)->with(['voucher_details' => function($q) use ($receive_account_id){
                $q->where('account_gl_id', $receive_account_id)->where('is_concile',0);
            }])->whereIn('CreatedBy', $created_by_ids)->get();
            // dd($vm);
            // with(['voucher_details'  => function($query) use ($receive_account_id) {
            //     $query->where('account_gl_id', '=', $receive_account_id)->where('is_concile', 0);}]) 
            // ->
            // whereIn('CreatedBy', $created_by_ids)->get()->toArray();
            $voucher_details = [];
            foreach ($vm as $key => $value) {
                foreach($value['voucher_details'] as $val){
                    unset($val['voucher']);
                    unset($val['account_head']);
                    // dd($val);
                    $voucher_details[] = $val;
                }
            }
            //  dd($voucher_details);

            $cash_received_today = 0;
            $cash_paid_today = 0;
            foreach ($voucher_details as $vd) {
                $cash_received_today += (int)$vd['dr_amount'];
                $cash_paid_today += (int)$vd['cr_amount'];
            }
        $cash_received_today=    $cash_received_today + $user_opening_balance;
        $cash_available = $cash_received_today  - $cash_paid_today;
        return response()->json([
            'users'=>$users,
            'cash_received_today'=>$cash_received_today,
            'cash_paid_today'=>$cash_paid_today,
            'cash_available'=>$cash_available,
            'user_opening_balance'=>$user_opening_balance,
            'receive_account_id' =>$receive_account_id,
        ]);

    }

    public function getIncludedVouchers(){
        $user = auth()->user();
        $v =  VoucherMaster::select('CreatedBy')->distinct('CreatedBy')->get();
            $created_by_ids = [];
            foreach ($v as $key => $value) {
                $userHasRole = User::where('id', $value->CreatedBy)
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', '=', 'Frontdesk');
                    })
                    ->first();
                    if($userHasRole){
                        $created_by_ids[] = $userHasRole['id'];
                    }
            }
            $created_by_ids[] = $user->id;
            return $created_by_ids;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
            //  dd($request->all());
    \DB::beginTransaction();
    try 
    {
        $sh = new ShiftHandover();
        $sh->cash_receive = $request['shift_handover']['cash_received_today'];
        $sh->cash_paid = $request['shift_handover']['cash_paid_today'];
        $sh->hand_over_to = $request['shift_handover']['hand_over_to'];
        $sh->hand_over_by = auth()->user()->id;
        $sh->save();

        $osh = new OpeningShiftHandover();
        $osh->shift_handover_id = $sh->id;
        $osh->user_id = $sh->hand_over_to;
        $osh->opening_balance = $request['shift_handover']['cash_available'];
        $osh->save();

        $user = auth()->user();
        OpeningShiftHandover::where('user_id',$user->id)->update(['is_closed' => 1]);

        $created_by_ids = $this->getIncludedVouchers();
        $vd = VoucherDetail::whereIn('created_by',$created_by_ids)->get();
        
        foreach($vd as $v){
            $v->is_concile = 1;
            $v->update();
        }

        // $vd->each(function($item, $key) {
        //     $item->is_concile = 1;
        //     $item->save();
        // });
        // $vd->update(['is_concile' => 1]);

        \DB::commit();
    } 
    catch (\Exception $e) 
    {
        dd($e);
        \DB::rollback();
        return response()->json([
            'success' => false,
            'message' => ['shift cannot be handover to user'],
            'msgtype' => 'danger',
            'shift_handover' => $sh
        ]);
    }
       
        return response()->json([
            'success' => true,
            'message' => ["shift handover successfully."],
            'msgtype' => 'success',
            'shift_handover' => $sh
        ]);
    }
}
