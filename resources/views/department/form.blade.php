<div id="addNewDepartment" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[deparment.id?'Update':'Add New']] Department</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        
        @include('layouts.form_messages')
        <form name="deparmentForm" id="deparmentForm" class="card-body" >
            <div class="row">
                <div class="col-md-6">
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class=" icon-magic-wand mr-2"></i>
                        Basic information
                    </legend>
                        <div class="collapse show bg-light p-2 mb-2">
                            <div class="form-group row">
                                <div class="col-md-6">  
                                    <label class=" col-form-label">Company<span class="text-danger">*</span></label>
                                    
                                        <md-select md-no-asterisk required aria-invalid="true" name="company_id" class="m-0" ng-model="department.company_id" placeholder="Select Company" required>
                                            <md-option ng-repeat="company in companies" ng-value="company.id">[[company.CompanyName]]</md-option>
                                        </md-select>
                                    <div ng-messages="deparmentForm.company_id.$error" ng-if='deparmentForm.company_id.$touched || deparmentForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Company is required</div>
                                    </div>
                                    
                                </div>
            
                                <div class="col-md-6">        
                                    <label class="col-form-label">Department Name<span class="text-danger">*</span></label>
                                    <input required name="departmentName" id="departmentName" type="text" class="form-control px-2 alphabets" maxlength="50" ng-model="department.Department" placeholder="Enter Department" required>
                                
                                    <div ng-messages="deparmentForm.departmentName.$error" ng-if='deparmentForm.departmentName.$touched || deparmentForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required"> Department is required</div>
                                    </div>
            
                                </div>
                            </div>
                        </div>
                    <legend class="font-weight-semibold text-uppercase font-size-sm">
                        <i class="icon-primitive-dot mr-2"></i>
                        Other information
                    </legend>
                        <div class="collapse show bg-light p-2 mb-4">
                            <div class="form-group row">
                                <div class="col-md-6">  
                                    {{-- <label class="col-form-label">Color Style</label>
                                    <md-select md-no-asterisk  aria-invalid="true" class="m-0" ng-model="department.bg_color" placeholder="Select color">
                                    <md-option ng-repeat="bg in bg_colors" ng-value="bg.bg_class" class="[[bg.bg_class]]">[[bg.name]]</md-option>
                                    </md-select> --}}


                                    <label class=" col-form-label">Color Style <span  class="text-danger">*</span> </label>
                                    <div class="color-picker">
                                      <input type="color" id="html5colorpicker" onchange="clickColor(0, -1, -1, 5)" ng-value="#45818e" ng-model="department.bg_color" style="width:85%;">
                                    </div>
                                    
                                </div>
            
                                <div class="col-md-6">        
                                    <label class="col-form-label">Visible to portal</label>
                                    <md-switch ng-model="department.IsClientService" ng-true-value="1" ng-false-value="0">
                                    </md-switch>
                                </div>
                            </div>
                        </div>    
                    
                </div>
            
                
                <div class="col-md-6">
                        <legend class="font-weight-semibold text-uppercase font-size-sm">
                            <i class="icon-star-full2 mr-2"></i>
                            Department Icon
                        </legend>
                        <div class="collapse show bg-light p-2 mb-4" id="demo4">
                            <div class="form-group row">
                                <div class="col-lg-2">
                                    <label class="d-block">Department Icon</label>   
                                    <div class="wrapper prof-wrap">
                                            <img id="preview" class="output_image" ng-src="[[ department.IconPath!=null ? department.IconPath : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR1ufblmJdkpCAb6Bhb447cqrlR3hYxFTN_w&usqp=CAU' ]]" style="padding:5px;">
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
                                        <button ng-hide="department.IconPath" name="department" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
                                        <button ng-show="department.IconPath" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture('department')"><i class="icon-cancel-circle2"></i> Remove</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>


            </div>
         
            <div class="text-right">
			<button type="button" ng-click="saveDepartment()" id="btn-save"  class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[department.id?'Update':'Save']]</button>
			</div>
        </form>
</div>