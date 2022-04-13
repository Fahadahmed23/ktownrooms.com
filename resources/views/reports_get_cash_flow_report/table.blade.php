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
                    CashFlow
                        <span><a href="#" class="" ng-click="showFilter()">
                            <i id="" class="icon-search4 " style="font-size: 12px;"></i>
                       </a></span>
                </h5>
            </div>

            <div class="table table-responsive dataTables_wrapper">
                {{-- <table id="examplefahad" datatable="ng" dt-options="dtOptions" class="table table-striped hover display dataTable datatable-basic receivable-report-table"> --}}
                <table ng-cloak class="table table-striped hover display dataTable datatable-basic">
                    <tbody ng-repeat='cf in cashflow'>
                        <tr class="unread">
                            <tr>
                                <th>Date</th>
                                <th> [[ cf.Date ]] </th>
                            </tr>
                            <tr>
                                <th>Opening Balance</th>
                                <th>[[ cf.OpeningBalance ]]</th>
                            </tr>
                            <tr>
                                <th>Cash In ( Add) </th>
                                <th>[[ cf.CashIn ]]</th>
                            </tr>
                            <tr>
                                <th>S#</th>
                                <th>Guest Name</th>
                                <th>Room No. </th>
                                <th>Booking No. </th>
                                <th>Amount Received  </th>
                                <th>User Name (Who Booked )</th>
                            </tr>
                            <tr ng-repeat='booking in cf.bookings'>
                                <td>101</td>
                                <td>[[ booking.customer_first_name ]] [[ booking.customer_last_name ]]</td>
                                <td>[[ booking.roomNumber ]]</td>
                                <td>[[ booking.booking_no ]]</td>
                                <td>[[ booking.payment_amount ]]</td>
                                <td>[[ booking.user_name ]]</td>
                            </tr>
                            <tr>
                                <th>Cash Out</th>
                                <th>[[ cf.CashOut ]]</th>
                            </tr>

                            <tr>
                                <th>S#</th>
                                <th>Expense Details </th>
                                <th>Date</th>
                                <th>Amount Paid </th>
                                <th>User Name</th>
                            </tr>
                            <tr ng-repeat='expenseDetail in cf.ExpenseDetails'>
                                <td>101</td>
                                <td>[[ expenseDetail.description ]]</td>
                                <td>[[ expenseDetail.created_at ]]</td>
                                <td>[[ expenseDetail.voucher_details[0].cr_amount ]]</td>
                                <td>[[ expenseDetail.post_user ]]</td>
                            </tr>

                            <tr>
                                <th>Cash in Drawer</th>
                                <th>[[ cf.CashInDrawer ]]</th>
                            </tr>

                            <tr>
                                <th>Closing Balance</th>
                                <th>[[ cf.ClosingBalance ]]</th>
                            </tr>

                        </tr>


                    </tbody>

                </table>

            </div>

        </div>
    </div>



