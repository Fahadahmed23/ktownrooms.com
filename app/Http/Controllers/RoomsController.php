<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
use App\Models\TaxRate;
use App\Models\RoomType;
use App\Models\RoomCategories;
use App\Models\Hotel;

use App\Models\Facility;
// use Validator;
use App\Http\Requests\AddRoomRequest;
use App\Models\RoomCategory;
use Illuminate\Support\Facades\DB;

class RoomsController extends Controller
{
    /**
     * Display base page for rooms.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('rooms.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRooms()
    {

        $rooms = Room::with(['hotel', 'room_type' , 'category' , 'tax_rate'])->get();   
        // get data for dropdown
        $facilities = Facility::all();
        $hotels = Hotel::all();
        $roomtypes = RoomType::all();
        $roomcategories = RoomCategory::all();
        $taxrates = TaxRate::all();
        return  response()->json([
            'hotels'=>$hotels,
            'rooms'=> $rooms,
            'facilities' => $facilities,
            'roomtypes'=>$roomtypes,
            'roomcategories'=>$roomcategories,
            'taxrates'=>$taxrates,

        ]);
      
        
        // return Room::all();
    //    return DB::table('rooms')
    //         ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
    //         ->join('room_types', 'rooms.room_type_id', '=', 'room_types.id')
    //         ->join('room_categories', 'rooms.room_category_id', '=', 'room_categories.id')
    //         ->join('tax_rates', 'rooms.tax_rate_id', '=', 'tax_rates.id')            
    //         ->select('rooms.*' , 'hotels.HotelName' , 'room_types.RoomType' ,
    //          'room_categories.RoomCategory' , 'rooms.RoomNumber' , 
    //          'rooms.FloorNo' , 'rooms.RoomCharges' ,'tax_rates.Tax')->get();

    }
    // public function getHotels()
    // {
    // $hotels = Hotel::all();
    // dd($hotels);
    // return response()->json([
    //     'hotels'=> $hotels,
    // ]); 
    // }

    // public function getRoomTypes()
    // {
    //     return RoomType::all();
    // }

    // public function getRoomCategories()
    // {
    //     return RoomCategory::all();
    // }
    // public function getTaxRates()
    // {
    //     return TaxRate::all();
    // }
    // public function getHotels()
    // {
    //     return Hotel::all();
    // }
    

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddRoomRequest $request)
    {
         //$roomExists = Room::where('Room', $request->Room)->get();
         $room = new Room();
         $room->hotel_id = $request->hotel_id;
         $room->room_type_id = $request->room_type_id;
         $room->room_category_id = $request->room_category_id;
         $room->room_title = $request->room_title;
         $room->RoomNumber = $request->RoomNumber;
         $room->FloorNo = $request->FloorNo;
         $room->RoomCharges = $request->RoomCharges;
         $room->tax_rate_id = $request->tax_rate_id;
         $room->CreationIP = request()->ip();
         $room->created_by = 1;
         $room->CreatedByModule = "model";     
         $room->save();

        return response()->json([
            'success' => true,
            'message' => ["Room '$request->Room' created successfully."],
            'msgtype' => 'success',
            'room' => $room
        ]);
      
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
        $room = Room::find($request->id);
        
        $room->hotel_id = $request->hotel_id;
        $room->room_type_id = $request->room_type_id;        
        $room->room_title = $request->room_title;
        $room->room_category_id = $request->room_category_id;
        $room->RoomNumber = $request->RoomNumber;
        $room->FloorNo = $request->FloorNo;
        $room->RoomCharges = $request->RoomCharges;
        $room->tax_rate_id = $request->tax_rate_id;       
        $room->UpdationIP = request()->ip();
        $room->save();

        return response()->json([
            'success' => true,
            'message' => ["Room '$request->Room' updated successfully."],
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
        Room::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["Room '$request->Room' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
