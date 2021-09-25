<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RoomCategory;
// use Validator;
use App\Http\Requests\AddRoomCategoryRequest;
use App\Models\Facility;
use App\Models\Room;
use Illuminate\Support\Facades\DB;

class RCategoriesController  extends Controller
{
    /**
     * Display base page for roomcategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roomcategory.index',['breadcrumb' => 'Room Categories']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getrCategories()
    {
        $roomcategories=  RoomCategory::with(['facilities'])->get();;
        $facilities = Facility::all();

        return response()->json([
            'roomcategories'=> $roomcategories,
            'facilities'=> $facilities,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoomCategoryRequest $request)
    {
        // dd($request->all());
        $roomcategoryExists = RoomCategory::where('RoomCategory', $request->RoomCategory)->get();
        $roomcategory = new RoomCategory();
        $roomcategory->RoomCategory = $request->RoomCategory;
        $roomcategory->AllowedOccupants = $request->AllowedOccupants;
        $roomcategory->MaxAllowedOccupants = $request->MaxAllowedOccupants;
        $roomcategory->Color = $request->Color;
        $roomcategory->CreationIP = request()->ip();
        $roomcategory->created_by = 1;
        $roomcategory->CreatedByModule = "model";
        if(count($roomcategoryExists) == 0)
        {
        $roomcategory->save();
        $roomcategory->facilities()->sync($request['facilities']);
        $roomcategory=RoomCategory::with(['facilities'])->where('id','=',$roomcategory->id)->first();
        return response()->json([
            'success' => true,
            'message' => ["RoomCategory '$request->RoomCategory' created successfully."],
            'msgtype' => 'success',
            'roomcategory' => $roomcategory
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["RoomCategory '$request->RoomCategory' already exists."],
            'msgtype' => 'error',
            'roomcategory' => $roomcategory
            
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
        // dd($request->all());
        $roomcategory = RoomCategory::find($request->id);
        $roomcategory->RoomCategory = $request->RoomCategory;
        $roomcategory->AllowedOccupants = $request->AllowedOccupants;
        $roomcategory->MaxAllowedOccupants = $request->MaxAllowedOccupants;
        $roomcategory->Color = $request->Color;
        $roomcategory->UpdationIP = request()->ip();
        
        $roomcategory->save();
        $roomcategory->facilities()->sync($request['facilities']);
        $roomcategory=RoomCategory::with(['facilities'])->where('id','=',$roomcategory->id)->first();

        return response()->json([
            'success' => true,
            'message' => ["RoomCategory '$request->RoomCategory' updated successfully."],
            'msgtype' => 'success',
            'roomcategory' => $roomcategory
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
       $checkAssignRoom= Room::with(['category'])->where('room_category_id','=',$request->id )->first();
       
       if ($checkAssignRoom) {
                return response()->json([
                    'success' => true,
                    'message' => ["Category couldn't be deleted, Assigned to the room already"],
                    'msgtype' => 'danger',
                ]);
       } else {
          $roomcategory =  RoomCategory::where('id',$request->id)->first();
          $roomcategory->delete();
        return response()->json([
            'success' => true,
            'message' => ["Room Category '$roomcategory->RoomCategory' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
       }
       
        

        
    }
}
