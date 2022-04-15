<style>
#IsShowDelayAlert
{
    display: block;
    width: 11%;
}
.previewicon{
    display: block;
    margin: 5px 0;
}
.form-group .input-group input{
    background: none;
}
span.input-group-prepend {
    margin: 0.25rem;
}
span.input-group-text {
    padding:10px 0px 0px 0;
}
</style>
<div id="addNewService" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[service.id?'Update':'Add New']] Service</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        
        @include('layouts.form_messages')
        <form id="serviceForm" class="card-body" name="myForm">
            <div class="row">
                <div class="col-md-6">
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class=" icon-magic-wand mr-2"></i>
                            Basic information
                        </legend>
                        <div class="collapse show bg-light p-2 mb-4" id="demo1">
                            <div class="form-group row">

                                <div class="col-md-6">        
                                    <label class="col-lg-6 col-form-label">Hotels <span class="text-danger">*</span></label>
                                    <md-select md-no-asterisk="true" aria-invalid="true" name="hotel_id" class="m-0" ng-model="service.hotel_id" placeholder="Select Hotel" required>
                                        <md-option ng-repeat="h in hotels" ng-value="h.id">[[h.HotelName]]</md-option>
                                    </md-select>
                                    <div ng-messages="myForm.hotel_id.$error" ng-if="myForm.hotel_id.$touched || myForm.$submitted">
                                        <div class="text-danger" ng-message="required">Please select a hotel</div>
                                    </div>
                                </div>

                                <div class="col-md-6">        
                                    <label class="col-lg-6 col-form-label">Department <span class="text-danger">*</span></label>
                                    <md-select md-no-asterisk="true" aria-invalid="true" name="department_id" class="m-0" ng-model="service.department_id" placeholder="Select Department" required>
                                        <md-option ng-repeat="department in departments" ng-value="department.id">[[department.Department]]</md-option>
                                    </md-select>
                                    <div ng-messages="myForm.department_id.$error" ng-if="myForm.department_id.$touched || myForm.$submitted">
                                        <div class="text-danger" ng-message="required">Please select a Department</div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">        
                                    <label class="col-lg-6 col-form-label">Service Type <span class="text-danger">*</span></label>
                                    <md-select required name="service_type_id" class="m-0" ng-model="service.service_type_id" placeholder="Select Service Type" md-no-asterisk="true">
                                        <md-option ng-repeat="servicetype in servicetypes" ng-value="servicetype.id">[[servicetype.ServiceType]]</md-option>
                                    </md-select>
                                    <div ng-messages="myForm.service_type_id.$error" ng-if="myForm.service_type_id.$touched || myForm.$submitted">
                                        <div class="text-danger" ng-message="required">Please select a Service Type</div>
                                    </div>
                                </div>

                                <div class="col-md-6 mt-2">        
                                    <label class="col-lg-6 col-form-label">Service <span class="text-danger">*</span></label>
                                    <input maxlength="150" ng-required="true" name="serviceName" id="serviceName" type="text" class="form-control px-2" ng-model="service.Service" placeholder="Enter Service">
                                    <div ng-messages="myForm.serviceName.$error" ng-if="myForm.serviceName.$touched || myForm.$submitted">
                                    <div class="text-danger" ng-message="required">Please enter Service Name</div>
                                    </div>
                                </div> 
                                
                            </div>
                        </div>

                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class=" icon-watch2 mr-2"></i>
                            Service Time information
                        </legend>
                        <div class="collapse show bg-light p-2" id="demo2">
                                <div class="form-group row">
                                    <div class="col-md-4">        
                                        <label class="col-lg-12 col-form-label">Serving Time <span class="text-danger">*</span> <small class="text-info">(Minutes)</small></label>
                                        <div class="input-group">
                                            <input maxlength="15" ng-required="true" name="ServingTime" id="ServingTime" type="text" class="form-control px-2 num4" ng-model="service.ServingTime" placeholder="5" >
                                            {{-- <span class="input-group-append m-0">
                                                <span class="input-group-text p-0 m-0 text-info">(Minutes)</span>
                                            </span> --}}
                                        </div>    
                                        <div ng-messages="myForm.ServingTime.$error" ng-if="myForm.ServingTime.$touched || myForm.$submitted">
                                           <div ng-message="required" class="text-danger">Please enter Serving Time</div>
                                       </div>
                                    </div>
                                    
                                    <div ng-hide="service.is_24hrs == '1'" class="col-md-3">
                                        <label  class="label  col-form-label">Service Start Time</label>
                    
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-alarm"></i></span>
                                            </span>
                                            <input ng-required="service.is_24hrs == '0'" name="service_start_time" id="service_start_time" placeholder="12:30 AM" readonly type="text" class="form-control px-2 pickatime-startTime pickatime" ng-model="service.service_start_time" placeholder="">
                                            
                                        </div>
                                        <div ng-messages="myForm.service_start_time.$error" ng-if="myForm.service_start_time.$touched || myForm.$submitted">
                                            <div ng-message="required" class="text-danger">Please enter service start time</div>
                                        </div>
                                        
                                    </div>
                    
                                    <div ng-hide="service.is_24hrs == '1'" class="col-md-3">
                                        <label  class="label  col-form-label">Service End Time </label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-alarm"></i></span>
                                            </span>
                                            <input ng-required="service.is_24hrs == '0'" name="service_end_time" id="service_end_time" placeholder="1:00 AM" type="text" class="form-control px-2 pickatime-endTime pickatime" ng-model="service.service_end_time" placeholder="">
                                            
                                        </div>
                                        <div ng-messages="myForm.service_end_time.$error" ng-if="myForm.service_end_time.$touched || myForm.$submitted">
                                            <div ng-message="required" class="text-danger">Please enter service end time</div>
                                        </div>
                                        
                                    </div>

                                    <div class="col-md-2">
                                        <label for="" class="label col-form-label">24 Hours Available</label>
                                        <md-switch ng-change="is24hrs(service.is_24hrs)" ng-model="service.is_24hrs" ng-selected ng-true-value="'1'" ng-false-value="'0'" style="display:block"></md-switch>
                                    </div>
                                </div>
                        </div>
                </div>

                <div class="col-md-6">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-star-full2 mr-2"></i>
                        Service Icon
                    </legend>
                    <div class="collapse show bg-light p-2 mb-4" id="demo4">
                        <div class="form-group row">
                            
                            <div class="col-lg-2">
                                <label class="d-block">Service Icon</label>   
                                <div class="wrapper prof-wrap">
                                        <img id="preview" class="output_image" ng-src="[[ service.IconPath!=null ? service.IconPath : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR1ufblmJdkpCAb6Bhb447cqrlR3hYxFTN_w&usqp=CAU' ]]" style="padding:5px;">
                                    <div class="custom-file">
                                        <input required name="logo" type="file" class="custom-file-input logo" form="logo-form">
                                        <label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="btns-div">
                                    <small class="text-danger"> 
                                        <ul style="padding: 0;">
                                            <li>Please upload only image file (eg: .jpeg,.png,.jpg,.gif,.svg )</li>
                                            <li>Icon resoultion should be of 50x50 pixels</li>
                                        </ul>
                                    </small>
                                    <button ng-hide="service.IconPath" name="service" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
                                    <button ng-show="service.IconPath" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture('service')"><i class="icon-cancel-circle2"></i> Remove</button>
                                </div>
                            </div>


                        </div>
                    </div>
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-cash4 mr-2"></i>
                        Service Charges
                    </legend>
                    <div class="collapse show mb-4 bg-light p-2" id="demo3">
                        <div class="form-group row">
                            <div class="col-md-3">        
                                <label class="col-lg-6 col-form-label">Charges <span class="text-danger">*</span></label>
                                <input maxlength="10" ng-required="true" name="Charges" id="Charges" data-type="currency" currency type="text" class="form-control px-2" ng-model="service.Charges" placeholder="Enter Charges">
                                    <div ng-messages="myForm.Charges.$error" ng-if="myForm.Charges.$touched || myForm.$submitted">
                                        <div ng-message="required" class="text-danger">Please enter Charges</div>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-primitive-dot mr-2"></i>
                        Other Information
                    </legend>
                    <div class="collapse show bg-light p-2" id="demo3">
                        <div class="form-group row">
                            <div class="col-md-2">        
                                <label class="col-form-label">Is Quantitative?</label>
                                <md-switch ng-model="service.IsQuantitative" ng-true-value="'1'" ng-false-value="'0'" style="display:block"></md-switch>
                            </div>

                            <div class="col-md-2">        
                                <label class="col-form-label">Is Inventory?</label>
                                <md-switch ng-model="service.IsInventory" ng-true-value="'1'" ng-false-value="'0'" style="display:block"></md-switch>
                            </div>
                            <div ng-if="service.IsInventory == '1'"class="col-md-4">        
                                <label class="col-form-label">Inventory <span class="text-danger">*</span></label>
                                <md-select md-no-asterisk="true" aria-invalid="true" name="inventory_id" class="m-0" ng-model="service.inventory_id" placeholder="Select Inventory" required>
                                    <md-option ng-repeat="i in inventories | filter: {hotel_id:service.hotel_id}" ng-value="i.id">[[i.Title]]</md-option>
                                </md-select>
                                <div ng-messages="myForm.hotel_id.$error" ng-if="myForm.hotel_id.$touched || myForm.$submitted">
                                    <div class="text-danger" ng-message="required">Please select a hotel</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>  
            

            <div class="text-right">
			<button ng-click="saveService()" type="button" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[service.id?'Update':'Save']]</button>
			</div>
        </form>
</div>



<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.2.6/jquery.inputmask.bundle.min.js"></script>
