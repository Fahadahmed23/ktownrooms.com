<div id="addNewCountry" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[country.id?'Update':'Add New']] Country</h5>
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
        <form id="countryForm" class="card-body" name="countryForm" method="POST">
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Country</label>
                 <input id="countryName" type="text" class="form-control px-2" ng-model="country.CountryName" placeholder="Enter Name">
                </div>
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Abbreviation</label>
                 <input id="abbreviation" type="text" class="form-control px-2" ng-model="country.Abbreviation" placeholder="Enter Abbreviaion">
                </div>               
            </div>
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="saveCountry()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[country.id?'Update':'Save']]</button>
			</div>
        </form>
</div>