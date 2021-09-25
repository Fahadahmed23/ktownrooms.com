<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CategoryFacility;
// use Validator;
use App\Http\Requests\AddCategoryFacilityRequest;
use App\Models\RoomCategory;
use Illuminate\Support\Facades\DB;
use DateTime;

class CategoryFacilitiesController extends Controller
{
    /**
     * Display base page for categoryfacilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categoryfacilities.index');
    }
    public function getDropDownfacilities(Request $request)
    {
        $facilities = CategoryFacility::where("roomcategory_id",$request["roomcategory_id"])
        ->select("facility_id")
        ->get();
        return response()->json($facilities); 
    }    

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCategoryFacilities()
    {
        return CategoryFacility::all();
    }
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
    public function store(AddCategoryFacilityRequest $request)
    {
        dd($request->all());
        $input = $request->all();
        $input1 = json_encode((array)$input['facility_id']);        
        $input1 = str_replace('["','',$input1);
        $input1 = str_replace('"]','',$input1);
        $newArr = explode('","',$input1);      

        for($i=0; $i<count($newArr); $i++)
        {
             $categoryfacility = new CategoryFacility();
             $categoryfacility->roomcategory_id = $request->roomcategory_id;
             $categoryfacility->facility_id =$newArr[$i];
             $categoryfacility->CreationIP =  request()->ip();
             $categoryfacility->created_by = 1;
             $categoryfacility->CreatedByModule = "model";
             $categoryfacility->save();
        }

        return response()->json([
            'success' => true,
            'message' => ["CategoryFacility '$request->roomcategory_id' created successfully."],
            'msgtype' => 'success',
            'categoryfacility' => $categoryfacility
        ]);
     
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
        dd($request->all());
        CategoryFacility::find($request->id)->delete();

        $input = $request->all();
        $input1 = json_encode((array)$input['facility_id']);        
        $input1 = str_replace('["','',$input1);
        $input1 = str_replace('"]','',$input1);
        $newArr = explode('","',$input1);      

        for($i=0; $i<count($newArr); $i++)
        {
             $categoryfacility = new CategoryFacility();
             $categoryfacility->roomcategory_id = $request->roomcategory_id;
             $categoryfacility->facility_id =$newArr[$i];
             $categoryfacility->CreationIP =  request()->ip();
             $categoryfacility->created_by = 1;
             $categoryfacility->CreatedByModule = "model";
             $categoryfacility->save();
        }

      

        return response()->json([
            'success' => true,
            'message' => ["CategoryFacility '$request->roomcategory_id' updated successfully."],
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
        CategoryFacility::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["CategoryFacility '$request->roomcategory_id' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
