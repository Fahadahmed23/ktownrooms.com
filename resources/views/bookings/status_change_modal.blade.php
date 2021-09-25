<!--Room Status Change Card-->
<div id="statusChange" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<h5 class="modal-title">Booking Status</h5>
				<button type="button" class="close" ng-click="hideStatusChangeModal()">&times;</button>
			</div>
            <div class="modal-body p-0">
                    <div class="card" style="margin-bottom: 0 !important;">
                        <div class="card-body">
                            <div class="col-md-12"><label>Booking : <strong>[[fBooking.booking_no]]</strong></label></div>
                            <div class="col-md-12">
                                <label>Change Status :</label>
                                <a href="javascript:void(0)" class="[[fBooking.status == 'Cancelled' || fBooking.status == 'CheckedOut' ? '' : 'dropdown-toggle']] badge" ng-class="getStatusClass(fBooking.status)" data-toggle="dropdown">[[fBooking.status]]</a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a ng-show="fBooking.status=='Pending'" href="javascript:void(0)" ng-click="changeStatus(fBooking, 'Confirmed')" class="dropdown-item"></i>Confirmed</a>
                                    <a ng-show="fBooking.status=='Confirmed' && today == fBooking.BookingFrom" href="javascript:void(0)" ng-click="changeStatus(fBooking, 'CheckedIn')" class="dropdown-item"></i>CheckedIn</a>
                                    <!-- <a ng-show="fBooking.status=='CheckedIn'" href="javascript:void(0)" ng-click="changeStatus(fBooking, 'CheckedOut')" class="dropdown-item"></i>CheckedOut</a> -->
                                    <a ng-show="fBooking.status=='Pending' || fBooking.status=='Confirmed'" href="javascript:void(0)" ng-click="changeStatus(fBooking, 'Cancelled')" class="dropdown-item"></i>Cancelled</a>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
		</div>
	</div>
</div>
<!--/Room Status Change Card-->