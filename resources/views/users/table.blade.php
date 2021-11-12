<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th> 
                <th>Role</th>
                <th>Hotel(s)</th>
                <th>Registered at</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="user in users" class="unread">
                <td>[[user.name]]</td>
                <td>[[user.email]]</td>
                <td>[[user.phone_no]]</td>
                <td>[[user.roles[0].name]]</td>
                <td>[[user.HotelNames.join(", ")]]</td>
                <td>[[user.created_at|date]]</td>
                <td>
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            @permission('can-edit-user')
                            <a id="edit-company" ng-click="editUser(user)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>
                            @endpermission
                            @permission('can-delete-user')            
                            <a id="delete-company" ng-click="deleteUser(user)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                            @endpermission
                            <a ng-click="resendPassword(user.id)" data-popup="tooltip" title="Reset Password" class="list-icons-item text-success"><i class="fas fa-envelope"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>