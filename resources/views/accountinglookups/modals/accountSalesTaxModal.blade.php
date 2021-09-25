<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="accountSalesTaxModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">[[account_sales_tax.id?'Update':'Add']] Account Sales Tax</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="AccountSalesTaxForm" name="AccountSalesTaxForm">
				<div class="modal-body">
						<div class="form-group row">	
                                                    
                                <div class="col-lg-4">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input required name="title" ng-model="account_sales_tax.title" type="text" placeholder="Current" class="form-control alphabets" maxlength="25">
                                
                                    <div ng-messages="AccountSalesTaxForm.title.$error" ng-if='AccountSalesTaxForm.title.$touched || AccountSalesTaxForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Title is required</div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <label class="col-form-label">Tax Rate <span class="text-danger">*</span></label>
                                    <input required name="taxrate" ng-model="account_sales_tax.tax_rate" type="text" placeholder="Current" class="form-control" maxlength="5">
                                
                                    <div ng-messages="AccountSalesTaxForm.taxrate.$error" ng-if='AccountSalesTaxForm.taxrate.$touched || AccountSalesTaxForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">TaxRate is required</div>
                                    </div>
                                </div>
                                <div class="col-lg-4">   
                                    <md-switch ng-model="account_sales_tax.is_active" ng-true-value="1" ng-false-value="0" style="display:block" >
                                        <span class="">Is Active</span>
                                    </md-switch>                               
                                </div>
                            
                        </div>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveAccountSalesTax()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[account_sales_tax.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>