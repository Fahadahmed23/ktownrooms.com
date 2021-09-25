<style type="text/css">
    .md-select-menu-container,
    md-backdrop {
        z-index: 999999 !important;
    }
</style>

<!-- Transfer Room Card-->
<div id="transferRoom" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2">
				<h5 class="modal-title">Room Transfer</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body p-0">
                <div class="card" style="margin-bottom: 0 !important;">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4"><label>Room: </label></div>
                                    <div class="col-md-8"><label>[[t_room_title]]</label></div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-4"><label>Checkout: </label></div>
                                    <div class="col-md-8"><label>[[room_checkout_date]]</label></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <form name="transfer_form" id="transfer_form">
                                    <div class="form-group row">
                                        <div class="col-md-4"><label class="col-form-label">Available Rooms <span class="text-danger">*</span></label></div>
                                        <div class="col-md-8">
                                            <md-select md-no-asterisk class="m-0" name="transferred_to" ng-model="tranfer_to" placeholder="Select" required>
                                                <md-option ng-repeat="room in available_rooms" ng-value="room.id">[[room.room_title]] (Room# [[room.RoomNumber]])</md-option>
                                            </md-select>
                                            <div ng-messages="transfer_form.transferred_to.$error" ng-if="transfer_form.transferred_to.$touched || transfer_form.$submitted">
                                                <div class="text-danger" ng-message="required">Please select a Room</div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <div class="col-md-12 text-right">
                                <small><button type="button" ng-click="requestRoomTransfer()" class="btn btn-success btn-sm mt-3"> <i class="icon-redo2 mr-2"></i> Transfer</button></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
		</div>
	</div>
</div>
<!--Transfer Room Card-->