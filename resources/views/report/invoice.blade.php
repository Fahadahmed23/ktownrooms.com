@extends('layouts.app')

<style>
    table {
        width: 100%;
    }

    .tab-content a {
        color: black;
    }

    .input-group-append {
        display: inline-flex;
    }
    .form-control{
        background: #d3d3d3;
    }
    @media print {
        #printPageButton {
            display: none;
        }
        .page-header{
            display: none;
        }
        @page { size: auto;  margin: 0mm; }
    }
</style>


@section('scripts')
<script src="{{ asset_path('app/report-controller.js') }}"></script>
<script src="{{ asset_path('assets/js/tableHTMLExport.js') }}"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script> -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.10/jspdf.plugin.autotable.min.js"></script> -->

@endsection

@section('content')
<!-- Page content -->
<div class="page-content" ng-controller="reportCtrl" ng-init="invoice()">

    <!-- Main sidebar -->

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        @include('report.header')
        <!--/page header-->

        <!-- Content area -->
        <div class="content" id="printarea">
            @if(isset($tour_invoice))
            {{-- <div class="card-body">

                <div class="header-elements col-md-4 m-auto">
                    <h5 class="card-title text-center"> Tour Reciept</h5>
                </div> --}}
                {{-- <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Patron Code</label>
                    <div class="col-md-9">
                        <span class="form-control">{{$tour_invoice->group->user_id ? $tour_invoice->group->user->code : $tour_invoice->group->prospect->code }}</span>
                    </div>
                </div>
                <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Patron Name</label>
                    <div class="col-md-9">
                        <span class="form-control">{{ $tour_invoice->group->user_id ? $tour_invoice->group->user->name : $tour_invoice->group->prospect->first_name .' '. $tour_invoice->group->prospect->last_name  }}</span>
                    </div>
                </div>
                <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Type - Level</label>
                    <div class="col-md-9">
                        <span class="form-control">{{ $tour_invoice->group->user_id ? ($tour_invoice->group->user->type . (isset($tour_invoice->group->user->memberships[0]) ? ' - '.$tour_invoice->group->user->memberships[0]->membershipLevel->name : '')  ) : 'prospect'  }}</span>
                    </div>
                </div>
                <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Phone</label>
                    <div class="col-md-5">
                        <span class="form-control">{{ $tour_invoice->group->user_id ? $tour_invoice->group->user->phone : $tour_invoice->group->prospect->phone }}</span>
                    </div>
                    <label class="col-lg-1 col-form-label">Ext</label>
                    <div class="col-md-3">
                        <span class="form-control">{{ $tour_invoice->group->user_id ? $tour_invoice->group->user->phone_ext : $tour_invoice->group->prospect->phone_ext }}</span>
                    </div>
                </div>
                <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Email</label>
                    <div class="col-md-9">
                        <span class="form-control">{{ $tour_invoice->group->user_id ? $tour_invoice->group->user->email : $tour_invoice->group->prospect->email }}</span>
                    </div>
                </div>
                <div class="form-group col-md-4 m-auto d-flex" >
                    <span class="badge badge-primary col-lg-4" style="font-size:100% !important">{{ $tour_invoice->group->adults }} Adults</span>
                    <span class="badge badge-info col-lg-4" style="font-size:100% !important"> {{ $tour_invoice->group->infants }} Children</span>
                    <span class="badge badge-warning col-lg-4" style="font-size:100% !important"> {{ $tour_invoice->group->family_members }} Family</span>

                    
                </div>
                <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Channel</label>
                    <div class="col-md-9">
                        <span class="form-control">{{ $tour_invoice->group->tour->channel }}</span>
                    </div>
                </div>
                @if(count($tour_invoice->group->tour->volunteers))
                    @foreach ($tour_invoice->group->tour->volunteers as $key => $item)
                        <div class="form-group col-md-4 m-auto d-flex" >
                            <label class="col-lg-3 col-form-label">Volunteer {{ $key+1 }}</label>
                            <div class="col-md-9">
                                <span class="form-control">{{ $item->volunteer->name ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach
                @endif
                @if($tour_invoice->group->campaign)
                <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Campaign</label>
                    <div class="col-md-9">
                        <span class="form-control">{{ $tour_invoice->group->campaign->title ?? '' }}</span>
                    </div>
                </div>
                @endif
                <div class="form-group col-md-4 m-auto d-flex" >
                    <label class="col-lg-3 col-form-label">Payment Type</label>
                    <div class="col-md-9">
                        <span class="form-control">{{ $tour_invoice->group->payment_type }}</span>
                    </div>
                </div> --}}
            {{-- </div> --}}
            {{-- <div class="receipt zig-zag-top col-md-4 m-auto">
                <div class="col-12"><label class="d-block font-weight-semibold"><i class="icon-calculator mr-1"></i>Invoice</label></div>
                <table class="table receipt-content">
                    @if($tour_invoice->group->visitor_type == 'prospect')
                    <tr>
                        <td>Adults</td>
                        <td>{{ $tour_invoice->adults }} x {{ $tour_invoice->adult_charges }}</td>
                        <td>${{ number_format($tour_invoice->adults * $tour_invoice->adult_charges, 2)  }} </td>
                    </tr>
                    <tr>
                        <td>Children</td>
                        <td>{{ $tour_invoice->infants }} x {{ $tour_invoice->infant_charges }}</td>
                        <td>${{ number_format($tour_invoice->infants * $tour_invoice->infant_charges, 2)  }} </td>
                    </tr>
                    @else
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center font-weight-bold">Included In Membership</td>
                        
                    </tr>
                    <tr>
                        <td>Adults</td>
                        <td>{{ $tour_invoice->inc_adults }}</td>
                        <td>${{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>Children</td>
                        <td>{{ $tour_invoice->inc_infants }}</td>
                        <td>${{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>Automobiles</td>
                        <td>{{ $tour_invoice->inc_cars }}</td>
                        <td>${{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>Family Members</td>
                        <td>{{ $tour_invoice->inc_family_members }}</td>
                        <td>${{ number_format(0,2) }}</td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="3" class="text-center font-weight-bold">Excluded from Membership</td>
                    </tr>
                    <tr>
                        <td>Adults </td>
                        <td>{{ $tour_invoice->adults}} x {{ $tour_invoice->adult_charges}}</td>
                        <td>${{ number_format($tour_invoice->adults * $tour_invoice->adult_charges,2) }}</td>
                    </tr>
                    <tr>
                        <td>Children</td>
                        <td>{{ $tour_invoice->infants }} x {{ $tour_invoice->infant_charges}}</td>
                        <td>${{ number_format($tour_invoice->infants * $tour_invoice->infant_charges,2) }}</td>
                    </tr>
                    <tr>
                        <td>Automobiles</td>
                        <td>{{ $tour_invoice->no_of_cars }} x {{ $tour_invoice->car_charges }}</td>
                        <td>${{ number_format( $tour_invoice->no_of_cars * $tour_invoice->car_charges,2) }}</td>
                    </tr>   
                    <tr>
                        <td>Family Members</td>
                        <td>{{ $tour_invoice->family_members }} x {{ $tour_invoice->adult_charges}}</td>
                        <td>${{ number_format($tour_invoice->family_members * $tour_invoice->adult_charges,2)  }}</td>
                    </tr> 
                   
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    @endif
                    @if($tour_invoice->group->visitor_type == 'prospect')
                    <tr>
                        <td>Automobiles</td>
                        <td>{{ $tour_invoice->no_of_cars }} x {{ $tour_invoice->car_charges }}</td>
                        <td>${{ number_format($tour_invoice->no_of_cars * $tour_invoice->car_charges, 2) }} </td>
                    </tr>
                    @endif
                    
                    
                    <tr>
                        <td>UnderAge (Free)</td>
                        <td>{{ $tour_invoice->under_age }}</td>
                        <td>${{ number_format(0,2) }}</td>
                    </tr>
                    @if($tour_invoice->convenience_charges_type == 'percent')
                    <tr >
                        <td>Convenience charges</td>
                        <td>{{ number_format($tour_invoice->convenience_charges,2) }} %</td>
                        <td>${{ number_format($tour_invoice->convenience_fee,2) }} </td>
                    </tr>
                    @else
                    <tr >
                        <td>Convenience charges</td>
                        <td>{{ number_format($tour_invoice->convenience_charges,2) }} /person</td>
                        <td>${{ number_format($tour_invoice->convenience_fee,2) }} </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Discount</td>
                        <td></td>
                        <td>${{ number_format($tour_invoice->discount, 2) }} </td>
                    </tr>
                    <tr>
                        <td>Adjustments</td>
                        <td></td>
                        <td>${{ $tour_invoice->adjustment_fee }} </td>
                    </tr>
                    
                    <tr class="font-weight-bold" >
                        <td>Grand Total</td>
                        <td></td>
                        <td>${{  number_format($tour_invoice->amount  - $tour_invoice->discount + $tour_invoice->adjustment_fee, 2) }} </td>
                    </tr>
                    
                </table>
                
            </div> --}}
            <div class="receipt col-md-4 m-auto">
                <table class="table receipt-content">
                    <tr>
                        <td colspan="3" class="text-center p-0" style="border: 0px; font-size:16px"><strong>{{ $admin_default_setting->museum_name }}</strong></td>                                            
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center p-0"style="border: 0px;"><strong>{{ $admin_default_setting->address }}, {{ $admin_default_setting->city }}, {{ $admin_default_setting->abbreviation }}, {{ $admin_default_setting->zip }}</strong></td>                                            
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center p-0"style="border: 0px;"><strong>{{ $admin_default_setting->phone }}</strong></td>                                            
                    </tr>
                    <tr>
                        <td colspan="3" class="text-center p-0"style="border: 0px;"><strong>{{ $admin_default_setting->email }}</strong></td>                                            
                    </tr>
                    <tr>
                        <td>Receipt #</td>
                        <td colspan="2">{{ $tour_invoice->group->group_code }}</td>
                        
                    </tr>
                    <tr>
                        <td>Booking Date</td>
                        <td colspan="2">{{ $tour_invoice->group->created_at }}</td>
                        
                    </tr>
                    <tr>
                        <td>Tour Date & Time</td>
                        <td colspan="2">{{ date('m/d/Y', strtotime($tour_invoice->group->tour->slot->date)) }} ({{ date('h:i a', strtotime($tour_invoice->group->tour->slot->start_time)) }} - {{ date('h:i a', strtotime($tour_invoice->group->tour->slot->end_time)) }})</td>
                        
                    </tr>
                    <tr>
                        <td>Patron Code</td>
                        <td colspan="2">{{$tour_invoice->group->user_id ? $tour_invoice->group->user->code : $tour_invoice->group->prospect->code }}</td>
                    </tr>
                    <tr>
                        <td>Patron Name</td>
                        <td colspan="2">{{ $tour_invoice->group->name  }}</td>
                    </tr>
                    {{-- <tr>
                        <td>Type - Level</td>
                        <td colspan="2">{{ $tour_invoice->group->user_id ? ($tour_invoice->group->user->type . (isset($tour_invoice->group->user->memberships[0]) ? ' - '.$tour_invoice->group->user->memberships[0]->membershipLevel->name : '')  ) : 'prospect'  }}</td>
                    </tr> --}}
                    <tr>
                        <td>Phone</td>
                        <td colspan="2">{{ $tour_invoice->group->contact }}</td>
                        {{-- <td> {{ $tour_invoice->group->user_id ? $tour_invoice->group->user->phone_ext : $tour_invoice->group->prospect->phone_ext }}</td> --}}
                    </tr>
                    <tr>
                        <td>Email</td>
                        <td colspan="2">{{ $tour_invoice->group->email }}</td>
                    </tr>
                    <tr>
                        <td>Channel</td>
                        <td colspan="2">{{ $tour_invoice->group->tour->channel }}</td>
                    </tr>
                    @if($tour_invoice->group->campaign)
                    <tr>
                        <td>Campaign</td>
                        <td colspan="2">{{ $tour_invoice->group->campaign->title ?? '' }}</td>
                    </tr>
                    @endif
                    @if(count($tour_invoice->group->tour->volunteers))
                    <tr>
                        <td colspan="3" class="text-center font-weight-bold">Assign Volunteers</td>
                        
                    </tr>
                        @foreach ($tour_invoice->group->tour->volunteers as $key => $item)
                            <tr>
                                <td>{{ $item->volunteer->active_status->status }}:</td>
                                <td colspan="2"> {{ $item->volunteer->name ?? '' }} </td>
                            </tr>
                        @endforeach
                    @endif

                    {{-- @if(isset($tour_invoice->group->prospect_id) && $tour_invoice->group->visitor_type == 'prospect') --}}
                    @if($tour_invoice->group->visitor_type == 'prospect')
                    <tr>
                        <td>Adults</td>
                        <td>{{ $tour_invoice->adults }} x ${{ number_format($tour_invoice->adult_charges,2) }}</td>
                        <td class="text-right">${{ number_format($tour_invoice->adults * $tour_invoice->adult_charges, 2)  }} </td>
                    </tr>
                    <tr>
                        <td>Children</td>
                        <td>{{ $tour_invoice->infants }} x ${{ number_format($tour_invoice->infant_charges,2) }}</td>
                        <td class="text-right">${{ number_format($tour_invoice->infants * $tour_invoice->infant_charges, 2)  }} </td>
                    </tr>
                    @else
                    
                    <tr>
                        <td colspan="3" class="text-center font-weight-bold">Included In Membership</td>
                        
                    </tr>
                    <tr>
                        <td>Adults</td>
                        <td>{{ $tour_invoice->inc_adults }}</td>
                        <td class="text-right">${{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>Children</td>
                        <td>{{ $tour_invoice->inc_infants }}</td>
                        <td class="text-right">${{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>Automobiles</td>
                        <td>{{ $tour_invoice->inc_cars }}</td>
                        <td class="text-right">${{ number_format(0,2) }}</td>
                    </tr>
                    <tr>
                        <td>Family Members</td>
                        <td>{{ $tour_invoice->inc_family_members }}</td>
                        <td class="text-right">${{ number_format(0,2) }}</td>
                    </tr>
                    
                    
                    <tr>
                        <td colspan="3" class="text-center font-weight-bold">Excluded from Membership</td>
                    </tr>
                    <tr>
                        <td>Adults </td>
                        <td>{{ $tour_invoice->adults}} x ${{ number_format($tour_invoice->adult_charges,2)}}</td>
                        <td class="text-right">${{ number_format($tour_invoice->adults * $tour_invoice->adult_charges,2) }}</td>
                    </tr>
                    <tr>
                        <td>Children</td>
                        <td>{{ $tour_invoice->infants }} x ${{ number_format($tour_invoice->infant_charges,2)}}</td>
                        <td class="text-right">${{ number_format($tour_invoice->infants * $tour_invoice->infant_charges,2) }}</td>
                    </tr>
                    <tr>
                        <td>Automobiles</td>
                        <td>{{ $tour_invoice->no_of_cars }} x ${{ number_format($tour_invoice->car_charges ,2)}}</td>
                        <td class="text-right">${{ number_format( $tour_invoice->no_of_cars * $tour_invoice->car_charges,2) }}</td>
                    </tr>   
                    <tr>
                        <td>Family Members</td>
                        <td>{{ $tour_invoice->family_members }} x ${{ number_format($tour_invoice->adult_charges,2)}}</td>
                        <td class="text-right">${{ number_format($tour_invoice->family_members * $tour_invoice->adult_charges,2)  }}</td>
                    </tr> 
                
                    
                    @endif
                    
                    @if($tour_invoice->group->visitor_type == 'prospect')
                    <tr>
                        <td>Automobiles</td>
                        <td>{{ $tour_invoice->no_of_cars }} x ${{ number_format($tour_invoice->car_charges,2) }}</td>
                        <td class="text-right">${{ number_format($tour_invoice->no_of_cars * $tour_invoice->car_charges, 2) }} </td>
                    </tr>
                    @endif
                    
                    
                    <tr>
                        <td>UnderAge (Free)</td>
                        <td>{{ $tour_invoice->under_age }}</td>
                        <td class="text-right">${{ number_format(0,2) }}</td>
                    </tr>
                    @if($tour_invoice->convenience_charges_type == 'percent')
                    <tr >
                        <td>Convenience charges</td>
                        <td>{{ number_format($tour_invoice->convenience_charges,2) }} %</td>
                        <td class="text-right">${{ number_format($tour_invoice->convenience_fee,2) }} </td>
                    </tr>
                    @else
                    <tr >
                        <td>Convenience charges</td>
                        <td>${{ number_format($tour_invoice->convenience_charges,2) }} /person</td>
                        <td class="text-right">${{ number_format($tour_invoice->convenience_fee,2) }} </td>
                    </tr>
                    @endif
                    @if($tour_invoice->discount != 0)
                    <tr>
                        <td>Discount</td>
                        <td></td>
                        <td class="text-right">${{ number_format($tour_invoice->discount, 2) }} </td>
                    </tr>
                    @endif
                    @if($tour_invoice->donation_amount > 0)
                        <tr>
                            <td>Donation Amount (inc. Convenience charges)</td>
                            <td></td>
                            <td class="text-right">${{ number_format($tour_invoice->donation_amount, 2) }} </td>
                        </tr>
                    @endif
                    @if($tour_invoice->adjustment_fee != 0)
                    <tr>
                        <td>Adjustments</td>
                        <td></td>
                        <td class="text-right">${{ number_format($tour_invoice->adjustment_fee, 2) }} </td>
                    </tr>
                    @endif
                    <tr>
                        <td>Payment Type</td>
                        <td></td>
                        <td class="text-right">{{ strtoupper($tour_invoice->group->payment_type) }} </td>
                    </tr>
                    @if($tour_invoice->group->payment_type == 'card')
                    <tr>
                        <td>Card No.</td>
                        <td></td>
                        <td class="text-right">{{ isset($tour_invoice->group->cardDetails) ? $tour_invoice->group->cardDetails->card_no : '**** **** **** ****' }} </td>
                    </tr>
                    @endif
                    @if($tour_invoice->group->payment_type == 'check')
                    <tr>
                        <td>Check No.</td>
                        <td></td>
                        <td class="text-right">{{ $tour_invoice->group->check_num }} </td>
                    </tr>
                    @endif
                
                    
                    <tr class="font-weight-bold" >
                        <td>Grand Total</td>
                        <td></td>
                        <td class="text-right">${{  number_format($tour_invoice->amount  - $tour_invoice->discount + $tour_invoice->adjustment_fee + $tour_invoice->donation_amount, 2) }} </td>
                    </tr>
                    
                </table>

                {{-- <button >Print</button> --}}
                
            </div>
            
            <button id="printPageButton" class="btn-lg btn-primary" style="margin-left: 46%">Print Invoice</button>
            @else
            <div>
                <h4>No invoice Found</h4>
            </div>
            @endif
        </div>


    </div>
    <!-- /content area -->


    <!-- /main content -->

</div>
</div>
@endsection

@section('inlineJS')
<script type="text/javascript">
    $('#printPageButton').click(function () {
        $("#printarea").show();
        window.print();
    });
</script>
@endsection