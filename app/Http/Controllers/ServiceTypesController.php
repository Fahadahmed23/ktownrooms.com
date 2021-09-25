<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ServiceType;
use App\Http\Requests\AddServiceTypeRequest;
use Illuminate\Support\Facades\DB;

class ServiceTypesController extends Controller
{
    /**
     * Display base page for servicetypes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('servicetypes.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getServiceTypes()
    {
        return ServiceType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddServiceTypeRequest $request)
    {
        $servicetypeExists = ServiceType::where('ServiceType', $request->ServiceType)->get();
        $servicetype = new ServiceType();
         $servicetype->ServiceType = $request->ServiceType;
         $servicetype->CreationIP = request()->ip();
         $servicetype->created_by = 1;
         $servicetype->CreatedByModule = "model";
        if(count($servicetypeExists) == 0)
        {
        $servicetype->save();
        return response()->json([
            'success' => true,
            'message' => ["ServiceType '$request->ServiceType' created successfully."],
            'msgtype' => 'success',
            'servicetype' => $servicetype
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["ServiceType '$request->ServiceType' already exists."],
            'msgtype' => 'error',
            'servicetype' => $servicetype
            
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
        $servicetype = ServiceType::find($request->id);
        
        $servicetype->ServiceType = $request->ServiceType;
        $servicetype->UpdationIP = request()->ip();

        $servicetype->save();

        return response()->json([
            'success' => true,
            'message' => ["ServiceType '$request->ServiceType' updated successfully."],
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
        ServiceType::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["ServiceType '$request->ServiceType' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
