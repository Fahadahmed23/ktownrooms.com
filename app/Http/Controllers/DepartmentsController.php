<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Department;
use App\Models\Company;
use App\Models\State;
// use Validator;
use App\Http\Requests\AddDepartmentRequest;
use Illuminate\Support\Facades\DB;

class DepartmentsController extends Controller
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
     * Display base page for departments.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('departments.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getDepartmentsDepartment()
    {
        // return Department::all();
        return DB::table('departments')
        ->join('companies', 'departments.company_id', '=', 'companies.id')
        ->join('states', 'departments.state_id', '=', 'states.id') 
        ->select('departments.*' , 'companies.CompanyName' , 'states.StateName')
        ->get();
    }

    public function getCompanies()
    {
        return Company::all();
    }

    public function getStates()
    {
        return State::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddDepartmentRequest $request)
    {
        $departmentExists = Department::where('Department', $request->Department)->get();
        $department = new Department();
        $department->company_id = $request->company_id;
        $department->Department = $request->Department;
        $department->state_id = $request->state_id;
        $department->CreationIP = "198";
        $department->created_by = 1;
        $department->CreatedByModule = "model";
        if(count($departmentExists) == 0)
        {
        
        $department->save();

        return response()->json([
            'success' => true,
            'message' => ["Department '$request->Department' created successfully."],
            'msgtype' => 'success',
            'department' => $department
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Department '$request->Department' already exists."],
            'msgtype' => 'error',
            'department' => $department
            
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
        $department = Department::find($request->id);
        $department->company_id = $request->company_id;
        $department->Department = $request->Department;
        $department->state_id = $request->state_id;
        $department->UpdationIP = request()->ip();

        $department->save();

        return response()->json([
            'success' => true,
            'message' => ["Department '$request->Department' updated successfully."],
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
        Department::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Department '$request->Department' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
