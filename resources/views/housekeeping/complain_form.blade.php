<style>
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
}
</style>

<div id="addNewComplain" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-lg modal-dialog-centered">
		<div class="modal-content ">
			<div class="modal-header pt-1">
				<button type="button" class="close" ng-click="hideComplainModal()">&times;</button>
			</div>

            <div class="modal-body  ">
                <ul class="nav nav-tabs nav-tabs-bottom nav-tabs-highlight ">
                    <li class="nav-item"><a id="c_form_tab" href="#complain-form-tab" class="nav-link active" data-toggle="tab"> <i class="icon-pencil7 mr-2"></i> Add New Complain</a></li>                    
                </ul>


                <div class="tab-content">
                    <div class="tab-pane fade active show" id="complain-form-tab">
                        <form name="housekeepingForm" id="housekeepingForm">
                            <div class="modal-body pt-0">
                                <div class="form-group mt-2">
                                    <div class="row">
                                        <div class="col-lg-12" ng-hide="booking.rooms.length==1">
                                            <label class=" col-form-label">Select Your Room<span class="text-danger"> *</span></label>
                                            <md-select md-no-asterisk required aria-invalid="true" name="room_id" class="m-0" ng-model="housekeeping.room_id" placeholder="Select Room" ng-required="booking.rooms.length > 1">
                                                <md-option ng-repeat="room in booking.rooms" ng-value="room.id">[[room.room_title]]</md-option>
                                            </md-select>
            
                                            <div ng-messages="housekeepingForm.room_id.$error" ng-if='housekeepingForm.room_id.$touched || housekeepingForm.$submitted' ng-cloak style="color:#e9322d;">
                                                <div class="text-danger" ng-message="required">Room is required</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
            
                                <div class="form-group mt-2">
                                    <div class="row">
            
                                        <div class="col-lg-6">
                                            <label class=" col-form-label">Subject<span class="text-danger"> *</span></label>
                                            <md-select md-no-asterisk required aria-invalid="true" name="subject" class="m-0" ng-model="housekeeping.subject" placeholder="Select Subject">
                                                <md-option ng-repeat="subject in complain_subjects" ng-value="subject.subject">[[subject.subject]]</md-option>
                                            </md-select>
                                            <div ng-messages="housekeepingForm.subject.$error" ng-if='housekeepingForm.subject.$touched || housekeepingForm.$submitted' ng-cloak style="color:#e9322d;">
                                                <div class="text-danger" ng-message="required">Subject is required</div>
                                            </div>
                                        </div>
                                        <div class="col-lg-12 mt-2">
                                            <label class=" col-form-label">Your Complain<span ng-if="housekeeping.subject == 'Other'" class="text-danger"> *</span></label>
                                            <textarea ng-required="housekeeping.subject == 'Other'" maxlength="250" name="complain" class="form-control" ng-model="housekeeping.complain" cols="30" rows="5" placeholder="My Floor was not cleaned!" style="border:1px solid #ddd !important;"></textarea>
                                        
                                            <div ng-messages="housekeepingForm.complain.$error" ng-if='housekeepingForm.complain.$touched || housekeepingForm.$submitted' ng-cloak style="color:#e9322d;">
                                                <div class="text-danger" ng-message="required">Please enter your complain </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
            
                            <div class="modal-footer">
                            <div class="text-right mt-3">
                                <button type="button" ng-click="saveComplain()" id="btn-save"  class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i>Launch Complain</button>
                            </div>
                            </div>
                           
                        </form>
                    </div> 
                </div>
            </div>
			
		</div>
	</div>
</div>



