<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Facility;
// use Validator;
use App\Http\Requests\AddFacilityRequest;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Storage;
use Validator;




class FacilitiesController extends Controller
{


    public function getIcons()
    {
        $path = public_path('/json/icons.json');
        $content = json_decode(file_get_contents($path), true);
         return json_encode($content);
        // dd($content);
    }


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('facilities.index',['breadcrumb' => 'Facilities']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getFacilities()
    {
        return Facility::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddFacilityRequest $request)
    { 
        // dd($request['Image']);
         $facilityExists = Facility::where('Facility', $request->Facility)->get();

         $facility = new Facility();
         $facility->Facility = $request['Facility'];
         $facility->Image = $request['Image'];
         $facility->CreationIP = request()->ip();
         $facility->created_by = 1;
         $facility->CreatedByModule = "model";    

        if(count($facilityExists) == 0)
        {
         $facility->save();

        return response()->json([
            'success' => true,
            'message' => ["Facility '$request->Facility' created successfully."],
            'msgtype' => 'success',
            'facility' => $facility
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Facility '$request->Facility' already exists."],
            'msgtype' => 'error',
            'facility' => $facility
            
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
        // dd($request['Image']);
        $facility = Facility::find($request->id);
        $facility->Facility = $request->Facility;
        $facility->Image = $request['Image'];
        $facility->UpdationIP = request()->ip();
        $facility->save();

        return response()->json([
            'success' => true,
            'message' => ["Facility '$request->Facility' updated successfully."],
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
        Facility::find($request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => ["Facility '$request->Facility' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }




}
