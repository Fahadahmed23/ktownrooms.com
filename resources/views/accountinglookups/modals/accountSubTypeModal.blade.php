<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="accountSubTypeModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">[[account_sub_type.id?'Update':'Add']] Account Sub Type</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="AccountSubTypeForm" name="AccountSubTypeForm">
				<div class="modal-body">
						<div class="form-group row">	
                                <div class="col-md-6">
                                    <label class="col-form-label">Account Type <span class="text-danger">*</span></label>
                                    <md-select md-no-asterisk required  name="account_type_id" class="m-0" ng-model="account_sub_type.account_type_id" placeholder="Select Account Type" >
                                        <md-option ng-repeat="a in account_types" ng-value="a.id" >[[a.title]]</md-option>
                                        </md-select>

                                        <div ng-messages="AccountSubTypeForm.account_type_id.$error" ng-if='AccountSubTypeForm.account_type_id.$touched || AccountSubTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Account Type is required</div>
                                        </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input required name="title" ng-model="account_sub_type.title" type="text" placeholder="Current" class="form-control alphabets" maxlength="25">
                                
                                    <div ng-messages="AccountSubTypeForm.title.$error" ng-if='AccountSubTypeForm.title.$touched || AccountSubTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Title is required</div>
                                    </div>
                                </div>
                            
                        </div>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveAccountSubType()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[account_sub_type.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>