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
                    Invoices
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
                        <th scope="col">Guest Name</th>
                        <th scope="col">Hotel Name</th>
                        <th scope="col">Booking #</th>
                        <th scope="col">Check-in Date</th>
                        <th scope="col">Check-out Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">View Invoice</th>
                    </tr>
                </thead>
                    <tbody data-link="row" class="rowlink">
                        <tr class="col-lg-12 unread" ng-repeat="c in getinvoice" ng-cloak>
                                <th scope="row">[[$index +1]]</th>
                                <td>[[c.customer_first_name]] [[c.customer_last_name]]</td>
                                <td>[[c.HotelName]]</td>
                                <td>[[c.booking_no]]</td>
                                <td>[[c.checkin_time]]</td>
                                <td>[[c.checkout_time]]</td>
                                <td>[[c.status]]</td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>

