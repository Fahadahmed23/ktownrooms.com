<div id="addNewCity" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[city.id?'Update':'Add New']] City</h5>
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
        <form id="cityForm" class="card-body" name="cityForm" method="POST">
            <div class="form-group row">

            <div class="col-md-3"> 
                 <label class="col-lg-6 col-form-label">Country</label>
             <select name="country_id" id="country_id"  ng-model="city.country_id" class="form-control" ng-change="loadState()">  
                  <option value="">Select your country</option>  
                  <option ng-repeat="country in countries  " ng-value="country.id">  
                     [[country.CountryName]]
                  </option>  
             </select> 
                </div>  

                <div class="col-md-3">          
                 <label class="col-lg-6 col-form-label">State</label>
                <select name="state_id" id="state_id" ng-model="city.state_id" class="form-control" >  
                  <option value="">Select your state</option>  
                  <option ng-repeat="state in states" ng-value="state.id" >  
                     [[state.StateName]]
                  </option>  
             </select>    
                </div> 
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">City</label>
                 <input id="cityName" type="text" class="form-control px-2" ng-model="city.CityName" placeholder="Enter City">
                </div> 

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Abbreviation</label>
                 <input id="abbreviation" type="text" class="form-control px-2" ng-model="city.Abbreviation" placeholder="Enter Abbreviaion">
                </div>  

               

                                      
            </div>
            
            <div class="text-right">
			<button type="button" id="btn-save" ng-click="saveCity()" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[city.id?'Update':'Save']]</button>
			</div>
        </form>
</div>