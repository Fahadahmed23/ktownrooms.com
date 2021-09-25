<style>
.gl-code-div span {
    border-bottom: 1px dashed #4caf51; font-weight: 600;font-size: 20px;color:#4caf51;
    }
.gl-code-div{
    margin-top: 5px;
}
textarea.form-control {
    border: 1px solid #e0e0e0 !important;}
</style>
<div id="addNewgeneralLedger" class="card" style="display:none;">

    <div class="card-header bg-white header-elements-inline">
        <h5 class="card-title" style="text-transform:capitalize;">[[general_ledger.id?'Update':'Add New']] Chart of Account</h5>
    <div class="header-elements">
      <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
        <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
      </div>
    </div>
    </div>
    <div class="card-body">
        <form id="general_ledgerForm" name="general_ledgerForm">
            <div class="form-group row">

                <div class="col-md-6">
                    <legend class="font-weight-semibold text-uppercase font-size-sm border-0">
                        <i class="icon-cash mr-2"></i>
                       Account Basic Information
                    </legend>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label class="col-form-label">Account Title <span class="text-danger">*</span></label>
                            <input required name="title" ng-model="general_ledger.title" type="text" placeholder="Current" class="form-control alphabets" maxlength="50"> 
                            <div ng-messages="general_ledgerForm.title.$error" ng-if='general_ledgerForm.title.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Account Title is required</div>
                            </div>
                        </div>	
        
                        <div class="col-md-4">
                            <label class="col-form-label">Account Level <span class="text-danger">*</span></label>
                            <md-select ng-change="getAccountlevel(general_ledger.account_level_id)" name="account_level_id" md-no-asterisk required class="m-0" ng-model="general_ledger.account_level_id" placeholder="Second">
                                <md-option ng-repeat="account_level in account_levels" ng-value="account_level.id">[[account_level.name]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.account_level_id.$error" ng-if='general_ledgerForm.account_level_id.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Account Level is required</div>
                            </div>
                        </div>

                        <div class="col-md-4" >
                            <label class="col-form-label">Fiscal year</label>
                            <md-select  name="account_fiscal_years_master_id" md-no-asterisk required class="m-0" ng-model="general_ledger.account_fiscal_years_master_id" placeholder="Current Assests">
                                <md-option ng-repeat="fy in fiscal_years" ng-value="fy.id">[[fy.title]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.account_fiscal_years_master_id.$error" ng-if='general_ledgerForm.account_fiscal_years_master_id.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Fiscal Year is required</div>
                            </div>
                        </div>

                    </div>


                    <legend class="font-weight-semibold text-uppercase font-size-sm border-0">
                        <i class="icon-cash2 mr-2"></i>
                       Account Type Information
                    </legend>
                    <div class="row mb-3">
                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">Account Type <span class="text-danger">*</span></label>
                            <md-select ng-disabled="general_ledger.id" ng-change="getAccountType(general_ledger.account_type)" name="account_type" md-no-asterisk required class="m-0" ng-model="general_ledger.account_type" placeholder="Assets">
                                <md-option ng-repeat="account_type in account_types" ng-value="account_type">[[account_type.title]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.account_type.$error" ng-if='general_ledgerForm.account_type.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Account Type is required</div>
                            </div>
                        </div>


                        <div class="col-md-4 parent_acount_typ mb-3" ng-show="general_ledger.account_level_id > 2" >
                            <label class="col-form-label"> Select Level [[general_ledger.account_level_id -1]] Parent Account <span class="text-danger">*</span></label>
                            <md-select ng-disabled="general_ledger.id" ng-change="getParentAccount(general_ledger.parent_acount)" ng-required="general_ledger.account_level_id > 2 && formType =='create'" name="parent_acount" md-no-asterisk  class="m-0" ng-model="general_ledger.parent_acount" placeholder="Second">
                                <md-option ng-repeat="gl in filtered_general_ledgers" ng-value="gl.account_gl_code">([[gl.title]])[[gl.account_gl_code]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.parent_acount.$error" ng-if='general_ledgerForm.parent_acount.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Parent Account is required</div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3" >
                            <label class="col-form-label">Sub Account Type</label>
                            <md-select  name="sub_account_type_id" md-no-asterisk required class="m-0" ng-model="general_ledger.sub_account_type_id" placeholder="Current Assests">
                                <md-option ng-repeat="sub_account_type in filter_account_sub_types" ng-value="sub_account_type.id">[[sub_account_type.title]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.sub_account_type_id.$error" ng-if='general_ledgerForm.sub_account_type_id.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Sub Account Account Type is required</div>
                            </div>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label class="col-form-label">Posting Type:</label>
                            <md-select ng-disabled="general_ledger.account_type_id" name="posting_type" md-no-asterisk required class="m-0" ng-model="general_ledger.posting_type" placeholder="P/L">
                                <md-option ng-repeat="posting_type in posting_types" ng-value="posting_type">[[posting_type]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.posting_type.$error" ng-if='general_ledgerForm.posting_type.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Posting type is required</div>
                            </div>
                        </div>

                    </div>    
                    <legend class="font-weight-semibold text-uppercase font-size-sm border-0 mb-0">
                        <i class="icon-cash4 mr-2"></i>
                       Amount Detail 
                    </legend>
                    <div class="row mt-3">
                        
                        <div class="col-md-4">
                            <label class="col-form-label">DR/CR:</label>
                            <md-select name="dr_cr" md-no-asterisk required class="m-0" ng-model="general_ledger.dr_cr" placeholder="Debit">
                                <md-option ng-repeat="val in dr_cr" ng-value="val">[[val]]</md-option>
                            </md-select>
                            <div ng-messages="general_ledgerForm.dr_cr.$error" ng-if='general_ledgerForm.dr_cr.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">DR/CR is required</div>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="col-form-label">Opening Balance <span class="text-danger">*</span></label>
                            <input required name="opening_balance" ng-model="general_ledger.opening_balance" data-type="currency" currency maxlength="6" placeholder="Current" class="form-control" > 
                            <div ng-messages="general_ledgerForm.opening_balance.$error" ng-if='general_ledgerForm.opening_balance.$touched || general_ledgerForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Opening balance is required</div>
                            </div>
                        </div>
                    </div> 
                </div>


                <div class="col-md-6">

                    <legend class="font-weight-semibold text-uppercase font-size-sm border-0 mb-0">
                        <i class="icon-check2 mr-2"></i>
                       Account GL CODE
                    </legend>
                    <div class="gl-code-div">
                        <label class="col-form-label">CODE:</label>
                        <span>[[general_ledger.account_gl_code]]</span>
                    </div>

                    <div class="row">
                        <div class="col-md-12 mt-3">
                            <label class="col-form-label pb-0">Description</label>
                            <textarea ng-model="general_ledger.description" name="description" class="form-control" placeholder="Description" cols="30" rows="5"></textarea>
                        </div>
                    </div>
                </div>
               
            </div>

           
            <div class="text-right mt-2">
                <button type="button" ng-click="saveGeneralLedger()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[general_ledger.id?'Update':'Save']]</button>
            </div>    
        </form>
    </div>
    
</div>

