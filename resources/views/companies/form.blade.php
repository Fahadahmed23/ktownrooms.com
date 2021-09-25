<div id="addNewCompany" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[company.id?'Update':'Add New']] Company</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>
        @include('layouts.form_messages')
        <form name="companyForm" id="companyForm" class="card-body">
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Title</label>
                 <input required name="companyName" id="companyName" type="text" class="form-control px-2 alphabets" maxlength="50" ng-model="company.CompanyName" placeholder="Datanet" >
                 
                 <div ng-messages="companyForm.companyName.$error" ng-if='companyForm.companyName.$touched || companyForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Company title is required</div>
                 </div>

                </div>
               
            </div>
            <div class="text-right">
			<button type="button" ng-click="saveCompany()" id="btn-save"  class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[company.id?'Update':'Save']]</button>
			</div>
        </form>
</div>