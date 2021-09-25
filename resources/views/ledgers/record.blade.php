<style>
table.table ul {
    list-style: none;
}
.remove-underline {
    text-decoration: none;
    font-weight: initial;
}
.aheads .row {
    background: #eeeeee21;
    border-bottom: 1px dashed #e8e8e8;
    padding: 1px 0px;
}
.my-table th, .my-table  td {
    border: 1px solid #eee !important;
    padding: 10px 5px;
}
.my-table{
    width: 100%;
}
</style>
<div class="row m-0">
    <div class="col-md-12 text-right">
        {{-- <a href="{{ route('pdfview',['download'=>'pdf']) }}" class="btn btn-success">Genrate Pdf</a> --}}
        <a ng-click="download_pdf()" class="btn btn-success" style="color: white" ng-if="general_ledgers.length > 0"><i class="fa fa-file mr-1"></i> Genrate Pdf</a>
        <a onclick="toCsv()" class="btn btn-success" style="color: white" ng-if="general_ledgers.length > 0"><i class="fa fa-file mr-1"></i> Genrate CSV</a>
    </div>
</div>
<div ng-repeat="general_ledger in general_ledgers">
    
    <div  class="row mx-0 my-3">
        <div class="col-md-8">
            <strong>[[general_ledger.Title]]</strong>
        </div>
        <div class="col-md-4 text-right">
            Total: 5000
        </div>
    </div>

    <div class="row m-0">
        <div class="col-md-12">
            <table class="my-table table-striped" id="ledger-tbl">
                <thead>
                    <tr>
                        <th>Voucher </th>
                        <th>Narration </th>
                        <th>Refrence No. </th>
                        <th>Party Name </th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>[[general_ledger.VoucherName]]</td>
                        <td>[[general_ledger.Narration]]</td>
                        <td>[[general_ledger.RefNo]]</td>
                        <td>[[general_ledger.PartyName]]</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th></th>
                        <th></th>
                        <th></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>    
    </div>
</div>

<script type="text/javascript">       
    function toCsv() {
        $("#ledger-tbl").tableHTMLExport({
            type:'csv',
            filename:'ledgers.csv'
        });
    }
</script>



















































{{-- <table class="table table-bordered">
    <tbody>
        <tr>
        <td>
            <ul style="padding: 0;">
                <li> 
                    <ul style="padding-left: 10px;">
                        <li ng-repeat="ah1 in account_heads |filter : {'account_level_id' : '1'}">
                            <span><u class="font-italic font-weight-bold">[[ah1.title]] </u></span>
                            <span class="float-right">[[ah1.opening_balance | currency]]</span>
                            <ul>
                                <li ng-repeat="ah2 in account_heads |filter : {'account_level_id' : '2' }" >
                                    <span><u>[[ah2.title]] </u></span>
                                    <span class="float-right">[[ah2.opening_balance | currency]]</span>

                                       <ul>
                                        <li ng-repeat="ah3 in account_heads |filter : {'account_level_id' : '3'}" >
                                            <span><u>[[ah3.title]] </u></span>
                                            <span class="float-right">[[ah3.opening_balance | currency]]</span>
                                            
                                            <ul>
                                                <li ng-repeat="ah4 in account_heads |filter : {'account_level_id' : '4'}" >
                                                    <span><u>[[ah4.title]]</u></span>
                                                    <span class="float-right">[[ah4.opening_balance | currency]]</span>
                                            </ul>
                                       </ul> 
                                </li>
                            </ul>
                        </li>
                    </ul>
                </li>
            </ul>
        </td>
        </tr>
    </tbody>
</table> --}}
