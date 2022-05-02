<div id="partnerTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Poc</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="client in clients | filter :{FullName:searchClient, EmailAddress:searchEmail, ContactNo:searchPhone }" class="unread">     
                <td>[[client.name]]</td>
                <td>[[client.email]]</td>
                <td>[[client.phone]]</td>
                <td>[[client.poc]]</td>
                <td>[[ client.status == 1?'Active':'Not Active']]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-partner" ng-click="editClient(client)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                            <a id="delete-partner" ng-click="deleteClient(client)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>