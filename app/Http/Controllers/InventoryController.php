<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Hotel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('inventory.index',['breadcrumb' => 'Inventories']);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getInventories(Request $request)
    {
        $qry = Inventory::with('hotel')->orderBy('Title', 'ASC');

            if(isset($request->Title)){
                $qry->where('Title', 'like', "%" . $request->Title . "%");
            }

            if(isset($request->Rate)){
                $qry->where('Rate', 'like', "%" . $request->Rate . "%");
            }

            if(isset($request->Description)){
                $qry->where('Description', 'like', "%" . $request->Description . "%");
            }

            if(isset($request->Hotel)){
                $qry->whereHas('hotel', function ($q) use ($request) {
                    $q->where('HotelName', 'like', "%" .$request->Hotel. "%");
                });
            }
        $user = Auth::user();
        if (auth()->user()->hasRole('Admin')) 
        {
            $inventories = $qry->get();
            $is_admin = true;
        }
            else{
                $inventories = $qry->whereIn('hotel_id', $user->HotelIds)->get();
                $is_admin = false;
            }

        // $hotels = Hotel::orderBy('HotelName', 'ASC')->get();
        $hotels = auth()->user()->user_hotels();
        
        return response()->json([
            'is_admin'=>$is_admin,
            'user'=>$user,
            'inventories'=> $inventories,
            'hotels'=>$hotels->get(),
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

        $inventory = new Inventory();

        $inventory->save($request->all());

        return response()->json([
            'success' => true,
            'message' => ["Inventory item $request->Title created successfully."],
            'msgtype' => 'success',
        ]);


    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function show(Inventory $inventory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function edit(Inventory $inventory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Inventory $inventory)
    {
        // dd($request->all());
        $inventory = Inventory::find($request->id);
        $inventoryData = [
            'hotel_id' => $request['hotel_id'],
            'Title' => $request['Title'],
            'Image' => $request['Image'],
            'Description' => $request['Description'],
            'Rate' => $request['Rate'],
            'LowStockAlert' => $request['LowStockAlert'],
            'Status' => $request['Status'],
        ];
       
        // dd($inventory);
        $inventory->save($inventoryData);

        return response()->json([
            'success' => true,
            'message' => ["Inventory item $request->Title updated successfully."],
            'msgtype' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Inventory  $inventory
     * @return \Illuminate\Http\Response
     */
    public function destroy(Inventory $inventory)
    {
        //
    }
}
