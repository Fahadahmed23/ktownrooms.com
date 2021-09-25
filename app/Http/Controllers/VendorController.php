<?php

namespace App\Http\Controllers;

use App\Models\Vendor;
use Illuminate\Http\Request;

class VendorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('vendors.index',['breadcrumb' => 'Vendors']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getVendors(Request $request)
    {
        $qry = Vendor::orderBy('Name', 'ASC');

        if(isset($request->Name)){
            $qry->where('Name', 'like', "%" . $request->Name . "%");
        }

        if(isset($request->Email)){
            $qry->where('Email', 'like', "%" . $request->Email . "%");
        }

        if(isset($request->Phone)){
            $qry->where('Phone', 'like', "%" . $request->Phone . "%");
        }
        
        if(isset($request->Address)){
            $qry->where('Address', 'like', "%" . $request->Address . "%");
        }



        $vendors = $qry->get();

        return response()->json([
            'vendors'=> $vendors,
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
        $vendor = new Vendor();

        $vendor->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Vendor $request->Name created successfully."],
            'msgtype' => 'success',
            'vendor'=> $vendor
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function show(Vendor $vendor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendor $vendor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendor $vendor)
    {
        $vendor = Vendor::find($request->id);
        
        // dd($inventory);
        $vendor->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Vendor $request->Name updated successfully."],
            'msgtype' => 'success',
            'vendor' => $vendor
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Vendor  $vendor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vendor $vendor)
    {
        //
    }
}
