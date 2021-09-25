<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\City;
use App\Models\Country;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use DateTime;
// use Validator;
use App\Http\Requests\AddCityRequest;

class CitiesController extends Controller
{
    /**
     * Display base page for cities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('cities.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function getCountryList(Request $request)
    {
        $countries = Country::select("CountryName","id")->get();
        return response()->json($countries);
    }
    public function getStateList(Request $request)
    {
        $states = State::where("country_id",$request->country_id)
                    ->select("StateName","id")
                    ->get();
        return response()->json($states);
    }

    public function getCitiesCity()
    {
        return DB::table('cities')
        ->join('countries', 'cities.country_id', '=', 'countries.id')
        ->join('states', 'cities.state_id', '=', 'states.id') 
        ->select('cities.*' , 'countries.CountryName' , 'states.StateName')
        ->get();
    }
    public function getCountries()
    {
        return Country::all();
    }
    public function ddStates(Request $request)
    {
       return  DB::table('state')->where('country_id', $request->country_id)->get();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCityRequest $request)
    {
        $cityExists = City::where('CityName', $request->CityName)->get();

        $city = new City();
        $city->CityName = $request->CityName;
        $city->country_id = $request->country_id;
        $city->state_id = $request->state_id;
        $city->Abbreviation = $request->Abbreviation;
        $city->CreationIP =  request()->ip();
        $city->created_by = 1;
        $city->CreatedByModule = "model";
        if(count($cityExists) == 0)
        {
        $city->save();
        
        return response()->json([
            'success' => true,
            'message' => ["City '$request->CityName' created successfully."],
            'msgtype' => 'success',
            'city' => $city
        ]);
        }
        else
        {
            return response()->json([
                'success' => false,
                'message' => ["City '$request->CityName' already exists."],
                'msgtype' => 'error',
                'city' => $city
                
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
      
        $city = City::find($request->id);
        
        $city->CityName = $request->CityName;
        $city->country_id = $request->country_id;
        $city->state_id = $request->state_id;
        $city->Abbreviation = $request->Abbreviation;
        $city->UpdationIP = request()->ip();
        $city->updated_by = '1';
        
        

        $city->save();

        return response()->json([
            'success' => true,
            'message' => ["City '$request->CityName' updated successfully."],
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
        City::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["City '$request->CityName' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
