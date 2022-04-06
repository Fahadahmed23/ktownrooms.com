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
                    Get KLC
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
                        <th scope="col">Guest Name</th>
                        <th scope="col">CheckIn</th>
                        <th scope="col">CheckOut</th>
                        <th scope="col">Room #</th>
                        <th scope="col">Room Rent</th>
                        <th scope="col">Nights</th>
                        <th scope="col">Total Other Amenities  (Room Services, Miscelaneous )</th>
                        <th scope="col">Total Room Revenue</th>
                        <th scope="col">Total Amount(All expenses + room rent)</th>
                        <th scope="col">Total Amount Received</th>
                        <th scope="col">Amount Balance  (I - J) </th>
                        <!--<th scope="col">KTOWN Booking Comission</th>
                        <th scope="col">KTOWN Software Fees</th> -->
                        <th scope="col">User Name</th>

                      </tr>
                </thead>
                    <tbody data-link="row" class="rowlink">
                            <tr ng-repeat="k in getklc" class="unread">
                                <th scope="row">[[$index +1]]</th>
                                <td>[[k.BookingFrom]]</td>
                                <td>
                                    [[k.customer_first_name]] [[k.customer_last_name]]
                                </td>
                                <td>[[k.checkin_time]]</td>
                                <td>[[k.checkout_time]]</td>
                                <td>[[k.roomnumber]]</td>
                                <td>[[k.roomscharges]]</td>
                                <td>[[k.nights]]</td>
                                <td>[[k.total_other_amenities]]</td>
                                <td>[[k.total_room_revenue]]</td>
                                <td>[[k.total_amount]]</td>
                                <td>[[k.total_amount_received]]</td>
                                <td>[[k.amount_balance]]</td>
                                <td>[[k.user_name]]</td>
                          </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
