<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Company;
use App\Models\City;
use App\Models\Hotel;
use App\Models\ContactType;
use App\Models\HotelContact;
use Carbon\Carbon;

use App\Http\Requests\AddHotelRequest;
use App\Http\Requests\AddHotelContactRequest;
use App\Models\AccountGeneralLedgerMapping;
use App\Models\AccountGeneralLedger;
use App\Models\CinCoutRule;
use App\Models\DefaultRule;
use App\Models\HotelCinCoutRule;
use App\Models\HotelRoomCategory;
use App\Models\HotelCategory;
use App\Models\HotelCategories;
use App\Models\HotelCobranding;

use App\Models\PartnerRequest;
use App\Models\RoomCategory;
use App\Models\TaxRate;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    protected $module_name = 'Hotel Management';

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view ('hotel.index', [
            'breadcrumb' => 'Hotel Management'
        ]);
    }

    public function get_account_gl_hotel_mappings(Request $request)
    {
        // dd($request->all());
        $hotel_gl_accounts = AccountGeneralLedger::get(['id', 'account_gl_code', 'is_active', 'title', 'account_level_id']);
        $hotel_gl_account_mappings = AccountGeneralLedgerMapping::where('hotel_id', $request->hotel)->get();
        $hotel_gl_accounts_map = $hotel_gl_accounts->toArray();
        if(count($hotel_gl_account_mappings)){
            
            foreach ($hotel_gl_accounts  as $key => $value) {
                // dd($value)
                $id = $this->searchForId($value->id, $hotel_gl_account_mappings->toArray());
                if(!$id){
                    $hotel_gl_accounts_map[$key]['is_active'] = '0';
                } else {
                    $aglm = AccountGeneralLedgerMapping::where('account_gl_id', $id)->first();
                    $hotel_gl_accounts_map[$key]['is_active'] = $aglm->is_active;
                }
            }
            // dd($hotel_gl_accounts_map);

        } else {
            // $array = ['products' => ['desk' => ['price' => 100]]];
            foreach ($hotel_gl_accounts as $key => $value) {
                // dd($value);
                $value->is_active = '0';
            }
            $hotel_gl_accounts_map = $hotel_gl_accounts->toArray();
            

        }

        return response()->json([
            'success' => true,
            'hotel_gl_accounts_map' => $hotel_gl_accounts_map,
        ]);
    }

    function searchForId($id, $array) {
        foreach ($array as $key => $val) {
            // dd($val, $id);
            if ($val['account_gl_id'] == $id) {
                return $val['account_gl_id'];
            }
        }
        return null;
     }

    public function testHotel()
    {
        $hotels = Hotel::with(['city','contacts.contact_type', 'checkin', 'checkout','hotel_cobrandings','hotel_categories'])->get();
        echo "<pre>";
        print_r($hotels);
        /*
        echo "<pre>";
        return response()->json([
            'hotels' => $hotels,
        ]);
        **/
    
    }

    public function getData()
    {
        $companies = Company::all();
        $cities = City::all();
        $partners = PartnerRequest::all();
        //$hotels = Hotel::with(['city','contacts.contact_type', 'checkin', 'checkout'])->get();
        $hotels = Hotel::with(['city','contacts.contact_type', 'checkin', 'checkout','hotel_cobrandings','hotel_categories'])->get();
        $hotel_gl_accounts = AccountGeneralLedger::all();
        $hotel_contacts = HotelContact::all();
        $contact_types = ContactType::all();
        $room_categories = RoomCategory::all();
        $hotel_categories = HotelCategories::all();
        $tax_rates=TaxRate::whereNull('deleted_at')->get();
        $check_in_rules=CinCoutRule::where('rule_type', 'early_check_in')->get();
        $check_out_rules=CinCoutRule::where('rule_type', 'late_check_out')->get();
        $default_rule=DefaultRule::first();
        foreach ($hotels as $key => $hotel) {
            $dt = [];
            $hotelroomcategories = HotelRoomCategory::where('hotel_id','=', $hotel['id'])->get();
            if (count($hotelroomcategories) > 0) {
                foreach ($hotelroomcategories as $c) {
                    $dt[$c['room_category_id']] = $c;
                }
            }
            $hotels[$key]['hotelroomcategories'] = $dt;
        }

        return response()->json([
            'hotel_gl_accounts' => $hotel_gl_accounts,
            'companies' => $companies,
            'cities' => $cities,
            'hotels' => $hotels,
            'hotel_contacts' => $hotel_contacts,
            'contact_types' => $contact_types,
            'partners'=>$partners,
            'room_categories'=>$room_categories,
            'hotel_categories'=>$hotel_categories,
            'tax_rates'=>$tax_rates,
            'check_in_rules'=>$check_in_rules,
            'check_out_rules'=>$check_out_rules,
            'default_rule'=>$default_rule,

        ]);
    }

    public function saveHotel(Request $request)
    {
            //  dd($request->all());
                \DB::beginTransaction();

                
                try {
               
                    $startdate= $request->hotel['AgreStartDate'];
                    $enddate= $request->hotel['AgreEndDate'];

                if ($startdate > $enddate) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => ["End Date should be greater than Start Date"],
                            'msgtype' => 'danger',
                        ]);
                    }
                    if ($enddate < $startdate) 
                    {
                        return response()->json([
                            'success' => false,
                            'message' => ["Start Date should be less than End Date"],
                            'msgtype' => 'danger',
                        ]);
                    }

                if ($request->formType == 'save') {
                    $hotel = new Hotel();
                    $msg="created";
                } else {
                    $hotel = Hotel::find($request->hotel['id']);
                    $msg="updated";
                }
               
                $hotel->HotelName = $request->hotel['HotelName'];
                $hotel->company_id = $request->hotel['company_id'];
                $hotel->city_id = $request->hotel['city_id'];
                $hotel->Address = $request->hotel['Address'];
                $hotel->ZipCode = $request->hotel['ZipCode'];
                $hotel->Latitude = $request->hotel['Latitude'];
                $hotel->Longitude = $request->hotel['Longitude'];
                $hotel->has_tax = $request->hotel['has_tax'];
                if ($request->hotel['has_tax'] == 1) {
                    $hotel->tax_rate_id = $request->hotel['tax_rate_id'];
                }else{
                    $hotel->tax_rate_id = Null;
                }
                $hotel->partner_id = $request->hotel['partner_id'];
                // $hotel->partnerPrice = $request->hotel['partnerPrice'];
                $hotel->Rating = $request->hotel['Rating'];
                if (!empty($request->hotel['Description'])) {
                    $hotel->Description = $request->hotel['Description'];
                }
                $hotel->Code = $request->hotel['Code'];

                if (!empty($request->hotel['mapimage'])) {
                    $hotel->mapimage = $request->hotel['mapimage'];
                }
                // if (!empty($request->hotel['metaTitle'])) {
                //     $hotel->metaTitle = $request->hotel['metaTitle'];
                // }
                // if (!empty($request->hotel['metaKeyword'])) {
                //     $hotel->metaKeyword = $request->hotel['metaKeyword'];
                // }
                // if (!empty($request->hotel['metaDescription'])) {
                //     $hotel->metaDescription = $request->hotel['metaDescription'];
                // }
                $hotel->AgreStartDate = $startdate;
                $hotel->AgreEndDate = $enddate;
                $hotel->created_by = Auth::id();
                $hotel->CreatedByModule = $this->module_name;
                $hotel->CreationIP = request()->ip();
                $hotel->updated_by = Auth::id();

                $hotel->save();

                // for saving multiple contacts with hotel addition

                if ($request->formType != 'save') {
                    HotelContact::where('hotel_id','=',$hotel->id)->delete();
                }

                if (!empty($request->hotel['contacts'])){
                    foreach($request->hotel['contacts'] as $c){
                        $contact = new HotelContact();
                        $contact->hotel_id = $hotel->id;
                        $contact->contact_type_id = $c['contact_type_id'];
                        $contact->Value = $c['Value'];
                        $contact->ContactPerson = $c['ContactPerson'];
                        $contact->CreationIP= request()->ip();
                        $contact->created_by= Auth::id();
                        $contact->CreatedByModule= $this->module_name;
                        $contact->updated_by= Auth::id();
                        $contact->save();
                    }
                }
                // dd($hotel->id);
                // for saving multiple hotelroomcategory with hotel addition
                if ($request->formType != 'save') {
                    HotelRoomCategory::where('hotel_id','=',$hotel->id)->delete();
                    HotelCinCoutRule::where('hotel_id',$hotel->id)->delete();
                }

                // dd($request->hotel['checkout']);
                if (!empty($request->hotel['hotelroomcategories'])){
                    
                    foreach($request->hotel['hotelroomcategories'] as $key => $h){
                        if (!empty($h)) {
                            $hotelroomcategory = new HotelRoomCategory();
                            $hotelroomcategory->hotel_id = $hotel->id;
                            $hotelroomcategory->room_category_id = $key;
                            $hotelroomcategory->allowed = $h['allowed'];
                            $hotelroomcategory->max_allowed = $h['max_allowed'];
                            $hotelroomcategory->additional_guest_charges = $h['additional_guest_charges'];
                            $hotelroomcategory->status = empty($h['status'])?0:$h['status'];
                            $hotelroomcategory->updated_by= Auth::id();
                            $hotelroomcategory->save();
                        }
                       
                    }
                }

                if (!empty($request->hotel['checkin'])){
                    foreach ($request->hotel['checkin'] as $key => $value) {
                        // dd(date('H:i:s', strtotime($value['start_time'])));
                        if($request->formType != 'save') 
                            $cin_cout_rule_id = $value['cin_cout_rule_id'];
                        else 
                            $cin_cout_rule_id = $value['id'];
                        
                        $hotelRule = new HotelCinCoutRule();
                        $hotelRule->hotel_id = $hotel->id;
                        $hotelRule->cin_cout_rule_id = $cin_cout_rule_id;
                        $hotelRule->rule_type = 'early_check_in';
                        $hotelRule->threshold_time = date('H:i:s', strtotime($request->hotel['checkin_time']));
                        $hotelRule->check_in_limit = date('H:i:s', strtotime($request->hotel['check_in_limit']));
                        $hotelRule->check_out_limit = date('H:i:s', strtotime($request->hotel['check_out_limit']));
                        $hotelRule->start_time = date('H:i:s', strtotime($value['start_time']));
                        $hotelRule->end_time = date('H:i:s', strtotime($value['end_time']));
                        $hotelRule->charges = $value['charges'];
                        $hotelRule->CreationIP= request()->ip();
                        $hotelRule->created_by= Auth::id();
                        $hotelRule->CreatedByModule= $this->module_name;
                        $hotelRule->updated_by= Auth::id();
                        $hotelRule->save();
                        
                    }
                }
                if (!empty($request->hotel['checkout'])){
                    foreach ($request->hotel['checkout'] as $key => $value) {
                        // dd(date('H:i:s', strtotime($value['start_time'])));
                        if($request->formType != 'save') 
                            $cin_cout_rule_id = $value['cin_cout_rule_id'];
                        else 
                            $cin_cout_rule_id = $value['id'];

                        $hotelRule = new HotelCinCoutRule();
                        $hotelRule->hotel_id = $hotel->id;
                        $hotelRule->cin_cout_rule_id = $cin_cout_rule_id;
                        $hotelRule->rule_type = 'late_check_out';
                        $hotelRule->threshold_time = date('H:i:s', strtotime($request->hotel['checkout_time']));
                        $hotelRule->check_in_limit = date('H:i:s', strtotime($request->hotel['check_in_limit']));
                        $hotelRule->check_out_limit = date('H:i:s', strtotime($request->hotel['check_out_limit']));
                        $hotelRule->start_time = date('H:i:s', strtotime($value['start_time']));
                        $hotelRule->end_time = date('H:i:s', strtotime($value['end_time']));
                        $hotelRule->charges = $value['charges'];
                        $hotelRule->CreationIP= request()->ip();
                        $hotelRule->created_by= Auth::id();
                        $hotelRule->CreatedByModule= $this->module_name;
                        $hotelRule->updated_by= Auth::id();
                        $hotelRule->save();
                        
                    }
                }
                /**
                 * Hotel Categories and Cobranding
                 */

                
                if (!empty($request->hotel['hotelcateogry_id'])) { 

                    $hotell = Hotel::findOrFail($hotel->id);
                    //$hotell->hotel_categories()->attach($request->hotel['hotelcateogry_id']);
                    
                    $hotell->hotel_categories()->attach($request->hotel['hotelcateogry_id'],['created_by' => Auth::id(),'updated_by' => Auth::id() ]);
                  
                }
                

                
                if (!empty($request->hotel['has_cobranding'])) { 

                    $has_cobranding = $request->hotel['has_cobranding'];
                    
                    $hotel_cobranding = new HotelCobranding();
                    $hotel_cobranding->hotel_id = $hotel->id;
                    $hotel_cobranding->status = $has_cobranding;
                    $hotel_cobranding->software_fee	 =  !empty($request->hotel['software_fees']) ? $request->hotel['software_fees'] : 0;
                    $hotel_cobranding->percentage_amount = !empty($request->hotel['percentage_amount']) ? $request->hotel['percentage_amount'] : 0;
                    $hotel_cobranding->created_by= Auth::id();
                    $hotel_cobranding->updated_by= Auth::id();
                    $hotel_cobranding->save();
                    
                    
                    
                    /*
                    $hotell = Hotel::findOrFail($hotel->id);
                    $hotel_cobrandings = $hotell->hotel_cobrandings()->create([
                        'hotel_id' => $hotel->id,
                        'status' => $has_cobranding,
                        'software_fee' => !empty($request->hotel['software_fees']) ? $request->hotel['software_fees'] : 0,
                        'percentage_amount' => !empty($request->hotel['percentage_amount']) ? $request->hotel['percentage_amount'] : 0,
                        'created_by' => Auth::id(),
                        'updated_by' => Auth::id()
                    ]);
                    **/
                
                }
                
                $hotel = Hotel::with(['city','contacts.contact_type'])->where('id', '=', $hotel->id)->first();
            } catch (\Exception $e) {
                dd($e);
                \DB::rollback();
                return response()->json([
                    'success' => false,
                    'message' => ['Hotel cannot be created'],
                    'msgtype' => 'danger',
                    'hotel' => $hotel
                ]);
            }

            \DB::commit();

            return response()->json([
                'success' => true,
                'message' => ["'$hotel->HotelName' $msg successfully"],
                'msgtype' => 'success',
                'hotel' => $hotel
            ]);
    }

    public function saveHotelGlAccountMapping(Request $request)
    {
        // dd($request->hotel_accounts);
        // update hotel gl acount in mapiing table
        if(!empty($request->hotel_accounts)){
            foreach ($request->hotel_accounts as $key => $value) {
                if($value){
                    $is_active = $value == 'true' ?  1 : 0;
                    // dd($key, $value, $request->hotel_id);
                    AccountGeneralLedgerMapping::updateOrCreate([
                        'account_gl_id'   => $key,
                        'hotel_id' => $request->hotel_id,
                    ],[
                        'is_active' => $is_active,
                    ]);
                }
            }
        }
        return response()->json([
            'success' => true,
            'message' => ['Account updated successfully'],
            'msgtype' => 'success',
        ]);
    }

    public function saveContact(Request $request)
    {
        if ($request->formType == 'save') {
            $contact = new HotelContact();
        } else {
            $contact = HotelContact::find($request['contact']['id']);
        }

        if ($request->formType == 'save') {
            $contact->hotel_id = $request['hotel_id'];
         }
         else{
            $contact->hotel_id = $request['contact']['hotel_id'];
         }
        $contact->contact_type_id = $request['contact']['contact_type_id'];
        $contact->Value = $request['contact']['Value'];
        $contact->ContactPerson = $request['contact']['ContactPerson'];

        $contact->created_by = Auth::id();
        $contact->CreatedByModule = $this->module_name;
        $contact->CreationIP = request()->ip();
        $contact->updated_by= Auth::id();

        $contact->save();

        return response()->json([
            'success' => true,
            'message' => ['Contact created successfully'],
            'msgtype' => 'success',
            'contact' => $contact
        ]);
    }


    public function deleteHotel(Request $request) 
    {

        $hotel = Hotel::findOrFail($request->id);
        $message = ["Hotel '$hotel->HotelName' deleted successfully!"];

        $hotel->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

    public function deleteContact(Request $request) 
    {
        $contact = HotelContact::findOrFail($request->id);
        $message = ["Contact '$contact->ContactPerson' deleted successfully!"];

        $contact->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }


    public function saveProfilePicture(Request $request)
    {
        $this->validate(
            $request,
            [
                'image' => 'required|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
