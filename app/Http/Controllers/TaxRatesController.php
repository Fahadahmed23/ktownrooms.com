<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\TaxRate;
// use Validator;
use App\Http\Requests\AddTaxRateRequest;

class TaxRatesController extends Controller
{
    /**
     * Display base page for taxrates.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('taxrates.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTaxRates()
    {
        return TaxRate::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddTaxRateRequest $request)
    {
        $taxExists = TaxRate::where('Tax', $request->Tax)->get();
        $taxrate = new TaxRate();
        $taxrate->Tax = $request->Tax;
        $taxrate->TaxValue = $request->TaxValue;
        $taxrate->IsDefault = $request->IsDefault;
        $taxrate->CreationIP = request()->ip();
        $taxrate->created_by = 1;
        $taxrate->CreatedByModule = "model";

        if(count($taxExists) == 0)
        {
           $taxrate->save();

          return response()->json([
            'success' => true,
            'message' => ["TaxRate '$request->TaxRate' created successfully."],
            'msgtype' => 'success',
            'taxrate' => $taxrate
          ]);
        }
        else
        {
         return response()->json([
             'success' => false,
             'message' => ["TaxRate '$request->TaxRate' already exists."],
             'msgtype' => 'error',
             'taxrate' => $taxrate
             
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
        $taxrate = TaxRate::find($request->id);
        
        $taxrate->Tax = $request->Tax;
        $taxrate->TaxValue = $request->TaxValue;
        $taxrate->IsDefault = $request->IsDefault;
        $taxrate->UpdationIP = request()->ip();

        $taxrate->save();

        return response()->json([
            'success' => true,
            'message' => ["TaxRate '$request->TaxRate' updated successfully."],
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
        TaxRate::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["TaxRate '$request->TaxRate' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
