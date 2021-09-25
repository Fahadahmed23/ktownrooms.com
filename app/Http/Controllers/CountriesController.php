<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Country;
// use Validator;
use App\Http\Requests\AddCountryRequest;

class CountriesController extends Controller
{
    /**
     * Display base page for countries.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('countries.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCountries()
    {
        return Country::all();
    }

    public function getCountryList(Request $request)
    {
        $countries = Country::select("CountryName","id")->get();
        return response()->json($countries);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCountryRequest $request)
    {
        $countryExists = Country::where('CountryName', $request->CountryName)->get();
        $country = new Country();
        $country->CountryName = $request->CountryName;
        $country->Abbreviation = $request->Abbreviation;
        $country->CreationIP = request()->ip();
        $country->created_by = 1;
        $country->CreatedByModule = "model";

        if(count($countryExists) == 0)
        {
        $country->save();

        return response()->json([
            'success' => true,
            'message' => ["Country '$request->CountryName' created successfully."],
            'msgtype' => 'success',
            'country' => $country
        ]);
        }
        else
        {
         return response()->json([
            'success' => false,
            'message' => ["Country '$request->CountryName' already exists."],
            'msgtype' => 'error',
            'country' => $country
            
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
        $country = Country::find($request->id);
        
        $country->CountryName = $request->CountryName;
        $country->Abbreviation = $request->Abbreviation;
        $country->UpdationIP = request()->ip();
        $country->save();

        return response()->json([
            'success' => true,
            'message' => ["Country '$request->CountryName' updated successfully."],
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
        Country::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Country '$request->CountryName' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
