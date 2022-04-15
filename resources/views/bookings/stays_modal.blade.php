
<div id="stayModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<h5 class="modal-title">Change Check-in Check-out Dates</h5>
				<button type="button" class="close" ng-click="hideStayModal()">&times;</button>
			</div>
            <form name="" id="">
                <div class="modal-body px-0">
                    <div class="col-md-12">
                        <label class="">Check-In Date</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <input ng-disabled="nBooking.status=='CheckedIn' && nBooking.id" ng-change="changeCheckinDate()"  type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="sdTemp" id="checkin_date" class="form-control pickadate startdate" required>
                        </div>
                    </div>

                    <div class="col-md-12">
                        <label >Check-Out Date</label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <input ng-change="changeCheckoutDate()" name="end_date" ng-model="edTemp" date type="text" placeholder="MM/DD/YYYY" id="checkout_date" class="form-control pickadate enddate" required>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <small><button type="button" ng-click="checkRoomsAvailability()" class="btn btn-success btn-sm mt-3">Change<i class="icon-redo2 ml-1"></i></button></small>
                        </div>
                    </div>
                </div>  
            </form>    
		</div>
	</div>
</div>