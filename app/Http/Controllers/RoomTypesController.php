<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RoomType;
// use Validator;
use App\Http\Requests\AddRoomTypeRequest;
use Illuminate\Support\Facades\DB;

class RoomTypesController extends Controller
{
    /**
     * Display base page for roomtypes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roomtypes.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoomTypes()
    {
        return RoomType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoomTypeRequest $request)
    {
         $roomtypeExists = RoomType::where('RoomType', $request->RoomType)->get();
         $roomtype = new RoomType();
         $roomtype->RoomType = $request->RoomType;
         $roomtype->CreationIP = request()->ip();
         $roomtype->created_by = 1;
         $roomtype->CreatedByModule = "model";
        if(count($roomtypeExists) == 0)
        {
       
        $roomtype->save();

        return response()->json([
            'success' => true,
            'message' => ["RoomType '$request->RoomType' created successfully."],
            'msgtype' => 'success',
            'roomtype' => $roomtype
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["RoomType '$request->RoomType' already exists."],
            'msgtype' => 'error',
            'roomtype' => $roomtype
            
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
        $roomtype = RoomType::find($request->id);        
        $roomtype->RoomType = $request->RoomType;
        $roomtype->UpdationIP = request()->ip();

        $roomtype->save();

        return response()->json([
            'success' => true,
            'message' => ["RoomType '$request->RoomType' updated successfully."],
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
        RoomType::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["RoomType '$request->RoomType' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
