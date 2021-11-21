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

<div id="role-form-section" class="card admin-form-section" style="display: none;">
    <div class="card-header bg-white header-elements-inline">
        <h5 class="card-title">[[roleForm.id==null?"Add New":(view ? 'View' : 'Edit')]] Role</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a class="list-icons-item new-rec-close" ng-click="hideForm()"><i class="icon-cross2"></i></a>
                <!-- <a class="list-icons-item" data-action="remove"></a> -->
            </div>
        </div>
    </div>

    <div class="card-body">
        <form name="myForm">
            <div class="row">
                <div class="col-md-6">
                    <fieldset>
                        <!--<legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Role details</legend>                                                  -->
                        @include('layouts.form_messages')

                        <div class="form-group row">
                            <div class="col-md-12">
                                <label class="col-form-label font-w-500 txt-unln">1. Role Details:</label>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Role <span class="required">*</span></label>
                                <input ng-disabled="view || roleForm.is_system == '1'" ng-model="roleForm.name" type="text" class="form-control" placeholder="Admin">
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Display Name <span class="required">*</span></label>
                                <input ng-disabled="view || roleForm.is_system == '1'" ng-model="roleForm.display_name" type="text" class="form-control" placeholder="Admin">
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Description</label>
                                <textarea ng-disabled="view" ng-model="roleForm.description" class="form-control"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label class="col-form-label">Can Have</label>
                                <md-switch ng-model="roleForm.has_multiple_hotels" ng-true-value="1" ng-false-value="0">Multiple Hotels</md-switch>
                                <md-switch ng-model="roleForm.has_discount_priviledge" ng-true-value="1" ng-false-value="0">Discount Priviledge</md-switch>
                                <md-switch ng-model="roleForm.self_manipulated_entries" ng-true-value="1" ng-false-value="0">Self Manipulated Entries</md-switch>

                                {{-- <md-checkbox class="mt-3" style="display:block" ng-checked="roleForm.has_discount_priviledge" ng-true-value="1" ng-false-value="0" ng-model="roleForm.has_discount_priviledge">Has Discount Priviledge</md-checkbox> --}}
                            </div>
                            <!-- <div class="col-lg-6">
                                <label class="col-form-label">Preference <span class="required">*</span></label>
                                <input data-type='number_format' type="text" ng-disabled="view" ng-model="roleForm.preference" class="form-control" />
                            </div> -->
                        </div>

                    </fieldset>
                    <div class="col-md-6">
                        <fieldset>
                            <div class="form-group row">
                                <div class="col-md-12">
                                    <label class="col-form-label font-w-500 txt-unln">3. Landing Page 
                                        <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-html="true" data-popup="tooltip" data-container="body" data-placement="bottom" title="" data-original-title="When user login with given role selected page will be main default page. </br> Note: Select permission(s) to populate landing page option(s)" aria-describedby="tooltip696410">
                                            <i class="icon-help top-0"></i>
                                        </a>
                                    </label>
                                </div>
                                <div class="col-lg-12">
                                    <label class="col-form-label">Select Page 
                                        
                                    </label>
                                    <md-select ng-disabled="view" ng-model="roleForm.landing_page" placeholder="Select Landing Page (select permission 1st)">
                                        <md-option ng-repeat="landingPg in landingPageOptions" value="[[ landingPg.url ]]">[[ landingPg.name ]]</md-option>
                                    </md-select>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                    <br>

                    <div ng-show="roleForm.id!=null" class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div style="height: 72px;" class="card-header header-elements-inline">
                                    <h5 class="card-title">[[roleForm.name]] Users</h5>
                                </div>
                                <div style="height:200px;overflow-y:auto;" class="card-body">
                                    <ul class="media-list">
                                        <li ng-repeat="asguser in assignedusers" class="media">
                                            <div class="mr-3">
                                                <a href="#">
                                                    <img ng-src="[[asguser.picture==null?'https://pwcenter.org/sites/default/files/default_images/default_profile.png':asguser.picture]]" class="rounded-circle" width="40" height="40" alt="">
                                                </a>
                                            </div>
                                            <div class="media-body">
                                                <div class="media-title font-weight-semibold">[[asguser.name]]</div>
                                                <span class="text-muted">[[getRolesName(asguser.roles)]]</span>
                                            </div>
                                            <div class="align-self-center ml-3" ng-hide="view">
                                                <div class="list-icons list-icons-extended">
                                                    <a href="#" class="list-icons-item" ng-click="RemoveIndividualRole(asguser)" data-popup="tooltip" title="" data-trigger="hover" data-original-title="Remove"><i class="icon-cross2"></i></a>
                                                </div>
                                            </div>
                                        </li>

                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header header-elements-inline">
                                    <h5 class="card-title">Available Users </h5>
                                    <div class="header-elements">
                                        <div class="list-icons" ng-disabled="view">
                                            <button ng-show="showAssign" ng-click="AssignRoleToUser()" type="button" class="btn btn-primary btn-sm">Assign</button>
                                        </div>
                                        <div class="input-group">
                                            <div class="form-group-feedback">
                                                <input type="text" class="form-control form-control-lg alpha-grey" placeholder="Search" ng-model="filterUsers" aria-invalid="false">
                                                <a href="#" class="form-control-feedback dright text-warning">
                                                    <div>
                                                        <i class="icon-search4"></i>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div style="height:200px;overflow-y:auto;" class="card-body">
                                    <ul class="media-list">
                                        <li class="media" ng-repeat="avuser in availableusers | filter:filterUsers">
                                            <div class="mr-3">
                                                <md-checkbox ng-hide="view" ng-model="AssignUsers[avuser.id]" ng-change="checkAvailable()" aria-label="a">
                                                </md-checkbox>
                                                <a href="">
                                                    <img ng-src="[[avuser.picture==null?'https://pwcenter.org/sites/default/files/default_images/default_profile.png':avuser.picture]]" class="rounded-circle" width="40" height="40" alt="">
                                                </a>
                                            </div>

                                            <div class="media-body">
                                                <div class="media-title font-weight-semibold">[[avuser.name]]</div>
                                                <!-- <span class="text-muted">[[getRolesName(avuser.roles)]]</span> -->
                                            </div>
                                        </li>

                                    </ul>
                                    <br>

                                </div>
                            </div>
                        </div>
                    </div>



                </div>

                <div class="col-md-6">
                    <fieldset>
                        <div class="form-group row">
                            <div class="col-md-4">
                                <label class="col-form-label font-w-500 txt-unln">2. Role(s) </label>
                            </div>
                            <div class="col-md-2">
                                <md-switch style="margin-left: 5px!important;" ng-disabled="view" ng-model="selectAllPermissions" ng-change="selectAll()" aria-label="Select All Permissions"></md-switch>
                            </div>
                            <div class="col-md-6">
                                <div class="input-group">
                                    <div class="form-group-feedback">
                                        <input type="text" class="form-control form-control-lg alpha-grey" placeholder="Search" ng-model="filterResult" aria-invalid="false">
                                        <a href="#" class="form-control-feedback dright text-primary">
                                            <div>
                                                <i class="icon-search4"></i>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div id="style4" class="form-group row scrollbar">
                            <div ng-repeat="pergroup in permissiongroup | filter:{group:filterResult}" class="col-md-6">
                                <div class="card">
                                    <div class="card-header">
                                        <h6 class="card-title">[[pergroup.group]] <div class="toggle-checkbox-div-all">
                                                <md-switch ng-disabled="view" ng-model="selectAllGroup[pergroup.group]" aria-label="pergroup.group" ng-change="selectAllgroupPermission(pergroup.group,selectAllGroup[pergroup.group]); selectabcd(pergroup.group)"></md-switch>
                                            </div>
                                        </h6>
                                    </div>
                                    <div style="height: 100px;overflow-y:auto;overflow-x:hidden;" class="card-body">
                                        <md-checkbox class="col-md-12" ng-disabled="view" ng-repeat="per in permissions| filter:{group:pergroup.group}:true:match" ng-model="roleForm.permissions[per.id]" ng-change="selectabcd(pergroup.group)">
                                            [[per.display_name]]
                                        </md-checkbox>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>
                

                
                <div class="col-md-12 text-right" ng-hide="view">
                    <button type="button" ng-click="createRole()" class="btn btn-primary"><i class="icon-floppy-disk mr-2"></i> [[roleForm.id==null?"Save":"Update"]]</button>
                </div>


            </div>
        </form>

    </div>
</div>