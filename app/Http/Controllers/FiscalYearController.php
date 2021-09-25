<?php

namespace App\Http\Controllers;

use App\Models\AccountFiscalYearMaster;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class FiscalYearController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('fiscalyears.index',['breadcrumb' => 'Fiscal Years']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFiscalYears()
    {
        $fiscalyears = AccountFiscalYearMaster::orderBy('title', 'ASC')->get();
        $hotels = Hotel::all();
        $is_admin = true;
        $current_user_hotel_id = null;
        if (!auth()->user()->hasRole('Admin')) {
            $is_admin = false;
            $current_user_hotel_id = auth()->user()->hotel_id;
        }
        return response()->json([
            'fiscalyears'=> $fiscalyears,
            'hotels'=> $hotels,
            'is_admin'=> $is_admin,
            'current_user_hotel_id'=> $current_user_hotel_id,
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
        //  dd($request->all());
         $fiscalYearExists = AccountFiscalYearMaster::where('title', $request->title)->get();
         
         $ficalyear = new AccountFiscalYearMaster();
         $ficalyear->title = $request['title'];
         $ficalyear->start_date = $request['start_date'];
         $ficalyear->end_date = $request['end_date'];
         $ficalyear->description = $request['description'];
         $ficalyear->status = $request['status'];

        if(count($fiscalYearExists) == 0)
        {
         $ficalyear->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Fiscal Year '$request->title' created successfully."],
            'msgtype' => 'success',
            'ficalyear' => $ficalyear
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Fiscal Year '$request->title' already exists."],
            'msgtype' => 'error',
            'ficalyear' => $ficalyear
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
        $ficalyear = AccountFiscalYearMaster::find($request->id);
        $ficalyear->title = $request['title'];
        $ficalyear->start_date = $request['start_date'];
        $ficalyear->end_date = $request['end_date'];
        $ficalyear->description = $request['description'];
        $ficalyear->status = $request['status'];
        $ficalyear->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Fiscal Year '$request->title' updated successfully."],
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
        $ficalyear = AccountFiscalYearMaster::where('id',$request->id)->first();
        $ficalyear->delete();
        return response()->json([
            'success' => true,
            'message' => ["Fiscal Year ".$ficalyear->title."  deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }




}
