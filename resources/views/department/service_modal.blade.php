<style>
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
    .previewicon{
    display: block;
    margin: 5px 0;
}
</style>
<div id="addService" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Service</h5>
				<button type="button" class="close" ng-click="hideServiceModal()">&times;</button>
			</div>
			<form name="serviceForm" id="serviceForm" class="">
				<div class="modal-body">
					<fieldset>
                        <div class="form-group row">
                            <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                                <i class=" fa fa-flag mr-2"></i>
                                Service information
                            </legend>
                            <div class="col-lg-4">
                                <label class="">Title <span class="text-danger">*</span></label>
                                <input required name="Service" ng-model="service.Service" class="form-control alphabets" maxlength="25" type="text" placeholder="Cleaning">
                                <div ng-messages="serviceForm.Service.$error" ng-if='serviceForm.Service.$touched || serviceForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Service Title is required</div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="">Service Type <span class="text-danger">*</span></label>
                                <md-select md-no-asterisk required aria-invalid="true" name="service_type_id" class="m-0" ng-model="service.service_type_id" placeholder="Select Type">
                                    <md-option ng-repeat="servicetype in servicetypes" ng-value="servicetype.id">[[servicetype.ServiceType]]</md-option>
                                </md-select>
                                <div ng-messages="serviceForm.service_type_id.$error" ng-if='serviceForm.service_type_id.$touched || serviceForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Service Type is required</div>
                                </div>
                            </div>

                            <div class="col-lg-4">
                                <label class="">Charges<span class="text-danger">*</span></label>
                                <input required data-type="currency" currency aria-invalid="true" name="Charges" maxlength="10" ng-model="service.Charges" type="text" placeholder="15,000.00" class="form-control">
                                <div ng-messages="serviceForm.Charges.$error" ng-if='serviceForm.Charges.$touched || serviceForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Service Title is required</div>
                                </div>
                            </div>
                        </div>
                                                
                        <div class="form-group row mt-4">
                            <div class="col-lg-4">
                                <label class="col-form-label">Serving Time <span class="text-danger">*</span></label>
                                <input required aria-invalid="true" name="ServingTime" ng-model="service.ServingTime" type="text" placeholder="One Time" class="form-control alphabets" maxlength="10">
                                <div ng-messages="serviceForm.ServingTime.$error" ng-if='serviceForm.ServingTime.$touched || serviceForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Serving Time is required</div>
                                </div>
                            </div>
                            <div class="col-md-4 ">        
                                <label class="col-lg-6 col-form-label">Icons</label>
                                <md-select md-no-asterisk required aria-invalid="true" name="IconPath" class="m-0" ng-model="service.IconPath" placeholder="Select Icon">
                                    <md-option ng-repeat="icon in fontawsomeicons" ng-value="icon"><md-icon> <i class="[[icon]]"></i></md-icon>[[icon]]</md-option>
                                </md-select>
                            </div>

                            <div class="col-lg-4 ">
                                <label  class="label  col-form-label">Icon Preview</label>
                                <i class="[[service.IconPath]] fa-2x previewicon"></i>
                            </div>

                            <div class="col-md-12 mt-4">        
                                <label class="col-lg-6 col-form-label">Is Show Delay Alert</label>
                                <md-switch ng-model="service.IsShowDelayAlert" ng-true-value="1" ng-false-value="0" style="display:block"></md-switch>
                            </div>
                            
                        </div>

                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="serviceSave()"  class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[serviceFormType=='save'?'Add':'Update']]</button>
                </div>
            </form>

		</div>
	</div>
</div>