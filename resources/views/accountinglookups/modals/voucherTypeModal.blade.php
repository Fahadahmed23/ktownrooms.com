<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="voucherTypeModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-2 border-bottom">
				<h5 class="modal-title">[[voucher_type.id?'Update':'Add']] Voucher Type</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="VoucherTypeForm" name="VoucherTypeForm">
				<div class="modal-body">
						<div class="form-group row">	
                                                    
                                <div class="col-lg-4">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input required name="title" ng-model="voucher_type.title" type="text" placeholder="Current" class="form-control alphabets" maxlength="25">
                                
                                    <div ng-messages="VoucherTypeForm.title.$error" ng-if='VoucherTypeForm.title.$touched || VoucherTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Title is required</div>
                                    </div>
                                </div>


                                <div class="col-lg-4">
                                    <label class="col-form-label">Abbreviation <span class="text-danger">*</span></label>
                                    <input required name="title" ng-model="voucher_type.abbreviation" type="text" placeholder="JV" class="form-control alphabets" maxlength="4">
                                
                                    <div ng-messages="VoucherTypeForm.title.$error" ng-if='VoucherTypeForm.title.$touched || VoucherTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Abbreviation is required</div>
                                    </div>
                                </div>


                                <div class="col-lg-4">   
                                    <label class="col-form-label">Description</label>
                                    <input aria-invalid="true" name="description" ng-model="voucher_type.description" type="text" placeholder="Journal Voucher" class="form-control alpha_numeric">
                                </div>


                                <div class="col-lg-4 mt-3">   
                                    <md-switch ng-true-value="'1'" ng-false-value="'0'" ng-model="voucher_type.is_configured">Is Configured</md-switch>
                                </div>
        
                        </div>
                            <fieldset class="mt-4" ng-show="voucher_type.is_configured == '1'">
                                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light"><i class="icon-cash3 mr-2"></i>
                                    Debit Account Head
                                </legend> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label">Account Type</label>
                                        <md-select ng-required="voucher_type.is_configured == '1'" name="debit_account_type_id" class="m-0" ng-model="voucher_type.debit_account_type_id" placeholder="Select Account Type" >
                                            <md-option ng-repeat="at in account_types |filter:search_account_types |orderBy:'title'" ng-value="at.id" >[[at.title]]</md-option>
                                        </md-select>
                                        <div ng-messages="VoucherTypeForm.debit_account_type_id.$error" ng-if='VoucherTypeForm.debit_account_type_id.$touched || VoucherTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Account type is required</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label">Debit Account</label>
                                        <md-select ng-required="voucher_type.is_configured == '1'" name="debit_gl_id" class="m-0" ng-model="voucher_type.debit_gl_id" placeholder="Select Debit Account" >
                                            <md-option ng-repeat="ah in account_heads | filter:{account_type_id:voucher_type.debit_account_type_id} | orderBy:'title'" ng-value="ah.id" >[[ah.title]] ([[ah.account_gl_code]])</md-option>
                                        </md-select>    
                                        <div ng-messages="VoucherTypeForm.debit_gl_id.$error" ng-if='VoucherTypeForm.debit_gl_id.$touched || VoucherTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Debit account is required</div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>



                            <fieldset class="mt-4" ng-show="voucher_type.is_configured == '1'">
                                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom bg-light"><i class="icon-cash3 mr-2"></i>
                                    Credit Account Head
                                </legend> 
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="col-form-label">Account Type</label>
                                        <md-select ng-required="voucher_type.is_configured == '1'" name="credit_account_type_id" class="m-0" ng-model="voucher_type.credit_account_type_id" placeholder="Select Account Type" >
                                            <md-option ng-repeat="at in account_types |filter:search_account_types |orderBy:'title'" ng-value="at.id" >[[at.title]]</md-option>
                                        </md-select>
                                        <div ng-messages="VoucherTypeForm.credit_account_type_id.$error" ng-if='VoucherTypeForm.credit_account_type_id.$touched || VoucherTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Account type is required</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="col-form-label">Credit Account</label>
                                        <md-select ng-required="voucher_type.is_configured == '1'" name="credit_gl_id" class="m-0" ng-model="voucher_type.credit_gl_id" placeholder="Select Credit Account" >
                                            <md-option ng-repeat="ah in account_heads | filter:{account_type_id:voucher_type.credit_account_type_id} | orderBy:'title'" ng-value="ah.id" >[[ah.title]] ([[ah.account_gl_code]])</md-option>
                                        </md-select>

                                        <div ng-messages="VoucherTypeForm.credit_gl_id.$error" ng-if='VoucherTypeForm.credit_gl_id.$touched || VoucherTypeForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Credit account is required</div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                       
                    </div>
				<div class="modal-footer border-top p-2">
					 <button type="button" ng-click="saveVoucherType()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[voucher_type.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>