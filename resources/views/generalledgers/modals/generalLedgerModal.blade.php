<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
    .gl-code-div span {
    border-bottom: 1px dashed #4caf51;
    }
    .gl-code-div{
        margin-top: 15px;
    }


</style>
<div id="generalLedgerModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add General Ledger</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="general_ledgerForm" name="general_ledgerForm">
				<div class="modal-body">
                    <div class="form-group row">	

                        <div class="col-md-6">
                            <label class="col-form-label">Account Level <span class="text-danger">*</span></label>
                            <md-select ng-change="getAccountlevel(general_ledger.account_level_id)" name="account_level_id" md-no-asterisk required class="m-0" ng-model="general_ledger.account_level_id" placeholder="Second">
                                <md-option ng-repeat="account_level in account_levels" ng-value="account_level.id">[[account_level.name]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.account_level_id.$error" ng-if='general_ledgerForm.account_level_id.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Account Level is required</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">Account Type <span class="text-danger">*</span></label>
                            <md-select ng-change="getAccountType(general_ledger.account_type_id)" name="account_type_id" md-no-asterisk required class="m-0" ng-model="general_ledger.account_type_id" placeholder="Assets">
                                <md-option ng-repeat="account_type in account_types" ng-value="account_type.id">[[account_type.title]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.account_type_id.$error" ng-if='general_ledgerForm.account_type_id.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Account Type is required</div>
                            </div>
                        </div>
                        
                        
                    
                    </div>

                    <div class="form-group row mt-3">	
                        <div class="col-lg-6">
                            <label class="col-form-label">Account Title <span class="text-danger">*</span></label>
                            <input required name="title" ng-model="general_ledger.title" type="text" placeholder="Current" class="form-control alphabets" maxlength="25"> 
                            <div ng-messages="general_ledgerForm.title.$error" ng-if='general_ledgerForm.title.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Account Title is required</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">Account Gl Code:</label>
                            <div class="gl-code-div">
                                <span>[[general_ledger.account_gl_code]]</span>
                            </div>
                        </div>
                        
                    </div>


                    <div class="form-group row mt-3">	
                        <div class="col-lg-6">
                            <label class="col-form-label">Opening Balance <span class="text-danger">*</span></label>
                            <input required name="opening_balance" ng-model="general_ledger.opening_balance" data-type="currency" currency maxlength="6" placeholder="Current" class="form-control" > 
                            <div ng-messages="general_ledgerForm.opening_balance.$error" ng-if='general_ledgerForm.opening_balance.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Opening balance is required</div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label class="col-form-label">Posting Type:</label>
                            <md-select name="posting_type" md-no-asterisk required class="m-0" ng-model="general_ledger.posting_type" placeholder="P/L">
                                <md-option ng-repeat="posting_type in posting_types" ng-value="posting_type">[[posting_type]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.posting_type.$error" ng-if='general_ledgerForm.posting_type.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Posting type is required</div>
                            </div>
                        </div>
                        
                    </div>

                    <div class="form-group row mt-3">	
                        <div class="col-lg-12">
                            <label class="col-form-label">Description</label>
                            <textarea ng-model="general_ledger.description" name="description" class="form-control" placeholder="Description"></textarea>
                        </div>
                        
                    </div>

				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveGeneralLedger()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[general_ledger.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>