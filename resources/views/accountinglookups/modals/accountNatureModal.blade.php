<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="accountNatureModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Account Nature</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="AccountNatureForm" name="AccountNatureForm">
				<div class="modal-body">
						<div class="form-group row">	
                                <div class="col-md-6">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input required name="title" ng-model="account_nature.title" type="text" placeholder="Current" class="form-control alphabets" maxlength="25">
                                
                                    <div ng-messages="AccountNatureForm.title.$error" ng-if='AccountNatureForm.title.$touched || AccountNatureForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Title is required</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label">Code <span class="text-danger">*</span></label>
                                    <input required name="code" ng-model="account_nature.code" type="text" placeholder="101xyx" class="form-control alpha_numeric" maxlength="25">
                                
                                    <div ng-messages="AccountNatureForm.code.$error" ng-if='AccountNatureForm.code.$touched || AccountNatureForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Code is required</div>
                                    </div>
                                </div>
                                
                        </div>
                        <div class="form-group row mt-3"> 

                                <div class="col-md-6">
                                        <label class="col-form-label">Company</label>
                                        <md-select name="comapany_id" class="m-0" ng-model="account_nature.company_id" placeholder="Select a Company" required>
                                        <md-option ng-repeat="company in companies" ng-value="company.id">[[company.CompanyName]]</md-option>
                                        </md-select>
                                    <div ng-messages="AccountNatureForm.HotelId.$error" ng-if='AccountNatureForm.HotelId.$touched || AccountNatureForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Company is required</div>
                                    </div>
                                </div>  

                                <div class="col-md-6">
                                    <md-switch ng-model="account_nature.is_active" ng-true-value="1" ng-false-value="0" style="display:block" >
                                        <span class="">Is Active</span>
                                    </md-switch>
                                </div>  
                        </div>

                        <div class="form-group row mt-3">

                            <div class="col-md-12">   
                                <label class="col-form-label">Description</label>
                                <textarea ng-model="account_nature.description" type="text" placeholder="The Account type is Current" class="form-control" name="description"></textarea>
                            </div>
                        </div>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveAccountNature()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[account_nature.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>