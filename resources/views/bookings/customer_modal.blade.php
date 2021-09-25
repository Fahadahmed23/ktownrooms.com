<!--Customer Card-->
<div id="customerDetail" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<h5 class="modal-title">Booking Customer</h5>
				<button ng-click="hideCustomerDetails()" type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
				<div class="modal-body p-0">
					@include('bookings.customer_card')
				</div>
		</div>
	</div>
</div>
<!--/Customer Card-->