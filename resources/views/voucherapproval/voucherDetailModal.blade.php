<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
    .voucher-info-table table th, .voucher-info-table table td {
    border-bottom: 1px dashed #b4b3b3;
    padding: 5px 10px;
    }
    .voucher-info-table table td{
        border-left: 1px dashed #b4b3b3;
    }
    .voucher-info-table {
    margin: 10px 0;
    }
    .voucher-info-table  table{
     width:100%;
    }
    .voucher_no {
    text-align: center;
    border: 1px dashed #b4b3b3;
    }   
    .voucher-detail-table  table{
        width: 100%;
    }
    .voucher-detail-table table thead th {
    border: 1px solid #b4b3b3;
    background: #b4b3b3;
    padding: 0 5px;
    }
    .voucher-detail-table table td {
    border: 1px solid #b4b3b3;
    padding: 0 5px;
    }
    .voucher-detail-table tfoot th {
    border: 1px solid #b4b3b3;
    padding:0 5px;
    }
    
</style>
<div id="voucherDetailModal" class="modal fade"  data-backdrop="static" data-keyboard="false" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
            <div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <div class="modal-body">
                <div class="row">
                    <div class="voucher_basic_info col-md-12">
                        <div class="voucher_no">
                            <h5 class="modal-title">Voucher # <span class="text-success font-weight-bold">[[posted_voucher.voucher_no]]</span> </h5>
                        </div>
                        <div class="voucher-info-table">
                            <table>
                                <tbody>
                                    <tr>
                                        <th class="text-right">Date:</th>
                                        <td>[[posted_voucher.date | date]]</td>                                    
                                    <tr>
                                        <th class="text-right">Fiscal Year:</th>
                                        <td>[[posted_voucher.FiscalYearName]]</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Voucher Type:</th>
                                        <td>[[posted_voucher.VoucherTypeName]]</td>
                                    </tr>
                                    <tr>
                                        <th class="text-right">Post:</th>
                                        <td> <span class="[[ posted_voucher.post == 'approved'?'badge-success':'badge-info']] badge">[[posted_voucher.post]]</span></td>
                                    </tr>
                                    <tr ng-show="posted_voucher.UserName">
                                        <th class="text-right">Posted By:</th>
                                        <td>[[posted_voucher.UserName]]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="voucher-detail-table">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Account Head </th>
                                        <th>Debit </th>
                                        <th>Credit </th>
                                    </tr>        
                                </thead>
                                <tbody>
                                    <tr ng-repeat="pv_detail in posted_voucher.voucher_details">
                                        <td>[[pv_detail.AccountHeadName]] ([[pv_detail.AccountHeadCode]])</td>
                                        <td class="text-success text-right"><span>[[pv_detail.dr_amount | currency]]</span></td>
                                        <td class="text-danger text-right"><span>[[pv_detail.cr_amount | currency]]</span></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr class="text-right">
                                      <th colspan="2">
                                        Total Debit: [[dr_total | currency]]
                                      </th>
                                      <th>Total Credit: [[cr_total  | currency]]</th>
                                    </tr>
                                  </tfoot>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
          

		</div>
	</div>
</div>