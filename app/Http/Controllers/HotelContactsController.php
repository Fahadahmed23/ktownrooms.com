<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\HotelContact;
use App\Models\Hotel;
use App\Models\ContactType;
// use Validator;
use App\Http\Requests\AddHotelContactRequest;
use Illuminate\Support\Facades\DB;

class HotelContactsController extends Controller
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
     * Display base page for hotelcontacts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('hotelcontacts.index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getHotelContacts()
    {
        // return HotelContact::all();
        return DB::table('hotel_Contacts')
       ->join('hotels', 'hotel_Contacts.hotel_id', '=', 'hotels.id')
       ->join('contact_types', 'hotel_Contacts.contact_type_id', '=', 'contact_types.id') 
       ->select('hotel_Contacts.*' , 'contact_types.ContactType' , 'hotels.HotelName')
       ->get();
    }
    public function getHotels()
    {
        return Hotel::all();
    }
    public function getContactTypes()
    {
        return ContactType::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddHotelContactRequest $request)
    {
       // $hotelcontactExists = HotelContact::where('HotelContactName', $request->HotelContactName)->get();
        $hotelcontact = new HotelContact();
        $hotelcontact->hotel_id = $request->hotel_id;
        $hotelcontact->contact_type_id = $request->contact_type_id; 
        $hotelcontact->Value =$request->Value;
        $hotelcontact->ContactPerson =$request->ContactPerson;
        $hotelcontact->CreationIP = "198";
        $hotelcontact->created_by = 1;
        $hotelcontact->CreatedByModule = "model";
        // if(count($hotelcontactExists) == 0)
        // {
        
        $hotelcontact->save();

        return response()->json([
            'success' => true,
            'message' => ["HotelContact '$request->contact_type_id' created successfully."],
            'msgtype' => 'success',
            'hotelcontact' => $hotelcontact
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
        $hotelcontact = HotelContact::find($request->id);
        $hotelcontact->hotel_id = $request->hotel_id;
        $hotelcontact->contact_type_id = $request->contact_type_id; 
        $hotelcontact->Value =$request->Value;
        $hotelcontact->ContactPerson =$request->ContactPerson;
        $hotelcontact->UpdationIP = request()->ip();

        $hotelcontact->save();

        return response()->json([
            'success' => true,
            'message' => ["HotelContact '$request->contact_type_id' updated successfully."],
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
        HotelContact::find($request->id)->delete();

        return response()->json([
            'success' => true,
            'message' => ["HotelContact '$request->contact_type_id' deleted successfully."],
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }
}
