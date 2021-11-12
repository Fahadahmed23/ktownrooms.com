<div id="ANR-filter" class="ANR-filter" ng-hide="lockdown || formType=='edit'" style="display: none">
    <!-- room details card -->
    <div ng-if="user.is_frontdesk" class="card p-2">
        <div class="row m-0">
            <div class="col-md-2">       
                <div class="card card-body bg-teal has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding"><span id="stats_total"></span></h3>
                            <span class="text-uppercase font-size-xs">Total Rooms</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-bed2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">       
                <div class="card card-body bg-info has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding"><span id="stats_available"></span></h3>
                            <span class="text-uppercase font-size-xs">Available Rooms</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-bed2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            




            <div class="col-md-2">
                <div class="card card-body bg-success has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding"><span id="stats_confirmed"></span></h3>
                            <span class="text-uppercase font-size-xs">Confirmed Bookings</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-clipboard2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-body bg-blue-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding"><span id="stats_occupied"></span></h3>
                            <span class="text-uppercase font-size-xs">Occupied Rooms</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-calendar2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2">
                <div class="card card-body bg-danger-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding"><span id="stats_cancelled"></span></h3>
                            <span class="text-uppercase font-size-xs">Cancelled Bookings</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-cancel-circle2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-2">       
                <div class="card card-body bg-warning has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding"><span id="stats_blocked"></span></h3>
                            <span class="text-uppercase font-size-xs">Blocked Rooms</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-bed2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>


            
            {{-- <div class="col-md-3">
                <div class="card card-body bg-indigo-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding">[[hotels[0].BookingRevenueSum| currency]]</h3>
                            <span class="text-uppercase font-size-xs">Total Revenue</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-cash2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div> --}}
            
            
        </div>
    </div>
    <!-- /room details card -->

    <!--Searching FIlters-->
    <div class="card">
        <ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
            <li class="nav-item active show"><a href="#search_by_room" class="nav-link active show" data-toggle="tab"><i class="icon-bed2 mr-2 text-success"></i> Search By Room</a></li>
            <li class="nav-item"><a href="#search_by_booking" class="nav-link" data-toggle="tab"><i class="icon-clipboard2 mr-2 text-warning"></i> Search By Booking</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade active show" id="search_by_room">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Search By Room</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    @include('layouts.form_messages')
                    <div class="row">
                    <form name="bookingFrm" action="javascript:void(0)" style="display:flex; width:100%" confirm-on-exit>
                        <div class="col-md-10 row">
        
                            <div class="col-md-3" >
                                <!-- Select All option -->
                                <div class="form-group">
                                    <label>Select <span class="font-weight-semibold">City</span><span class="text-danger"> * </span></label>
        
                                    <md-select ng-change="changeCity()" md-no-asterisk ng-disabled="formType=='edit'" name="city" class="m-0" ng-model="nBooking.city_id" ng-disabled="cities.length==1" placeholder="Select a City" required>
                                        <md-option ng-repeat="city in cities" ng-value="city.id">[[city.CityName]]</md-option>
                                    </md-select>
                                    <div ng-messages="bookingFrm.city.$error" ng-if='bookingFrm.city.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">City is required</div>
                                    </div>
                                </div>
                            </div>
        
                            {{-- <div class="col-md-3" ng-show="user.is_frontdesk">
                                <div class="form-group" style="display: inline-grid">
                                    <label>City: </label>
                                    <input type="text" class="form-control" readonly disabled ng-value="cities[0].CityName">
                                </div>
                            </div>
        
                            <div class="col-md-3" ng-show="user.is_frontdesk">
                                <div class="form-group" style="display: inline-grid">
                                    <label>Hotel: </label>
                                    <input type="text" class="form-control" readonly disabled ng-value="hotels[0].HotelName">
                                </div>
                            </div> --}}
        
                            <div class="col-md-3" >
                                <!-- Select All option -->
                                <div class="form-group">
                                    <label>Select <span class="font-weight-semibold">Hotel</span><span class="text-danger"> * </span></label>
                                    <md-select md-no-asterisk ng-disabled="formType=='edit'" name="hotel" class="m-0" ng-model="nBooking.hotel" placeholder="Select a Hotel" required ng-change="changeHotel()">
                                        <md-option ng-repeat="hotel in filteredHotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                                        {{-- <md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option> --}}
                                    </md-select>
        
                                    <div ng-messages="bookingFrm.hotel.$error" ng-if='bookingFrm.hotel.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Hotel is required</div>
                                    </div>
                                </div>
                                <!-- /select All option -->
                            </div>
        
                            <div class="col-md-6">
                                <div class="col-md-6 float-left">
                                    <label class="">Check-in Date <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </span>
                                        <input ng-change="changeStartDate()" ng-disabled="formType=='edit'" type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="start_date" id="startdate" class=" form-control pickadate startdate" required>
                                        <div ng-messages="bookingFrm.start_date.$error" ng-if='bookingFrm.start_date.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Check-in Date is required</div>
                                        </div>
                                    </div>
                                </div>
        
                                <div class="col-md-6 float-left">
                                    <label class="">Check-out Date <span class="required">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </span>
                                        <input ng-change="changeEndDate()" name="end_date" ng-model="end_date" date type="text" placeholder="MM/DD/YYYY" id="enddate" class="form-control pickadate enddate" required>
                                        <div ng-messages="bookingFrm.end_date.$error" ng-if='bookingFrm.end_date.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Check-out Date is required</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
        
        
                        </div>
                        <div class="col-md-2">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label>Occupants:</label>
                                    <div class="def-number-input number-input safari_only">
                                        <button ng-click="decrementOccupants()" class="minus p-2"></button>
                                        <input readonly ng-model="nBooking.occupants" class="quantity form-control" min="1" name="occupants" type="number">
                                        <button ng-click="incrementOccupants()" class="plus p-2"></button>
                                    </div>
                                    <div ng-messages="bookingFrm.occupants.$error" ng-if="bookingFrm.occupants.$touched || bookingFrm.$submitted">
                                        <div class="text-danger" ng-message="required">No. of Occupants is required</div>
                                        <div class="text-danger" ng-message="min">Occupants should be greater than 0</div>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <label># of Rooms</label>
                                    <div class="def-number-input number-input safari_only">
                                        <button ng-click="decrementRooms()" class="minus p-2"></button>
                                        <input readonly ng-model="nBooking.no_rooms" class="quantity form-control" min="1" name="rooms" type="number">
                                        <button ng-click="incrementRooms()" class="plus p-2"></button>
                                    </div>
                                    <div ng-messages="bookingFrm.rooms.$error" ng-if="bookingFrm.rooms.$touched || bookingFrm.$submitted">
                                        <div class="text-danger" ng-message="required">No. of Rooms is required</div>
                                        <div class="text-danger" ng-message="min">Rooms should be greater than 0</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    </div>
                    <div class="text-right mt-3">
                        
                        
                        @if (auth()->user()->hasRole('Frontdesk'))
                            <button ng-click="ourRooms()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-search4 mr-1"></i>Search Rooms</button>
                        @else
                            <button ng-if="formType=='create'" ng-click="searchRooms()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-search4 mr-1"></i>Search Rooms</button>
                            <button ng-if="formType=='edit'" ng-click="searchAddRooms()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-search4 mr-1"></i>Search Rooms</button>
                            <button type="button" ng-click="hideSearch()" class="btn btn-outline-danger bkng-cncl"><i class="icon-close2 mr-1"></i>Cancel</button>
                        @endif
                    </div>
                </div>
            </div>
        
            <div class="tab-pane fade" id="search_by_booking">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">Search By Booking</h5>
                    <div class="header-elements">
                        <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <form ng-submit="ourBookings()" name="bookingFrmNew" action="javascript:void(0)"  confirm-on-exit>
                    @include('layouts.form_messages')
                    <div class="row">
                        <div class="col-md-12 row">
        
                            <div class="col-md-3">
                                <!-- Select All option -->
                                <div class="form-group">
                                    <label>Booking No</span></label>
        
                                    <input type="text" class="form-control" name="booking_no" ng-model="booking_no" placeholder="RGP0010821701">
                                    <div ng-messages="bookingFrmNew.city.$error" ng-if='bookingFrmNew.city.$touched || bookingFrmNew.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">City is required</div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-3">
                                <!-- Select All option -->
                                <div class="form-group">
                                    <label>Booking <span class="font-weight-semibold">Status</span></label>
                                    <md-select md-no-asterisk name="booking_status" class="m-0" ng-model="booking_status" placeholder="Select a Booking Status">
                                        <md-option ng-repeat="booking_status in booking_statuses" ng-value="booking_status">[[booking_status]]</md-option>
                                    </md-select>
        
                                    {{-- <div ng-messages="bookingFrmNew.booking_status.$error" ng-if='bookingFrmNew.booking_status.$touched || bookingFrmNew.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Booking Status is required</div>
                                    </div> --}}
                                </div>
                                <!-- /select All option -->
                            </div>
        
                            <div class="col-md-3">
                                <label class="">Customer Name</label>
                                <div class="input-group">
                                    {{-- <input ng-change="changeStartDate()" ng-disabled="formType=='edit'" type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="start_date" id="startdate" class=" form-control pickadate startdate" required> --}}
                                    <input type="text" name="customer_name" placeholder="John Doe" ng-model="customer_name" class="form-control">
                                    <div ng-messages="bookingFrmNew.customer_name.$error" ng-if='bookingFrmNew.customer_name.$touched || bookingFrmNew.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Check-in Date is required</div>
                                    </div>
                                </div>
                            </div>
    
                            <div class="col-md-3">
                                <label class="">CNIC/Passport</label>
                                <div class="input-group">
                                    <input name="customer_cnic" ng-model="customer_cnic" type="text" placeholder="42000-0000000-0" class="form-control" maxlength="25">
                                    <div ng-messages="bookingFrmNew.customer_cnic.$error" ng-if='bookingFrmNew.customer_cnic.$touched || bookingFrmNew.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Check-out Date is required</div>
                                    </div>
                                </div>
                            </div>
        
                        </div>
                    </div>
                    <div class="text-right mt-3">
                        
                        
                        <button type="submit" class="btn bg-success legitRipple"><i class="icon-search4 mr-1"></i>Search Bookings</button>
                        
                    </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Search Rooms</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            @include('layouts.form_messages')
            <div class="row">
            <form name="bookingFrm" action="javascript:void(0)" style="display:flex; width:100%" confirm-on-exit>
                <div class="col-md-10 row">

                    <div class="col-md-3" ng-hide="user.is_frontdesk">
                        <!-- Select All option -->
                        <div class="form-group">
                            <label>Select <span class="font-weight-semibold">City</span><span class="text-danger"> * </span></label>

                            <md-select ng-change="changeCity()" md-no-asterisk ng-disabled="formType=='edit'" name="city" class="m-0" ng-model="nBooking.city_id" placeholder="Select a City" required>
                                <md-option ng-repeat="city in cities" ng-value="city.id">[[city.CityName]]</md-option>
                            </md-select>
                            <div ng-messages="bookingFrm.city.$error" ng-if='bookingFrm.city.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">City is required</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3" ng-show="user.is_frontdesk">
                        <div class="form-group" style="display: inline-grid">
                            <label>City: </label>
                            <input type="text" class="form-control" readonly disabled ng-value="cities[0].CityName">
                        </div>
                    </div>

                    <div class="col-md-3" ng-show="user.is_frontdesk">
                        <div class="form-group" style="display: inline-grid">
                            <label>Hotel: </label>
                            <input type="text" class="form-control" readonly disabled ng-value="hotels[0].HotelName">
                        </div>
                    </div>

                    <div class="col-md-3" ng-hide="user.is_frontdesk">
                        <!-- Select All option -->
                        <div class="form-group">
                            <label>Select <span class="font-weight-semibold">Hotel</span><span class="text-danger"> * </span></label>
                            <md-select md-no-asterisk ng-disabled="formType=='edit'" name="hotel" class="m-0" ng-model="nBooking.hotel" placeholder="Select a Hotel" required ng-change="changeHotel()">
                                <md-option ng-repeat="hotel in filteredHotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                            </md-select>

                            <div ng-messages="bookingFrm.hotel.$error" ng-if='bookingFrm.hotel.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Hotel is required</div>
                            </div>
                        </div>
                        <!-- /select All option -->
                    </div>

                    <div class="col-md-6">
                        <div class="col-md-6 float-left">
                            <label class="">Check-in Date <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input ng-change="changeStartDate()" ng-disabled="formType=='edit'" type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="start_date" id="startdate" class=" form-control pickadate startdate" required>
                                <div ng-messages="bookingFrm.start_date.$error" ng-if='bookingFrm.start_date.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Check-in Date is required</div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6 float-left">
                            <label class="">Check-out Date <span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input ng-change="changeEndDate()" name="end_date" ng-model="end_date" date type="text" placeholder="MM/DD/YYYY" id="enddate" class="form-control pickadate enddate" required>
                                <div ng-messages="bookingFrm.end_date.$error" ng-if='bookingFrm.end_date.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Check-out Date is required</div>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="col-md-2">
                    <div class="row">
                        <div class="col-sm-6">
                            <label>Occupants:</label>
                            <div class="def-number-input number-input safari_only">
                                <button ng-click="decrementOccupants()" class="minus p-2"></button>
                                <input readonly ng-model="nBooking.occupants" class="quantity form-control" min="1" name="occupants" type="number">
                                <button ng-click="incrementOccupants()" class="plus p-2"></button>
                            </div>
                            <div ng-messages="bookingFrm.occupants.$error" ng-if="bookingFrm.occupants.$touched || bookingFrm.$submitted">
                                <div class="text-danger" ng-message="required">No. of Occupants is required</div>
                                <div class="text-danger" ng-message="min">Occupants should be greater than 0</div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <label># of Rooms</label>
                            <div class="def-number-input number-input safari_only">
                                <button ng-click="decrementRooms()" class="minus p-2"></button>
                                <input readonly ng-model="nBooking.no_rooms" class="quantity form-control" min="1" name="rooms" type="number">
                                <button ng-click="incrementRooms()" class="plus p-2"></button>
                            </div>
                            <div ng-messages="bookingFrm.rooms.$error" ng-if="bookingFrm.rooms.$touched || bookingFrm.$submitted">
                                <div class="text-danger" ng-message="required">No. of Rooms is required</div>
                                <div class="text-danger" ng-message="min">Rooms should be greater than 0</div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            </div>
            <div class="text-right mt-3">
                
                
                @if (auth()->user()->hasRole('Frontdesk'))
                    <button ng-click="ourRooms()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-search4 mr-1"></i>Search Rooms</button>
                @else
                    <button ng-if="formType=='create'" ng-click="searchRooms()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-search4 mr-1"></i>Search Rooms</button>
                    <button ng-if="formType=='edit'" ng-click="searchAddRooms()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-search4 mr-1"></i>Search Rooms</button>
                    <button type="button" ng-click="hideSearch()" class="btn btn-outline-danger bkng-cncl"><i class="icon-close2 mr-1"></i>Cancel</button>
                @endif
            </div>
        </div>
    </div> --}}
    <script>
        $.extend($.fn.pickadate.defaults, {
            // formatSubmit: 'yyyy-mm-dd',
            format: 'mm/dd/yyyy',
            // hiddenName: true,
            // hiddenSuffix: '_submit'
        })
    </script>
    <!--/Searching Filters-->
</div>