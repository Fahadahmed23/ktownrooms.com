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
        return view ('discount_requests.index', [
            'breadcrumb' => $this->module_name
        ]);
    }


    public function getDiscountRequests(Request $request)
    {
        $inputs = $request->all();
        // dd($inputs);
        $user = [
            'is_frontdesk' => false
        ];

        $discount_requests = DiscountRequest::with([
                'booking:id,booking_no',
                'booking.invoice',
                'requester:id,name',
                'supervisor:id,name',
        ]);

        if (Auth::user()->roles()->where('name', 'Frontdesk')->count() > 0) {
            $discount_requests = $discount_requests->where('requester_id', Auth::id());
            $user['is_frontdesk'] = true;
        } else if(!auth()->user()->hasRole('Admin')) { 
            // dd(Auth::user()->hotel_id);
            $discount_requests = $discount_requests->where('hotel_id', Auth::user()->hotel_id);
        } else {
            $discount_requests = $discount_requests->where('status','Pending');
        }
        
        $count = $discount_requests->count();

        $discount_requests = $discount_requests->skip($inputs['page'] * $inputs['perPage'] - $inputs['perPage'])->take($inputs['page'] * $inputs['perPage'])->orderBy('created_at', $request->sorting);

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
            'msgtype' => 'success'
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
