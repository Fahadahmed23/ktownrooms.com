<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\PaymentMode;
// use Validator;
use App\Http\Requests\AddPaymentModeRequest;
use Illuminate\Support\Facades\DB;
use DateTime;

class PaymentModesController extends Controller
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
     * Display base page for paymentmodes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('paymentmodes.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPaymentModes()
    {
        return PaymentMode::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddPaymentModeRequest $request)
    {
        $paymentmodeExists = PaymentMode::where('PaymentMode', $request->PaymentMode)->get();
        $paymentmode = new PaymentMode();

        $paymentmode->PaymentMode = $request->PaymentMode;
        $paymentmode->CreationIP = "198";
        $paymentmode->created_by = 1;
        $paymentmode->CreatedByModule = "model";
        if(count($paymentmodeExists) == 0)
        {
        
        $paymentmode->save();

        return response()->json([
            'success' => true,
            'message' => ["PaymentMode '$request->PaymentMode' created successfully."],
            'msgtype' => 'success',
            'paymentmode' => $paymentmode
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["PaymentMode '$request->PaymentMode' already exists."],
            'msgtype' => 'error',
            'paymentmode' => $paymentmode
            
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
        $paymentmode = PaymentMode::find($request->id);
        
        $paymentmode->PaymentMode = $request->PaymentMode;
        $paymentmode->UpdationIP = request()->ip();

        $paymentmode->save();

        return response()->json([
            'success' => true,
            'message' => ["PaymentMode '$request->PaymentMode' updated successfully."],
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
        PaymentMode::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["PaymentMode '$request->PaymentMode' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
