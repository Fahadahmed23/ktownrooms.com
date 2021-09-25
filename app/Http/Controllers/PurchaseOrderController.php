<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Hotel;
use App\Models\Inventory;
use App\Models\PurchaseOrder;
use App\Models\PurchaseOrderDetail;
use App\Models\Vendor;
use Illuminate\Support\Facades\Auth;


class PurchaseOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('purchaseorders.index',['breadcrumb' => 'Purchase Orders']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getPurchaseOrders(Request $request)
    {

        $qry = PurchaseOrder::with(['details.inventory'])->orderBy('id', 'ASC');
        $hotels = Hotel::orderBy('HotelName', 'ASC')->get();
        $vendors = Vendor::orderBy('Name', 'ASC')->get();
        $inventories = Inventory::orderBy('Title', 'ASC')->get();


        $user = Auth::user();
        if (auth()->user()->hasRole('Admin')) {
            $purchase_orders = $qry->get();
            $is_admin = true;
            }
            else{
                $purchase_orders = $qry->where('hotel_id', auth()->user()->hotel->id)->get();
                $is_admin = false;
            }
        return response()->json([
            'user'=>$user,
            'is_admin'=>$is_admin,
            'purchase_orders'=> $purchase_orders,
            'hotels'=> $hotels,
            'inventories'=> $inventories,
            'vendors'=> $vendors,
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
        //  dd($request->all());
        \DB::beginTransaction();
        try{
            $po = new PurchaseOrder();
            $po->hotel_id = $request->purchase_order['hotel_id'];
            $po->vendor_id = $request->purchase_order['vendor_id']; 
            $po->PurchaseOrderDate = $request->purchase_order['purchase_date'];
            $po->Status = $request->purchase_order['Status'];
            $po->PurchaseOrderNumber = Hotel::where('id',$request->purchase_order['hotel_id'])->pluck('Code')[0].'-PO-'.$request->purchase_order['purchase_date']; 
            $po->gTotal = $request->purchase_order['gTotal'];
            $po->save();


            foreach($request->purchase_order['details'][0] as $p){
                $pod = new PurchaseOrderDetail();
                $pod->purchase_order_id =  $po->id;
                $pod->inventory_id = $p['inventory_id'];
                $pod->Description = $p['Description'];
                $pod->Quantity = $p['Quantity'];
                $pod->Rate = $p['Rate'];
                $pod->Total = ($p['Rate']) * ($p['Quantity']);
                $pod->save();
            }
            $po = PurchaseOrder::where('id', '=', $po->id)->first();
        }catch (\Exception $e) {
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => ['Purchase order cannot be created'],
                'msgtype' => 'danger',
                'po'=>$po
            ]);
        }
        \DB::commit();
            return response()->json([
                'success' => true,
                'message' => [$po->PurchaseOrderNumber. " created successfully"],
                'msgtype' => 'success',
                'purchase_order' => $po
            ]); 
    }
    public function update(Request $request , $id)
    {
        // dd($request->all());
        \DB::beginTransaction();
        try{
        $po = PurchaseOrder::find($id);
        $po->hotel_id = $request->purchase_order['hotel_id'];$po->hotel_id = $request->purchase_order['hotel_id'];
        $po->vendor_id = $request->purchase_order['vendor_id']; 
        $po->PurchaseOrderDate = $request->purchase_order['purchase_date'];
        $po->Status = $request->purchase_order['Status'];
        $po->PurchaseOrderNumber = Hotel::where('id',$request->purchase_order['hotel_id'])->pluck('Code')[0].'-PO-'.$request->purchase_order['purchase_date']; 
        $po->gTotal = $request->purchase_order['gTotal'];
        $po->save();
        
        PurchaseOrderDetail::where('purchase_order_id',$id)->delete();
        foreach($request->purchase_order['details'][0] as $p){

            $pod = new PurchaseOrderDetail();
            $pod->purchase_order_id =  $po->id;
            $pod->inventory_id = $p['inventory_id'];
            $pod->Description = $p['Description'];
            $pod->Quantity = $p['Quantity'];
            $pod->Rate = $p['Rate'];
            $pod->Total = ($p['Rate']) * ($p['Quantity']);
            $pod->save();
        }
        $po = PurchaseOrder::where('id', '=', $po->id)->first();
        }catch (\Exception $e) {
            dd($e);
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => ['Purchase order cannot be created'],
                'msgtype' => 'danger'
            ]);
        }
        \DB::commit();
            return response()->json([
                'success' => true,
                'message' => [ $po->PurchaseOrderNumber. " updated successfully"],
                'msgtype' => 'success',
                'purchase_order' => $po
            ]);
    }

    public function delete(Request $request) 
    {
        $po = PurchaseOrder::find($request->id);
        $message = [$po->PurchaseOrderNumber. " deleted successfully!"];
        $po->delete();
        PurchaseOrderDetail::where('purchase_order_id',$request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

}
