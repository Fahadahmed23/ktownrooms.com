<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="accountLevelModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">[[account_level.id?'Update':'Add']] Account Level</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="AccountLevelForm" name="AccountLevelForm">
				<div class="modal-body">
						<div class="form-group row">	
                            <div class="col-md-4">
                                <label class="col-form-label">Name <span class="text-danger">*</span></label>
                                <input required name="name" ng-model="account_level.name" type="text" placeholder="Current" class="form-control alphabets" maxlength="25">
                                <div ng-messages="AccountLevelForm.name.$error" ng-if='AccountLevelForm.name.$touched || AccountLevelForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Name is required</div>
                                </div>
                            </div>


                            <div class="col-md-4">
                                <label class="col-form-label">Level No. <span class="text-danger">*</span></label>
                                <input required name="level_no" ng-model="account_level.level_no" type="text" placeholder="Current" class="form-control num3">
                                <div ng-messages="AccountLevelForm.level_no.$error" ng-if='AccountLevelForm.level_no.$touched || AccountLevelForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Level No. is required</div>
                                </div>
                            </div>

                            <div class="col-md-4">   
                                <label class="col-form-label">Length <span class="text-danger">*</span></label>
                                <input required name="length" ng-model="account_level.length" type="text" placeholder="Current" class="form-control num3">
                                <div ng-messages="AccountLevelForm.length.$error" ng-if='AccountLevelForm.length.$touched || AccountLevelForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">length is required</div>
                                </div>                             
                            </div>
                        </div>


                        <div class="form-group row mt-4">	

                            <div class="col-md-4">
                                <md-select md-no-asterisk required  name="company_id" class="m-0" ng-model="account_level.company_id" placeholder="Select Company" >
                                    <md-option ng-repeat="c in companies" ng-value="c.id" >[[c.CompanyName]]</md-option>
                                  </md-select>
    
                                  <div ng-messages="AccountLevelForm.company_id.$error" ng-if='AccountLevelForm.company_id.$touched || AccountLevelForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Company is required</div>
                                  </div>
                            </div>


                            <div class="col-md-4">   
                                <md-switch ng-model="account_level.is_active" ng-true-value="1" ng-false-value="0" style="display:block" >
                                    <span class="">Is Active</span>
                                </md-switch>                               
                            </div>

                            <div class="col-md-4">   
                                <md-switch ng-model="account_level.is_entry_level" ng-true-value="1" ng-false-value="0" style="display:block" >
                                    <span class="">Is Entry Level</span>
                                </md-switch>                               
                            </div>
                        </div>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveAccountLevel()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[account_level.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>