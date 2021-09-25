<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="state_form" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add State</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form name="stateForm" id="v_state" class="" confirm-on-exit>
				<div class="modal-body">
					<fieldset>

						<div class="form-group row">		                         
                            <div class="col-lg-4">
                                <label>Country Name <span class="text-danger">*</span></label>
                                <md-select name="country_id" required md-no-asterisk class="m-0" ng-model="state.country_id" placeholder="Pakistan">
                                    <md-option ng-repeat="country in countries" ng-value="country.id">[[country.CountryName]]</md-option>
                                </md-select>

                                <div ng-messages="stateForm.country_id.$error" ng-if='stateForm.country_id.$touched || stateForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Country is required</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>State Name <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="StateName" required  ng-model="state.StateName" type="text" placeholder="Sindh" class="form-control alphabets" maxlength="50">
                                
                                <div ng-messages="stateForm.StateName.$error" ng-if='stateForm.StateName.$touched || stateForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">State Name is required</div>
                                </div>
                            
                            
                            </div>
                            <div class="col-lg-4">
                                <label>Abbreviation <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="Abbreviation" required  ng-model="state.Abbreviation" type="text" placeholder=" Sin" class="form-control alphabets" maxlength="4">
                                

                                <div ng-messages="stateForm.Abbreviation.$error" ng-if='stateForm.Abbreviation.$touched || stateForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Abbreviation is required</div>
                                </div>
                            
                            
                            </div>
                        </div>
                    
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveState()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk"></i> [[state.id?'Update':'Add']]</button>
                </div>
            </form>
		</div>
	</div>
</div>