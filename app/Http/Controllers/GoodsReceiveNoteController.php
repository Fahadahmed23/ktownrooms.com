<?php

namespace App\Http\Controllers;

use App\Models\GoodRecieveNoteDetail;
use App\Models\GoodsReceiveNote;
use App\Models\GoodsReceiveNoteDetail;
use App\Models\Inventory;
use App\Models\Hotel;
use App\Models\PurchaseOrder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
class GoodsReceiveNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('goodsreceivenotes.index',['breadcrumb' => 'Goods Receive Notes']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getGoodsReceiveNotes(Request $request)
    {
        $qry = GoodsReceiveNote::orderBy('id', 'ASC');
        $hotels= Hotel::orderBy('HotelName', 'ASC')->get();
        $user = Auth::user();
        if (auth()->user()->hasRole('Admin')) {
            $goods_receive_notes = $qry->get();
            $purchase_orders = PurchaseOrder::where('Status', 'pending')->with('details')->get();
            $inventories = Inventory::orderBy('Title', 'ASC')->get();
            $is_admin = true;
        }
        else{
            $goods_receive_notes = $qry->where('hotel_id', auth()->user()->hotel->id)->get();
            $purchase_orders = PurchaseOrder::where('Status', 'pending')->where('hotel_id',auth()->user()->hotel_id)->with('details')->get();
            $inventories = Inventory::orderBy('Title', 'ASC')->where('hotel_id',auth()->user()->hotel_id)->get();
            $is_admin = false;
        }
        

        return response()->json([
            'is_admin'=>$is_admin,
            'user' => $user,
            'hotels'=>$hotels,
            'purchase_orders'=> $purchase_orders,
            'goods_receive_notes'=> $goods_receive_notes,
            'inventories'=> $inventories, 
        ]);
    }

    public function getPO_GRN(Request $request)
    {
            $grn = GoodsReceiveNote::with(['grn_details.inventory','puchase_order'])->where('id',$request->id)->first();
            return response()->json([
                'grn'=> $grn,
                'success'=> true,
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
            $grn = new GoodsReceiveNote();
            $grn->purchase_order_id = $request->good_receive_note['purchase_order_id'];
            $grn->hotel_id          = $request->good_receive_note['hotel_id'];
            $grn->InvoiceNumber     = $request->good_receive_note['InvoiceNumber'];
            $grn->GRN_Date          = $request->good_receive_note['GRN_Date'];
            $grn->gTotal            = $request->good_receive_note['gTotal'];
            $grn->GRN_Number        = 'GRN-'.$request->good_receive_note['purchase_order_id'].'-'.$request->good_receive_note['GRN_Date'];
            $grn->save();   
                $po=PurchaseOrder::find($request->good_receive_note['purchase_order_id']);
                $po->Status = $request->good_receive_note['Status'];
                $po->save();

            
            foreach($request->good_receive_note['products'][0] as $g){
                $grnd = new GoodsReceiveNoteDetail();
                $grnd->goods_receive_note_id    = $grn->id;
                $grnd->inventory_id             = $g['inventory_id'];
                $grnd->Description              = $g['Description'];
                $grnd->ReceivedQuantity         = $g['Quantity'];
                $grnd->Rate                     = $g['Rate'];
                $grnd->Total                    = $g['Total'];
                $grnd->save();
            }   
            $grn = GoodsReceiveNote::where('id',$grn->id)->first();

        }catch(\Exception $e){
            dd($e);
            \DB::rollback();
            return response()->json([
                'success' => false,
                'message' => ['Good recieve note cannot be created'],
                'msgtype' => 'danger',
            ]);
        }
        \DB::commit();
        return response()->json([
                'success' => true,
                'message' => [ $grn->GRN_Number. " created successfully"],
                'msgtype' => 'success'
        ]);

    }


    public function delete(Request $request) 
    {
        $gnr = GoodsReceiveNote::find($request->id);
        $message = [$gnr->GRN_Number. " deleted successfully!"];
        $gnr->delete();
        GoodsReceiveNoteDetail::where('goods_receive_note_id',$request->id)->delete();
        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\GoodsReceiveNote  $goodsReceiveNote
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GoodsReceiveNote $goodsReceiveNote)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\GoodsReceiveNote  $goodsReceiveNote
     * @return \Illuminate\Http\Response
     */
    public function destroy(GoodsReceiveNote $goodsReceiveNote)
    {
        //
    }
}
