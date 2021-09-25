
<style>
.nav-tabs-bottom .nav-link.active:before {
    background-color: #b7b7b7;
}
</style>
<ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
    <li class="nav-item active show"><a href="#approved_voucher" class="nav-link active show" data-toggle="tab"><i class="icon-stack-check mr-2 text-success"></i> Approved Voucher</a></li>
    <li class="nav-item"><a href="#posted_voucher" class="nav-link" data-toggle="tab"><i class="icon-hour-glass2 mr-2 text-warning"></i> Approval Pending</a></li>
</ul>

<div class="tab-content">
    <div class="tab-pane fade active show" id="approved_voucher">
        <div id="voucherTable" class="table-responsive">
            <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                <thead>
                    <tr>
                        <th>Voucher #</th>
                        <th>Voucher Type</th>
                        <th>Fiscal Year</th>
                        <th>Post</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr ng-repeat="pv in posted_vouchers | filter: {post:'approved',voucher_no:searchVoucherNo , VoucherTypeName:SearchVoucherTypeName}" class="unread">     
                        <td>[[pv.voucher_no]]</td>
                        <td>[[pv.VoucherTypeName]]</td>    
                        <td>[[pv.FiscalYearName]]</td>
                        <td> <span class="[[ pv.post == 'approved'?'badge-success':'badge-info']] badge">[[pv.post]]</span></td>
                         <td class="">
                            <div class="align-self-center">
                                <div class="list-icons list-icons-extended">
                                    <button ng-if="pv.post == 'posted'" ng-click="approveVoucher(pv)" class=" btn btn-outline-success approve_voucher"><i class="icon-stack-check mr-1"></i> Approve</button>
                                    <button ng-click="detailVoucher(pv)" class=" btn btn-outline-info detail_voucher"><i class="icon-eye8 mr-1"></i> View Detail</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="tab-pane fade" id="posted_voucher">
        <div id="voucherTable" class="table-responsive">
            <table id="dTable"  class="table table-user table-striped hover display datatable-basic" datatable="ng" dt-options="dtOptions" dt-column-defs="dtColumnDefs">
                <thead>
                    <tr>
                        <th>Voucher #</th>
                        <th>Voucher Type</th>
                        <th>Fiscal Year</th>
                        <th>Post</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody data-link="row" class="rowlink">
                    <tr ng-repeat="pv in posted_vouchers | filter: {post:'posted',voucher_no:searchVoucherNo , VoucherTypeName:SearchVoucherTypeName}" class="unread">     
                        <td>[[pv.voucher_no]]</td>
                        <td>[[pv.VoucherTypeName]]</td>    
                        <td>[[pv.FiscalYearName]]</td>
                        <td> <span class="[[ pv.post == 'approved'?'badge-success':'badge-info']] badge">[[pv.post]]</span></td>
                         <td class="">
                            <div class="align-self-center">
                                <div class="list-icons list-icons-extended">
                                    <button ng-if="pv.post == 'posted'" ng-click="approveVoucher(pv)" class=" btn btn-outline-success approve_voucher"><i class="icon-stack-check mr-1"></i> Approve</button>
                                    <button ng-click="detailVoucher(pv)" class=" btn btn-outline-info detail_voucher"><i class="icon-eye8 mr-1"></i> View Detail</button>
                                </div>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
