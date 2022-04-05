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
                    Sales Summary
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
                        <th scope="col">Total Rooms</th>
                        <th scope="col">Today's Occupancy</th>
                        <th scope="col">Booking Revenue</th>
                        <th scope="col">Total Revenue</th>
                        <th scope="col">Occupancy %</th>
                        {{-- <th scope="col">ADR Average Daily Rate</th> --}}
                      </tr>
                </thead>
                    <tbody data-link="row" class="rowlink">
                        <tr class="col-lg-12 unread" ng-repeat="a in getsummaryreport" ng-cloak>
                                <th scope="row">[[$index +1]]</th>
                                <td>[[a.Date]]</td>
                                <td>[[a.total_rooms]]</td>
                                <td>[[a.today_occupancy]]</td>
                                <td>[[a.booking_revenue]]</td>
                                <td>[[a.total_revenue]]</td>
                                <td>[[a.occupancy_in_percentage]]</td>
                          </tr>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
