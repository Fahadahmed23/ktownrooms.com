<?php

namespace App\Http\Controllers;

use App\Models\AccountGeneralLedger;
use App\Models\Hotel;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LedgerController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('ledgers.index',['breadcrumb' => 'Genaral Ledgers']);
    }

    public function getAccountGL()
    {
        $general_ledgers = AccountGeneralLedger::get();
        foreach ($general_ledgers as $key => $value) {
            # code...
            $general_ledgers[$key]['agl_state'] = 'unselected';
        }
        $fiscal_year = date('Y') .'-'. date('y', strtotime('+1 year'));
        $hotels = Hotel::all();
        $is_admin = true;
        $current_user_hotel_id = null;
        if (!auth()->user()->hasRole('Admin')) {
            $is_admin = false;
            $current_user_hotel_id = auth()->user()->hotel_id;
        }

        // dd($general_ledgers);
        return response()->json([
            'general_ledgers'=> $general_ledgers,
            'fiscal_year'=> $fiscal_year,
            'hotels'=>$hotels,
            'is_admin'=> $is_admin,
            'current_user_hotel_id'=> $current_user_hotel_id,
        ]);

    }


    public function get_ledger(Request $request)
    {
        // dd($request->all());

        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';
        $status = $request->status ?? '';
        $account_gl_ids = isset($request->account_gl_ids) ?implode(",", $request->account_gl_ids) : '';
        $hotel_id = $request->hotel_id ?? '';

        $account_gls  = DB::select('call GetGeneralLedger(?,?,?,?,?)',array($start_date, $end_date,$account_gl_ids,$status, $hotel_id));
        // dd($account_gls);
        return response()->json([
            'account_gls'=>$account_gls,
        ])->setEncodingOptions(JSON_NUMERIC_CHECK);

        
    }


    public function pdfview(Request $request)
    {

        // dd($request->all());
        $fiscal_year = $request->fiscal_year ?? (date('Y') .'-'. date('y', strtotime('+1 year')));
        // dd($fiscal_year);
        $start_date = $request->start_date ?? '';
        $end_date = $request->end_date ?? '';
        $status = $request->status ?? '';
        $account_gl_ids = isset($request->account_gl_ids) ?implode(",", $request->account_gl_ids) : '';
        $hotel_id = $request->hotel_id ?? '';

        $account_gls  = DB::select('call GetGeneralLedger(?,?,?,?,?)',array($start_date, $end_date,$account_gl_ids,$status, $hotel_id));

        $pdf = app('dompdf.wrapper');
        $pdf->getDomPDF()->set_option("enable_php", true);
        $pdf->loadView('ledgers.pdf',['general_ledgers' => $account_gls, 'status'=>$status, 'fiscal_year'=>$fiscal_year]);
    
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
