<?php

namespace App\Http\Controllers;

use App\Models\AccountFiscalYearMaster;
use App\Models\AccountGeneralLedger;
use App\Models\VoucherDetail;
use App\Models\VoucherMaster;
use App\Models\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class BalanceSheetController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('balance_sheet.index',['breadcrumb' => 'Balance Sheet']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function get_balance_sheet(Request $request)
    {
        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';
        $fiscal_year = $request->fiscal_year ?? '';
        $hotel_id = $request->hotel_id ?? '';

        $balance_sheets  = DB::select('call GetBalanceSheet(?,?,?,?)',array($fiscal_year,$start_date, $end_date, $hotel_id));
        $income_statements  = DB::select('call GetIncomeStatement(?,?,?,?)',array($fiscal_year,$start_date, $end_date, $hotel_id));
        
        $net = 0;
        $net_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Total Equity';
        });
        $array_key = array_keys($net_array);
        $net = $net_array[$array_key[0]]->Net; 

        // dd($net);

        $total = 0;
        $total_array = array_filter($income_statements, function ($event)  {
            return $event->AccountTitle == 'Net Income';
        });
        $array_key = array_keys($total_array);
        $total = $total_array[$array_key[0]]->Total; 

        $total_equity = 0;
        $total_equity = floatval($total) + floatval($net);

        // dd($total_equity);
        // forea
        // $balance_sheets[]
        return response()->json([
            'balance_sheets'=>$balance_sheets,
            'total_equity'=>$total_equity,
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);

    }

    public function balance_sheet_pdf(Request $request)
    {

        // dd($request->all());
        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';
        $fiscal_year = $request->fiscal_year ?? '';
        $hotel_id = $request->hotel_id ?? '';

        $balance_sheets  = DB::select('call GetBalanceSheet(?,?,?,?)',array($fiscal_year,$start_date, $end_date, $hotel_id));
        $income_statements  = DB::select('call GetIncomeStatement(?,?,?,?)',array($fiscal_year,$start_date, $end_date, $hotel_id));
        
        $net = 0;
        $net_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Total Equity';
        });
        $array_key = array_keys($net_array);
        $net = $net_array[$array_key[0]]->Net; 

        // dd($net);

        $total = 0;
        $total_array = array_filter($income_statements, function ($event)  {
            return $event->AccountTitle == 'Net Income';
        });
        $array_key = array_keys($total_array);
        $total = $total_array[$array_key[0]]->Total; 

        $total_equity = 0;
        $total_equity = floatval($total) + floatval($net);

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('balance_sheet.pdf',['balance_sheets' => $balance_sheets, 'total_equity'=> $total_equity]);
    
        $filename = time() . ".pdf";

        $pdf->save('pdf/' . $filename);
        $pdf->download($filename);

        // $pdf = PDF::loadView('ledgers.pdf',['general_ledgers' => $account_gls]);
        // //dd($pdf);
        // return $pdf->download('pdfview.pdf');


        return response()->json([
            'success'=>true,
            'filename' => $filename,
        ]);
    }

}
