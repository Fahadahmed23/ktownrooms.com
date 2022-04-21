<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\State;
use App\Models\UserHotel;
use App\Models\User;
use App\Models\City;
use App\Models\Hotel;
use App\Models\UserExperience;
use App\Models\Department;
use App\Models\Designation;
use App\Models\UserAddress;


use App\Imports\ClientsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\CorporateClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class CorporateClientController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('corporate_clients.index',['breadcrumb' => 'Corporate Clients']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getClients()
    {

        // Mr optimist 21 April 2022

        $user = \Auth::user();
        $username = $user->name;
        $role_name =$user->roles->first()->name;
        $userr = auth()->user();
        $hotel_ids = array();
        
        $hotel_array = array();

        foreach ($user->hotels->toArray() as $hotel) {

            $h = Hotel::find($hotel['hotel_id']);
            $hotel_id   =   $h['id'];
            $hotel_name =   $h['HotelName'];
            $hotel_array[$hotel_id] = $hotel_name;
            $hotel_ids[] = $hotel['hotel_id'];
        }

        if($role_name=='Admin') {

            unset($hotel_array); // $foo is gone
            $hotel_array = array();

            $hotels = Hotel::get();
            $all_hotels = count($hotels);
            foreach($hotels as $single_hotel) {

                $hotel_id    = $single_hotel['id'];
                $hotel_name  = $single_hotel['HotelName'];
                $hotel_array[$hotel_id] = $hotel_name;
            }

            $clients = CorporateClient::orderBY('FullName', 'ASC')->get();
        }
        else {
            $clients = CorporateClient::whereIn('hotel_id',$hotel_ids)->orderBY('FullName', 'ASC')->get();
        }
        
        return response()->json([
            'clients'=> $clients,
            'hotels'=> $hotel_array,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // dd($request->all());
        
        $clientExists = CorporateClient::where('FullName', $request->FullName)->get();

            $client = new CorporateClient();
            $client->FullName = $request['FullName'];
            $client->EmailAddress = $request['EmailAddress'];
            $client->ContactNo = $request['ContactNo'];
            $client->Status = $request['Status'];

        if(count($clientExists) == 0)
        {
         $client->save();

        return response()->json([
            'success' => true,
            'message' => ["Client '$request->FullName' created successfully."],
            'msgtype' => 'success',
            'client' => $client
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Client '$request->FullName' already exists."],
            'msgtype' => 'error',
            'client' => $client
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
            $client = CorporateClient::find($request->id);
            
            $client->FullName = $request['FullName'];
            $client->EmailAddress = $request['EmailAddress'];
            $client->ContactNo = $request['ContactNo'];
            $client->Status = $request['Status'];
            $client->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Client '$request->FullName' updated successfully."],
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
        $client = CorporateClient::where('id',$request->id)->first();
        $client->delete();
        return response()->json([
            'success' => true,
            'message' => ["Client ".$client->FullName."  deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

        // public function importExcel()
        // {
        //     Excel::import(new ClientsImport, 'text.xlsx');
        //     return redirect('/')->with('success', 'All good!');
        // }


        public function importExcel(Request $request)
        {
    
            // dd($request->all());
            $this->validate(
                $request,
                [
                    'excelfile' => 'required|mimes:xlsx',
                ],
                [
                    'excelfile.mimes' => 'The file must be file of type xlsx'
                ]
            );

            $excelfile = $request->file('excelfile');
            Excel::import(new ClientsImport, $excelfile);
            return back()->with('success', 'Excel Data Imported successfully.');
            dd("out");

        




           
        }



}
