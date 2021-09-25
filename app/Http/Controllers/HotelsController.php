<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hotel;
use App\Models\City;
use App\Models\Company;
// use Validator;
use App\Http\Requests\AddHotelRequest;
use Illuminate\Support\Facades\DB;

class HotelsController extends Controller
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
     * Display base page for hotels.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hotels.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHotels()
    {
       // return Hotel::all();

       return DB::table('hotels')
       ->join('companies', 'hotels.company_id', '=', 'companies.id')
       ->join('cities', 'hotels.city_id', '=', 'cities.id') 
       ->select('hotels.*' , 'companies.CompanyName' , 'cities.CityName','hotels.Address'
       ,'hotels.ZipCode','hotels.Longitude','hotels.Latitude' )
       ->get();
    }
    public function getCurrentHotels()
    {
        $hotels = Hotel::orderBy('HotelName', 'ASC')->get();

       return response()->json([
        'success' => true,
        'hotels' => $hotels
        
        ]);
    }
    public function getCompanies()
    {
        return Company::all();
    }
    public function getCities()
    {
        return City::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddHotelRequest $request)
    {
        $hotelExists = Hotel::where('HotelName', $request->HotelName)->get();
        $hotel = new Hotel();
        $hotel->company_id = $request->company_id;
        $hotel->city_id = $request->city_id;
        $hotel->Address = $request->Address;
        $hotel->ZipCode = $request->ZipCode;
        $hotel->Longitude = $request->Longitude;
        $hotel->Latitude = $request->Latitude;


        $hotel->CreationIP = "198";
        $hotel->created_by = 1;
        $hotel->CreatedByModule = "model";
        if(count($hotelExists) == 0)
        {
        
        $hotel->save();

        return response()->json([
            'success' => true,
            'message' => ["Hotel '$request->HotelName' created successfully."],
            'msgtype' => 'success',
            'hotel' => $hotel
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Hotel '$request->HotelName' already exists."],
            'msgtype' => 'error',
            'hotel' => $hotel
            
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
        $hotel = Hotel::find($request->id);
        
        $hotel->company_id = $request->company_id;
        $hotel->city_id = $request->city_id;
        $hotel->Address = $request->Address;
        $hotel->ZipCode = $request->ZipCode;
        $hotel->Longitude = $request->Lonitude;
        $hotel->Latitude = $request->Latitude;

        $hotel->UpdationIP = request()->ip();

        $hotel->save();

        return response()->json([
            'success' => true,
            'message' => ["Hotel '$request->HotelName' updated successfully."],
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
        Hotel::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Hotel '$request->HotelName' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
