<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Company;
// use Validator;
use App\Http\Requests\AddCompanyRequest;
use Illuminate\Support\Facades\DB;
use DateTime;

class CompaniesController extends Controller
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
     * Display base page for companies.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('companies.index',['breadcrumb' => 'Companies']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCompanies()
    {
        return Company::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCompanyRequest $request)
    {
        
        $companyExists = Company::where(DB::raw("UPPER(CompanyName)"), strtoupper($request->CompanyName))->
        where('CompanyName', $request->CompanyName)->get();
        $company = new Company();
        $company->CompanyName = $request->CompanyName;
        $company->CreationIP = "198";
        $company->created_by = 1;
        $company->CreatedByModule = "model";
        if(count($companyExists) == 0)
        {
        
        $company->save();

        return response()->json([
            'success' => true,
            'message' => ["Company '$request->CompanyName' created successfully."],
            'msgtype' => 'success',
            'company' => $company
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Company '$request->CompanyName' already exists."],
            'msgtype' => 'error',
            'company' => $company
            
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
        $company = Company::find($request->id);
        
        $company->CompanyName = $request->CompanyName;
        $company->UpdationIP = request()->ip();

        $company->save();

        return response()->json([
            'success' => true,
            'message' => ["Company '$request->CompanyName' updated successfully."],
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
        Company::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Company '$request->CompanyName' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
