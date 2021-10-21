<style>
/* category box */
.categorycounter button {
    /* background: #00bcd4; */
    float: left;
    width: 15%;
    padding: 0 0px !important;
    color: #fff;
}
.categorycounter input {
    width: 50%;
    float: left;
    height: 22px;
    text-align: center;
}
.addi_charges input{
    margin-top: 5px;
    padding: 5px;
    width: 80%;
    height: 25px;
    border: 1px solid rgb(158 158 158) !important
}

/* Chrome, Safari, Edge, Opera */
.categorycounter input::-webkit-outer-spin-button,
.categorycounter input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
.categorycounter input[type=number] {
  -moz-appearance: textfield;
}


/* category box */

   img#preview {
    width: 100%;
    height: auto;
    border: 1px solid #a6a7a8;
    border-radius: 0;
    }
    .wrapper.prof-wrap .custom-file{
        height: 100%;
    }
    .wrapper.prof-wrap .custom-file .logo{
        height: 100%;
    }
.hotelroomcategorysec{
    height: 276px;
    overflow-y: auto;
}

.hotelroomcategorysec::-webkit-scrollbar {
  width: 0px;
}

.hotelroomcategorysec::-webkit-scrollbar-track {
  background: #dddddd;
}

.hotelroomcategorysec::-webkit-scrollbar-thumb {
    background-color: #757575;
    border-radius: 20px;
    border: 3px solid #757575;
}
.gl-info-sec {
    border: 1px dashed #66bb6a59;
}
.hotel-gl-list li {
    list-style: none;
}
/* li.aheads {
    padding: 15px 0;
    margin: 0px 0;
    border-bottom:  1px dashed #eee;
} */
.hotel-gl-list {
    max-height: 200px;
    overflow: auto;
}
.lvl-1 {
    border-top: 1px dashed #66bb6a;
    margin-top: 10px;
    padding-top: 10px;
}
.lvl-1:first-child {
    border: none;
    padding: 0;
    margin: 0;
}
</style>
<div id="addNewHotel" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[hotel.id?'Update':'Add New']] Hotel</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>


    <div ng-if="formType == 'edit'" class="p-2">
        <div class="row">
            <div  class="col-md-4 ">
                <a href="http://localhost:8000/nrooms" target="_blank">
                    <div class="card card-body bg-blue-400 has-bg-image" style="min-height: 95px;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">[[hotel.RoomCount]]</h3>
                                <span class="text-uppercase font-size-xs">Total Rooms</span>
                            </div>
            
                            <div class="ml-3 align-self-center">
                                <i class="icon-city icon-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        
             <div class="col-md-4">
                 <a href="http://localhost:8000/bookings" target="_blank">
                    <div class="card card-body bg-success-400 has-bg-image" style="min-height: 95px;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">[[hotel.BookingCount]]</h3>
                                <span class="text-uppercase font-size-xs">Total Bookings</span>
                            </div>
            
                            <div class="ml-3 align-self-center">
                                <i class="far fa-calendar-check fa-4x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                 </a>
            </div>
    
    
            <div class="col-md-4">
                   <div class="card card-body bg-indigo-400 has-bg-image" style="min-height: 95px;">
                       <div class="media">
                           <div class="media-body">
                               <h3 class="mb-0">[[hotel.BookingRevenueSum |currency ]]</h3>
                               <span class="text-uppercase font-size-xs">Total Revenue</span>
                           </div>
           
                           <div class="ml-3 align-self-center">
                            <i class="far fa-money-bill-alt fa-4x opacity-75"></i>
                           </div>
                       </div>
                   </div>
           </div>
        </div>
    </div>


        @include('layouts.form_messages')

        <form id="hotelForm" class="card-body" name="hotelForm" >
            <div class="form-group row">
                    <div class="col-md-6 leftcol-6">  
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
                                    <textarea name="Description" maxlength="255" ng-model="hotel.Description" class="form-control" cols="30" rows="5" style="border: 1px solid #e0e0e0 !important;"></textarea>
                                    {{-- <input name="Description"  ng-model="hotel.Description" type="text" class="form-control alphabets" maxlength="20" placeholder="New Description"> --}}
                                </div>
                            </div>


                            <div ng-if="formType == 'edit'" class="row mt-2 gl-account-div">
                                <div class="col-md-12">
                                    <div class="gl-info-sec p-2">
                                        <div class="hotel-title d-flex">
                                            <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 mb-0 bg-light"><i class="icon-cash mr-2"></i>
                                                [[hotel.HotelName]] GL Accounts:
                                            </legend>
                                            <md-checkbox ng-checked="selectAll" ng-value="" ng-model="is_selected" ng-change="selectCheck()"> Select All</md-checkbox>
                                            

                                        </div>
                                        <div class="hotel-gl-list py-2">
                                            <ul class="p-0">
                                                <li ng-repeat="gl in hotel_gl_accounts" class="aheads [[ gl.account_level_id == '1'?'lvl-1':'']]" >
                                                    <span ng-class="getLevel(gl.account_level_id)">
                                                        <md-checkbox ng-model="hotel.hotel_accounts[gl.id]" ng-checked="[[gl.is_active == '1']]" aria-checked="[[gl.is_active == '1' ? true : false]]" ng-value="[[gl.is_active]]"></md-checkbox>
                                                        [[gl.title]] ( [[gl.account_gl_code]])
                                                    </span>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="text-right">
                                            <button type="button" ng-click="saveHotelGlAccountMapping()" id="btn-save" class="btn btn-sm bg-success ng-binding legitRipple"><i class="icon-floppy-disk mr-1"></i> Update Accounts</button>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{-- <ul ng-if="formType == 'edit'"  class="nav nav-tabs nav-tabs-bottom flex-nowrap my-3">
                                <li class="nav-item active show"><a href="#basic_info" class="nav-link active show" data-toggle="tab"><i class="icon-checkmark-circle mr-2 text-success"></i>Basic Information</a></li>
                                <li class="nav-item"><a href="#gl_information" class="nav-link" data-toggle="tab"><i class="icon-cash  mr-2 text-warning"></i>Account Gl Information</a></li>
                            </ul> --}}
                            {{-- <div class="tab-content"> --}}
                                {{-- <div class="tab-pane fade active show" id="basic_info"> --}}
                                   
                                {{-- </div> --}}
                                
                                {{-- <div ng-if="formType == 'edit'" class="tab-pane fade" id="gl_information"> --}}
                                {{-- </div> --}}

                            {{-- </div> --}}

                        </fieldset>

                        <fieldset class="mt-2">
                            <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light"><i class="icon-city mr-2"></i>
                                Tax Information
                            </legend> 
                            <div class="row d-flex">
                                <div class="col-md-3">
                                    <label class="col-form-label">Tax Chargeable</label>
                                    <md-switch ng-true-value="1" ng-false-value="0" ng-model="hotel.has_tax" style="display:inline;float: right; margin-top: 5px; margin-right: 50px;"></md-switch>
                                </div>
                                <div class="col-md-9">    
                                    <div id="taxrateDD" ng-if="hotel.has_tax == 1">
                                        {{-- <label class="col-lg-6 col-form-label">Tax<span class="text-danger">*</span></label> --}}
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
                            <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light">
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
                        

                        <fieldset class="mt-3">    
                                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light">
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

                                    {{-- <div class="col-md-4">
                                        <label class="col-form-label">Partner Price <span class="text-danger">*</span></label>
                                        <input required data-type="currency" currency aria-invalid="true" name="partnerPrice"  ng-model="hotel.partnerPrice" maxlength="10" type="text" class="form-control" placeholder="1,500.00">
                                   
                                        <div ng-messages="hotelForm.partnerPrice.$error" ng-if='hotelForm.partnerPrice.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Partner Price is required</div>
                                        </div>
                                    </div> --}}

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

                        {{-- <fieldset class="mt-3">    
                            <legend class="font-weight-semibold text-uppercase font-size-sm border-0">
                                <i class="fa fa-poll mr-2"></i>
                                SEO
                            </legend> 
                                <div class="row">
                                   

                                    <div class="col-md-4">
                                        <label class="col-form-label">Meta Title</label>
                                        <input name="metaTitle" ng-model="hotel.metaTitle" type="text" class="form-control" maxlength="255" placeholder="New Title">
                                        
                                    </div>

                                    <div class="col-md-4">
                                        <label class="col-form-label">Meta Keywords </label>
                                        <input  name="metaKeyword" ng-model="hotel.metaKeyword" type="text" class="form-control" maxlength="255" placeholder="New Keyword">
                                        
                                    </div>

                                    <div class="col-md-4">
                                        <label class="col-form-label">Meta Description </label>
                                        <input  name="metaDescription" ng-model="hotel.metaDescription" type="text" class="form-control " maxlength="255" placeholder="New Description">
                                        
                                    </div>
                                </div>
                        </fieldset>  --}}
                        
                        
                        <div class="row mt-2">
                            <div class="col-lg-12">
                                <div class="row">
                                <div class="col-md-12">
                                  <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom">
                                    <i class="icon-city mr-2"></i>
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
                        </div>

                        <fieldset class="mt-3">    
                                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light">
                                    <i class="fa fa-users mr-2"></i>
                                    Hotel Categories
                                </legend> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label">Hotel Categories <span class="text-danger">*</span></label>
                                        <md-select name="hotelcateogry_id" md-no-asterisk required class="m-0" ng-model="hotel.hotelcateogry_id" placeholder="Select a Hotel Category">
                                            <md-option ng-repeat="hotel_category in hotel_categories" ng-value="hotel_category.id">[[hotel_category.name]]</md-option>
                                        </md-select>
                                        <div ng-messages="hotelForm.hotelcateogry_id.$error" ng-if='hotelForm.hotelcateogry_id.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Hotel Cateogory is required</div>
                                        </div>
                                    </div>
                                </div>
                        </fieldset>
                        <fieldset class="mt-3">    
                                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light">
                                    <i class="fa fa-users mr-2"></i>
                                    Co-Branding
                                </legend> 
                                <div class="row">
                                    <div class="col-md-4">        
                                        <label class="col-form-label">Co-Branding</label>
                                        <md-switch ng-true-value="1" ng-false-value="0" ng-model="hotel.has_cobranding" style="display:inline;float: right; margin-top: 5px; margin-right: 50px;"></md-switch>
                                        <input type="hidden" name="cobranding" ng-model="hotel.cobranding"  ng-value="hotel.has_cobranding"/>
                                    </div>
                                    
                                </div>
                        </fieldset>
                        <fieldset class="mt-3" ng-if="hotel.has_cobranding == 1">    
                                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light">
                                    <i class="fa fa-users mr-2"></i>
                                    Software Fees & Percentage Ammount in percentage
                                </legend> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label">Software Fees <span class="text-danger">*</span></label>
                                        <input type="text" name="software_fees"  ng-model="hotel.software_fees" ng-min="0" ng-max="100" class="form-control" required>
                                        <div ng-messages="hotelForm.software_fees.$error" ng-if='hotelForm.software_fees.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Software Fees is required</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">        
                                        <label class="col-form-label">Percentage Ammount <span class="text-danger">*</span></label>
                                        <input type="text" name="percentage_amount"  ng-model="hotel.percentage_amount" ng-min="0" ng-max="100" class="form-control" required>
                                        <div ng-messages="hotelForm.percentage_amount.$error" ng-if='hotelForm.percentage_amount.$touched || hotelForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Percentage Amount is required</div>
                                        </div>
                                    </div>
                                </div>
                        </fieldset>  
                    </div>   

                    <div class="col-md-6">
                         <!-- HotelContact list -->
                         <div class="card">
                            <div class="card-header header-elements-inline">
                                <h5 class="card-title">Hotel Contacts</h5>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" ng-click="addContact()"><i class="icon-plus2"></i></a>
                                        <a class="list-icons-item" data-action="collapse"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body mx-2" style="">
                                    <ul id="mediaList" class="media-list">
                                        <div class="">
                                            <li class="media m-0" ng-repeat="contact in hotel.contacts">
                                                <div class="media-body">
                                                    <div class="media-title font-weight-semibold">[[contact.ContactPerson]]
                                                        
                                                    <span class="align-self-center ml-3 float-right">
                                                        <span class="list-icons list-icons-extended">
                                                            <a href="" class="list-icons-item" ng-click="editContact(contact)" title="Edit Address"><i class="icon-pencil6"></i></a>
                                                            <a href="" class="list-icons-item" data-popup="tooltip" title="" ng-click="deleteContact(contact)" data-trigger="hover" data-original-title="Remove"><i class="icon-cross2"></i></a>
                                                        </span>
                                                    </span>
                                                    </div>
                                                    <span class="text-muted"> 
                                                        <p class="my-0"><i ng-class="getTypeClass(contact.contact_type.ContactType)" class="mr-2"></i>: [[contact.Value]] </p>
                                                    </span>
                                                </div>

                                                
                                            </li>
                                        </div>
                                    
                                    </ul>
                            </div>
                        </div>
                        <!-- /HotelContact list -->
                        <fieldset class="">    
                            <legend class="font-weight-semibold text-uppercase font-size-sm border-0">
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

                        <div class="card mt-3">
                            <div class="card-header header-elements-inline">
                                <h5 class="card-title">Hotel Room Categories</h5>
                                <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group scrollbar">
                                <div style="" class="card-body hotelroomcategorysec">
                                    <div class="row">
                                        <div ng-repeat="room_category in room_categories" class="col-md-6 ">
                                            <div class="card">
                                                <div class="card-header px-1">
                                                    <span class="card-title"> 
                                                        <div class="toggle-checkbox-div-all">
                                                            <md-switch ng-change="hotelRoomCategory(room_category)" ng-model="hotel.hotelroomcategories[room_category.id].status" ng-true-value="1" ng-false-value="0" style="display:block" >
                                                                <span class="">[[room_category.RoomCategory]]</span>
                                                            </md-switch>
                                                        </div>
                                                    </span>
                                                </div>
                                                <div class="card-body py-0" style="padding: 0 10px !important;">
                                                    <div class="row pt-0">
                                                        <div class="col-md-6"><span class="">Occupants:</span> <div class="categorycounter"><button ng-click="decrementAllowedOccupants(room_category)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button><input readonly ng-model="hotel.hotelroomcategories[room_category.id].allowed" ng-value="hotel.hotelroomcategories[room_category.id].allowed?hotel.hotelroomcategories[room_category.id].allowed:room_category.AllowedOccupants" class="quantity form-control num2" min="1" name="AllowedOccupants" type="number" aria-invalid="false" style=""><button ng-click="incrementAllowedOccupants(room_category)" type="button" class="btn btn-sm  btn-primary"><i class="fa fa-plus"></i></button> </div></div>
                                                        <div class="col-md-6"><span class="">Max Occupants:</span> <div class="categorycounter"><button ng-click="decrementMaxAllowedOccupants(room_category)" type="button" class="btn btn-sm  btn-danger"><i class="fa fa-minus"></i></button> <input  readonly ng-model="hotel.hotelroomcategories[room_category.id].max_allowed" ng-value="hotel.hotelroomcategories[room_category.id].max_allowed?hotel.hotelroomcategories[room_category.id].max_allowed:room_category.MaxAllowedOccupants" class="quantity form-control num2" min="1" name="MaxAllowedOccupants" type="number" aria-invalid="false" style=""><button ng-click="incrementMaxAllowedOccupants(room_category)" type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button></div></div>

                                                            <div class="col-md-6 py-2">
                                                                <span style="display: inline-block; padding-top:12px;">Add. Guest Charges:</span>
                                                            </div>
                                                            <div class="col-md-6 pt-2 addi_charges">
                                                                <span style="font-weight: 800">
                                                                <!-- <ng-form name="subform[[$index]]"> -->
                                                                    <!-- <input ng-required="checkRequired(hotel.hotelroomcategories[room_category.id].status)" maxlength="5"  ng-model="hotel.hotelroomcategories[room_category.id].additional_guest_charges" ng-value="hotel.hotelroomcategories[room_category.id]?hotel.hotelroomcategories[room_category.id].additional_guest_charges:room_category.AdditionalGuestCharges" data-type="currency" currency type="text" class="form-control" name="AdditionalGuestCharges">
                                                                    <div ng-messages="subform[[$index]].AdditionalGuestCharges.$error" ng-if='hotelForm.AdditionalGuestCharges.$touched || hotelForm.$submitted || subform[[$index]].AdditionalGuestCharges.$touched' ng-cloak style="color:#e9322d;">
                                                                        <div class="text-danger" ng-message="required">Additional guest charges are required</div>
                                                                    </div> -->
                                                                <!-- </ng-form> -->
                                                                <input maxlength="8"  ng-model="hotel.hotelroomcategories[room_category.id].additional_guest_charges" ng-value="hotel.hotelroomcategories[room_category.id]?hotel.hotelroomcategories[room_category.id].additional_guest_charges:room_category.AdditionalGuestCharges" data-type="currency" currency type="text" class="form-control">
                                                                    <!-- <div ng-messages="subform[[$index]].AdditionalGuestCharges.$error" ng-if='hotelForm.AdditionalGuestCharges.$touched || hotelForm.$submitted || subform[[$index]].AdditionalGuestCharges.$touched' ng-cloak style="color:#e9322d;">
                                                                        <div class="text-danger" ng-message="required">Additional guest charges are required</div>
                                                                    </div> -->
                                                                </span>
                                                            </div>
                                                        

                                                    </div>
                                                </div>
                                                <div class="card-body" style=" display:none;">
                                                    <div class="row py-2">
                                                        <div class="col-md-6 pb-2">
                                                            <span>Occupants:</span>
                                                            <div class="col-md-10 pl-0">
                                                                <div class="def-number-input number-input safari_only">
                                                                <button type="button" ng-click="decrementAllowedOccupants(room_category)" class="minus p-2"></button>
                                                                <input  ng-model="hotel.hotelroomcategories[room_category.id].allowed" ng-value="hotel.hotelroomcategories[room_category.id].allowed?hotel.hotelroomcategories[room_category.id].allowed:room_category.AllowedOccupants" class="quantity form-control" min="1" name="AllowedOccupants" type="number" aria-invalid="false" style="">
                                                                <button type="button" ng-click="incrementAllowedOccupants(room_category)" class="plus p-2"></button>
                                                                </div>
                                                            </div> 
                                                            
                                                        </div> 


                                                        <div class="col-md-6 pb-2">
                                                            <span>Max Occupants:</span>
                                                            <div class="col-md-10 pl-0">
                                                            
                                                                <div class="def-number-input number-input safari_only">
                                                                <button type="button" ng-click="decrementMaxAllowedOccupants(room_category)" class="minus p-2"></button>
                                                                <input  ng-model="hotel.hotelroomcategories[room_category.id].max_allowed" ng-value="hotel.hotelroomcategories[room_category.id].max_allowed?hotel.hotelroomcategories[room_category.id].max_allowed:room_category.MaxAllowedOccupants" class="quantity form-control" min="1" name="MaxAllowedOccupants" type="number" aria-invalid="false" style="">
                                                                <button type="button" ng-click="incrementMaxAllowedOccupants(room_category)" class="plus p-2"></button>
                                                                </div>
                                                            </div> 
                                                        </div> 

                                                        <div class="col-md-6 pt-2">
                                                            <span style="display: inline-block; padding-top:12px;">Add. Guest Charges:</span>
                                                        </div>
                                                        <div class="col-md-6 pt-2">
                                                            <span style="font-weight: 800">
                                                                <input  ng-model="hotel.hotelroomcategories[room_category.id].additional_guest_charges" ng-value="hotel.hotelroomcategories[room_category.id]?hotel.hotelroomcategories[room_category.id].additional_guest_charges:room_category.AdditionalGuestCharges"  type="text" data-type="currency" class="form-control" name="AdditionalGuestCharges">
                                                            </span>
                                                        </div>  
                                                    </div>


                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        @include('hotel.check_in')
                        @include('hotel.check_out')


                        
                    </div>
            </div>
            <div class="text-right">
                <button type="button" ng-click="saveHotel()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[hotel.id?'Update':'Save']]</button>
			</div>
        </form>

        <form action="saveProfilePicture" method="post" enctype="multipart/form-data" id="logo-form" onsubmit="return false;"></form>
</div>

<script>
    


    
// $(".pickadate").pickadate({
//     min: true
//         });

        $.extend($.fn.pickadate.defaults, {
            min:true,
            // formatSubmit: 'yyyy-mm-dd',
            format: 'mm/dd/yyyy',
            // hiddenName: true,
            // hiddenSuffix: '_submit',
        })
</script>