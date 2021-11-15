<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddCityRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\HotelCategories;
use App\Http\Requests\AddCountryRequest;
class LocaleController extends Controller
{
    protected $module_name = "Locale";

    public function __construct()
    {
        return view ('hotel.index');
    }

    public function index()
    {
        return view ('locale.index', [
            'breadcrumb' => 'Locale'
        ]);
    }

    public function init() {
        $countries = Country::get(['id', 'CountryName', 'Abbreviation']);
        $states = State::get(['id', 'StateName', 'country_id', 'Abbreviation']);
        $cities = City::get(['id', 'CityName', 'country_id', 'state_id', 'Abbreviation']);
        $hotel_categories = HotelCategories::get(['id', 'name', 'status']);

        return response()->json([
            'countries' => $countries,
            'states' => $states,
            'cities' => $cities,
            'hotel_categories' => $hotel_categories
        ]);
    }

    public function deleteCountry(Request $request) {
        $country = Country::findOrFail($request->id);

        $message = ["Country '$country->CountryName' deleted successfully!"];

        $country->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    public function deleteHotelCategory(Request $request) {
        $hotel_category = HotelCategories::findOrFail($request->id);

        $message = ["Hotel Category '$hotel_category->name' deleted successfully!"];

        $hotel_category->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    public function deleteState(Request $request) {
        $state = State::findOrFail($request->id);

        $message = ["State '$state->StateName' deleted successfully!"];

        $state->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    public function deleteCity(Request $request) {
        $city = City::findOrFail($request->id);

        $message = ["City '$city->CityName' deleted successfully!"];

        $city->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    public function storeCountry(Request $request)
    {
        $countryId = $request->country['id'] ?? null;
        $countryExist = Country::where(DB::raw("UPPER(CountryName)"), strtoupper($request->country['CountryName']))
        ->where('CountryName', $request->country['CountryName']) 
        ->where('id', '!=', $countryId) 
        ->count();

        // $countryExist = Country::where('CountryName' ,$request->country['CountryName'])->get();
        if ($countryExist == 0) {
            if ($request->formType == "save") {
                $country = new Country();
            } else {
                $country = Country::find($request->country['id']);
            }
    
            $country->CountryName = $request->country['CountryName'];
            $country->Abbreviation = $request->country['Abbreviation'];
    
            $country->CreationIP = request()->ip();
            $country->created_by = Auth::id();
            $country->CreatedByModule = $this->module_name;
            $country->save();
    
            return response()->json([
                'success' => true,
                'message' => ["$country->CountryName added successfully"],
                'msgtype' => 'success',
                'country' => $country
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => ["Country '".$request->country['CountryName']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }
        
    }

    /*
    * Mr Optimist
    * HotelCategories
    **/
    public function storeHotelCategory(Request $request)
    {
        
        $hotelcategoryId = $request->hotelcategory['id'] ?? null;
        $hotelcategoryExist = HotelCategories::where('name', $request->hotelcategory['name']) 
        ->where('id', '!=', $hotelcategoryId) 
        ->count();

        // $countryExist = Country::where('CountryName' ,$request->country['CountryName'])->get();
        if ($hotelcategoryExist == 0) {
            if ($request->formType == "save") {
                $hotel_category = new HotelCategories();
                $hotel_category->created_by = Auth::id();
            } else {
                $hotel_category = HotelCategories::find($request->hotelcategory['id']);
                $hotel_category->updated_by = Auth::id();
            }
    
            $hotel_category->name = $request->hotelcategory['name'];
            $hotel_category->status = $request->hotelcategory['status'];
            
            $hotel_category->save();
    
            return response()->json([
                'success' => true,
                'message' => ["$hotel_category->name added successfully"],
                'msgtype' => 'success',
                'hotel' => $hotel_category
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Hotel Category '".$request->hotelcategory['name']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }

    }


    public function storeState(Request $request)
    {

        $stateId = $request->state['id'] ?? null;
        $stateExist = State::where(DB::raw("UPPER(StateName)"), strtoupper($request->state['StateName']))
        ->where('StateName', $request->state['StateName']) 
        ->where('id', '!=', $stateId) 
        ->count();


        // $stateExist = State::where('StateName',$request->state['StateName'])->get();
        if ($stateExist == 0) {
            if ($request->formType == "save") {
                $state = new State();
            } else {
                $state = State::find($request->state['id']);
            }

            $state->StateName = $request->state['StateName'];
            $state->country_id = $request->state['country_id'];
            $state->Abbreviation = $request->state['Abbreviation'];

            $state->CreationIP = request()->ip();
            $state->created_by = Auth::id();
            $state->CreatedByModule = $this->module_name;
            $state->save();

            return response()->json([
                'success' => true,
                'message' => ["$state->StateName added successfully"],
                'msgtype' => 'success',
                'state' => $state
            ]);  
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["State '".$request->state['StateName']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }
        
    }

    public function storeCity(AddCityRequest $request)
    {
        $cityId = $request->city['id'] ?? null;
        $cityExist = City::where(DB::raw("UPPER(CityName)"), strtoupper($request->city['CityName']))
        ->where('CityName', $request->city['CityName']) 
        ->where('id', '!=', $cityId) 
        ->count();


        // $cityExist = City::where('CityName', $request->city['CityName'])->get();
        if ($cityExist==0) {
            if ($request->formType == "save") {
                $city = new City();
            } else {
                $city = City::find($request->city['id']);
            }
    
            $city->CityName = $request->city['CityName'];
            $city->country_id = $request->city['country_id'];
            $city->state_id = $request->city['state_id'];
            $city->Abbreviation = $request->city['Abbreviation'];
    
            $city->CreationIP = request()->ip();
            $city->created_by = Auth::id();
            $city->CreatedByModule = $this->module_name;
            $city->save();
    
            return response()->json([
                'success' => true,
                'message' => ["$city->CityName added successfully"],
                'msgtype' => 'success',
                'city' => $city
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["City '".$request->city['CityName']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }

        
    }
}
