<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RoomService;
// use Validator;
use App\Http\Requests\AddRoomServiceRequest;
use Illuminate\Support\Facades\DB;

class RoomServicesController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display base page for roomservices.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roomservices.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoomServices()
    {
        return RoomService::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoomServiceRequest $request)
    {
        $roomserviceExists = RoomService::where('RoomService', $request->RoomService)->get();
        $roomservice = new RoomService();

        $roomservice->RoomService = $request->RoomService;
        $roomservice->room_id = $request->room_id;
        $roomservice->service_id = $request->service_id;
        $roomservice->IsServiceForAll = $request->IsServiceForAll;
        $roomservice->AllowedServiceForPersons = $request->AllowedServiceForPersons;

        $roomservice->CreationIP = "198";
        $roomservice->created_by = 1;
        $roomservice->CreatedByModule = "model";
        if(count($roomserviceExists) == 0)
        {
        
        $roomservice->save();

        return response()->json([
            'success' => true,
            'message' => ["RoomService '$request->RoomService' created successfully."],
            'msgtype' => 'success',
            'roomservice' => $roomservice
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["RoomService '$request->RoomService' already exists."],
            'msgtype' => 'error',
            'roomservice' => $roomservice
            
            ]);
       }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $roomservice = RoomService::find($request->id);
        
        $roomservice->RoomService = $request->RoomService;
        $roomservice->room_id = $request->room_id;
        $roomservice->service_id = $request->service_id;
        $roomservice->IsServiceForAll = $request->IsServiceForAll;
        $roomservice->AllowedServiceForPersons = $request->AllowedServiceForPersons;
     
        $roomservice->UpdationIP = request()->ip();

        $roomservice->save();

        return response()->json([
            'success' => true,
            'message' => ["RoomService '$request->RoomService' updated successfully."],
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
        // dd($request);
        RoomService::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["RoomService '$request->RoomService' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
