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
                    BTC Pending
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
                        <th scope="col">Date</th>
                        <th scope="col">Hotel Name</th>
                        <th scope="col">Booking No.</th>
                        <th scope="col">Company Name</th>
                        <th scope="col">Guest Name</th>
                        <th scope="col">Room No.</th>
                        <th scope="col">No. of occupants</th>
                        <th scope="col">Check in Date</th>
                        <th scope="col">Check out date </th>
                        <th scope="col">Nights </th>
                        <th scope="col">TAX </th>
                        <th scope="col">Room Rate</th>
                        <th scope="col">Total Amenties Amount</th>
                        <th scope="col">Amount Paid</th>
                        <th scope="col">Amount Balance</th>
                        <th scope="col">BTC Type</th>
                        <th scope="col">User Name (who booked)</th>
                    </tr>
                </thead>
                    <tbody data-link="row" class="rowlink">
                        <tr class="col-lg-12 unread" ng-repeat="c in btcpendinglist" ng-cloak>
                                <th scope="row">[[$index +1]]</th>
                                <td>[[c.BookingFrom]]</td>
                                <td>[[c.HotelName]]</td>
                                <td>[[c.booking_no]]</td>
                                <td>[[c.corporate_client_name]]</td>
                                <td>[[c.customer_first_name]] [[c.customer_last_name]]</td>
                                <td>[[c.roomNumber]]</td>
                                <td>[[c.no_occupants]]</td>
                                <td>[[c.checkin_time]]</td>
                                <td>[[c.checkout_time]]</td>
                                <td>[[c.nights]]</td>
                                <td>[[c.tax_charges]]</td>
                                <td>[[c.RoomRent]]</td>
                                <td>[[c.total_other_amenities]]</td>
                                <td>[[c.payment_amount]]</td>
                                <td>[[c.net_total]]</td>
                                <td>[[c.btc_type]]</td>
                                <td>[[c.user_name]]</td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
