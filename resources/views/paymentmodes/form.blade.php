<div id="addNewPaymentMode" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[paymentmode.id?'Update':'Add New']] PaymentMode</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        
        @include('layouts.form_messages')
        <form id="paymentmodeForm" class="card-body" name="paymentmodeForm" method="POST">
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Name</label>
                 <input id="paymentmodeName" type="text" class="form-control px-2" ng-model="paymentmode.PaymentMode" placeholder="Enter Payment Mode"  pattern="^[A-Z a-z]+$" ng-pattern-restrict>
                </div>
               
            </div>
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="savePaymentMode()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[paymentmode.id?'Update':'Save']]</button>
			</div>
        </form>
</div>