<!-- Checkout Date Extend Card-->
<div id="checkOutExtend" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<h5 class="modal-title">Booking Date Extend</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <form id="extendBookingForm" name="extend_booking_form">
                <div class="modal-body p-0">
                    <div class="card" style="margin-bottom: 0 !important;">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-12"><label>Booking : <strong>[[fBooking.booking_no]]</strong></label></div>
                                <div class="col-md-12"><label>Previous Checkout : <strong>[[fBooking.invoice.checkout_date | date]]</strong></label></div>
                                <div class="col-md-3">
                                    <label class="mt-1">Add Day(s) :</label>
                                </div>
                                <div class="col-md-6">
                                    <div class="media-body text-center text-md-left">
                                        <input type="text" placeholder="MM/DD/YYYY" name="bookingExtendedDate" ng-model="extended_date" id="extend" class="form-control pickadate" required>
                                        <div ng-messages="extend_booking_form.bookingExtendedDate.$error" ng-if="extend_booking_form.bookingExtendedDate.$touched || extend_booking_form.$submitted">
                                            <div class="text-danger" ng-message="required">Extended Date is required</div>
                                        </div>
                                    </div>
                                </div>
                                {{-- <div class="col-md-3">
                                    <div class="media-body text-center text-md-left">
                                        <div class="def-number-input number-input safari_only">
                                            <button ng-click="decrementDays()" class="minus p-2"></button>
                                            <input readonly ng-model="extend" class="quantity form-control min="1" name="quantity" type="number" >
                                            <button ng-click="incrementDays()" class="plus p-2 "></button> 
                                        </div>
                                    </div>
                                </div> --}}
                                <div class="col-md-12 text-right">
                                    <small><button ng-click="extendBooking()" class="btn btn-success btn-sm"> <i class="far fa-calendar-plus mr-2"></i> Extend Checkout</button></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
		</div>
	</div>
</div>
<!--/Checkout Date Extend Card-->