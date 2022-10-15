<form id="hotelForm" class="card-body" name="hotelForm" >
    <div class="row m-0 mt-4">
        <div class="col-md-4">
            <fieldset>   
                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 bg-light"><i class="icon-check mr-2"></i>
                    Basic Information
                </legend>

                <div class="row ">
                    <div class="col-md-4">
                        <label>Name <span class="text-danger">*</span></label>
                        <input type="text" name="HotelName" class="form-control alpha_numeric" maxlength="50" ng-model="hotel.HotelName" required placeholder="Regend Plaza" >
                        <div ng-messages="hotelForm.HotelName.$error" ng-if='hotelForm.HotelName.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Hotel Name is required</div>
                        </div>
                    </div>    

                    <div class="col-md-4">
                        <label>Company <span class="text-danger">*</span> </label>
                        <md-select md-no-asterisk name="company_id" class="m-0" ng-model="hotel.company_id" placeholder="Select a Company" required>
                            <md-option ng-repeat="company in companies" ng-value="company.id">[[company.CompanyName]]</md-option>
                        </md-select>
                        <div ng-messages="hotelForm.company_id.$error" ng-if='hotelForm.company_id.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Company is required</div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <label class="">Code <span class="text-danger">*</span> </label>
                        <input name="Code"  ng-model="hotel.Code" type="text" class="form-control" maxlength="6" minlength="6" placeholder="Hotel010" required ng-keypress="$event.keyCode != 32 ? $event:$event.preventDefault()">
                        <div ng-messages="hotelForm.Code.$error" ng-if='hotelForm.Code.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Code is required</div>
                            <div class="text-danger" ng-message="maxlength">Code length must be 6 characters</div>
                            <div class="text-danger" ng-message="minlength">Code length must be 6 characters</div>
                        </div>
                    </div>
                </div>
                <div class="row">    
                    <div class="col-md-12 mt-2">
                        <label class="col-form-label">Description </label>
                        <textarea name="Description" maxlength="255" ng-model="hotel.Description" class="form-control" style="border: 1px solid #e0e0e0 !important;"></textarea>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mt-3">    
                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 bg-light">
                    <i class="icon-calendar mr-2"></i>
                    Agreement Validity
                </legend>  
                <div class="row">
                    <div class="col-md-6">
                        <label class="col-form-label">Agreement Start Date <span class="text-danger">*</span> </label>

                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <input required ng-change="changeStartDate()"   name="AgreStartDate" type="text" date placeholder="MM/DD/YYYY" id="AgreStartDate"  ng-model="hotel.AgreStartDate" class="form-control pickadate">
                            <input type="hidden" id="hdnAgreStartDate">
                        </div>

                        <div ng-messages="hotelForm.AgreStartDate.$error" ng-if='hotelForm.AgreStartDate.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required"> Start Date is required</div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label class="col-form-label">Agreement End Date <span class="text-danger">*</span> </label>
                        <div class="input-group">
                            <span class="input-group-prepend">
                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                            </span>
                            <input required ng-change="changeEndDate()"  name="AgreEndDate" type="text" placeholder="MM/DD/YYYY" date id="AgreEndDate"  ng-model="hotel.AgreEndDate" class="form-control pickadate">
                            <input type="hidden" id="hdnAgreEndDate">
                        </div>

                        <div ng-messages="hotelForm.AgreEndDate.$error" ng-if='hotelForm.AgreEndDate.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required"> End Date is required</div>
                        </div>

                    </div>
                </div>
            </fieldset>
        </div>

        <div class="col-md-4">
            <fieldset class="">    
                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 bg-light">
                    <i class="fa fa-map mr-2"></i>
                    Address information
                </legend> 
                <div class="row">
                    <div class="col-md-4">
                        <label class="col-form-label">Address <span class="text-danger">*</span></label>
                        <input aria-invalid="true" name="Address" required ng-model="hotel.Address" maxlength="50" type="text" class="form-control" placeholder="Main Shahrah e Faisal Karachi Cantonment">
                        
                        <div ng-messages="hotelForm.Address.$error" ng-if='hotelForm.Address.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required"> Address is required</div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label class="col-form-label">City <span class="text-danger">*</span></label>

                        <md-select name="city_id" md-no-asterisk class="m-0" ng-model="hotel.city_id" placeholder="Select a City" required>
                            <md-option ng-repeat="city in cities" ng-value="city.id">[[city.CityName]]</md-option>
                        </md-select>

                        <div ng-messages="hotelForm.city_id.$error" ng-if='hotelForm.city_id.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required"> City is required</div>
                        </div>
                    </div> 

                    <div class="col-md-4">
                        <label class="col-form-label">Zip Code <span class="text-danger">*</span></label>
                        <input required name="ZipCode" type="text" ng-model="hotel.ZipCode" placeholder="35950" class="form-control zip_us">
                        
                        <div ng-messages="hotelForm.ZipCode.$error" ng-if='hotelForm.ZipCode.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required"> ZipCode is required</div>
                        </div>

                    </div>

                    <div class="col-md-6">        
                        <label class="col-form-label">Longitude <span class="text-danger">*</span></label>
                        <input id="longitude" required name="Longitude" type="text" class="form-control px-2 latlng" ng-model="hotel.Longitude" placeholder="12.123456" required>
                    
                        <div ng-messages="hotelForm.Longitude.$error" ng-if='hotelForm.Longitude.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required"> Longitude is required</div>
                        </div>
                    </div>

                    <div class="col-md-6">        
                        <label class="col-form-label">Latitude <span class="text-danger">*</span></label>
                        <input id="Latitude" required name="Latitude" type="text" class="form-control px-2 latlng" ng-model="hotel.Latitude" placeholder="12.123456" required>
                        
                        <div ng-messages="hotelForm.Latitude.$error" ng-if='hotelForm.Latitude.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required"> Latitude is required</div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mt-3">    
                    <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 bg-light">
                        <i class="fa fa-users mr-2"></i>
                        Partner information
                    </legend> 
                    <div class="row">
                        <div class="col-md-4">
                            <label class="col-form-label">Partner <span class="text-danger">*</span></label>
                            <md-select name="partner_id" md-no-asterisk required class="m-0" ng-model="hotel.partner_id" placeholder="Select a Partner">
                                <md-option ng-repeat="partner in partners" ng-value="partner.id">[[partner.FullName]]</md-option>
                            </md-select>
                            <div ng-messages="hotelForm.partner_id.$error" ng-if='hotelForm.partner_id.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Partner is required</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Ratings <span class="text-danger">*</span></label>                                       
                            <md-select name="Rating" md-no-asterisk required class="m-0" ng-model="hotel.Rating" placeholder="Select Rating">
                                <md-option ng-value="1"> <md-icon> 1 </md-option>
                                <md-option ng-value="2">2</md-option>
                                <md-option ng-value="3">3</md-option>
                                <md-option ng-value="4">4</md-option>
                                <md-option ng-value="5">5</md-option>
                            </md-select>


                            
                            <div ng-messages="hotelForm.Rating.$error" ng-if='hotelForm.Rating.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Rating is required</div>
                            </div>

                        </div>
                    </div>
            </fieldset> 
        </div>

        <div class="col-md-4">

            <fieldset class="">
                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 bg-light"><i class="icon-city mr-2"></i>
                    Tax Information
                </legend> 
                <div class="row d-flex">
                    <div class="col-md-4">
                        <label class="col-form-label">Tax Chargeable</label>
                        <md-switch ng-true-value="'1'" ng-false-value="'0'" ng-model="hotel.has_tax" style="float: left;margin-top: 2px;"></md-switch>
                    </div>
                    <div class="col-md-8">    
                        <div id="taxrateDD" ng-if="hotel.has_tax == '1'">
                            <md-select  md-no-asterisk name="tax_rate_id" class="m-0" ng-model="hotel.tax_rate_id" placeholder="Select Tax*" required>
                                <md-option ng-repeat="tax_rate in tax_rates" ng-value="tax_rate.id">[[tax_rate.Tax]]</md-option>
                            </md-select>

                            <div ng-messages="hotelForm.tax_rate_id.$error" ng-if='hotelForm.tax_rate_id.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Tax is required</div>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="mt-3">
                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 bg-light"><i class="icon-city mr-2"></i>
                    Images
                </legend> 
                <div class="row d-flex">
                    <div class="col-lg-6">
                        <div class="row">
                        <div class="col-md-12">
                        <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom">
                            <i class="icon-image2 mr-2"></i>
                            Map Image
                        </legend>
                        </div>
                        <div class="col-lg-3">
                            <div class="wrapper prof-wrap">
                            <img id="preview" class="output_image" ng-src="[[ hotel.mapimage!=null ? hotel.mapimage : 'https://icons-for-free.com/iconfiles/png/512/add+photo+instagram+upload+icon-1320184027593509107.png' ]]">
                            <div class="custom-file">
                                <input name="logo" type="file" class="custom-file-input logo" form="logo-form">
                                <label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-div">
                            <button ng-hide="hotel.mapimage" name="hotel" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
                            <button ng-show="hotel.mapimage" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture(hotel)"><i class="icon-cancel-circle2"></i> Remove</button>
                            </div>
            
                        </div>
            
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="row">
                        <div class="col-md-12">
                        <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom">
                            <i class="icon-image2 mr-2"></i>
                            Mail Image
                        </legend>
                        </div>
                        <div class="col-lg-3">
                            <div class="wrapper prof-wrap">
                            <img id="preview" class="output_image" ng-src="[[hotel.mailimage!=null ? hotel.mailimage : 'https://icons-for-free.com/iconfiles/png/512/add+photo+instagram+upload+icon-1320184027593509107.png']]">
                            <div class="custom-file">
                                <input name="logo" type="file" class="custom-file-input logo" form="pos-img-form">
                                <label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-div">
                            <button ng-hide="hotel.mailimage" name="hotel" class="btn m-b-xs w-auto btn-success upload-mail-img" type="button"><i class="icon-upload"></i> Upload</button>
                            <button ng-show="hotel.mailimage" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearMailPicture(hotel)"><i class="icon-cancel-circle2"></i> Remove</button>
                            </div>
            
                        </div>
            
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="row">
                        <div class="col-md-12">
                        <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom">
                            <i class="icon-image2 mr-2"></i>
                            Pos Image
                        </legend>
                        </div>
                        <div class="col-lg-3">
                            <div class="wrapper prof-wrap">
                            <img id="preview" class="output_image" ng-src="[[hotel.posimage!=null ? hotel.posimage : 'https://icons-for-free.com/iconfiles/png/512/add+photo+instagram+upload+icon-1320184027593509107.png']]">
                            <div class="custom-file">
                                <input name="logo" type="file" class="custom-file-input logo" form="mail-img-form">
                                <label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
                            </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="btns-div">
                            <button ng-hide="hotel.posimage" name="hotel" class="btn m-b-xs w-auto btn-success upload-pos-img" type="button"><i class="icon-upload"></i> Upload</button>
                            <button ng-show="hotel.posimage" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPosPicture(hotel)"><i class="icon-cancel-circle2"></i> Remove</button>
                            </div>
            
                        </div>
            
                        </div>
                    </div>
                </div>
            </fieldset>


        </div>
    </div>

     <div class="text-right">
        <button type="button" ng-click="saveHotel()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[hotel.id?'Update':'Save & Proceed']]</button>
	 </div>
</form>     