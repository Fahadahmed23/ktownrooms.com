<style>
.previewicon{
    display: block;
    margin: 5px 0;
}
    
</style>
<div id="addNewFacility" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[facility.id?'Update':'Add New']] Facility</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        <form name="facilityForm" id="facilityForm" class="card-body">

        <div class="form-group row">
               <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Facility</label>
                 <input required name="facilityName" id="facilityName" type="text" class="form-control px-2 alphabets" maxlength="15" ng-model="facility.Facility" placeholder="Enter Facility">

                 <div ng-messages="facilityForm.facilityName.$error" ng-if='facilityForm.facilityName.$touched || facilityForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Facility is required</div>
                 </div>
                </div>

                <div class="col-md-6">
                    <div class="row">
                        <div class="col-lg-2">
                            <label class="d-block">Facility Icon</label>
                            {{-- <small class="text-danger"> 
                                <ul>
                                    <li>Please upload only image file (eg: .jpeg,.png,.jpg,.gif,.svg )</li>
                                    <li>Icon resoultion should be of 50x50 pixels</li>
                                </ul>
                            </small> --}}
                            
                            <div class="wrapper prof-wrap">
                                    <img id="preview" class="output_image" ng-src="[[ facility.Image!=null ? facility.Image : 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSR1ufblmJdkpCAb6Bhb447cqrlR3hYxFTN_w&usqp=CAU' ]]" style="padding:5px;">
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
                                <button ng-hide="facility.Image" name="facility" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
                                <button ng-show="facility.Image" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture('facility')"><i class="icon-cancel-circle2"></i> Remove</button>
                            </div>
                        </div>
                    </div>
                </div>
                



                {{-- <div class="col-md-3">        
                    <label class="col-lg-6 col-form-label">Icons</label>

                    <input required  name="IconPath" id="IconPath" type="text" class="form-control" maxlength="50" ng-model="facility.IconPath" placeholder="fa fa-user" ng-value="fa ">
                    <span><small> <a href="https://fontawesome.com/v4.7/icons/" target="_blank">For Icons click on this link </a>  </small></span> --}}

                    {{-- <md-select  md-no-asterisk required aria-invalid="true" name="IconPath" class="m-0" ng-model="facility.IconPath" placeholder="Select Icon">
                        <md-option ng-repeat="icon in fontawsomeicons" ng-value="icon"><md-icon> <i class="[[icon]]"></i></md-icon>[[icon]]</md-option>
                    </md-select> --}}

                    {{-- <div ng-messages="facilityForm.IconPath.$error" ng-if='facilityForm.IconPath.$touched || facilityForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Facility Icon is required</div>
                    </div>
                    
                </div> --}}


                {{-- <div class="col-md-3">
                    <label class="label  col-form-label">Icon Preview</label>
                    <i class="fa [[facility.IconPath]] fa-2x previewicon"></i>
                </div> --}}
               
            </div>
            <div class="text-right">
			<button type="button" ng-click="saveFacility()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[facility.id?'Update':'Save']]</button>
			</div>
        </form>
</div>


