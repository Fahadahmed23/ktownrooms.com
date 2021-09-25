<?php

namespace App\Http\Controllers;

use App\Models\BookingThirdParty;
use App\Models\BookingThirdPartyDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ThirdPartyBookingController extends Controller
{
    public function third_party_booking(Request $request)
    {
        //entry in third_party_booking table

        // dd($request->all());
        $bookingRequest = $request->bookingRequest ?? null;
        $sessionRequest = $request->sessionRequest ?? null;
        $bookingData = $request->bookingData ?? null;

        $no_of_occupants = 0;
        if(isset($bookingRequest['NoOfRooms'])){
            foreach ($bookingRequest['NoOfRooms'] as $key => $value) {
                if($value != '0'){
                    if(isset($bookingRequest['occupants'])){
                        $no_of_occupants += $bookingRequest['occupants'][$key];
                    }
                }
            }
        }

        $btp = BookingThirdParty::create([
            'id' => isset($bookingData['BookingID']) ? $bookingData['BookingID'] : null,
            'booking_no' => isset($bookingData['BookingCode']) ? $bookingData['BookingCode'] : null,
            'first_name' => isset($bookingRequest['FirstName']) ? $bookingRequest['FirstName'] : null,
            'last_name' => isset($bookingRequest['LastName']) ? $bookingRequest['LastName'] : null,
            'phone' => isset($bookingRequest['Cell']) ? $bookingRequest['Cell'] : null,
            'email' => isset($bookingRequest['EmailAddress']) ? $bookingRequest['EmailAddress'] : null,
            'total_rooms' => isset($bookingRequest['hdnTotalCost']) ? $bookingRequest['hdnTotalCost'] : null,
            'total_cost' => isset($bookingRequest['hdnTotalRoom']) ? $bookingRequest['hdnTotalRoom'] : null,
            'no_occupants' => $no_of_occupants,
            'hotel_id' => isset($sessionRequest['SlugId']) ? $sessionRequest['SlugId'] : null,
            'hotel_name' => isset($sessionRequest['Slug']) ? $sessionRequest['Slug'] : null,
            'booking_date' => Carbon::now()->toDateTimeString(),
            'booking_from' => isset($sessionRequest['HotelCheckInDate']) ? $sessionRequest['HotelCheckInDate'] : null,
            'booking_to' => isset($sessionRequest['HotelCheckOutDate']) ? $sessionRequest['HotelCheckOutDate'] : null,
            // 'total_cost' => $request->hdnTotalRoom,
        ]);

        foreach ($bookingRequest['NoOfRooms'] as $key => $value) {
            if($value != '0'){
                $arr = explode("/", $request->room_type_name[$key], 2);
                $room_type_name = $arr[0];
                BookingThirdPartyDetail::create([
                    'booking_third_party_id' => $btp->id,
                    'partner_price' => $request->PartnerPrice[$key],
                    'selling_price' => $request->SellingPrice[$key],
                    'hotel_id' => $request->HotelID[$key] ?? '',
                    'hotel_name' => $request->HotelName[$key] ?? '',
                    'room_type_name' => $room_type_name,
                    'no_of_rooms' => $value,
                    'cost_of_rooms' => $request->costOfRoom[$key],
                    'occupants' => $request->occupants[$key],
                ]);
            }
        }



    }

    public function booking_mapping(Request $request){

        // dd($type, $source_type, $source, $destination);
        $source_type = 'int';
        if($request->type == 'room_category'){
            $source_type = 'str';
        }
        DB::table('booking_mappings')->create([
            'client' => 'Ktown',
            'type' => $request->type,
            'source_type' => $source_type,
            'source' => $request->source,
            'destination' => $request->destination,
        ]);


    }

}
