<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use Illuminate\Http\Request;
use App\Models\PartnerRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class PartnersController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('partners.index',['breadcrumb' => 'Partners']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPartners()
    {
        $partners = PartnerRequest::orderBy('FullName', 'ASC')->get();
        $hotels = Hotel::orderBy('HotelName', 'ASC')->get();
        return response()->json([
            'partners'=> $partners,
            'hotels'=>$hotels,
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
        // dd($request->all());
         $partnerExists = PartnerRequest::where('FullName', $request->FullName)->get();
         $partner = new PartnerRequest();
        //  $partner->FullName = $request['FullName'];
        //  $partner->HotelName = $request['HotelName'];
        //  $partner->EmailAddress = $request['EmailAddress'];
        //  $partner->ContactNo = $request['ContactNo'];
        //  $partner->Status = $request['Status'];

        if(count($partnerExists) == 0)
        {
         $partner->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Partner '$request->FullName' created successfully."],
            'msgtype' => 'success',
            'facility' => $partner
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Partner '$request->FullName' already exists."],
            'msgtype' => 'error',
            'facility' => $partner
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
        $partner = PartnerRequest::find($request->id);
        // $partner->FullName = $request['FullName'];
        // $partner->HotelName = $request['HotelName'];
        // $partner->EmailAddress = $request['EmailAddress'];
        // $partner->ContactNo = $request['ContactNo'];
        // $partner->Status = $request['Status'];
        $partner->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Partner '$request->FullName' updated successfully."],
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
        $partner = PartnerRequest::where('id',$request->id)->first();
        $partner->delete();
        return response()->json([
            'success' => true,
            'message' => ["Partner ".$partner->FullName."  deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }




}
