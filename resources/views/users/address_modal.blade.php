<style type="text/css">
    .md-select-menu-container,
    md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="addNAddress" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Address</h5>
				<button type="button" class="close" ng-click="hideAddressModal()">&times;</button>
			</div>
			<form id="addressForm" name="aForm">
				<div class="modal-body">
					<fieldset>
                        <div class="row">
                            <div class="col-lg-6">
                                <label class="col-form-label">Address Type <span class="text-danger">*</span></label>
                                <md-select required md-no-asterisk name="atype" ng-model="address.type" placeholder="Select your Place">
                                    <md-option value="home">Home</md-option>
                                    <md-option value="office">Office</md-option>
                                    <md-option value="other">Other</md-option>
                                </md-select>
                                <div ng-messages="aForm.atype.$error" ng-if="aForm.atype.$touched || aForm.$submitted">
                                    <div class="text-danger" ng-message="required">Address Type is required</div>
                                </div>
                            </div>
                            <div class="col-lg-6" id="primary_address">
                                <label>Set as primary</label>
                                <md-switch ng-model="address.primary" style="display:inline"></md-switch>
                            </div>

                            <div ng-if="address.type=='other'" class="col-lg-6">
                                <label class="col-form-label">Address Type <span class="text-danger">*</span></label>
                                <input ng-required="address.type=='other'" aria-invalid="true" name="aother" ng-model="address.other" type="text" class="form-control">
                                <div ng-messages="aForm.aother.$error" ng-if="aForm.aother.$touched || aForm.$submitted">
                                    <div class="text-danger" ng-message="required">Address Type is required</div>
                                </div>
                            </div>
                        </div>

                        
                        
                        <div class="form-group row">
                            <div class="col-lg-6">
                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                <input required aria-invalid="true" name="aaddress" ng-model="address.address" type="text" placeholder="" class="form-control">
                                <div ng-messages="aForm.aaddress.$error" ng-if="aForm.aaddress.$touched || aForm.$submitted">
                                    <div class="text-danger" ng-message="required">Address is required</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="col-form-label">State <span class="text-danger">*</span></label>
                                <md-select required md-no-asterisk name="astate" class="m-0" ng-model="address.state" placeholder="Select a State">
                                    <md-option ng-repeat="state in states" ng-value="state">[[state.StateName]]</md-option>
                                </md-select>
                                <div ng-messages="aForm.astate.$error" ng-if="aForm.astate.$touched || aForm.$submitted">
                                    <div class="text-danger" ng-message="required">State is required</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label class="col-form-label">City <span class="text-danger">*</span></label>
                                <md-select required md-no-asterisk name="acity" class="m-0" ng-model="address.city" placeholder="Select a City">
                                    <md-option ng-repeat="city in cities | filter: {state_id: address.state.id}" ng-value="city">[[city.CityName]]</md-option>
                                </md-select>
                                <div ng-messages="aForm.acity.$error" ng-if="aForm.acity.$touched || aForm.$submitted">
                                    <div class="text-danger" ng-message="required">City is required</div>
                                </div>
                            </div>
                            

                            <div class="col-lg-6">
                                <label class="col-form-label">Zip Code <span class="text-danger">*</span></label>
                                <input required aria-invalid="true" name="azip" type="text" ng-model="address.zip" placeholder="" class="form-control zip_us">
                                <div ng-messages="aForm.azip.$error" ng-if="aForm.azip.$touched || aForm.$submitted">
                                    <div class="text-danger" ng-message="required">Zip Code is required</div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="addressSave()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[addressFormType=='save'?'Add':'Update']]</button>
                </div>
            </form>

		</div>
	</div>
</div>