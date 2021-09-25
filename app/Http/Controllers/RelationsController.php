<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Relation;
// use Validator;
use App\Http\Requests\AddRelationRequest;
use Illuminate\Support\Facades\DB;
use DateTime;

class RelationsController extends Controller
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
     * Display base page for relations.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('relations.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRelations()
    {
        return Relation::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRelationRequest $request)
    {
        $relationExists = Relation::where('Relation', $request->Relation)->get();
        $relation = new Relation();

        $relation->Relation = $request->Relation;
        $relation->CreationIP = "198";
        $relation->created_by = 1;
        $relation->CreatedByModule = "model";
        if(count($relationExists) == 0)
        {
        
        $relation->save();

        return response()->json([
            'success' => true,
            'message' => ["Relation '$request->Relation' created successfully."],
            'msgtype' => 'success',
            'relation' => $relation
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Relation '$request->Relation' already exists."],
            'msgtype' => 'error',
            'relation' => $relation
            
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
        $relation = Relation::find($request->id);        
        $relation->Relation = $request->Relation;        
        $relation->UpdationIP = request()->ip();
        $relation->save();

        return response()->json([
            'success' => true,
            'message' => ["Relation '$request->Relation' updated successfully."],
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
        Relation::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Relation '$request->Relation' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
