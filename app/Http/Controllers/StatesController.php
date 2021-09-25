<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\State;
use App\Models\Country;
use Illuminate\Support\Facades\DB;
// use Validator;
use App\Http\Requests\AddStateRequest;

class StatesController extends Controller
{
    /**
     * Display base page for states.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('states.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getStatesState()
    {
       //return State::all();
       return DB::table('states')
       ->join('countries', 'countries.id', '=', 'states.country_id')        
       ->select('states.*' , 'countries.CountryName')
       ->get();      
    }
  
    public function getCountries()
    {
        return Country::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddStateRequest $request)
    {
        $state = new State();
        $state->StateName = $request->StateName;
        $state->country_id = $request->country_id;        
        $state->Abbreviation = $request->Abbreviation;
        $state->CreationIP = request()->ip();
        $state->created_by = 1;
        $state->CreatedByModule = "model";

        $state->save();

        return response()->json([
            'success' => true,
            'message' => ["State '$request->StateName' created successfully."],
            'msgtype' => 'success',
            'state' => $state
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

    public function getStateList(Request $request, $country_id)
    {
        $states = State::where("country_id",$request->country_id)
                    ->select("StateName","id")
                    ->get();
        return response()->json($states);
    }

    public function update(Request $request, $id)
    {
        $state = State::find($request->id);        
        $state->StateName = $request->StateName;
        $state->country_id = $request->country_id;        
        $state->Abbreviation = $request->Abbreviation;
        $state->UpdationIP = request()->ip();
        $state->updated_by = '1';

        $state->save();

        return response()->json([
            'success' => true,
            'message' => ["State '$request->StateName' updated successfully."],
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
        State::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["State '$request->StateName' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
