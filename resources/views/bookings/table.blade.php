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
                    Bookings 
                    <span><a href="#" class="" ng-click="showFilter()">
                        <i id="" class="icon-search4 " style="font-size: 12px;"></i> 
                   </a></span>
            </h5>
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-sm btn-primary " ng-click="showSearch();newBooking()"><i class="mr-1 icon-plus22"></i>New Booking</button>
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload" ng-click="init()"></a>

                </div>
            </div>
        </div>

        <div class="table table-responsive dataTables_wrapper">
            <table ng-cloak class="table table-striped hover display dataTable datatable-basic">
                <thead>
                    <tr>
                        <th ng-cloak ng-repeat="col in columns" ng-show="col.isShow" ng-model="sortColumn[col.Name]" ng-class="col.isSort ? (sortColumn[col.Name]?sortColumn[col.Name]:'sorting') : ''" ng-click="col.isSort ? sort(col,sortColumn[col.Name]) : ''">[[col.Alias]]</th>
                    </tr>
                    {{-- <tr>
                        <th>Booking #</th>
                        <th>Customer</th>
                        <th>Hotel</th>
                        <th>Phone</th>
                        <th>Status</th>
                        <th>Booking Date</th>
                        <th>Check-In Date</th>
                        <th>Check-Out Date</th>
                        <th>Occupants</th>
                        <th>Actions</th>
                    </tr> --}}
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr class="col-lg-12" dir-paginate="booking in bookings | itemsPerPage:perPage" current-page="currentPage" total-items="TotalRecords" pagination-id="bookingPagination" ng-cloak>
                        <td>[[booking.booking_no ? booking.booking_no : (booking.is_third_party ? booking.third_party_booking_no  : '')]]</td>
                        <td>[[booking.FullName]]</td>
                        <td>[[booking.HotelName]]</td>
                        <td>[[booking.RoomNumber]]</td>
                        <!-- <td class="cursorShow" data-placement="left" data-popup="popover" data-title="" data-trigger="hover" data-html="true" data-content="[[booking.HotelName]]" data-original-title="">[[booking.HotelName | limitTo: 15]] [[booking.HotelName.length > 15 ? '...' : '']]</td> -->
                        {{-- <td>[[booking.Phone]]</td> --}}
                        <td style="display: inline-grid">
                            <a href="javascript:void(0)" ng-hide="booking.status == 'CheckedIn' || booking.status == 'CheckedOut' || booking.status=='Cancelled'" ng-click="changeRoomStatus(booking.id)" class="badge" ng-class="getStatusClass(booking.status)">[[booking.status]]</a>
                            <a href="javascript:void(0)" ng-show="booking.status == 'CheckedIn' || booking.status == 'CheckedOut' || booking.status=='Cancelled'" class="badge" ng-class="getStatusClass(booking.status)">[[booking.status]]</a>
                            <!-- <div class="dropdown-menu dropdown-menu-right">
                                <a ng-show="booking.status=='Pending'" href="javascript:void(0)" ng-click="changeStatus(booking, 'Confirmed')" class="dropdown-item"></i>Confirmed</a>
                                <a ng-show="booking.status=='Confirmed'" href="javascript:void(0)" ng-click="changeStatus(booking, 'CheckedIn')" class="dropdown-item"></i>CheckedIn</a>
                                <a ng-show="booking.status=='CheckedIn' && today==booking.BookingFrom" href="javascript:void(0)" ng-click="changeStatus(booking, 'CheckedOut')" class="dropdown-item"></i>CheckedOut</a>
                                <a ng-show="booking.status=='Pending' || booking.status=='Confirmed'" href="javascript:void(0)" ng-click="changeStatus(booking, 'Cancelled')" class="dropdown-item"></i>Cancelled</a>
                            </div> -->
                            <span ng-if="booking.DiscountStatus" class="badge" style="cursor: default;">Discount: [[booking.DiscountStatus]]</span>

                                {{-- <a href="javascript:void(0)" class="dropdown-item"></i>Discount: [[booking.DiscountStatus]]</a> --}}
                        </td>
                        <td>[[booking.created_at | date]]</td>
                        <td>[[booking.BookingFrom | date]]</td>
                        <td>[[booking.BookingTo | date]]</td>
                        {{-- <th>[[booking.num_occupants]]</th> --}}
                        <th>[[booking.created_by]]</th>
                        <th ng-hide="true">[[booking.created_at | date]]</th>
                        <td>
                            <div class="align-self-left">
                                <div class="list-icons list-icons-extended">
                                    <a ng-click="adminCustomerDetails(booking.id)" class="list-icons-item" href="javascript:void(0)"><i class="fa fa-user-tag"></i></a>
                                    <a class="list-icons-item" ng-click="showInvoiceModal(booking.id)"><i class="icon-clipboard3"></i></a>
                                    <a ng-click="showBookDetailRBox(booking.id)" class="list-icons-item view-pro"><i class="icon-folder-search"></i></a>
                                    <a ng-if="booking.status!='Cancelled'" ng-click="editBooking(booking.id)" class="list-icons-item edit-sec"><i class="icon-pencil5"></i></a>
                                    <a ng-if="booking.status=='Confirmed'" ng-click="resendInvoice(booking.id)" data-popup="tooltip" title="Resend Invoice" class="list-icons-item"><i class="fas fa-envelope"></i></a>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <dir-pagination-controls pagination-id="bookingPagination" on-page-change="pageChanged(newPageNumber)" direction-links="true" boundary-links="true"></dir-pagination-controls>
        </div>

        <!--<ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-3">
            <li class="nav-item active show"><a href="#bookings_table" class="nav-link active show" data-toggle="tab"><i class="icon-table mr-2 text-success"></i>Tabular View</a></li>
            <li class="nav-item"><a href="#bookings_calender" class="nav-link my_leaves" data-toggle="tab"><i class="icon-calendar2 mr-2 text-warning"></i>Calendar View</a></li>
        </ul>-->

        <!--<div class="tab-content">
            <div class="tab-pane fade active show" id="bookings_table">
            </div>

            <div class="tab-pane fade" id="bookings_calender">
                    <div class="fullcalendar-event-colors p-2"></div>
            </div>
        </div>-->
       
    </div>
</div>