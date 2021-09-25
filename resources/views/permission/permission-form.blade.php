<div id="permission-form-section" class="card admin-form-section" style="display: none;">
    <div class="card-header bg-white header-elements-inline">
        <h5 class="card-title">Create Permission</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <!-- <a class="list-icons-item" data-action="remove"></a> -->
                <a class="list-icons-item new-rec-close" ng-click="hideForm()"><i class="icon-cross2"></i></a>
            </div>
        </div>
    </div>

    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <fieldset>
                    <legend class="font-weight-semibold"><i class="icon-reading mr-2"></i> Permission details</legend>

                    <form ng-submit="createPermission()">
                        
                        @include('layouts.form_messages')
          
                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Permission:</label>

                            <div class="col-lg-9 ">
                                <input ng-model="permissionForm.name" type="text" class="form-control" placeholder="Enter Name">
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Display Name:</label>

                            <div class="col-lg-9 ">
                                <input ng-model="permissionForm.display_name" type="text" class="form-control" placeholder="Enter Display Name">
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Description:</label>

                            <div class="col-lg-9 ">
                                <input ng-model="permissionForm.description" type="text" class="form-control" placeholder="Enter Description">
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Url (if view):</label>

                            <div class="col-lg-9 ">
                                <input ng-model="permissionForm.url" type="text" class="form-control" >
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">View Name (if view):</label>

                            <div class="col-lg-9 ">
                                <input ng-model="permissionForm.view_name" type="text" class="form-control" >
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Group:</label>

                            <div class="col-lg-9 ">
                                <input ng-model="permissionForm.group" type="text" class="form-control" >
                               
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-lg-3 col-form-label">Active (1/0):</label>

                            <div class="col-lg-9 ">
                                <input ng-model="permissionForm.is_active" type="text" class="form-control" >
                               
                            </div>
                        </div>
        
                        <div class="text-right">
                            <button type="submit" class="btn btn-primary">Submit <i class="icon-paperplane ml-2"></i></button>
                        </div>
                    </form>
                   

                </fieldset>
            </div>
        </div>

    </div>
</div>
