<?php

namespace App\Http\Controllers;

use App\Models\AccountFiscalYearMaster;
use App\Models\AccountGeneralLedger;
use App\Models\AccountLevel;
use App\Models\AccountSubType;
use App\Models\AccountType;
use App\Models\Hotel;
use App\Models\SubAccountType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class GeneralLedgerController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('generalledgers.index',['breadcrumb' => 'Genaral Ledgers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGeneralLedgers(Request $request)
    {
// dd($request['filters']);
        $general_ledgers = AccountGeneralLedger::where('is_active', 1);
        if(!empty($request['filters']))
        {
            if (!empty($request['filters']['account_type_id'])) {
                $general_ledgers = $general_ledgers->whereIn('account_type_id',$request['filters']['account_type_id']);
            }
            if (!empty($request['filters']['account_level_id'])) {
                $general_ledgers = $general_ledgers->whereIn('account_level_id',$request['filters']['account_level_id']);
            }

            if (!empty($request['filters']['title'])) {
                $general_ledgers = $general_ledgers->where('title','like',$request['filters']['title'].'%');
            }

            if (!empty($request['filters']['account_gl_code'])) {
                $general_ledgers = $general_ledgers->where('account_gl_code','like',$request['filters']['account_gl_code'].'%');
            }
        }
        $general_ledgers = $general_ledgers->get();

        // for dropdown
        $account_types = AccountType::all();
        $account_levels = AccountLevel::all();
        $account_sub_types = AccountSubType::all();
        $fiscal_years = AccountFiscalYearMaster::all();

        return response()->json([
            'general_ledgers'=> $general_ledgers,
            'account_types'=>$account_types,
            'account_levels'=>$account_levels,
            'account_sub_types'=>$account_sub_types,
            'fiscal_years'=>$fiscal_years
        ]);

    }


    public function findGLCode(Request $request)
    {
        //   dd($request->all());
        $gl_code =  AccountGeneralLedger::where('account_type_id',$request->account_typ['id'])
        ->where('account_level_id',$request->level)
        ->orderBy('account_gl.created_at', 'desc')
        ->first(['account_gl.account_gl_code','account_gl.parent_account']);

        if ($request->level > 2 && !empty($request->parent_acount)) {
            $code = $request->parent_acount ;
            $interval = (int)$request->account_typ['interval'];

            $c=  explode("-", $code);
            $last_index = count($c) - 1;
            $c[$last_index] += $interval;
            $lastdight = $c[$last_index];
            $code = $code.'-'.$lastdight;
            // dd($code);
            $exist=  AccountGeneralLedger::where('parent_account',$request->parent_acount)->orderBy('account_gl.created_at', 'desc')->first();
                        if(!empty($exist)){
                            // dd($exist);
                            $code = $exist->account_gl_code;
                            $interval = $request->account_typ['interval'];
                            $level = $request->level;
                                return response()->json([
                                    'success' => true,
                                    'gl_code' => $this->getNewGlCOde($code,$interval),
                                    ]);
                        }
            return response()->json([
                'success' => true,
                'gl_code' => $code,
                ]);
        }

        if (empty($gl_code)) {
            $level = (2*(((int)$request->level)-1));
            $code = $request->account_typ['initial_state'] .'-'. strval(((int)$request->account_typ['initial_state']) +$level);
          return response()->json([
            'success' => true,
            'gl_code' => $code,
            ]);
        }
        
        else{
            if (!empty($gl_code->parent_account)) {
                $code = $request->parent_acount ;
                $interval = (int)$request->account_typ['interval'];
    
                $c=  explode("-", $code);
                $last_index = count($c) - 1;
                $c[$last_index] += $interval;
                $lastdight = $c[$last_index];
                $code = $code.'-'.$lastdight;
                
                    $exist=  AccountGeneralLedger::where('account_gl_code',$code)->orderBy('account_gl.created_at', 'desc')->first();
                        if(!empty($exist)){
                            $code = $gl_code->account_gl_code;
                            $interval = $request->account_typ['interval'];
                            $level = $request->level;
                                return response()->json([
                                    'success' => true,
                                    'gl_code' => $this->getNewGlCOde($code,$interval),
                                    ]);
                        }
                return response()->json([
                    'success' => true,
                    'gl_code' => $code,
                    ]);
            }
        }
        
    }

    public function getNewGlCOde($code,$interval)
    {
        $c=  explode("-", $code);
        $last_index = count($c) - 1;
        $c[$last_index] += $interval;
        return join("-", $c);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $general_ledgerExists = AccountGeneralLedger::where('title', $request->title)->where('account_level_id', $request['account_level_id'])->where('parent_account',$request->parent_acount)->get();
        $gl = new AccountGeneralLedger();
        $gl->title = $request['title'];
        $gl->account_level_id = $request['account_level_id'];
        $gl->account_type_id =  $request->account_type['id'];
        $gl->sub_account_type_id = $request['sub_account_type_id'];
        $gl->account_gl_code = $request['account_gl_code'];
        $gl->description = $request['description'];
        $gl->opening_balance = $request['opening_balance'];
        $gl->posting_type = $request['posting_type'];
        $gl->dr_cr = $request['dr_cr'];
        $gl->parent_account = $request->parent_acount;
        $gl->account_fiscal_years_master_id = $request['account_fiscal_years_master_id'];

        if(count($general_ledgerExists) == 0)
        {
         $gl->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Genaral Ledger '$request->title' created successfully."],
            'msgtype' => 'success',
            'general_ledger' => $gl
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Genaral Ledger '$request->title' already exists."],
            'msgtype' => 'error',
            'general_ledger' => $gl
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
    //    dd($request->all());
        $gl = AccountGeneralLedger::find($request->id);
        // dd($gl->title);
        $gl->title = $request['title'];
        $gl->account_level_id = $request['account_level_id'];
        $gl->account_type_id = $request['account_type_id'];
        $gl->sub_account_type_id = $request['sub_account_type_id'];
        $gl->account_gl_code = $request['account_gl_code'];
        $gl->description = $request['description'];
        $gl->opening_balance = $request['opening_balance'];
        $gl->posting_type = $request['posting_type'];
        $gl->dr_cr = $request['dr_cr'];
        $gl->account_fiscal_years_master_id = $request['account_fiscal_years_master_id'];
        $gl->save();

        return response()->json([
            'success' => true,
            'message' => ["Genaral Ledger '$request->title' updated successfully."],
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
        $general_ledger = AccountGeneralLedger::where('id',$request->id)->first();
        $general_ledger->delete();
        return response()->json([
            'success' => true,
            'message' => ["General Ledger ".$general_ledger->title."  deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }




}
