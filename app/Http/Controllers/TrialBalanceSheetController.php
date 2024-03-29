<?php

namespace App\Http\Controllers;

use App\Models\AccountFiscalYearMaster;
use App\Models\AccountGeneralLedger;
use App\Models\AccountLevel;
use App\Models\Hotel;
use App\Models\VoucherDetail;
use App\Models\VoucherMaster;
use App\Models\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class TrialBalanceSheetController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('trial_balance_sheet.index',['breadcrumb' => 'Trial Balance Sheet']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function TrialBalanceSheet(Request $request)
    {
        // dd($request->start_date);

        $account_heads  = DB::select('call gettrialbalance(?,?,?,?,?)',array($request->level,$request->fiscal_year, $request->start_date , $request->end_date, $request->hotel_id));
        return response()->json([
            'account_heads'=>$account_heads,
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);

    }

    public function getLevels_FiscalYear()
    {
        $levels = AccountLevel::all();
        $fiscal_years = AccountFiscalYearMaster::all();
        $hotels = Hotel::all();
        $is_admin = true;
        $current_user_hotel_id = null;
        if (!auth()->user()->hasRole('Admin')) {
            $is_admin = false;
            $current_user_hotel_id = auth()->user()->hotel_id;
        }
        return response()->json([
            'fiscal_years'=>$fiscal_years,
            'levels'=>$levels,
            'hotels'=>$hotels,
            'is_admin'=> $is_admin,
            'current_user_hotel_id'=> $current_user_hotel_id,
        ]);
    }

    public function tb_pdfview(Request $request)
    {
        $account_heads  = DB::select('call gettrialbalance(?,?,?,?,?)',array($request->level,$request->fiscal_year, $request->start_date , $request->end_date, $request->hotel_id));
        $totalDebit = 0;
        $totalCredit = 0;
        foreach ($account_heads as $key => $value) {
            $totalDebit += $account_heads[$key]->Debit;
            $totalCredit += $account_heads[$key]->Credit;
        }
        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('trial_balance_sheet.pdf',['account_heads' => $account_heads, 'totalDebit'=> number_format($totalDebit, 2), 'totalCredit'=> number_format($totalCredit, 2), 'level'=> $request->level]);
    
        $filename = time() . ".pdf";

        $pdf->save('tb_pdf/' . $filename);
        $pdf->download($filename);
        
        return response()->json([
            'success'=>true,
            'filename' => $filename,
        ]);
    }


}
