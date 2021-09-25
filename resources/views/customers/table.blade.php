<div id="partnerTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>CNIC/Passport #</th>
                <th>Nationality</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="customer in customers | filter :{FirstName:searchFirstName,LastName:searchLastName, Email:searchEmail }" class="unread">     
                <td>[[customer.FirstName]] [[customer.LasttName]]</td>
                <td>[[customer.Email]]</td>
                <td>[[customer.Phone]]</td>
                <td>[[customer.CNIC]]</td>
                <td> <span class="text-uppercase">[[customer.nationality]]</span></td>
                <td>[[ customer.IsActive == 1?'Active':'Not Active']]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-customer" ng-click="editCustomer(customer)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                            <a id="delete-customer" ng-click="deleteCustomer(customer)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>