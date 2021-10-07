<?php

namespace App\Http\Controllers;

use App\Models\AccountLevel;
use App\Models\AccountType;
use App\Models\AccountSalesTax;
use App\Models\AccountSubType;
use App\Models\Company;
use App\Models\VoucherType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

// checking
// yes

class AccountLookupController extends Controller
{

    protected $module_name = "Accounts Lookup";

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
        return view('accountinglookups.index', [
            "breadcrumb" => "Account Lookup's"
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getAccountLookups()
    {
        $account_types= AccountType::all();
        $account_sub_types = AccountSubType::all();
        $voucher_types = VoucherType::all();
        $account_levels = AccountLevel::all();
        $account_sales_taxes = AccountSalesTax::all();
        // for dropdown
        $companies= Company::all();
        return response()->json([
            'account_types'=> $account_types,
            'account_sub_types'=>$account_sub_types,
            'voucher_types'=>$voucher_types,
            'account_levels'=>$account_levels,
            'account_sales_taxes'=>$account_sales_taxes,
            'companies'=>$companies
        ]);
    }

    // for Account Type
    public function saveAccountType(Request $request)
    {
        $accounTypeId = $request->account_type['id'] ?? null;
        $accountTypeExist = AccountType::where(DB::raw("UPPER(title)"), strtoupper($request->channel['title']))
        ->where('title', $request->account_type['title']) 
        ->where('id', '!=', $accounTypeId) 
        ->count();

        if ($accountTypeExist==0) {
            if ($request->formType == "save") {
                $account_type = new AccountType();
                $msg = "added ";
            } else {
                $account_type = AccountType::find($request->account_type['id']);
                $msg = "updated ";
            }
    
            $account_type->title = $request->account_type['title'];
            $account_type->description = $request->account_type['description'];
            $account_type->CreationIP = request()->ip();
            $account_type->created_by = Auth::id();
            $account_type->CreatedByModule = $this->module_name;
            $account_type->save();
    
            return response()->json([
                'success' => true,
                'message' => [" Account Type '".$account_type->title."' $msg successfully"],
                'msgtype' => 'success',
                'account_type' => $account_type
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Account Type '".$request->account_type['title']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }
        
        
    }

    public function deleteAccountType(Request $request) {
       
        $account_type = AccountType::findOrFail($request->id);
        $message = ["Account Type '$account_type->title' deleted successfully!"];
        $account_type->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
        
    }


    // for Account Sub Type
    public function saveAccountSubType(Request $request)
    {
        $accountSubTypeId = $request->account_sub_type['id'] ?? null;
        $accountSubTypeExist = AccountSubType::where(DB::raw("UPPER(title)"), strtoupper($request->channel['title']))
        ->where('title', $request->account_sub_type['title']) 
        ->where('id', '!=', $accountSubTypeId) 
        ->count();

        if ($accountSubTypeExist==0) {
            if ($request->formType == "save") {
                $account_sub_type = new AccountSubType();
                $msg = "added ";
            } else {
                $account_sub_type = AccountSubType::find($request->account_sub_type['id']);
                $msg = "updated ";
            }
    
            $account_sub_type->title = $request->account_sub_type['title'];
            $account_sub_type->account_type_id = $request->account_sub_type['account_type_id'];
            $account_sub_type->CreationIP = request()->ip();
            $account_sub_type->created_by = Auth::id();
            $account_sub_type->CreatedByModule = $this->module_name;
            $account_sub_type->save();
    
            return response()->json([
                'success' => true,
                'message' => [" Account Type '".$account_sub_type->title."' $msg successfully"],
                'msgtype' => 'success',
                'account_sub_type' => $account_sub_type
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Account Sub Type '".$request->account_sub_type['title']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }
        
        
    }

    public function deleteAccountSubType(Request $request) {
    //    dd($request->all());
        $account_sub_type = AccountSubType::findOrFail($request->id);

        $message = ["Account Sub Type '$account_sub_type->title' deleted successfully!"];
        $account_sub_type->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
        
    }




    // for Voucher Type
    public function saveVoucherType(Request $request)
    {
        // dd($request->all());
        $voucherTypeID = $request->voucher_type['id'] ?? null;
        $voucherTypeExist = VoucherType::where(DB::raw("UPPER(title)"), strtoupper($request->voucher_type['title']))
        ->where('title', $request->voucher_type['title']) 
        ->where('id', '!=', $voucherTypeID) 
        ->count();

        if ($voucherTypeExist==0) {
            if ($request->formType == "save") {
                $voucher_type = new VoucherType();
                $msg = "added ";
            } else {
                $voucher_type = VoucherType::find($request->voucher_type['id']);
                $msg = "updated ";
            }
            $voucher_type->title = $request->voucher_type['title'];
            $voucher_type->abbreviation = $request->voucher_type['abbreviation'];
            $voucher_type->description = $request->voucher_type['description'];
            $voucher_type->CreationIP = request()->ip();
            $voucher_type->created_by = Auth::id();
            $voucher_type->CreatedByModule = $this->module_name;
            $voucher_type->save();
    
            return response()->json([
                'success' => true,
                'message' => [" Voucher Type '".$voucher_type->title."' $msg successfully"],
                'msgtype' => 'success',
                'voucher_type' => $voucher_type
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Voucher Type '".$request->voucher_type['title']."' already exists."],
                'msgtype' => 'error',
                
                ]);
        }
        
        
    }
    
    public function deleteVoucherType(Request $request) 
    {
        
        $voucher_type = VoucherType::findOrFail($request->id);
        $message = ["VOucher Type '$voucher_type->title' deleted successfully!"];
        $voucher_type->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
        
    }


    // for Account Level 
    public function saveAccountLevel(Request $request)
    {
        // dd($request->all());
        $accountLevelID = $request->account_level['id'] ?? null;
        $accountLevelExist = AccountLevel::where(DB::raw("UPPER(name)"), strtoupper($request->account_level['name']))
        ->where('name', $request->account_level['name']) 
        ->where('id', '!=', $accountLevelID) 
        ->count();

        if ($accountLevelExist==0) {
            if ($request->formType == "save") {
                $account_level = new AccountLevel();
                $msg = "added ";
            } else {
                $account_level = AccountLevel::find($request->account_level['id']);
                $msg = "updated ";
            }
            $account_level->name = $request->account_level['name'];
            $account_level->level_no = $request->account_level['level_no'];
            $account_level->length = $request->account_level['length'];
            $account_level->is_entry_level = isset($request->account_level['is_entry_level']) ? $request->account_level['is_entry_level'] : '0'; 
            $account_level->is_active = isset($request->account_level['is_active']) ? $request->account_level['is_active'] : '0'; 
            $account_level->company_id = $request->account_level['company_id'];
            $account_level->CreationIP = request()->ip();
            $account_level->created_by = Auth::id();
            $account_level->CreatedByModule = $this->module_name;
            $account_level->save();
    
            return response()->json([
                'success' => true,
                'message' => [" Account Level '".$account_level->name."' $msg successfully"],
                'msgtype' => 'success',
                'account_level' => $account_level
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Account Level '".$request->account_level['name']."' already exists."],
                'msgtype' => 'error',
                
                ]);
        }
        
        
    }
    
    public function deleteAccountLevel(Request $request) 
    {
        
        $account_level = AccountLevel::findOrFail($request->id);
        $message = ["Account Level '$account_level->name' deleted successfully!"];
        $account_level->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
        
    }




    // for Account Sales tax
    public function saveAccountSalesTax(Request $request)
    {
        // dd($request->all());
        $accounSalesTaxId = $request->account_sales_tax['id'] ?? null;
        $accountSalesTaxExist = AccountSalesTax::where(DB::raw("UPPER(title)"), strtoupper($request->account_sales_tax['title']))
        ->where('title', $request->account_sales_tax['title']) 
        ->where('id', '!=', $accounSalesTaxId) 
        ->count();

        if ($accountSalesTaxExist==0) {
            if ($request->formType == "save") {
                $account_sales_tax = new AccountSalesTax();
                $msg = "added ";
            } else {
                $account_sales_tax = AccountSalesTax::find($request->account_sales_tax['id']);
                $msg = "updated ";
            }
            $account_sales_tax->title = $request->account_sales_tax['title'];
            $account_sales_tax->tax_rate = $request->account_sales_tax['tax_rate'];
            $account_sales_tax->is_active = isset($request->account_sales_tax['is_active']) ? $request->account_sales_tax['is_active'] : '0'; 
            $account_sales_tax->CreationIP = request()->ip();
            $account_sales_tax->created_by = Auth::id();
            $account_sales_tax->CreatedByModule = $this->module_name;
            $account_sales_tax->save();
    
            return response()->json([
                'success' => true,
                'message' => [" Sales Tax '".$account_sales_tax->title."' $msg successfully"],
                'msgtype' => 'success',
                'account_sales_tax' => $account_sales_tax
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Sales Tax '".$request->account_sales_tax['title']."' already exists."],
                'msgtype' => 'error',
                
                ]);
        }
        
        
    }
    
    public function deleteAccountSalesTax(Request $request) 
    {
        
        $account_sales_tax = AccountSalesTax::findOrFail($request->id);
        $message = ["Sales Tax '$account_sales_tax->title' deleted successfully!"];
        $account_sales_tax->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
        
    }

  
}
