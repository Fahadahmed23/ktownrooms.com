<div id="addNewState" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[state.id?'Update':'Add New']] State</h5>
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
        <form id="stateForm" class="card-body" name="stateForm" method="POST">
            <div class="form-group row">
               
                <div class="col-md-3"> 
                 <label class="col-lg-6 col-form-label">Country</label>
             <select name="country_id" ng-value="state.country_id" ng-model="state.country_id" class="form-control">  
                  <option value="">Select your country</option>  
                  <option ng-repeat="country in countries" value="[[country.id]]">  
                     [[country.CountryName]]
                  </option>  
             </select>                  
                </div> 
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">State</label>
                 <input id="stateName" type="text" class="form-control px-2" ng-model="state.StateName" placeholder="Enter State Name">
                </div>  
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Abbreviation</label>
                 <input id="abbreviation" type="text" class="form-control px-2" ng-model="state.Abbreviation" placeholder="Enter Abbreviaion">
                </div>                                   
            </div>
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="saveState()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[state.id?'Update':'Save']]</button>
			</div>
        </form>
</div>