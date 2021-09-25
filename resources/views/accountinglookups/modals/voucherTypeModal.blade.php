<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="voucherTypeModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
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
                            
                        </div>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveVoucherType()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[voucher_type.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>