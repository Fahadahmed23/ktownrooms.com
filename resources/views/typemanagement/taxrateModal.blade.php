<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="taxRateModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Tax Rate</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="TaxRateForm" class="form-validate-jquery" ng-submit="saveTaxRate()">
				<div class="modal-body">
						<div class="form-group row">	
                                                    
                                <div class="col-lg-4">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input required name="Tax" ng-model="taxrate.Tax" type="text" placeholder="GST" class="form-control alphabets" maxlength="10">
                                </div>
                                <div class="col-lg-4">   
                                    <label class="col-form-label">Value<span> in (%) </span> <span class="text-danger">*</span></label>
                                    <input aria-invalid="true" required name="TaxValue" ng-model="taxrate.TaxValue" type="text" placeholder="12.00" class="form-control num2">
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-form-label"></label>
                                    <md-checkbox ng-model="taxrate.IsDefault" >
                                       Is Default
                                    </md-checkbox>
                                </div>
                            
                        </div>
				</div>
				<div class="modal-footer">
					 <button type="submit" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[taxrate.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>