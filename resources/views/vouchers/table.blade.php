<div id="voucherTable" class="table-responsive">
    <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
        <thead>
            <tr>
                <th>Voucher #</th>
                <th>Voucher Type</th>
                <th>Fiscal Year</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody data-link="row" class="rowlink">
            <tr ng-repeat="v in vouchers | filter: {voucher_no:searchVoucherNo , VoucherTypeName:SearchVoucherTypeName}" class="unread">     
                <td>[[v.voucher_no]]</td>
                <td>[[v.VoucherTypeName]]</td>    
                <td>[[v.FiscalYearName]]</td>
                <td><span class="[[ v.post == 'approved'?'badge-success':'badge-info']] badge text-uppercase">[[v.post]]</span></td>
                 <td class="">
                    <div class="align-self-center">
                        <div class="list-icons list-icons-extended">
                            <a id="edit-v" ng-click="editVoucher(v)" class="list-icons-item text-info edit-info"><i class="[[v.post=='approved'?'icon-eye':'icon-pencil5']]"></i></a>            
                            <a id="delete-v" ng-hide="v.post=='approved'" ng-click="deleteVoucher(v)" class="list-icons-item text-danger delete"><i class="fas fa-trash"></i></a>                        
                        </div>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>
</div>