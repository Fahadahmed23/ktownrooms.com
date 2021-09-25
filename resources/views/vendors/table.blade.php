<div class="table-responsive">
    <table id="dTable" class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone No.</th> 
                <th>Address</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="vendor in vendors" class="unread">
                <td>[[vendor.Name]]</td>
                <td>[[vendor.Email]]</td>
                <td>[[vendor.Phone]]</td>
                <td>[[vendor.Address]]</td>
                <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-inventory" ng-click="editVendor(vendor)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>