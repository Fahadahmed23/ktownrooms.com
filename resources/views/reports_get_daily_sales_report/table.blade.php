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
                    Daily Sales
                        <span><a href="#" class="" ng-click="showFilter()">
                            <i id="" class="icon-search4 " style="font-size: 12px;"></i>
                       </a></span>
                </h5>
            </div>

            <div class="table table-responsive dataTables_wrapper">
                <table ng-cloak class="table table-striped hover display dataTable datatable-basic">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Booking No.</th>
                        <th scope="col">Guest Name</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">No. of occupants</th>
                        <th scope="col">Check in Date</th>
                        <th scope="col">Check out date </th>
                        <th scope="col">Room Rent</th>
                        <th scope="col">Late checkout </th>
                        <th scope="col">Early checkin </th>
                        <th scope="col">Misc amount</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Paid Amount</th>
                        <th scope="col">Balance Outstanding</th>
                      </tr>
                </thead>
                    <tbody data-link="row" class="rowlink">
                        <tr class="col-lg-12 unread" ng-repeat="d in dailysales" ng-cloak>
                                <th scope="row">[[$index +1]]</th>
                                <td>[[d.booking_no]]</td>
                                <td>[[d.customer_first_name]] [[d.customer_last_name]]</td>
                                <td>[[d.RoomNumber]]</td>
                                <td>[[d.no_occupants]]</td>
                                <td>[[d.checkin_time]]</td>
                                <td>[[d.checkout_time]]</td>
                                <td>[[d.roomscharges]]</td>
                                <td>[[d.late_checkout]]</td>
                                <td>[[d.early_checkin]]</td>
                                <td>[[d.miscellaneous_amount]]</td>
                                <td>[[d.net_total]]</td>
                                <td>[[d.payment_amount]]</td>
                                <td>[[d.balance_outstanding]]</td>
                          </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
