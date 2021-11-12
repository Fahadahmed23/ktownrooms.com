<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\CustomerComplain;
use App\Models\ComplainStatus;
use App\Models\DiscountRequest;
use App\Models\BookingInvoice;

use Illuminate\Support\Facades\Auth;


class DiscountRequestController extends Controller
{
    protected $module_name = 'Discount Request View';

    public function index()
    {
        if(!auth()->user()->hasRole('Admin')){
            $module_name = 'My Requests';
        }
        else{
            $module_name = 'Discount Request View';
        }
        return view ('discount_requests.index', [
            'breadcrumb' => $module_name
        ]);
    }


    public function getDiscountRequests(Request $request)
    {
        $user = Auth::user();
        $inputs = $request->all();

        $filters = json_decode($request->filters);

        $discount_requests = DiscountRequest::with([
                'booking:id,booking_no',
                'booking.invoice',
                'requester:id,name',
                'supervisor:id,name',
        ]);
        
        if ($filters->date_filter != '') {
            $discount_requests = $discount_requests->where('created_at', '>=', $filters->date_filter . ' 00:00:00');
        }
        if ($filters->status_filter != '') {
            if($filters->status_filter != 'All'){
                $discount_requests = $discount_requests->where('status', $filters->status_filter);
            }   
        }

        
        if(!auth()->user()->hasRole('Admin')) { 
            $discount_requests = $discount_requests->whereIn('hotel_id', $user->HotelIds);
        }
        else{
            if(empty($filters->status_filter) && empty($filters->date_filter)){
                $discount_requests = $discount_requests->where('status','Pending');
            }
        }

        $count = $discount_requests->count();

        $discount_requests = $discount_requests
        ->skip($inputs['page'] * $inputs['perPage'] - $inputs['perPage'])
        ->take($inputs['perPage'])
        ->orderBy('created_at', $request->sorting);

        return response()->json([
            'success' => true,
            'discount_requests' => $discount_requests->get(),
            'totalRecords' => $count,
            'user' => $user
        ]);
    }


    public function setStatus(Request $request)
    {
        $discount_request = DiscountRequest::find($request->discount_request_id);
        $discount_request->status = $request->status;
        $discount_request->supervisor_id = Auth::id();

        $discount_request->supervisor_comments = $request->supervisor_comments;
        $discount_request->save();

        if ($request->status == 'Declined') {
            $this->declineDiscount($discount_request->booking_id, $discount_request->requester);
        }

        return response()->json([
            'success' => true,
            'message' => ['Status Changed Successfully'],
            'msgtype' => 'success',
            'discount_request'=>$discount_request
        ]);
    }

    private function declineDiscount($booking_id, $requester)
    {

        $invoice = BookingInvoice::where('booking_id', $booking_id)->first();
        $diff = $invoice->discount_amount - $requester->max_allowed_discount;
        $invoice->discount_amount = $requester->max_allowed_discount;
        $invoice->net_total += $diff;

        $invoice->save();
    }
}
