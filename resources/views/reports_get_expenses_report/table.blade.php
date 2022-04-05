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
                    Expenses
                        <span><a href="#" class="" ng-click="showFilter()">
                            <i id="" class="icon-search4 " style="font-size: 12px;"></i>
                       </a></span>
                </h5>
            </div>

            <div class="table table-responsive dataTables_wrapper">
                <table id="examplefahad" datatable="ng" dt-options="dtOptions" class="table table-striped hover display dataTable datatable-basic receivable-report-table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Date</th>
                        <th scope="col">Expense Details</th>
                        <th scope="col">Expense Amount</th>
                      </tr>
                </thead>
                    <tbody data-link="row" class="rowlink">
                        <tr class="col-lg-12 unread" ng-repeat="c in getexpenses" ng-cloak>
                                <th scope="row">[[$index +1]]</th>
                                <td>[[c.created_at]]</td>
                                <td>[[c.description]]</td>
                                    <td ng-repeat="o in c.voucher_details">
                                        [[o.cr_amount]]
                                    </td>
                              </tr>
                    </tbody>
                </table>

            </div>

        </div>
    </div>
