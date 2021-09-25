<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="city_form" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add City</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            @include('layouts.form_messages')
			<form  name="cityForm" id="v_city" class="" confirm-on-exit>
				<div class="modal-body">
					<fieldset>

						<div class="form-group row">		                         
                            <div class="col-lg-6">
                                <label>Country Name  <span class="text-danger">*</span></label>
                                <md-select md-no-asterisk required name="country_id" ng-change="city.state_id = 0" class="m-0" ng-model="city.country_id" placeholder="Pakistan">
                                    <md-option ng-repeat="country in countries" ng-value="country.id" required>[[country.CountryName]]</md-option>
                                </md-select>

                                <div ng-messages="cityForm.country_id.$error" ng-if='cityForm.country_id.$touched || cityForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Country is required</div>
                                </div>

                            </div>
                            <div class="col-lg-6">
                                <label>State Name <span class="text-danger">*</span></label>
                                <md-select md-no-asterisk required name="state_id"  class="m-0" ng-model="city.state_id" placeholder="Sindh">
                                    <md-option ng-repeat="state in states | filter:{country_id:city.country_id}" ng-value="state.id" required>[[state.StateName]]</md-option>
                                </md-select>

                                <div ng-messages="cityForm.state_id.$error" ng-if='cityForm.state_id.$touched || cityForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">State is required</div>
                                </div>


                            </div>
                            <div class="col-lg-12 mb-2"></div>
                            <div class="col-lg-6">
                                <label>City Name <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="CityName" required  ng-model="city.CityName" type="text" placeholder="Karachi" class="form-control alphabets" maxlength="15" >
                                
                                <div ng-messages="cityForm.CityName.$error" ng-if='cityForm.CityName.$touched || cityForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">City is required</div>
                                </div>
                            
                            </div>
                            <div class="col-lg-6">
                                <label>Abbreviation <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="Abbreviation" required  ng-model="city.Abbreviation" type="text" placeholder="khi" class="form-control alphabets" maxlength="4">
                                
                                <div ng-messages="cityForm.Abbreviation.$error" ng-if='cityForm.Abbreviation.$touched || cityForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Abbreviation is required</div>
                                </div>
                            
                            </div>
                        </div>
                    
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button"  ng-click="saveCity()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[city.id?'Update':'Add']] </button>
                </div>
            </form>
		</div>
	</div>
</div>