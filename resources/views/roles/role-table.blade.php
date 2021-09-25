<div class="flex-fill overflow-auto">

    <!-- Basic datatable -->
    <div class="card client-search-grid">
        <div class="card-header header-elements-inline">
            <h5 class="card-title"><span><a href="#" class="sidebar-control sidebar-component-toggle legitRipple mr-2">
                    <i id="icon-shift" class="icon-drag-right"></i>
                </a></span> Roles</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <button type="button" class="btn btn-primary heading-btn" ng-click="showRoleForm()"><i class="icon-plus22"></i> Add Role</button>
                    <a class="list-icons-item" data-action="collapse"></a>
                    <a class="list-icons-item" data-action="reload" ng-click="getRoles()"></a>

                </div>
            </div>
        </div>

        @include('layouts.delete_message')

        <table class="table table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
            <thead>
                <tr>
                    <th>Role</th>
                    <th>Display Name</th>
                    <th>Description</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-cloak ng-repeat="role in roles" >
                    <td>[[role.name]]</td>
                    <td>[[role.display_name]]</td>
                    <td>[[role.description]]</td>
                    <td>
                        <div class="align-self-center">
                            <div class="list-icons list-icons-extended">
                                @permission('can-edit-role')
                                <a ng-click="showRoleForm(role.id)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                                @endpermission
                                
                                @permission('can-delete-role')
                                <a ng-click="removeRole(role)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                                @endpermission
                            </div>
                        </div>
                    </td>
                </tr>

            </tbody>
        </table>
    </div>
    <!-- /basic datatable -->

</div>