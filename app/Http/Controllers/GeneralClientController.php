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
use App\Models\GeneralClient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class GeneralClientController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('general_clients.index',['breadcrumb' => 'General Clients']);
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

            $inner_array = array();

            $h = Hotel::find($hotel['hotel_id']);
            $hotel_id   =   $h['id'];
            $hotel_name =   $h['HotelName'];
            //$hotel_array[$hotel_id] = $hotel_name;
            $hotel_ids[] = $hotel['hotel_id'];

            $inner_array['hotel_id'] = $hotel_id;
            $inner_array['hotel_name'] = $hotel_name;
            $hotel_array[] = $inner_array;

        }

        if($role_name=='Admin') {

            unset($hotel_array); // $foo is gone
            $hotel_array = array();

            $hotels = Hotel::get();
            $all_hotels = count($hotels);
            foreach($hotels as $single_hotel) {

                $inn_array = array();

                $hotel_id    = $single_hotel['id'];
                $hotel_name  = $single_hotel['HotelName'];

                //$hotel_array[$hotel_id] = $hotel_name;

                $inn_array['hotel_id'] = $hotel_id;
                $inn_array['hotel_name'] = $hotel_name;
                $hotel_array[] = $inn_array;


            }

            $clients = GeneralClient::orderBY('name', 'ASC')->get();
        }
        else {
            $clients = GeneralClient::whereIn('hotel_id',$hotel_ids)->orderBY('name', 'ASC')->get();
        }

        return response()->json([
            'clients'=> $clients,
            'hotels'=> $hotel_array,
        ]);

    }

    public function getClients_id(Request $request)
    {

        // Mr optimist 21 April 2022

        $user = \Auth::user();
        $username = $user->name;
        $role_name =$user->roles->first()->name;
        $userr = auth()->user();

        $hotel_id = isset($request['hotel_id']) ?$request['hotel_id']:0;
        $clients = GeneralClient::where('hotel_id',$hotel_id)->where('status',1)->orderBY('name', 'ASC')->get();
        // $clients = CorporateClient::where('hotel_id',$hotel_id)->orderBY('FullName', 'ASC')->get();
        return response()->json([
            'clients'=> $clients,
            'hotel_id'=> $hotel_id,
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


        $clientExists = GeneralClient::where('hotel_id',$request['hotel_id'])->where('name', $request->FullName)->get();
        $client = new GeneralClient();

        // Mr Optimist 22 April 2022
        $client->hotel_id = isset($request['hotel_id']) ? $request['hotel_id'] : 0;
        $client->name = $request['name'];
        $client->poc = $request['poc'];
        $client->email = $request['email'];
        $client->phone = $request['phone'];
        $client->status = $request['status'];
        //$client->action = $request['action'];

        if(count($clientExists) == 0)
        {



            $client->save();




            return response()->json([
                'success' => true,
                'message' => ["Client '$request->name' created successfully."],
                'msgtype' => 'success',
                'client' => $client
            ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Client '$request->name' already exists."],
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
            $client = GeneralClient::find($request->id);
            $client->hotel_id = $request['hotel_id'];
            $client->name = $request['name'];
            $client->poc = $request['poc'];
            $client->email = $request['email'];
            $client->phone = $request['phone'];
            $client->status = $request['status'];
            //$client->action = $request['action'];
            $client->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Client '$request->name' updated successfully."],
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
        $client = GeneralClient::where('id',$request->id)->first();
        $client->delete();
        return response()->json([
            'success' => true,
            'message' => ["Client ".$client->name."  deleted successfully."],
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
