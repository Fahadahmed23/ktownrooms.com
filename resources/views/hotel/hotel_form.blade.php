<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="hotel_form" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Hotel</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form id="v_hotel" class="form-validate-jquery" confirm-on-exit ng-submit="saveHotel()" name="myForm">
				<div class="modal-body">
                    @include('layouts.form_messages')
					<fieldset>
						<div class="form-group row">	
                            <div class="col-lg-4">
                                <label>Name<span class="danger">*</span></label>
                                <input type="text" class="form-control" ng-model="hotel.HotelName" required placeholder="Asad Ali">
                            </div>                
                            <div class="col-lg-4">
                                <label>Company</label>
                                <md-select class="m-0" ng-model="hotel.company_id" placeholder="Select a Company" required>
                                    <md-option ng-repeat="company in companies" ng-value="company.id">[[company.CompanyName]]</md-option>
                                </md-select>
                            </div>
                            <div class="col-lg-4">
                                <label>City</label>
                                <md-select class="m-0" ng-model="hotel.city_id" placeholder="Select a City" required>
                                    <md-option ng-repeat="city in cities" ng-value="city.id">[[city.CityName]]</md-option>
                                </md-select>
                            </div>

                            <div class="col-lg-12 mb-2"></div>

                            <div class="col-lg-8">
                                <label class="col-form-label">Address <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="name" required ng-model="hotel.Address" type="text" class="form-control">
                            </div>
                            <div class="col-lg-4">
                                <label class="col-form-label">Zip Code <span class="text-danger">*</span></label>
                                <input required name="zip" type="text" ng-model="hotel.ZipCode" placeholder="12345" class="form-control zip_us">
                            </div>

                            <div class="col-lg-12 mb-2"></div>

                            <div class="col-md-4">        
                                <label class="col-form-label">Longitude</label>
                                <input id="longitude" type="text" class="form-control px-2 latlng" ng-model="hotel.Longitude" placeholder="12.123456" required>
                            </div>
                            <div class="col-md-4">        
                                <label class="col-form-label">Latitude</label>
                                <input id="Latitude" type="text" class="form-control px-2 latlng" ng-model="hotel.Latitude" placeholder="12.123456" required>
                            </div>
                        </div>
                    
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="submit" class="btn btn-success">[[hotel.id?'Update':'Add']] <i class=" mr-2 icon-floppy-disk mr-2"></i></button>
                </div>
            </form>
		</div>
	</div>
</div>