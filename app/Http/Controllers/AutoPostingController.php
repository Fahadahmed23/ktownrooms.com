<?php

namespace App\Http\Controllers;

use App\Models\AccountAutoPosting;
use App\Models\AccountAutoPostingType;
use App\Models\AccountType;
use App\Models\AccountGeneralLedger;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Validator;




class AutoPostingController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auto_postings.index',['breadcrumb' => 'Auto Posting']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData()
    {
        $auto_postings = AccountAutoPosting::with(['posting_type'])->get();
        // for dropdown
        $account_types = AccountType::get(['id','title']);
        $auto_posting_types = AccountAutoPostingType::all();
        $account_heads = AccountGeneralLedger::where('account_level_id' , 5)->where('is_active' , 1)->get();
        return response()->json([
            'account_types'=>$account_types,
            'auto_postings'=> $auto_postings,
            'auto_posting_types'=> $auto_posting_types,
            'account_heads'=>$account_heads,
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
    dd($request->all());
    \DB::beginTransaction();
    try 
    {
        if (!empty($request['posting_type'])){

            $auto_posting_type_id = $request['posting_type']['auto_posting_type_id'];
            foreach($request['auto_postings_arr'] as $p){
                $ap = new AccountAutoPosting();
                $ap->auto_posting_type_id = $auto_posting_type_id;
                $ap->account_gl_code= $p['account_gl_code'];
                $ap->account_gl_name = $p['account_gl_name'];
                $ap->account_level = $p['account_level'];
                $ap->is_dr = isset($p['is_dr']) ? $p['is_dr'] : '0';
                $ap->is_cr = isset($p['is_cr']) ? $p['is_cr'] : '0';
                $ap->save();
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
            'message' => ['Auto Posting cannot be created'],
            'msgtype' => 'danger',
            'auto_posting' => $ap
        ]);
    }
       
        return response()->json([
            'success' => true,
            'message' => ["Auto Posting created successfully."],
            'msgtype' => 'success',
            'auto_posting' => $ap
        ]);
    }



    public function update(Request $request, $id)
    {
        // dd($request['posting_type']['auto_posting_type_id']);
        \DB::beginTransaction();
         try 
         {
            $posting_type_id = $request['posting_type']['auto_posting_type_id'];
            AccountAutoPosting::where('auto_posting_type_id','=',$posting_type_id)->delete();
            if (!empty($request['auto_postings_arr'])){
                foreach($request['auto_postings_arr'] as $p){
                    $ap = new AccountAutoPosting();
                    $ap->auto_posting_type_id = $posting_type_id;
                    $ap->account_gl_code = $p['account_gl_code'];
                    $ap->account_gl_name = $p['account_gl_name'];
                    $ap->account_level = $p['account_level'];
                    $ap->is_dr = isset($p['is_dr']) ? $p['is_dr'] : '0';
                    $ap->is_cr = isset($p['is_cr']) ? $p['is_cr'] : '0';
                    $ap->save();
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
                 'message' => ['Auto Posting  cannot be created'],
                 'msgtype' => 'danger',
                 'auto_posting' => $ap
             ]);
         }
            
             return response()->json([
                 'success' => true,
                 'message' => ["Auto Posting  updated successfully."],
                 'msgtype' => 'success',
                 'auto_posting' => $ap
             ]);
         }

    public function destroy(Request $request)
        { 
            $v = AccountAutoPosting::where('id',$request->id)->first();
            $v->delete();
            return response()->json([
                'success' => true,
                'message' => ["Auto Posting  deleted successfully."],
                'msgtype' => 'success',
                'id' => $request->id
            ]);
        }


        public function getAutoPostingByType(Request $request)
        {
            //   dd($request->all());
            $ap = AccountAutoPosting::join('account_gl','account_auto_posting.account_gl_code','=','account_gl.account_gl_code' )
             ->join('account_types','account_gl.account_type_id','=','account_types.id')
            ->where('auto_posting_type_id', $request['auto_posting_type_id'])
            ->get(['account_gl.id as account_gl_id', 'account_gl.account_type_id', 'account_types.title as account_type_name', 'account_auto_posting.account_gl_code','account_auto_posting.account_gl_name', 'account_auto_posting.account_level','account_auto_posting.is_dr','account_auto_posting.is_cr' ,'account_auto_posting.auto_posting_type_id'])
            ->toArray();
            return response()->json([
                'success' => true,
                'ap' => $ap
            ]);

        }
}
