<div id="voucherTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr> 
                <th>Posting Type</th>
                <th>Account Gl</th>
                <th>Level</th>
                <th>Debit</th>
                <th>Credit</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="ap in auto_postings" class="unread">     
                <td>[[ap.PostingTypeName]]</td>
                <td>[[ap.account_gl_name]] ([[ap.account_gl_code]]) </td>    
                <td>[[ap.account_level]]</td>
                <td> <span class="[[ap.is_dr?' text-info':'']]"> [[ap.is_dr=='1'?'Debit':'']]</span></td>
                <td><span class="[[ap.is_cr?' text-danger':'']]">[[ap.is_cr=='1'?'Credit':'']]</span></td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-v" ng-click="editAutoPosting(ap)" class="list-icons-item text-info edit-info"><i class="icon-pencil5"></i></a>            
                            <a id="delete-v" ng-click="deleteAutoPosting(ap)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a>
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>