<div class="flex-fill overflow-auto">

    <!-- Basic datatable -->
    <div class="card client-search-grid">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><span><a href="#" class="sidebar-control sidebar-component-toggle legitRipple mr-2">
                    <i id="icon-shift" class="icon-drag-right"></i>
                </a></span> Search Result</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-primary heading-btn" ng-click="showPermissionForm()">Create</button>
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload" ng-click="getPermissions()"></a>

                </div>
            </div>
        </div>

        @include('layouts.delete_message')

        <table class="table table-striped hover display datatable-basic">
            <thead>
                <tr>
                    <th>Permission</th>
                    <th>Display Name</th>
                    <th>Description</th>
                    <th class="text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-cloak ng-repeat="permission in permissions | filter : permissionSearchText">
                    <td>[[permission.name]]</td>
                    <td>[[permission.display_name]]</td>
                    <td>[[permission.description]]</td>
                    <td class="text-center">
                        <div class="list-icons">
                            <a href="" class="list-icons-item mr-2" ng-click="showPermissionForm(permission.id)">
                                <i class="icon-pencil6"></i>
                            </a>
                            <a href="" class="list-icons-item mr-2" ng-click="removePermission(permission.id)">
                                <i class="icon-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->

</div>