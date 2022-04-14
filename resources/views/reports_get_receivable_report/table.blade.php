<style>
.fc-widget-content .fc-scroller {height: auto !important;}
.booking_detail {line-height: 13px;font-size: 13px;}
.fc-right button {float: right;}
.cursorShow{cursor: default;}
</style>

<div id="bookings-table" class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
    <div class="card bookingTable">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">
                Receivables
                    <span><a href="#" class="" ng-click="showFilter()">
                        <i id="" class="icon-search4 " style="font-size: 12px;"></i>
                   </a></span>
            </h5>
        </div>

        <div class="table table-responsive dataTables_wrapper">
            <table id="examplefahad" datatable="ng" dt-options="dtOptions" class="table table-striped hover display dataTable datatable-basic receivable-report-table">
            {{-- <table ng-cloak class="table table-striped hover display dataTable datatable-basic"> --}}
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
                <tbody data-link="row" class="rowlink">
                    <tr class="col-lg-12 unread" ng-repeat="a in rec1" ng-cloak>
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
