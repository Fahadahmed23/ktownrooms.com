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
                    CashFlow Cash Out
                        <span><a href="#" class="" ng-click="showFilter()">
                            <i id="" class="icon-search4 " style="font-size: 12px;"></i>
                       </a></span>
                </h5>
            </div>

            <div class="table table-responsive dataTables_wrapper">
                <table id="examplefahad" datatable="ng" dt-options="dtOptions" class="table table-striped hover display dataTable datatable-basic receivable-report-table">
                 {{-- <table class="table table-striped hover display dataTable datatable-basic receivable-report-table"> --}}
                 <!-- <table ng-cloak class="table table-striped hover display dataTable datatable-basic"> -->
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Expense Details</th>
                            <th scope="col">Date</th>
                            <th scope="col">Amount Paid</th>
                            <th scope="col">User Name</th>
                            <th scope="col">Closing Balance</th>
                            <th scope="col">Cash in Drawer</th>
                          </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink">
                        <tr class="col-lg-12 unread" ng-repeat="d in cashflowcashout" ng-cloak>
                                <th scope="row">[[$index +1]]</th>
                                <td>[[d.description]]</td>
                                <td>[[d.created_at]]</td>
                                <td>[[d.cr_amount]]</td>
                                <td>[[d.post_user]]</td>
                                <td>[[d.closing_balance]]</td>
                                <td>[[d.cash_in_drawer]]</td>
                          </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


