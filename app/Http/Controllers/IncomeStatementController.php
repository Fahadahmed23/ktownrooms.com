<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class IncomeStatementController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('income_statement.index',['breadcrumb' => 'Income Statements']);
    }

    public function get_income_statement(Request $request)
    {
        // dd($request->all());

        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';
        $fiscal_year = $request->fiscal_year ?? '';
        $hotel_id = $request->hotel_id ?? '';

        $income_statements  = DB::select('call GetIncomeStatement(?,?,?,?)',array($fiscal_year,$start_date, $end_date, $hotel_id));
        // dd($income_statements);
        return response()->json([
            'income_statements'=>$income_statements,
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);

        
    }


    public function income_pdf(Request $request)
    {

        // dd($request->all());
        $fiscal_year = $request->fiscal_year;
        // dd($fiscal_year);
        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';
        $hotel_id = $request->hotel_id ?? '';

        $income_statements  = DB::select('call GetIncomeStatement(?,?,?,?)',array($fiscal_year,$start_date, $end_date, $hotel_id));

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('income_statement.pdf',['income_statements' => $income_statements]);
    
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
