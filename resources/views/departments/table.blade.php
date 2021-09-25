<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th style="display:none;">Department Id #</th>
                <th>Department</th>
                <th>Company</th>
                <th>State</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="department in departments | filter : filterSearchText" class="unread">
                <td style="display:none;">[[department.id]]</td>
                <td><span class="letter-icon-title text-default">[[department.Department]]</span></td>
                <td><span class="letter-icon-title text-default">[[department.CompanyName]]</span></td>
                <td><span class="letter-icon-title text-default">[[department.StateName]]</span></td>
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-department" ng-click="editDepartment(department)" class="list-icons-item text-info edit-info" data-popup="tooltip" title="Edit Detail" data-trigger="hover"><i class="icon-pencil5"></i></a>            
                            <a id="delete-department" ng-click="deleteDepartment(department)" class="list-icons-item text-danger delete"  data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>