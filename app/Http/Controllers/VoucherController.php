<?php

namespace App\Http\Controllers;

use App\Models\AccountFiscalYearMaster;
use App\Models\AccountGeneralLedger;
use App\Models\VoucherDetail;
use App\Models\VoucherMaster;
use App\Models\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;




class VoucherController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vouchers.index',['breadcrumb' => 'Vouchers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVouchers()
    {
        $vouchers = VoucherMaster::with('voucher_details')->get();
        // for dropdown
        $voucher_types = VoucherType::all();
        $account_heads = AccountGeneralLedger::where('account_level_id' , 5)->where('is_active' , 1)->get();
        $fiscal_years = AccountFiscalYearMaster::all();
        return response()->json([
            'vouchers'=> $vouchers,
            'voucher_types'=> $voucher_types,
            'account_heads'=>$account_heads,
            'fiscal_years'=>$fiscal_years,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        //   dd($request->all());

    \DB::beginTransaction();
    try 
    {
        $v = new VoucherMaster();
        $v->voucher_type_id = $request['voucher_type_id'];
        $v->fiscal_year_master_id = $request['fiscal_year_master_id'];
        // $v->current_fiscal_year = $request['current_fiscal_year'];
        // $v->voucher_no = $request['voucher_no'];
        $v->date = $request['date'];
        $v->description = $request['description'];
        $v->CreatedBy = Auth::id();
        $v->post_user_id = Auth::id();
        $v->post = "posted";
        $v->save();
    
        if (!empty($request['voucher_details'])){
            foreach($request['voucher_details'] as $d){
                // dd($vd);
                $vd = new VoucherDetail();
                $vd->voucher_master_id = $v->id;
                $vd->account_gl_id = $d['account_gl_id'];
                $vd->narration = $d['narration'];
                $vd->dr_amount = $d['dr_amount'];
                $vd->cr_amount = $d['cr_amount'];
                $vd->created_by = Auth::id();
                $vd->save();
            }
        }
        \DB::commit();
    } 
    catch (\Exception $e) 
    {
        dd($e);
        \DB::rollback();
        return response()->json([
            'success' => false,
            'message' => ['Voucher cannot be created'],
            'msgtype' => 'danger',
            'voucher' => $v
        ]);
    }
       
        return response()->json([
            'success' => true,
            'message' => ["Voucher '$request->voucher_no' created successfully."],
            'msgtype' => 'success',
            'voucher' => $v
        ]);
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
        \DB::beginTransaction();
         try 
         {
            //  dd($request->all());
            $v = VoucherMaster::find($request->id);

            $v->voucher_type_id = $request['voucher_type_id'];
            $v->fiscal_year_master_id = $request['fiscal_year_master_id'];
            // $v->current_fiscal_year = $request['current_fiscal_year'];
            // $v->voucher_no = $request['voucher_no'];
            $v->date = $request['date'];
            $v->description = $request['description'];
            $v->CreatedBy = Auth::id();
            $v->post_user_id = Auth::id();
            $v->post = "posted";
            $v->save();

            VoucherDetail::where('voucher_master_id','=',$v->id)->delete();
            if (!empty($request['voucher_details'])){
                foreach($request['voucher_details'] as $d){
                    $vd = new VoucherDetail();
                    $vd->voucher_master_id = $v->id;
                    $vd->account_gl_id = $d['account_gl_id'];
                    $vd->narration = isset($d['narration']) ? $d['narration'] : '';
                    $vd->dr_amount = $d['dr_amount'];
                    $vd->cr_amount = $d['cr_amount'];
                    $vd->updated_by = Auth::id();
                    $vd->save();
                }
             }
             \DB::commit();
         } 
         catch (\Exception $e) 
         {
             dd($e);
             \DB::rollback();
             return response()->json([
                 'success' => false,
                 'message' => ['Voucher cannot be created'],
                 'msgtype' => 'danger',
                 'voucher' => $v
             ]);
         }
            
             return response()->json([
                 'success' => true,
                 'message' => ["Voucher '$request->voucher_no' updated successfully."],
                 'msgtype' => 'success',
                 'voucher' => $v
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

        // dd($request->all());
        $v = VoucherMaster::where('id',$request->id)->first();
        $v->delete();
        return response()->json([
            'success' => true,
            'message' => ["Voucher ".$v->voucher_no."  deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }


    public function destroy_detail(Request $request)
    { 
        // dd($request->id);    
         $vdetail = VoucherDetail::where('id',$request->id)->first();
        //  dd($vdetail->VoucherName);
         $vdetail->delete();
        return response()->json([
            'success' => true,
            'message' => ["".$vdetail->AccountHeadName."  detail deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    public function add_single_detail(Request $request)
    {
        // dd($request->voucher_detail['cr_amount']);
        $vd = new VoucherDetail();
        $vd->voucher_master_id = $request->voucher_master_id;
        $vd->account_gl_id = $request->voucher_detail['account_gl_id'];
        $vd->narration = isset($request->voucher_detail['narration']) ? $request->voucher_detail['narration'] : '';
        $vd->dr_amount = isset($request->voucher_detail['dr_amount']) ? $request->voucher_detail['dr_amount'] : '0';
        $vd->cr_amount = isset($request->voucher_detail['cr_amount']) ? $request->voucher_detail['cr_amount'] : '0';
        $vd->save();


        return response()->json([
            'success' => true,
            'message' => ["".$vd->AccountHeadName." detail added successfully."],
            'msgtype' => 'success',
            'voucher_detail' => $vd
        ]);
    }



    public function postedvouchers()
    {
        return view('voucherapproval.index',['breadcrumb' => 'Posted Vouchers']);
    }


    public function getPostedVouchers()
    {
        $posted_vouchers = VoucherMaster::with('voucher_details')->get();
        return response()->json([
            'posted_vouchers'=> $posted_vouchers,
        ]);

    }


    public function aproval(Request $request)
    { 

        $v = VoucherMaster::find($request->id);
        $v->post = 'approved';
        $v->save();
        return response()->json([
            'success' => true,
            'message' => ["Voucher ".$v->voucher_no."  approved successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }




}
