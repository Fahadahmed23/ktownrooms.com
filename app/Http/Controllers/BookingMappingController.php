<?php

namespace App\Http\Controllers;

use App\Models\BookingMapping;
use Illuminate\Http\Request;

class BookingMappingController extends Controller
{
    public function index()
    {
        return view('bookingmappings.index',['breadcrumb' => 'Booking Mappings']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getBookingMappings(Request $request)
    {
        $qry = BookingMapping::orderBy('id', 'DESC');

        // if(isset($request->Name)){
        //     $qry->where('Name', 'like', "%" . $request->Name . "%");
        // }

        // if(isset($request->Email)){
        //     $qry->where('Email', 'like', "%" . $request->Email . "%");
        // }

        // if(isset($request->Phone)){
        //     $qry->where('Phone', 'like', "%" . $request->Phone . "%");
        // }
        
        // if(isset($request->Address)){
        //     $qry->where('Address', 'like', "%" . $request->Address . "%");
        // }



        $mappings = $qry->get();

        return response()->json([
            'mappings'=> $mappings,
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
        // $mapping = new BookingMapping();
        // dd($mapping);
        
        // dd($request->all());
        $mapping = BookingMapping::create([
            'client' => $request['client'],
            'type' => $request['type'],
            'source_type' => $request['source_type'],
            'source' => $request['source'],
            'destination' => $request['destination'],
        ]);
        // dd($data);
        // $mapping->save($data);

        return response()->json([
            'success' => true,
            'message' => ["Mapping created successfully."],
            'msgtype' => 'success',
            'mapping'=> $mapping
        ]);
    }


    public function update(Request $request, BookingMapping $BookingMapping)
    {
        $mapping = BookingMapping::find($request->id);
        
        // dd($inventory);
        $mapping->update($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Mapping updated successfully."],
            'msgtype' => 'success',
            'mapping' => $mapping
        ]);
    }
}
