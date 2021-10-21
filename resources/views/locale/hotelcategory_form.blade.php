<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="hotelcategory_form" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Hotel Category</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            @include('layouts.form_messages')
			<form  name="hotelcategoryForm" id="v_hotelcategory" class="" confirm-on-exit>
				<div class="modal-body">
					<fieldset>

						<div class="form-group row">		                         
                            <div class="col-lg-6">
                                <label>Hotel Category Name <span class="text-danger">*</span> </label>
                                <input aria-invalid="true" name="name" required  ng-model="hotelcategory.name" type="text" placeholder="Franchise Hotel" class="form-control alphabets" maxlength="15">
                            
                                <div ng-messages="hotelcategoryForm.name.$error" ng-if='hotelcategoryForm.CountryName.$touched || hotelcategoryForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Country Name is required</div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <label>Status  <span class="text-danger">*</span></label>
                                <md-select md-no-asterisk required name="status" class="m-0" ng-model="hotelcategory.status" placeholder="Select Status">
                                    <md-option ng-value="1">On</md-option>
                                    <md-option ng-value="0">Off</md-option>
                                </md-select>

                                <div ng-messages="hotelcategoryForm.status.$error" ng-if='hotelcategoryForm.status.$touched || hotelcategoryForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Status is required</div>
                                </div>

                            </div>

                        </div>
                    
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveHotelCategory()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[hotelcategory.id?'Update':'Add']] </button>
                </div>
            </form>
		</div>
	</div>
</div>