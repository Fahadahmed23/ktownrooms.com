<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Promotion;
// use Validator;
use App\Http\Requests\AddPromotionRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
class PromotionsController extends Controller
{
    /**
     * Display base page for promotions.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('promotions.index',['breadcrumb' => 'Promotions']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function getPromotions()
    {
        return Promotion::where('deleted_at', Null)->get();
    }
    
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(AddPromotionRequest $request)
    {     
        
        $promoExists = Promotion::where('PromoName', $request->PromoName)->get();

        $f= $request->ValidFrom;
        $t= $request->ValidTo;

        $fromdate = Carbon::parse($f)->format('Y-m-d');
        $todate = Carbon::parse($t)->format('Y-m-d');
            if ($fromdate> $todate) 
            {
                return response()->json([
                    'success' => false,
                    'message' => ["To Date should be greater than from Date"],
                    'msgtype' => 'danger',
                ]);
            }
            if ($todate < $fromdate) 
            {
                return response()->json([
                    'success' => false,
                    'message' => ["From Date should be less than to Date"],
                    'msgtype' => 'danger',
                ]);
            }
        // $DiscountValue = round($request->DiscountValue, 2);
        $promo = new Promotion();
        $promo->PromoName = $request->PromoName;
        $promo->Code = $request->Code;
        // $promo->IsPercentage = $request->IsPercentage == "" ? 0 : 1;
        $promo->IsPercentage = $request->IsPercentage;
        $promo->DiscountValue =$request->DiscountValue;
          
        $promo->ValidFrom = $fromdate;
        $promo->ValidTo = $todate;
        $promo->CreationIP =  request()->ip();
        $promo->created_by = 1;
        $promo->CreatedByModule = "Promotion";

        if(count($promoExists) == 0)
            { 
                $promo->save();
                return response()->json([
                    'success' => true,
                    'message' => ["Promotion '$request->PromoName' created successfully."],
                    'msgtype' => 'success',
                    'promotion' => $promo
                ]);
            }
        else
        {
            return response()->json([
                'success' => false,
                'message' => ["Promotion '$request->PromoName' already exists."],
                'msgtype' => 'error',
                'promotion' => $promo
                
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
       
        $f= $request->ValidFrom;
        $t= $request->ValidTo;

        $fromdate = Carbon::parse($f)->format('Y-m-d');
        $todate = Carbon::parse($t)->format('Y-m-d');


            if ($fromdate> $todate) 
            {
                return response()->json([
                    'success' => false,
                    'message' => ["To Date should be greater than from Date"],
                    'msgtype' => 'danger',
                ]);
            }
            if ($todate < $fromdate) 
            {
                return response()->json([
                    'success' => false,
                    'message' => ["From Date should be less than to Date"],
                    'msgtype' => 'danger',
                ]);
            }


        // $DiscountValue = round($request->DiscountValue);
        // dd($request->DiscountValue);
        $promo = Promotion::find($request->id);
        $promo->promoName = $request->PromoName;
        $promo->id = $request->id;        
        $promo->Code = $request->Code;
        $promo->IsPercentage = $request->IsPercentage;
        $promo->DiscountValue = $request->DiscountValue;
        $promo->ValidFrom = $fromdate;
        $promo->ValidTo = $todate;
        $promo->UpdationIP = request()->ip();
        $promo->updated_by = '1';
        // dd($promo);
        $promo->save();

        return response()->json([
            'success' => true,
            'message' => ["Promo '$request->PromoName' updated successfully."],
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
        // dd($request->id);
        Promotion::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Promotion Code deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    
}
