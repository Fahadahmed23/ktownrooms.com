<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\AddDepartmentRequest;

use App\Models\Department;
use App\Models\ServiceType;
// use Validator;
use App\Http\Requests\AddServiceRequest;
use App\Models\Company;
use App\Models\Service;
use App\Models\State;
use Illuminate\Support\Facades\DB;
use DateTime;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{

    protected $module_name = "Department";

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
     * Display base page for services.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        return view('department.index',['breadcrumb' => 'Departments']);
    }

    public function getIcons()
    {
        $path = public_path('/json/icons.json');
        $content = json_decode(file_get_contents($path), true);
         return json_encode($content);
        // dd($content);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getnDepartments()
    {
      $services=  Service::all();
      $departments=  Department::with(['services','company'])->get();
      $servicetypes= ServiceType::all();
      $companies= Company::all();
      
      return response()->json([
          'services'=> $services,
          'departments'=>$departments,
          'servicetypes'=>$servicetypes,
          'companies'=>$companies,
      ])->setEncodingOptions(JSON_NUMERIC_CHECK);
       
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddDepartmentRequest $request)
    {
        //  dd(request()->all());  
        $departmentExists = Department::where('Department', $request->Department)->get();
        if (count($departmentExists) == 0) {
            $department = new Department();
            $department->company_id = $request->company_id;
            $department->Department = $request->Department;
            $department->IconPath = $request->IconPath;
            $department->bg_color = $request->bg_color;
            $department->CreationIP= request()->ip();
            $department->created_by= Auth::id();
            $department->CreatedByModule= $this->module_name;
            $department->IsClientService = $request->IsClientService;
            
            $department->save();
            return response()->json([
                'success' => true,
                'message' => ["Department '$request->Department' Added Successfully!"],
                'msgtype' => 'success',
                'department' => $department
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => ["Department '$request->Department' already exists."],
                'msgtype' => 'error',
               
                ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        }

            // if (!empty($request->services)){
               
            //     foreach($request->services as $key => $s){
            //         // $serviceExists = Service::where('Service', $s['Service'])->get();
                    
            //         // if (count($serviceExists) > 0) { 
            //         //     return response()->json([
            //         //         'success' => false,
            //         //         'message' => ["Service ".$request->services[$key]['Service']." already exists."],
            //         //         'msgtype' => 'error',
                           
            //         //         ]);
            //         // }
            //         // else
            //         // {
            //             $service = new Service();
            //             $service->department_id = $department->id;
            //             $service->Service = $s['Service'];
            //             $service->service_type_id = $s['service_type_id'];
            //             $service->Charges = $s['Charges'];
            //             $service->ServingTime = $s['ServingTime'];
            //             $service->IconPath = $s['IconPath'];
            //             $service->IsShowDelayAlert = empty($s['IsShowDelayAlert'])?0:1;
            //             $service->CreationIP= request()->ip();
            //             $service->created_by= Auth::id();
            //             $service->CreatedByModule= $this->module_name;
            //             $service->save();
            //         // }
                    
            //     }
            // }  
    }

    public function update(Request $request, $id)
    {
        //  dd($request->services);
        // dd(request()->all());  
        DB::beginTransaction();

        try {
            $department = Department::find($id);
            $department->company_id = $request->company_id;
            $department->Department = $request->Department;
            $department->IconPath = $request->IconPath;
            $department->bg_color = $request->bg_color;
            $department->CreationIP= request()->ip();
            $department->created_by= Auth::id();
            $department->CreatedByModule= $this->module_name;
            $department->IsClientService = $request->IsClientService;
            $department->save();


            // Service::where('department_id','=',$id)->delete();

            // if (!empty($request->services)){
            //     foreach($request->services as $s){
            //         $service = new Service();
            //         $service->department_id = $department->id;
            //         $service->Service = $s['Service'];
            //         $service->service_type_id = $s['service_type_id'];
            //         $service->Charges = $s['Charges'];
            //         $service->ServingTime = $s['ServingTime'];
            //         $service->IconPath = $s['IconPath'];
            //         $service->IsShowDelayAlert = empty($s['IsShowDelayAlert'])?0:1;
            //         $service->CreationIP= request()->ip();
            //         $service->created_by= Auth::id();
            //         $service->CreatedByModule= $this->module_name;
            //         $service->save();
            //     }
            // }

            $department = Department::where('id', '=', $department->id)->first();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => ["Department '$department->Department' Updated Successfully!"],
                'msgtype' => 'success',
                'department' => $department
            ])->setEncodingOptions(JSON_NUMERIC_CHECK);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => [$e->getMessage()],
                'msgtype' => 'danger',
            ]);
        }
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
        $name = $request->department['Department'];
        Department::find($request->department['id'])->delete();

        return response()->json([
            'success' => true,
            'message' => ["Department '$name' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    // public function saveService(Request $request)
    // {
    //     if ($request['formType'] == "save") {
    //         $service = new Service();
    //         $msg="Saved";
    //     } else {
    //         $service = Service::find($request['service']['id']);
    //         $msg = "Updated";
    //     }

    //     $service->department_id = $request->department_id;
    //     $service->Service = $request['service']['Service'];
    //     $service->service_type_id = $request['service']['service_type_id'];
    //     $service->Charges =$request['service']['Charges'];
    //     $service->ServingTime = $request['service']['ServingTime'];
    //     $service->IconPath = $request['service']['IconPath'];
    //     $service->IsShowDelayAlert= empty($request['service']['IsShowDelayAlert']) ? 0 : $request['service']['IsShowDelayAlert'];
    //     $service->CreationIP= request()->ip();
    //     $service->created_by= Auth::id();
    //     $service->CreatedByModule= $this->module_name;
    //     $service->save();

    //     return response()->json([
    //         'success' => true,
    //         'message' => ["Service $msg Successfully"],
    //         'msgtype' => 'success',
    //         'service' => $service
    //     ]);
    // }

    // public function removeService(Request $request) {
    //     // dd($request->all());
    //     Service::find($request->id)->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => ['Service deleted successfully'],
    //         'msgtype' => 'success',
    //         'id'=> $request->id,
    //     ]);
    // }










}
