
<div id="addNewDepartment" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[department.id?'Update':'Add New']] Department</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>

        @include('layouts.form_messages')
        <form id="departmentForm"  ng-submit="saveDepartment()" class="card-body form-validate-jquery" name="departmentForm" method="POST" >

            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Company<span class="text-danger">*</span></label>
                  <select name="company_id" id="company_id"  ng-model="department.company_id" class="form-control" aria-invalid="true" required>  
                  <option value="">Select your Company</option>  
                  <option ng-repeat="company in companies  " ng-value="company.id">  
                     [[company.CompanyName]]
                  </option>  
                  </select>  
                  
                  
                </div>

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Department Name<span class="text-danger">*</span></label>
                 <input name="departmentName" id="departmentName" type="text" class="form-control px-2" ng-model="department.Department" placeholder="Enter Department"  pattern="^[A-Z a-z]+$" ng-pattern-restrict aria-invalid="true" required>
                </div>
                <div class="col-md-3">       
                
                 <label class="col-lg-6 col-form-label">State<span class="text-danger">*</span></label>
                <select name="state_id" id="state_id" ng-model="department.state_id" class="form-control"aria-invalid="true" required >  
                  <option value="">Select your state</option>  
                  <option ng-repeat="state in states" ng-value="state.id" >  
                     [[state.StateName]]
                  </option>  
                </select>    
                </div>
               
            </div>
            <div class="text-right">
			<button type="submit" id="btn-save"  class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[department.id?'Update':'Save']]</button>
			</div>
        </form>
</div>