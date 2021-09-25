<?php

namespace App\Http\Controllers;

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
        $clients = CorporateClient::orderBY('FullName', 'ASC')->get();
        return response()->json([
            'clients'=> $clients,
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
