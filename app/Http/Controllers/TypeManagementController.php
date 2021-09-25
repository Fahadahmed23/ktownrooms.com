<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Channel;
use App\Models\ContactType;
use App\Models\Relation;
use App\Models\RoomType;
use App\Models\Service;
use App\Models\ServiceType;
use App\Models\TaxRate;
use App\Models\Room;
use App\Models\RoomImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TypeManagementController extends Controller
{

    protected $module_name = "Type Management";

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
        return view('typemanagement.index', [
            'breadcrumb' => 'Lookup'
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getTypeManagement()
    {
        $contacttypes= ContactType::all();
        $servicetypes= ServiceType::all();
        $relations= Relation::all();
        $roomtypes= RoomType::all();
        $taxrates =TaxRate::all();
        $channels = Channel::where('Channel','!=','Ktown Website')->get();

      
        return response()->json([
            'contacttypes'=> $contacttypes,
            'servicetypes'=>$servicetypes,
            'relations'=>$relations,
            'roomtypes'=>$roomtypes, 
            'taxrates'=>$taxrates,
            'channels'=>$channels
        ]);
    }

    // for channel 
    public function saveChannel(Request $request)
    {
        // dd($request->all());

        $channelId = $request->channel['id'] ?? null;
        $channelExist = Channel::where(DB::raw("UPPER(Channel)"), strtoupper($request->channel['Channel']))
        ->where('Channel', $request->channel['Channel']) 
        ->where('id', '!=', $channelId) 
        ->count();

        if ($channelExist==0) {
            if ($request->formType == "save") {
                $channel = new Channel();
                $msg = "added ";
            } else {
                $channel = Channel::find($request->channel['id']);
                $msg = "updated ";
            }
    
            $channel->Channel = $request->channel['Channel'];
            $channel->isShowPropertyLevel = $request->channel['isShowPropertyLevel'];
            $channel->additionalInfo = $request->channel['additionalInfo'];
            $channel->CreationIP = request()->ip();
            $channel->created_by = Auth::id();
            $channel->CreatedByModule = $this->module_name;
            $channel->save();
    
            return response()->json([
                'success' => true,
                'message' => [" Channel '".$channel->Channel."' $msg successfully"],
                'msgtype' => 'success',
                'channel' => $channel
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Channel '".$request->channel['Channel']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }
        
        
    }

    public function deleteChannel(Request $request) {
        $checkinBooking = Booking::where('channel', '=', $request->channel['Channel'])->first();
        if ($checkinBooking) {
            return response()->json([
                'success' => true,
                'message' => ["Channel couldn't be deleted, has booking already"],
                'msgtype' => 'danger',
            ]);
        }else{
            $channel = Channel::findOrFail($request->id);
            $message = ["Channel'$channel->Channel' deleted successfully!"];
            $channel->delete();

            return response()->json([
                'success' => true,
                'message' => $message,
                'msgtype' => 'success',
                'id' => $request->id
            ]);
        }
    }

    // for Service Type
    public function saveSType(Request $request)
    {

        $servicetypeId = $request->servicetype['id'] ?? null;
        $servicetypeExist = ServiceType::where(DB::raw("UPPER(ServiceType)"), strtoupper($request->servicetype['ServiceType']))
        ->where('ServiceType', $request->servicetype['ServiceType']) 
        ->where('id', '!=', $servicetypeId) 
        ->count();

        if ($servicetypeExist == 0) {
            if ($request->formType == "save") {
                $servicetype = new ServiceType();
                $msg = "added ";
            } else {
                $servicetype = ServiceType::find($request->servicetype['id']);
                $msg = " updated ";
            }
    
            $servicetype->ServiceType = $request->servicetype['ServiceType'];
            $servicetype->CreationIP = request()->ip();
            $servicetype->created_by = Auth::id();
            $servicetype->CreatedByModule = $this->module_name;
            $servicetype->save();
            
    
            return response()->json([
                'success' => true,
                'message' => ["Service Type: '".$request->servicetype['ServiceType']."' $msg successfully"],
                'msgtype' => 'success',
                'servicetype' => $servicetype
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => ["Service Type '".$request->servicetype['ServiceType']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }
        
    }


    public function deleteSType(Request $request) {
        $checkinService = Service::where('service_type_id', '=', $request->id)->first();
        if ($checkinService) {
            return response()->json([
                'success' => true,
                'message' => ["Service Type couldn't be deleted, has service already"],
                'msgtype' => 'danger',
            ]);
        }
        else{
            $servicetype = ServiceType::findOrFail($request->id);
            $message = ["Service Type '$servicetype->ServiceType' deleted successfully!"];
            $servicetype->delete();
    
            return response()->json([
                'success' => true,
                'message' => $message,
                'msgtype' => 'success',
                'id' => $request->id
            ]);
        }
   
    }

    //for Room Type
    public function saveRType(Request $request)
    {
        $roomtypeId = $request->roomtype['id'] ?? null;
        $roomtypeExist = RoomType::where(DB::raw("UPPER(RoomType)"), strtoupper($request->roomtype['RoomType']))
        ->where('RoomType', $request->roomtype['RoomType']) 
        ->where('id', '!=', $roomtypeId) 
        ->count();

        if ($roomtypeExist==0) {
            if ($request->formType == "save") {
                $roomtype = new RoomType();
                $msg = "added";
            } else {
                $roomtype = RoomType::find($request->roomtype['id']);
                $msg = "updated";
            }
    
            $roomtype->RoomType = $request->roomtype['RoomType'];
            $roomtype->CreationIP = request()->ip();
            $roomtype->created_by = Auth::id();
            $roomtype->CreatedByModule = $this->module_name;
            $roomtype->save();
    
            return response()->json([
                'success' => true,
                'message' => ["Room Type: '".$request->roomtype['RoomType']."' $msg successfully"],
                'msgtype' => 'success',
                'roomtype' => $roomtype
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Room Type '".$request->roomtype['RoomType']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }

       
    }

    public function deleteRType(Request $request) {

        $checkinRoom = Room::where('room_type_id', '=', $request->id)->first();
        if ($checkinRoom) {
            return response()->json([
                'success' => true,
                'message' => ["Room Type couldn't be deleted, has room already"],
                'msgtype' => 'danger',
            ]);
        }
        else{
            $roomtype = RoomType::findOrFail($request->id);
            $message = ["Room Type '$roomtype->RoomType' deleted successfully!"];
            $roomtype->delete();

            return response()->json([
                'success' => true,
                'message' => $message,
                'msgtype' => 'success',
                'id' => $request->id
            ]);
        }

        
    }

    //for relation Type
    public function saveRel(Request $request)
    {
        
        $relationId = $request->relation['id'] ?? null;
        $relExist = Relation::where(DB::raw("UPPER(Relation)"), strtoupper($request->relation['Relation']))
        ->where('Relation', $request->relation['Relation']) 
        ->where('id', '!=', $relationId) 
        ->count();

        if ($relExist==0) {
            if ($request->formType == "save") {
                $relation = new Relation();
                $msg = "added";
            } else {
                $relation = Relation::find($request->relation['id']);
                $msg = "updated";
            }
    
            $relation->Relation = $request->relation['Relation'];
            $relation->CreationIP = request()->ip();
            $relation->created_by = Auth::id();
            $relation->CreatedByModule = $this->module_name;
            $relation->save();
    
            return response()->json([
                'success' => true,
                'message' => ["Relation: '".$request->relation['Relation']."' $msg successfully"],
                'msgtype' => 'success',
                'relation' => $relation
            ]);
        }else{
            return response()->json([
                'success' => false,
                'message' => ["Relation '".$request->relation['Relation']."' already exists."],
                'msgtype' => 'error',
               
                ]);
        }
       
    }

    public function deleteRel(Request $request) {
        $relation = Relation::findOrFail($request->id);
        $message = ["$relation->Relation' deleted successfully!"];
        $relation->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }



    //for TaxRate 
    public function saveTaxRate(Request $request)
    {
        $taxrateId = $request->taxrate['id'] ?? null;
        $taxrateExist = TaxRate::where(DB::raw("UPPER(Tax)"), strtoupper($request->taxrate['Tax']))
        ->where('id', '!=', $taxrateId)
        ->count();

        if ($taxrateExist == 0) {
            if ($request->formType == "save") {
                $taxrate = new TaxRate();
                $msg = "added ";
            }
             else {
                $taxrate = TaxRate::find($request->taxrate['id']);
                $msg = "updated ";
            }
    
            
            $taxrate->Tax = $request->taxrate['Tax'];
            $taxrate->TaxValue = $request->taxrate['TaxValue'];
            $taxrate->IsDefault = $request->taxrate['IsDefault'];
            $taxrate->CreationIP = request()->ip();
            $taxrate->created_by = Auth::id();
            $taxrate->CreatedByModule = $this->module_name;
            $taxrate->save();
    
            return response()->json([
                'success' => true,
                'message' => ["Tax: '".$request->taxrate['Tax']."' $msg successfully"],
                'msgtype' => 'success',
                'taxrate' => $taxrate
            ]);
        }
        else{
            return response()->json([
                'success' => false,
                'message' => ["Tax '".$request->taxrate['Tax']."' already exists."],
                'msgtype' => 'error',
                ]);
        }
        
    }

    public function deleteTaxRate(Request $request) {
        $taxrate = TaxRate::findOrFail($request->id);
        // dd($taxrate->Tax);
        $message = ["Tax: '".$taxrate->Tax."' deleted successfully!"];
        $taxrate->delete();

        return response()->json([
            'success' => true,
            'message' => $message,
            'msgtype' => 'success',
            'id' => $request->id
        ]);
    }

}
