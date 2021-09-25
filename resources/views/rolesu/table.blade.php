<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Role Id #</th>
                <th>Role Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="role in roles | filter : filterSearchText" class="unread">
                <td>[[role.Id]]</td>
                <td><span class="letter-icon-title text-default">[[role.RoleName]]</span></td>
                
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a ng-click="editRole(role)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a ng-click="deleteRole(role)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>