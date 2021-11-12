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
        $level = $request->level;
        $start_date = $request->start_date ?? NULL;
        $end_date = $request->end_date ?? NULL;
        $fiscal_year = $request->fiscal_year;
        // $hotel_id = $request->hotel_id ?? NULL;

        $hotel_id = isset($request->hotel_id) ?implode(",", $request->hotel_id) : '';
        // dd($hotel_id);

        $balance_sheets  = DB::select('call GetBalanceSheet(?,?,?,?,?)',array($level, $fiscal_year,$start_date, $end_date, $hotel_id));
        // $income_statements  = DB::select('call GetIncomeStatement(?,?,?,?,?)',array(1,$fiscal_year,$start_date, $end_date, $hotel_id));
        
        $net = 0;
        $net_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Total Equity';
        });
        $array_key = array_keys($net_array);
        $net = $net_array[$array_key[0]]->Total; 

        $total_liability = 0;
        $liability_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Total Liabilities';
        });
        $array_key = array_keys($liability_array);
        $total_liability = $liability_array[$array_key[0]]->Total; 

        // dd($net);

        $total = 0;
        $total_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Net Income';
        });
        $array_key = array_keys($total_array);
        $total = $total_array[$array_key[0]]->Total; 

        $total_equity = 0;
        $total_equity = floatval($total) + floatval($net) + floatval($total_liability);

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

        $level = $request->level;
        $start_date = $request->start_date ?? NULL;
        $end_date = $request->end_date ?? NULL;
        $fiscal_year = $request->fiscal_year;
        // $hotel_id = $request->hotel_id ?? NULL;
        $hotel_id = isset($request->hotel_id) ?implode(",", $request->hotel_id) : '';

        $balance_sheets  = DB::select('call GetBalanceSheet(?,?,?,?,?)',array($level, $fiscal_year,$start_date, $end_date, $hotel_id));
        // $income_statements  = DB::select('call GetIncomeStatement(?,?,?,?,?)',array(1,$fiscal_year,$start_date, $end_date, $hotel_id));
        
        $net = 0;
        $net_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Total Equity';
        });
        $array_key = array_keys($net_array);
        $net = $net_array[$array_key[0]]->Total; 

        $total_liability = 0;
        $liability_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Total Liabilities';
        });
        $array_key = array_keys($liability_array);
        $total_liability = $liability_array[$array_key[0]]->Total; 


        // dd($net);

        $total = 0;
        $total_array = array_filter($balance_sheets, function ($event)  {
            return $event->AccountTitle == 'Net Income';
        });
        $array_key = array_keys($total_array);
        $total = $total_array[$array_key[0]]->Total; 

        $total_equity = 0;
        $total_equity = floatval($total) + floatval($net) + floatval($total_liability);

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
