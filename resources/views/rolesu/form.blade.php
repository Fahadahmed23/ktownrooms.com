<style>
    #style4 {
        height: 500px;
        overflow-y: scroll;
    }

    ::-webkit-scrollbar {
        width: 8px;
    }

    ::-webkit-scrollbar-track {
        box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
    }

    ::-webkit-scrollbar-thumb {
        background-color: darkgrey;
        outline: 1px solid slategrey;
    }

    .role-per {
        float: left;
        display: inline-block;
    }
</style>

<div id="create-form" class="card" style="display:none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[roleForm.id?'Update':'Add New']] Role</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="hideCreate()"><i class="icon-cross2"></i></a>
			</div>
		</div>
    </div>
    
    <div class="card-body">
        <form>
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        @include('layouts.form_messages')
                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label font-w-500">1. Role Details:</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Role <span class="required">*</span></label>
                                <input ng-model="roleForm.name" type="text" class="form-control" placeholder="Admin">
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Display Name <span class="required">*</span></label>
                                <input ng-model="roleForm.display_name" type="text" class="form-control" placeholder="Admin">
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Description</label>
                                <textarea ng-model="roleForm.description" class="form-control"></textarea>
                            </div>
                        </div>
                    </fieldset>
                    <div class="col-md-6">
                        <fieldset>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="col-form-label font-w-500">3. Landing Page 
                                        <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-html="true" data-popup="tooltip" data-container="body" data-placement="bottom" title="" data-original-title="When user login with given role selected page will be main default page. </br> Note: Select permission(s) to populate landing page option(s)" aria-describedby="tooltip696410">
                                            <i class="icon-help top-0"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-lg-12">
                                    <label class="col-form-label">Select Page 
                                        
                                    </label>
                                    <md-select ng-disabled="view" ng-model="roleForm.landing_page" placeholder="Select Landing Page (select permission 1st)">
                                        <md-option ng-repeat="landingPage in landingPages" value="[[ landingPage.url ]]">[[ landingPage.name ]]</md-option>
                                    </md-select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <br>
                </div>
                <div class="col-md-6">
                    <fieldset>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-form-label font-w-500">2. Role(s) Permissions </label>
                            </div>
                            <div class="col-md-2">
                                <md-switch style="margin-left: 5px!important;" ng-disabled="view" ng-model="selectAllPermissions" ng-change="selectAll()" aria-label="Select All Permissions"></md-switch>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="form-group-feedback">
                                        <input type="text" class="form-control form-control-lg alpha-grey" placeholder="Search" ng-model="filterResult" aria-invalid="false">
                                        <a href="#" class="form-control-feedback dright text-warning">
                                            <div>
                                                <i class="icon-search4"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="style4" class="form-group row scrollbar">
                            <div ng-repeat="pergroup in permissiongroups | filter:{group:filterResult}" class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">[[pergroup.group]] <div class="toggle-checkbox-div-all">
                                                <md-switch ng-disabled="view" ng-model="selectAllGroup[pergroup.group]" aria-label="pergroup.group" ng-change="selectAllgroupPermission(pergroup.group,selectAllGroup[pergroup.group]); selectabcd(pergroup.group)"></md-switch>
                                            </div>
                                        </h6>
                                    </div>
                                    <div style="height: 100px;overflow-y:auto;" class="card-body">
                                        <md-checkbox ng-disabled="view" ng-repeat="per in permissions| filter:{group:pergroup.group}:true:match" ng-model="roleForm.permissions[per.id]" ng-change="selectabcd(pergroup.group)">
                                            [[per.display_name]]
                                        </md-checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                <div class="col-md-12 text-right" ng-hide="view">
                    <button type="button" ng-click="saveRole()" class="btn btn-success"><i class="icon-floppy-disk mr-2"></i> [[roleForm.id==null?"Save":"Update"]]</button>
                </div>
            </div>
        </form>
    </div>
</div>