<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Validator;




class CustomersController extends Controller
{


    /**
     * Display base page for facilities.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('customers.index',['breadcrumb' => 'Customers']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCustomers()
    {
        $customers = Customer::orderBY('FirstName', 'ASC')->get();

        // for dropdown
        $path = public_path('/json/nationalities.json');
        $nationalities = json_decode(file_get_contents($path), true);

        return response()->json([
            'customers'=> $customers,
            'nationalities'=>$nationalities,
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        // dd($request->all());
        
        $customerExists = Customer::where('FirstName', $request->FirstName)->get();

            $customer = new Customer();
            $customer->FirstName = $request['FirstName'];
            $customer->LastName = $request['LastName'];
            $customer->Email = $request['Email'];
            $customer->Phone = $request['Phone'];
            $customer->iso = $request['iso'];
            $customer->CNIC = $request['CNIC'];
            $customer->IsActive = $request['IsActive'];
            $customer->is_cnic = $request['is_cnic'];
            $customer->nationality = $request['nationality'];

        if(count($customerExists) == 0)
        {
         $customer->save();

        return response()->json([
            'success' => true,
            'message' => ["Customer '$request->FirstName' created successfully."],
            'msgtype' => 'success',
            'customer' => $customer
        ]);
       }
       else
       {
        return response()->json([
            'success' => false,
            'message' => ["Customer '$request->FirstName' already exists."],
            'msgtype' => 'error',
            'customer' => $customer
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
            $customer = Customer::find($request->id);
            
            $customer->FirstName = $request['FirstName'];
            $customer->LastName = $request['LastName'];
            $customer->Email = $request['Email'];
            $customer->Phone = $request['Phone'];
            $customer->CNIC = $request['CNIC'];
            $customer->iso = $request['iso'];
            $customer->IsActive = $request['IsActive'];
            $customer->is_cnic = $request['is_cnic'];
            $customer->nationality = $request['nationality'];
            $customer->save();

        return response()->json([
            'success' => true,
            'message' => ["Customer '$request->FirstName' updated successfully."],
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
        $customer = Customer::where('id',$request->id)->first();
        // dd($customer);
        $customer->delete();
        return response()->json([
            'success' => true,
            'message' => ["Customer ".$customer->FirstName."  deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }



    public function blacklistCustomer(Request $request)
    {
        // dd($request->all());
        $customer = Customer::find($request->id);
        $customer->black_list = 1;
        $customer->save();

        return response()->json([
            'success' => true,
            'message' => ["Customer '$customer->FirstName' black listed successfully."],
            'msgtype' => 'success'
        ]);
    }


}
