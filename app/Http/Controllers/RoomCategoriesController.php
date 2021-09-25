<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\RoomCategory;
// use Validator;
use App\Http\Requests\AddRoomCategoryRequest;
use Illuminate\Support\Facades\DB;

class RoomCategoriesController extends Controller
{
    /**
     * Display base page for roomcategories.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('roomcategories.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoomCategories()
    {
        return RoomCategory::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoomCategoryRequest $request)
    {
        $roomcategoryExists = RoomCategory::where('RoomCategory', $request->RoomCategory)->get();
        $roomcategory = new RoomCategory();
         $roomcategory->RoomCategory = $request->RoomCategory;
         $roomcategory->AllowedOccupants = $request->AllowedOccupants;
         $roomcategory->CreationIP = request()->ip();
         $roomcategory->created_by = 1;
         $roomcategory->CreatedByModule = "model";
        if(count($roomcategoryExists) == 0)
        {

        $roomcategory->save();

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
        $roomcategory = RoomCategory::find($request->id);
        
        $roomcategory->RoomCategory = $request->RoomCategory;
        $roomcategory->AllowedOccupants = $request->AllowedOccupants;
        $roomcategory->UpdationIP = request()->ip();
        $roomcategory->save();

        return response()->json([
            'success' => true,
            'message' => ["RoomCategory '$request->RoomCategory' updated successfully."],
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
        RoomCategory::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["RoomCategory '$request->RoomCategory' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
