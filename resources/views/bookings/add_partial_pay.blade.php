<div id="addPartialPay" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header p-2 border-bottom">
				<h5 class="modal-title">Add Payment</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form ng-submit="savePayment()">
				<div class="modal-body">
						<div class="form-group row" ng-hide="paymentCleared">
							<label class="col-md-12 label col-form-label">Remaining Amount: <span class="font-weight-semibold">[[max_payment | currency]]</span></label>
						</div>
						@include('bookings.partial_payment_form')


						<div class="form-group row" id="showaddedAmount" style="display: none;">
							<div class="col-md-12 mt-2">
								<p> <b>[[added_amount|currency]]</b> has been received!</p>
							</div>
						</div>
				</div>
				<div class="modal-footer p-2" ng-hide="paymentCleared">
					<button ng-click="hidePartialPay(); bookingReceipt(Invoice.id, 'checkout')" type="button" class="btn btn-warning" id="checkoutbtn" style="display: none;"> <i class="icon-redo2"></i> Checkout!</button>
					<a href="/bookings/receipt/[[fBooking.id]]?invoice_no=[[invoice_no]]" target="_blank" id="invPrintBtn" style="display: none;" class="btn btn-info"> <i class="icon-printer2"></i> Print Invoice</a>
					<button type="submit" class="btn btn-success" id="addpymntbtn"><i class=" mr-2 icon-floppy-disk mr-2"></i>Save Payment</button>
				</div>
			</form>

		</div>
	</div>
</div>
