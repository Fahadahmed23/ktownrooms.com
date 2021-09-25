<div id="addNewTaxRate" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[taxrate.id?'Update':'Add New']] TaxRate</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        <!-- <div id="form-errors" class="alert alert-danger" style="display:none">
            <ul ng-repeat="error in errors">
                <li>[[error]]</li>
            </ul>
        </div> -->
        @include('layouts.form_messages')
        <form id="taxrateForm" class="card-body" name="taxrateForm" method="POST">
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Tax</label>
                 <input id="tax" type="text" class="form-control px-2" ng-model="taxrate.Tax" placeholder="Enter Tax" pattern="^[A-Z a-z]*$" ng-pattern-restrict>
                </div>   
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Tax Value</label>
                 <input id="taxvalue" type="text" class="form-control px-2" ng-model="taxrate.TaxValue"  pattern="^\d*\.?\d*$" ng-pattern-restrict placeholder="Enter Value">
                </div>    
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">IsDefault</label>
                 <input id="isdefault" type="checkbox" class="form-control px-2" ng-model="taxrate.IsDefault"  ng-true-value="1" ng-false-value="0">
                </div>        
            </div>
            
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="saveTaxRate()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[taxrate.id?'Update':'Save']]</button>
			</div>
        </form>
</div>

<!-- <script>

$('input[type="checkbox"]').on('change', function() {
    if ($('#isdefault').is(":checked"))
            $("#hdnisdefault").val("1");
        else
            $("#hdnisdefault").val("0");
   
}).change();

</script> -->