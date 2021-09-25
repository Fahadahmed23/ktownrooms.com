<style>
.popoverdiv {
    height: 65px;
    overflow: auto;
}

.popoverdiv span {
    display: block;
}
.popoverdiv::-webkit-scrollbar-thumb {
    background-color: #757575;
    border-radius: 20px;
    border: 3px solid #757575;
}
.popoverdiv::-webkit-scrollbar {
    width: 5px;
}
</style>
<ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
    <li class="nav-item active show"><a ng-click="getHotelBookingServices('awaiting')" href="#awaiting" class="nav-link active show" data-toggle="tab"><i class="icon-hour-glass2 mr-2 text-warning"></i> Awaiting Services</a></li>
    <li class="nav-item"><a ng-click="getHotelBookingServices('accepted')" href="#accepted" class="nav-link" data-toggle="tab"><i class="icon-stack-check mr-2 text-success"></i> Accepted Services</a></li>
    <li class="nav-item"><a ng-click="getHotelBookingServices('rejected')" href="#rejected" class="nav-link" data-toggle="tab"><i class="icon-close2 mr-2 text-danger"></i> Rejected Services</a></li>
</ul>


<div class="tab-content">
    <div class="tab-pane fade active show" id="awaiting">
        <div id="hotelBoookingServicesTable" class="table-responsive">
            <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                <thead>
                    <tr>
                        <th>Booking #</th>
                        <th>Room #</th>
                        <th>Room</th>
                        <th>Service Name</th>
                        {{-- <th>Department</th> --}}
                        {{-- <th>Charges</th> --}}
                        {{-- <th>Serving Time</th> --}}
                        <th>Status</th>
                        <th ng-hide="service_status == 'rejected'">Action</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr ng-repeat="bs in hotelbookingservices" class="unread">     
                        <td>[[bs.BookingNo]]</td>
                        <td>[[bs.RoomNumber]]</td>
                        <td>[[bs.RoomTitle]]</td>
                        <td><a href="javascript:void(0);" data-placement="top" data-popup="popover" data-title="" data-trigger="focus" data-html="true" 
                            data-content="<div class='popoverdiv'><span><b>Service</b>: [[bs.service_name]]</span>
                            <span><b>Charges</b> : [[bs.service_charges | currency]] </span>
                            <span><b>Department</b> : [[bs.department_name]] </span>
                            <span><b>Serving Time</b> : [[bs.serving_time]] </span>
                            <span><b>Start Time</b> : [[tConvert(bs.start_time)]] </span>
                            <span><b>Status</b> : [[bs.status]] </span></div>
                          " data-original-title=""> 
                            [[bs.service_name]]</a></td>
                        {{-- <td>[[bs.department_name]]</td>     --}}
                        {{-- <td>[[bs.service_charges]]</td> --}}
                        {{-- <td>[[bs.serving_time]]</td> --}}
                        <td><span ng-class="getServiceStatus(bs.status)" class="badge">[[bs.status|camelCase]]</span></td>
                        <td class="" ng-hide="service_status == 'rejected'">
                            <div class="align-self-center">
                                <div class="list-icons list-icons-extended">
                                    <button ng-click="acceptRejectBookingService(bs.id , 'accepted')" ng-show ="bs.status == 'awaiting'" class="list-icons-item btn btn-success edit-service" data-placement="top" data-popup="popover" data-trigger="hover" data-content="Accepted"><i class="icon-checkmark3"></i></button>            
                                    <button ng-click="acceptRejectBookingService(bs.id , 'rejected')" ng-show ="bs.status == 'awaiting'" class="list-icons-item btn btn-danger " data-placement="top" data-popup="popover" data-trigger="hover" data-content="Rejected"><i class="icon-cross3"></i></button>
                                    <button ng-click="cancelBookingService(bs.id)" ng-show ="bs.status == 'accepted'" class="list-icons-item btn btn-danger cancel-service" data-placement="top" data-popup="popover" data-trigger="hover" data-content="Cancel"><i class="icon-cancel-circle2"></i></button>     
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>