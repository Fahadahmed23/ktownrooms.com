
<div class="rooms" >
    <!-- City Reports Graph View-->
    <div id="roomsChartSec" class="card p-3" style="display: none">
        <div class="row">
            <div  class=" col-md-6 roomchartbox" ng-repeat="(key, room) in room_ids " >
                <div class="card">
                    <div class="card-body">
                        <div class="card-header header-elements-inline">
                            <h5 class="card-title">[[room.room_title]]</h5>
                        </div>
                        <div class="chart-container has-scroll text-center">
                        {{-- <div class="chart-container "> --}}

                            <div class="d-inline-block" id="room-donut[[key]]" ></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-4">
                                <a href="#" class="hotel-rec-view">
                                    <h5 class="font-weight-semibold mb-0" style="font-size:15px;">[[room.confirmed]]</h5>
                                    <span class="text-muted font-size-sm">Confirmed Booking</span>
                                </a>
                            </div>

                            <div class="col-4">
                                <a href="#">
                                    <h5 class="font-weight-semibold mb-0" style="font-size:15px;">[[room.cancelled]]</h5>
                                    <span class="text-muted font-size-sm">Cancelled Booking</span>
                                </a>
                            </div>

                            <div class="col-4">
                                <a href="#">
                                    <h5 class="font-weight-semibold mb-0" style="font-size:15px;">[[room.pending]]</h5>
                                    <span class="text-muted font-size-sm">Pending Booking</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

