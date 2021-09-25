<style>
    .md-select-menu-container,
        md-backdrop {
            z-index: 999999 !important;
        }
    .in_modal_tab_table td, .in_modal_tab_table th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 5px !important;
        font-size: 11px;
    }   
    .in_modal_tab_table {
    width: 100%;
    border-collapse: collapse;
    }
    .in-modal-tabs .nav-link.active.show{
        background: #eee !important;
    }
    </style>
    <div id="calnderBookingDetailModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header p-2 border-bottom">
                    <h5 class="modal-title">Booking Detail ([[booking_detail_calendar.booking_no]]) </h5>
                    <button type="button" class="close" ng-click="hideCalendarBookingDetail()">&times;</button>
                </div>
                
                    <div class="modal-body">
                        <div class="row">
                            <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom px-2 py-1 bg-light  mb-0">
                                <i class="icon-user mr-2 text-success"></i>
                                Customer Information
                            </legend>
                            <div class="col-md-12">
                                <div class="user-details my-2">
                                    <div class="u-name">
                                       <span>Name: </span> <strong>[[booking_detail_calendar.customer.FirstName]] [[booking_detail_calendar.customer.LastName]]</strong>
                                    </div>
                                    <div class="u-cnic">
                                        <span>CNIC: </span> <span>[[booking_detail_calendar.customer.CNIC]]</span>
                                    </div>
                                    <div class="u-phone">
                                        <span>Phone: </span><span>[[booking_detail_calendar.customer.Phone]]</span>
                                    </div>
                                    <div class="u-email">
                                        <span>Email: </span> <span>[[booking_detail_calendar.customer.Email]]</span>
                                    </div>
                                    <div class="u-latestbooking">
                                        <span>Latest Booking On: </span> <span>[[booking_detail_calendar.customer.LatestBooking | date]]</span>
                                    </div>
                                </div>
                            </div>
    
                        </div>


                        <div class="row">
                            <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom px-2 py-1 bg-light mb-0 ">
                                <i class="icon-calendar3 mr-2 text-success"></i>
                                Booking Information
                            </legend>
                            <div class="col-md-12">
                                <div class="booking-details my-2">
                                    <div class="booking-num">
                                       <span>Booking No : </span> <strong>[[booking_detail_calendar.booking_no]]</strong>
                                    </div>
                                    <div class="b-from">
                                        <span>Booking From: </span> <span>[[booking_detail_calendar.cBookingFrom]]</span>
                                    </div>
                                    <div class="b-to">
                                        <span>Booking To: </span><span>[[booking_detail_calendar.cBookingTo]]</span>
                                    </div>
                                    <div class="b-occupants">
                                        <span>Total Occupants: </span> <span>[[booking_detail_calendar.no_occupants]]</span>
                                    </div>
                                    <div class="b-night">
                                        <span>Nights: </span> <span>[[booking_detail_calendar.invoice.nights]]</span>
                                    </div>
                                    <div class="b-net-total">
                                        <span>Booking Amount: </span> <span>[[booking_detail_calendar.invoice.net_total | currency ]]</span>
                                    </div>

                                    <div class="b-net-total">
                                        <span>Status: </span> <span ng-class="getStatusClass(booking_detail_calendar.status)" class="badge">[[booking_detail_calendar.status ]]</span>
                                    </div>
                                </div>
                            </div>
    
                        </div>



                        <div class="row my-2">
                            <ul class="nav nav-tabs nav-tabs-bottom nav-justified mb-3 w-100 in-modal-tabs">
                                <li class="nav-item"><a href="#rooms_info" class="nav-link active show bg-light text-left px-2" data-toggle="tab"><i class="icon-bed2 mr-2 text-success"></i>Rooms</a></li>
                                <li ng-if="booking_detail_calendar.services.length > 0" class="nav-item"><a href="#b_services" class="nav-link bg-light text-left px-2" data-toggle="tab"><i class="icon-magic-wand2 mr-2 text-warning"></i>Services</a></li>
                            </ul>
                            <div class="tab-content w-100">
                                <div class="tab-pane fade active show" id="rooms_info">
                                    <table class="in_modal_tab_table">
                                        <thead>
                                            <tr>
                                                <th>Room(s)</th>
                                                <th>Category</th>
                                                <th>Charges</th> 
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="room in booking_detail_calendar.rooms">
                                                <td><img class="img-thumbnail mr-2" ng-if="room.thumbnail" width="30px" height="auto" ng-src="[[room.thumbnail]]"> [[room.room_title]]</td>
                                                <td><span class="badge text-white" style="background-color: [[room.category.Color]];">[[room.RoomCategory]]</span> </td>
                                                <td>[[room.RoomCharges|currency]]</td>

                                            </tr>
                                        </tbody>
                                    </table>
                                </div>

                                <div ng-if="booking_detail_calendar.services.length > 0" class="tab-pane fade" id="b_services">
                                    <table class="in_modal_tab_table">
                                        <thead>
                                            <tr>
                                                <th>Service(s)</th>
                                                <th>Amount</th>
                                            </tr>
                                            
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="service in booking_detail_calendar.services">
                                                <td><img class="img-thumbnail mr-2" ng-if="service.icon_class" width="30px" height="auto" ng-src="[[service.icon_class]]"> [[service.service_name]]</td>
                                                <td>[[service.excludes]] [[service.service_name]] @ [[service.service_charges | currency]] </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>   
                    </div>

                <div class="modal-footer modal-footer p-2 border-top">
                    <div class="text-right">
                        {{-- <button ng-click="adminExtend()" class="btn btn-info" data-popup="popover" title="" data-trigger="hover" data-html="true" data-content="Extend Booking" data-original-title=""><i class="icon-calendar"></i></button>
                        <button ng-click="viewPOS(booking_detail_calendar)" class="btn btn-warning" data-popup="popover" title="" data-trigger="hover" data-html="true" data-content="POS Receipt" data-original-title=""><i class="icon-clipboard3"></i></button> --}}
                        <button ng-click="hideCalendarBookingDetail(); editBooking(booking_detail_calendar.id)" class="btn btn-info" data-popup="popover" title="" data-trigger="hover" data-html="true" data-content="Edit Booking" data-original-title=""><i class="icon-pencil4"></i></button>
                        <button ng-click="hideCalendarBookingDetail(); viewPOS(booking_detail_calendar, 'checkout')" class="btn btn-primary" data-popup="popover" title="" data-trigger="hover" data-html="true" data-content="Checkout" data-original-title=""><i class="icon-paperplane"></i></button>
                    </div>
                </div>    
            </div>
        </div>
    </div>