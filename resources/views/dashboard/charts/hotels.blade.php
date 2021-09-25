<div id="hotelsChartSec" class="hotel-GV card p-3">
    <!-- Hotel Reports Graph View-->
    <div class="row">
        <div class="col-md-4" ng-repeat="(key, hotel)  in records.hotels ">
            <div class="card">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">[[hotel.HotelName]]</h5>
                </div>

                <div class="card-body" style="min-height: 315px;">
                    <div class="chart-container  text-center">
                        <div ng-if="hotel.BookingCount == 0" class="hasnobooking">
                            <h5  class="text-muted text-left px-2"><i class="fa fa-ban text-danger" aria-hidden="true"></i> Has No Booking</h5>
                        </div>
                        <div  class="d-inline-block" id="hotel-donut[[key]]"></div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-4">
                            <a href="#" class="hotel-rec-view">
                                <h5 class="font-weight-semibold mb-0" style="font-size: 15px;">[[hotel.RoomCount]]</h5>
                                <span class="text-muted font-size-sm" >Rooms</span>
                            </a>
                        </div>

                        <div class="col-4">
                            <a href="#">
                                <h5 class="font-weight-semibold mb-0" style="font-size: 15px;">[[hotel.BookingCount]]</h5>
                                <span class="text-muted font-size-sm">Bookings</span>
                            </a>
                        </div>

                        <div class="col-4">
                            <h5 class="font-weight-semibold mb-0" style="font-size: 15px;">[[hotel.BookingRevenueSum | currency]]</h5>
                            <span class="text-muted font-size-sm">Revenue</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>        

