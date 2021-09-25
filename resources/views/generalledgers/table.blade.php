<div id="generalledgerTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Title</th>
                <th>Account GL Code</th>
                <th>Opening Balance</th>
                <th>DR/CR</th>
                <th>Account Type</th>
                <th>Level</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="gl in general_ledgers | filter :{title:searchTitle}" class="unread">     
                <td>[[gl.title]]</td>
                <td>[[gl.account_gl_code]]</td>    
                <td>[[gl.opening_balance | currency]]</td>
                <td class="[[ gl.dr_cr == 'Credit'?'text-danger':'text-info']]">[[gl.dr_cr]]</td>
                <td>[[gl.AccountTypeName]]</td>
                <td>[[gl.AccountLevelName]]</td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-generalledger" ng-click="editGeneralLedger(gl)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                            {{-- <a id="delete-generalledger" ng-click="deleteGeneralLedger(gl)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a> --}}
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>