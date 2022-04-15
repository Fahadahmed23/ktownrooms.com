<style>
    .fc-widget-content .fc-scroller {height: auto !important;}
    .booking-counts label {margin: 0;}
    .fc-right button {float: right;}
    </style>
    
    <div class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
        <div class="card">
            <!-- <div class="card-header header-elements-inline border-bottom p-2">
                <h5 class="card-title">
                    Serach Filter   
                </h5>
            </div> -->
            <div class="row">
                <div class="col-md-4 m-auto">
                    <div class="card-body">
                        <form ng-submit="filterBooking()" name="filterBookingForm" action="javascript:void(0)"  confirm-on-exit>
                                <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                    <label>Select <span class="font-weight-semibold">Hotel</span></label>
                                                    <md-select ng-disabled="hotel_count == 1" md-no-asterisk name="hotel_id" class="m-0" ng-model="filters.hotel_id" placeholder="Select Hotel" multiple>
                                                        <md-button layout-fill value="all" ng-click="selectAllHotels()">Select All</md-button>
                                                        <md-option ng-repeat="h in hotels track by $index" ng-selected="hotel_count == 1 ? hotels[0].id : ''" ng-value="h.id">[[h.HotelName]]</md-option>
                                                    </md-select>
                                            </div>
                                          
                                        </div>
        
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                    <label>Booking <span class="font-weight-semibold">Status</span></label>
                                                    <md-select md-no-asterisk name="booking_status" class="m-0" ng-model="filters.booking_status" placeholder="Select a Booking Status" multiple>
                                                    <md-button layout-fill value="all" ng-click="selectAllStatus()">Select All</md-button>
                                                        <md-option ng-repeat="booking_status in booking_statuses track by $index" ng-value="booking_status">[[booking_status]]</md-option>
                                                    </md-select>
                                            </div>
                                        </div>
                                </div>
                                <div class="text-right mt-3">
                                    <button class="btn btn-info" ng-click="resetFilters('clear')" type="reset"><i class="icon-rotate-ccw3 mr-1"></i>Reset</button>
                                    <button type="submit" class="btn bg-success legitRipple"><i class="icon-search4 mr-1"></i>Search Bookings</button>
                                </div>
                        </form>
        
                    </div>
                </div>
            </div>
            
        </div>
        <div class="card">
            <div class="fullcalendar-event-colors p-2"></div>
        </div>
    </div>