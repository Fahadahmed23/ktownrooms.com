<div id="addmiscamount" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-md">
		<div class="modal-content">
			<div class="modal-header p-2 border-bottom">
				<h5 class="modal-title">Add Misc Amount</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form ng-submit="savemislinsonPayment()">
				<div class="modal-body">

						@include('bookings.add_misc_amount_form')

				</div>
				<div class="modal-footer p-2" ng-hide="paymentCleared">
					<button ng-click="hidePartialPay(); bookingReceipt(Invoice.id, 'checkout')" type="button" class="btn btn-warning" id="checkoutbtn" style="display: none;"> <i class="icon-redo2"></i> Checkout!</button>
					<a href="/bookings/receipt/[[fBooking.id]]?invoice_no=[[invoice_no]]" target="_blank" id="invPrintBtn" style="display: none;" class="btn btn-info"> <i class="icon-printer2"></i> Print Invoice</a>
					<button  type="submit" class="btn btn-success" id="addpymntbtn"><i class=" mr-2 icon-floppy-disk mr-2"></i>Save Payment</button>
				</div>
			</form> 

		</div>
	</div>
</div>
