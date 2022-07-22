<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Room;
// use App\Models\TaxRate;
use App\Models\RoomType;
use App\Models\Hotel;

use App\Models\Facility;
// use Validator;
use App\Http\Requests\AddRoomRequest;
use App\Models\Booking;
use App\Models\BookingRoom;
use App\Models\FacilityRoom;
use App\Models\HotelRoomCategory;
use App\Models\RoomCategory;
use App\Models\RoomService;
use App\Models\Service;
use App\Models\RoomImage;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class RoomController extends Controller
{
    /**
     * Display base page for rooms.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('room.index',['breadcrumb' => 'Rooms']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getRoomBookings(Request $request)
    {
        $booking_count = BookingRoom::where('room_id', $request->room_id)
        
        ->whereHas('booking', function($query) use ($request) {
            $query->whereIn('status', ['Pending', 'Confirmed', 'CheckedIn']);
        })
        ->count();
        // dd($booking_count);
        // ->whereIn('status', ['Pending', 'Confirmed', 'CheckedIn'])->count();
        return  response()->json([
            'booking_count'=>$booking_count
        ]);
        
    }

    public function fetchrooms(Request $request)
    {
        $user = Auth::user();
        //$rooms = Room::with(['hotel', 'room_type' , 'category.facilities' , 'tax_rate','facilities', 'services','images', 'bookings']);
        
        $results_per_page = $request->has('results_per_page') ? $request->results_per_page : 10;
        $total_rooms = Room::with(['hotel', 'room_type' , 'category.facilities' , 'tax_rate','facilities', 'services','images', 'bookings'])->count();
        
         //determine the total number of pages available  
        $number_of_page = ceil ($total_rooms / $results_per_page);

        $page = $request->has('PageNo') ? $request->PageNo : 1;

        //determine the sql LIMIT starting number for the results on the displaying page  
        $page_first_result = ($page-1) * $results_per_page;  

        //$rooms = Room::with(['hotel', 'room_type' , 'category.facilities' , 'tax_rate','facilities', 'services','images', 'bookings']);
        //$rooms = Room::with(['hotel', 'room_type' , 'category','images']);

        
    
        $rooms = Room::with(['hotel']);
        
        if($request->has('HotelName')){

            $hotel_name = $request->HotelName;
            //$hotel_name = 'GOHO Rooms DHA Phase 7';
            //$hotel_name = 'GOHO Hunza Peace Point';

            $rooms->whereHas('hotel', function ($hh) use ($hotel_name)  {
                $hh->where('HotelName',$hotel_name);
            });

        }

        
        
        $request->RoomCategory = ['Budget Double Room','Deluxe Double Room','Quad Room','Master Room','Deluxe Room'];
        //$request->RoomCategory = ['Budget Double Room'];

        if($request->has('RoomCategory')){
            if(is_array($request->RoomCategory) && count($request->RoomCategory) >0){
                
                $room_category = $request->RoomCategory;

                $rooms->with('category');
                //$rooms->with(['category'=> function($c) use ($room_category){
                //    $c->whereIn('RoomCategory',$room_category);
                //}]);

                $rooms->whereHas('category', function ($cc) use ($room_category)  {
                    $cc->whereIn('RoomCategory',$room_category);
                });

                //return  response()->json([
                //    'success'=>true,
                //    'fahad'=>'ahmed'
                //]);
                
                //$rooms->whereIn('RoomCategory',$request->RoomCategory);
            }
        }
        

        $request->RoomType = ['Premium','Budget','Quad Room','Deluxe Room','Family Hall'];
        //$request->RoomType = ['Budget'];
        if($request->has('RoomType')){
            if(is_array($request->RoomType) && count($request->RoomType)>0){
                
                $room_types = $request->RoomType;
                $rooms->with('room_types');
                
               
                $rooms->whereHas('room_types', function($rr) use ($room_types) {
                    $rr->whereIn('RoomType',$room_types);
                });
 
            }
        }

        if($request->has('RoomTitle')) {

            $room_title = $request->RoomTitle;
            //$room_title = 'Deluxe Rooms';
            $rooms->where('room_title',$room_title);

        }

        // filters name
        // HotelName , RoomTitle, RoomType, RoomCategory, RoomNumber, FloorNo, RoomCharges
        // HotelNameMinus , RoomTitleMinus, RoomTypeMinus, RoomCategoryMinus, RoomNumberMinus, 
        // FloorNoMinus, RoomChargesMinus

        // RoomTitle(room_title) , RoomNumber(RoomNumber),FloorNo(FloorNo), RoomCharges (RoomCharges)

        
        //if($request->has('OrderBy')) {

            //$filter_order_by = $request->OrderBy;
            $filter_order_by = 'HotelName';

            /*
            if($filter_order_by == 'HotelName'){

                //return 3232;
                $rooms->orderBy('hotel.HotelName', 'DESC');
                //$rooms->orderBy('hotel.HotelName', 'DESC');
                
                //$rooms->orderBy('HotelName', 'DESC');
                //$rooms->whereHas('hotel', function ($hh) {
                //    $hh->orderBy('HotelName','desc');
                //});
            
            }
            elseif($filter_order_by == 'HotelNameMinus'){
                $rooms->whereHas('hotel', function ($hh) {
                    $hh->orderBy('HotelName', 'ASC');
                });
            }

            **/
            
            if($filter_order_by == 'RoomTitle'){
                $rooms->orderBy('room_title', 'DESC');
            }
            elseif($filter_order_by == 'RoomTitleMinus'){
                $rooms->orderBy('room_title', 'ASC');
            }
            elseif($filter_order_by == 'RoomNumber'){
                $rooms->orderBy('RoomNumber', 'DESC');
            }
            elseif($filter_order_by == 'RoomNumberMinus'){
                $rooms->orderBy('RoomNumber', 'ASC');
            }
            elseif($filter_order_by == 'FloorNo'){
                $rooms->orderBy('RoomNumber', 'DESC');
            }
            elseif($filter_order_by == 'FloorNoMinus'){
                $rooms->orderBy('RoomNumber', 'ASC');
            }
            elseif($filter_order_by == 'RoomCharges'){
                $rooms->orderBy('RoomCharges', 'DESC');
            }
            elseif($filter_order_by == 'RoomChargesMinus'){
                $rooms->orderBy('RoomCharges', 'ASC');
            }
           
        //}
        


        $rooms->skip($page_first_result)->take($results_per_page);
   
        return  response()->json([
            'success'=>true,
            //'rooms' => count($rooms->get()),
            'count' => $total_rooms,
            'page_no' => $page,
            'total_pages' => $number_of_page,
            'result_count' =>count($rooms->get()), 
            'result' =>$rooms->get()
        
        ]);



    }

    public function getnRooms()
    {
        $user = Auth::user();
        $rooms = Room::with(['hotel', 'room_type' , 'category.facilities' , 'tax_rate','facilities', 'services','images', 'bookings']);
        if (!auth()->user()->hasRole('Admin')) 
        {
            if($user->self_manipulated()){
                $rooms = $rooms->where('created_by',$user->id);
            }else{
                $rooms = $rooms->whereIn('hotel_id',$user->HotelIds);
            }
            $is_admin = false;
        }
        else
        {
            $is_admin = true;
        }

            
        // $rooms = Room::with(['hotel', 'room_type' , 'category.facilities' , 'tax_rate','facilities', 'services','images', 'bookings'])->get();   
        // get data for dropdown
        $facilities = Facility::orderBy('Facility', 'ASC')->get();
        $services=  Service::orderBy('Service', 'ASC')->where('services.deleted_at', Null)->get();
        // $hotels = Hotel::with(['hotelroomcategories'])->orderBy('HotelName', 'ASC')->get();
        $hotels = auth()->user()->user_hotels();
        $roomtypes = RoomType::orderBy('RoomType', 'ASC')->get();
        $roomcategories = RoomCategory::with(['facilities'])->orderBy('RoomCategory', 'ASC')->get();
        $hotelroomcategories=HotelRoomCategory::get();
        // $taxrates = TaxRate::orderBy('Tax', 'ASC')->get();
        return  response()->json([
            'user'=>$user,
            'is_admin'=>$is_admin,
            'hotelroomcategories'=>$hotelroomcategories,
            'hotels'=>$hotels->with(['hotelroomcategories'])->orderBy('HotelName', 'ASC')->get(),
            'rooms'=> $rooms->get(),
            'facilities' => $facilities,
            'roomtypes'=>$roomtypes,
            'roomcategories'=>$roomcategories,
            // 'taxrates'=>$taxrates,
            'services'=>$services,

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
        $services = $request->services;
        $room = $request->room;
        $nroom = new Room();
        $nroom->hotel_id            =       $room['hotel_id'];
        $nroom->room_type_id        =       $room['room_type_id'];
        $nroom->room_category_id    =       $room['room_category_id'];
        if (!empty($room['thumbnail'])) {
            $nroom->thumbnail       =       $room['thumbnail'];
        }
        $nroom->room_title          =       $room['room_title'];
        $nroom->RoomNumber          =       $room['RoomNumber'];
        $nroom->FloorNo             =       $room['FloorNo'];
        $nroom->RoomCharges         =       $room['RoomCharges'];
        // $nroom->tax_rate_id         =       $room['tax_rate_id'];
        $nroom->is_available        =       $room['is_available'];
        $nroom->CreationIP          =       request()->ip();
        $nroom->created_by          =       Auth::id();
        $nroom->CreatedByModule     =       "model";     
        $nroom->save();
        if (!empty($room['facilities'])) {
            $nroom->facilities()->sync($room['facilities']);
        }
        foreach ($services as $key => $service) {
            if (!empty($service)) {
                if ($service['status'] == "true") {
                    $roomservice = New RoomService();
                    $roomservice->room_id = $nroom->id;
                    $roomservice->service_id= $service['id'];
                    // $roomservice->limit = $service['count'];
                    $roomservice->save();
                } else {
                    unset($services[$key]);
                }
            } else {
                unset($services[$key]);
            }
        }
        if (!empty($request->room['images'])) {
            $images = $request->room['images'];
            foreach ($images as $image) {
                $roomimage = New RoomImage();
                $roomimage->room_id= $nroom->id;
                $roomimage->ImagePath= $image['ImagePath'];
                $roomimage->save();
            }

        }
       
        if($request->count > 1){
            $room_id = $nroom->id;
            $this->addMultipleRooms($room_id,$request->count );
        }

        $room=RoomCategory::with(['facilities', 'services'])->where('id','=',$nroom->id)->first();
        return response()->json([
            'success' => true,
            'message' => ["Room '$nroom->room_title' created successfully."],
            'msgtype' => 'success',
            'room' => $room
        ]);
      
    }

    private function addMultipleRooms($room_id, $cnt)
    {
            $room = Room::with(['facilities' ,'services'])->find($room_id);
            for ($i=0; $i < $cnt-1; $i++) { 
                $nroom = new Room();
                $nroom->hotel_id            =       $room['hotel_id'];
                $nroom->room_type_id        =       $room['room_type_id'];
                $nroom->room_category_id    =       $room['room_category_id'];
                if (!empty($room['thumbnail'])) {
                    $nroom->thumbnail       =       $room['thumbnail'];
                }
                $nroom->room_title          =       $room['room_title'].'-'.str_pad($i+2, 3, '0',STR_PAD_LEFT);
                $nroom->RoomNumber          =       $room['RoomNumber']+$i+1;
                $nroom->FloorNo             =       $room['FloorNo'];
                $nroom->RoomCharges         =       $room['RoomCharges'];
                $nroom->is_available        =       $room['is_available'];
                $nroom->CreationIP          =       request()->ip();
                $nroom->created_by          =       Auth::id();
                $nroom->CreatedByModule     =       "model";     
                $nroom->save(); 
                if (!empty($room->services->toArray())) {

                    foreach ($room->services->toArray() as $service) {
                        $roomservice = New RoomService();
                        $roomservice->room_id = $nroom->id;
                        $roomservice->service_id= $service['pivot']['service_id'];
                        $roomservice->save();
                    }
                }
                if (!empty($room->facilities->toArray())) {
                    foreach ($room->facilities->toArray() as $facility) {
                        $roomfacility = New FacilityRoom();
                        $roomfacility->room_id = $nroom->id;
                        $roomfacility->facility_id= $facility['pivot']['facility_id'];
                        $roomfacility->save();
                    }
                }
                if (!empty($room->images->toArray())) {
                    foreach ($room->images->toArray() as $image) {
                        $roomimage = New RoomImage();
                        $roomimage->room_id = $nroom->id;
                        $roomimage->ImagePath= $image['ImagePath'];
                        $roomimage->save();
                    }
                }
            }

            return response()->json([
                'success' => true,
                'msgtype' => 'success',
                'room' => $room
            ]);
    
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
        // dd($request->all());
        $room = $request->room;
        $nroom = Room::find($request->id);
        $nroom->hotel_id            =      $room['hotel_id'];
        $nroom->room_type_id        =      $room['room_type_id'];
        $nroom->room_category_id    =      $room['room_category_id'];
        $nroom->thumbnail           =      $room['thumbnail'];
        $nroom->room_title          =      $room['room_title'];
        $nroom->RoomNumber          =      $room['RoomNumber'];
        $nroom->FloorNo             =      $room['FloorNo'];
        $nroom->RoomCharges         =      $room['RoomCharges'];
        // $nroom->tax_rate_id         =      $room['tax_rate_id'];
        $nroom->is_available        =       $room['is_available'];
        $nroom->CreationIP          =      request()->ip();
        $nroom->created_by          =      1;
        $nroom->CreatedByModule     =      "model";     
        $nroom->save();
        if (!empty($room['facilities'])) {
            $nroom->facilities()->sync($room['facilities']);
        }
        $nroom->services()->sync([]);
        $services = $request->services;
// dd($services);
        foreach ($services as $key => $service) {
            if (!empty($service)) {
                if ($service['status'] == "true") {
                    $roomservice = New RoomService();
                    $roomservice->room_id = $nroom->id;
                    $roomservice->service_id= $service['id'];
                    // $roomservice->limit = $service['count'];
                    $roomservice->save();
                } else {
                    unset($services[$key]);
                }
            } else {
                unset($services[$key]);
            }
        }
        
        $nroom->images()->delete();
        if (!empty($request->room['images'])) {
            $images = $request->room['images'];
            foreach ($images as $image ) {
                $roomimage = New RoomImage();
                $roomimage->room_id= $nroom->id;
                $roomimage->ImagePath= $image['ImagePath'];
                $roomimage->save();
            }
        }
        $nroom=Room::with(['facilities','services'])->where('id','=',$nroom->id)->first();
        // dd($nroom);
        return response()->json([
            'success' => true,
            'message' => ["Room '$nroom->room_title' updated successfully."],
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
        $checkBooking = Room::with("bookings")->where('id',$request->id)->first();

        if ($checkBooking->ConfirmBookingCount > 0) {
            return response()->json([
            'success' => true,
            'message' => ["This '$checkBooking->room_title' Room has bookings couldn't be deleted"],
            'msgtype' => 'danger',
            ]);
        }
        else{
           $room= Room::findOrFail($request->id);
           $message = ["Room: '$room->room_title' deleted successfully!"];
           $room->delete();
            return response()->json([
                'success' => true,
                'message' => $message,
                'msgtype' => 'success',
                'id' => $request->id
            ]);
        }
      
        
    }

    public function saveProfilePicture(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ],
            [
                'image.mimes' => 'The image must be file of type jpeg,png,jpg,gif,svg'
            ]
        );

        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);

        echo json_encode(['success' => true, 'payload' => url('images/' . $name)]);
    }




    public function saveImages(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            ],
            [
                'image.mimes' => 'The image must be file of type jpeg,png,jpg,gif,svg'
            ]
        );

        $image = $request->file('image');
        $name = time() . '.' . $image->getClientOriginalExtension();
        $destinationPath = public_path('/images');
        $image->move($destinationPath, $name);

        echo json_encode(['success' => true, 'payload' => url('images/' . $name)]);
    }
}
