<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ContactType;
// use Validator;
use App\Http\Requests\AddContactTypeRequest;
use DateTime;

class ContactTypesController extends Controller
{
    /**
     * Display base page for contacttypes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('contacttypes.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getContactTypes()
    {
        return ContactType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddContactTypeRequest $request)
    {
        $contacttypeExists = ContactType::where('ContactType', $request->ContactType)->get();
        $contacttype = new ContactType();
        $contacttype->ContactType = $request->ContactType;       
        $contacttype->CreationIP = request()->ip();
        $contacttype->created_by = 1;
        $contacttype->CreatedByModule = "model";
       
        if(count($contacttypeExists) == 0)
        {
        $contacttype->save();

        return response()->json([
            'success' => true,
            'message' => ["ContactType '$request->ContactType' created successfully."],
            'msgtype' => 'success',
            'contacttype' => $contacttype
        ]);

        }
        else
        {
         return response()->json([
            'success' => false,
            'message' => ["Contact '$request->ContactType' already exists."],
            'msgtype' => 'error',
            'contacttype' => $contacttype
            
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
        $contacttype = ContactType::find($request->id);
        $contacttype->ContactType = $request->ContactType;
        $contacttype->UpdationIP = request()->ip();

        $contacttype->save();

        return response()->json([
            'success' => true,
            'message' => ["ContactType '$request->ContactType' updated successfully."],
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
        ContactType::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["ContactType '$request->ContactType' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
