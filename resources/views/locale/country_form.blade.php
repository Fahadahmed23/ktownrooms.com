<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="country_form" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Country</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            @include('layouts.form_messages')
			<form  name="countryForm" id="v_country" class="" confirm-on-exit >
				<div class="modal-body">
					<fieldset>

						<div class="form-group row">		                         
                            <div class="col-lg-4">
                                <label>Country Name <span class="text-danger">*</span> </label>
                                <input aria-invalid="true" name="CountryName" required  ng-model="country.CountryName" type="text" placeholder="Pakistan" class="form-control alphabets" maxlength="15">
                            
                                <div ng-messages="countryForm.CountryName.$error" ng-if='countryForm.CountryName.$touched || countryForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Country Name is required</div>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label>Abbreviation <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="Abbreviation" required  ng-model="country.Abbreviation" type="text" placeholder="Pk" class="form-control alphabets" maxlength="4">
                               
                                <div ng-messages="countryForm.Abbreviation.$error" ng-if='countryForm.Abbreviation.$touched || countryForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Abbreviation is required</div>
                                </div>
                            </div>
                        </div>
                    
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveCountry()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[country.id?'Update':'Add']] </button>
                </div>
            </form>
		</div>
	</div>
</div>