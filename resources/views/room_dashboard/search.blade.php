<div id="ANR-filter" class="ANR-filter" ng-hide="lockdown || formType=='edit'" style="display: none">


    <!--Searching FIlters-->
    <div class="card">
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

                    <div class="col-md-3">
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

                    <div class="col-md-3" >
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
                                <input ng-change="changeStartDate()" ng-disabled="formType=='edit'" type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="start_date" id="startdate" class="form-control pickadate" required>
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
                                <input ng-change="changeEndDate()" name="end_date" ng-model="end_date" date type="text" placeholder="MM/DD/YYYY" id="enddate" class="form-control pickadate" required>
                                <div ng-messages="bookingFrm.end_date.$error" ng-if='bookingFrm.end_date.$touched || bookingFrm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Check-out Date is required</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </form>
            </div>
            <div class="text-right mt-3">
                <button ng-click="searchRooms()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-search4 mr-1"></i>Search Rooms</button>
            </div>
        </div>
    </div>





    <!-- room details card -->
    <div class="card p-2 show-rooms" style="display:none;">
        <div class="row m-0">
            <div class="col-md-4">
               
                <div class="card card-body bg-teal has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding">[[rooms.length]]</h3>
                            <span class="text-uppercase font-size-xs">Total Rooms</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-bed2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-body bg-success has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            
                            <h3 class="mb-0 ng-binding">[[total_reserved]]</h3>
                            <span class="text-uppercase font-size-xs">Confirmed Bookings</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-clipboard2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card card-body bg-danger-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0 ng-binding">[[breakdown.cancelled?breakdown.cancelled:0]]</h3>
                            <span class="text-uppercase font-size-xs">Cancelled Booking</span>
                        </div>
                        <div class="ml-3 align-self-center">
                            <i class="icon-cancel-circle2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </div>
            
            
        </div>
    </div>
    <!-- /room details card -->


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