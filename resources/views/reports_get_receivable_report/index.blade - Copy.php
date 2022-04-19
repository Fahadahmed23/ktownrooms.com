@extends('layouts.app')

@section('scripts')
    <!-- <script src="~/app/reports-controller.js"></script> -->
    <script src="{{ asset_path('app/report-controller.js') }}"></script>

@endsection

@section('content')

{{-- <div class="content" ng-controller='reportsCtrl' ng-init='getSavedReports()'> --}}
    <div class="content" ng-controller='reportCtrl'>
    <div class="content-wrapper">

        <div class="content">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h4 class="card-title">Receivables
                            <span>
                                <a href="#" class="" ng-click="showFilter()">
                                    <i id="" class="icon-search4 " style="font-size: 12px;"></i> 
                                </a>
                            </span>

                        </h4>
                    </div>
                    {{-- [[rec1 | json]] --}}
                    <table class="table" ng-init="GetReceivableReport()">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Room No.</th>
                            <th scope="col">Booking No.</th>
                            <th scope="col">Guest Name</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Amount Paid</th>
                            <th scope="col">Out Standing Balance</th>
                            <th scope="col">UserName</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="a in rec1" class="unread">
                            <th scope="row">[[$index +1]]</th>
                            <td>[[a.checkin_time]]</td>
                            <td>[[a.roomNumber]]</td>
                            <td>[[a.booking_no]]</td>
                            <td>[[a.customer_first_name]] [[a.customer_last_name]]</td>
                            <td>[[a.net_total]]</td>
                            <td>[[a.payment_amount]]</td>
                            <td>[[a.balance_outstanding]]</td>
                            <td>[[a.user_name]]</td>
                            
                          </tr>
                        </tbody>
                      </table>

             
                </div>
            </div>

        </div>
        <!-- /content area -->


        <!-- /main content -->

    </div>
  
</div>
@endsection
