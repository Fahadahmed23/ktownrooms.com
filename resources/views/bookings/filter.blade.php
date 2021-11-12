<div class="sidebar sidebar-light bg-transparent sidebar-component border-0 shadow-0 sidebar-expand-md" style="none">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Filter -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="#" class="" ng-click="hideFilter()"><i class="fa fa-close" style="font-size: 12px;"></i></a>
                        {{-- <a class="list-icons-item" data-action="collapse"></a> --}}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form>
                    <div class="floating-label">
                        <md-select ng-model="searchBookingAttributes.Status" placeholder="Booking Status" multiple>
                            <md-option value="Pending" ng-selected="selectall">Pending</md-option>
                            <md-option value="Confirmed" ng-selected="selectall">Confirmed</md-option>
                            <md-option value="Cancelled" >Cancelled</md-option>
                            <md-option value="CheckedIn" ng-selected="selectall">CheckedIn</md-option>
                            <md-option value="CheckedOut" >CheckedOut</md-option>
                        </md-select>
                    </div>
                    <div class="floating-label"> 
                        <input ng-model="searchBookingAttributes.Code" type="text" class="form-control" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Booking #</label>
                    </div>

                    <div class="floating-label"> 
                        <input ng-model="searchBookingAttributes.Name" type="text" class="form-control alphabets" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Customer Name </label> 
                    </div>
                    
                    <md-select name="hotel" class="m-0" ng-model="searchBookingAttributes.Hotel" placeholder="Select a Hotel">
                        <md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                    </md-select>

                    <div class="floating-label">    
                        <input ng-model="searchBookingAttributes.Phone" type="text" class="form-control phone_us" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Customer Phone No. </label> 
                    </div>

                    {{-- <div class="floating-label"> 
                        <input ng-model="searchStatus" type="text" class="form-control alphabets" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Status</label>
                    </div> --}}

                    <!-- <div class="floating-label"> 
                        <input ng-model="searchBookingAttributes.BookingDate" type="text" class="form-control date_format" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Booking Date</label>
                    </div> -->
                    <div class="floating-label">
                        <div class="input-group">
                        <input type="text" placeholder=" " ng-model="searchBookingAttributes.BookingDate" class=" form-control pickadate">
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <label>Booking Date</label>
                        </div>
                    </div>
                    

                    <!-- <div class="floating-label"> 
                        <input ng-model="searchBookingAttributes.CheckIn" type="text" class="form-control date_format" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Check-In Date</label>
                    </div> -->
                    <div class="floating-label">
                        <div class="input-group">
                            <input type="text" placeholder=" " ng-model="searchBookingAttributes.CheckIn" class=" form-control pickadate">
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <label>Check-In Date</label>
                        </div>
                    </div>

                    <div class="floating-label">
                        <div class="input-group">
                            <input type="text" placeholder=" " ng-model="searchBookingAttributes.CheckOut" class=" form-control pickadate">
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <label>Check-Out Date</label>
                        </div>
                    </div>

                    <!-- BookingFrom and BookingTo Range -->

                    <div class="floating-label">
                        <div class="input-group">
                            <input type="text" placeholder=" " ng-model="searchBookingAttributes.BookedFrom" class=" form-control pickadate">
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <label>Booking From</label>
                        </div>
                    </div>

                    <div class="floating-label">
                        <div class="input-group">
                            <input type="text" placeholder=" " ng-model="searchBookingAttributes.BookedTo" class=" form-control pickadate">
                            <span class="input-group-append">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <label>Booking To</label>
                        </div>
                    </div>
                    
                    <!-- <div class="floating-label"> 
                        <input ng-model="searchBookingAttributes.CheckOut" type="text" class="form-control date_format" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Check-Out Date</label>
                    </div> -->

                    <div class="floating-label"> 
                        <input ng-model="searchBookingAttributes.Occupants" type="text" class="form-control num2" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Occupants</label>
                    </div>

                    <div class="float-right">
                        <button class="btn btn-default float-right" ng-click="filterData(searchBookingAttributes, 'clear')"  type="reset">Reset</button>
                        <button class="btn btn-primary float-right" ng-click="filterData(searchBookingAttributes)">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /filter -->
    </div>
    <!-- /sidebar content -->
</div>