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
.thicker{
    font-weight: 900;
    font-size: initial;
    font-style: initial;
}
</style>
<div class="row m-0">
    <div class="col-md-12" ng-if="income_statements.length > 0">
    <div class="float-right">
        <md-switch class="d-inline" ng-change="hideZeroValue(zero_records)" ng-model="zero_records" ng-value="zero_records" ng-true-value="1" ng-false-value="0">
            <span class="">Show Non Zero Value Records</span>
        </md-switch>
        <a ng-click="download_pdf()" class="btn btn-success ml-4" style="color: white"><i class="fa fa-file mr-1"></i> Genrate Pdf</a>
    </div>
    </div>
</div>
<div>
    
    {{-- <div  class="row mx-0 my-3">
        <div class="col-md-8">
            <strong>[[income_statement.Title]]</strong>
        </div>
        <div class="col-md-4 text-right">
            Total: 5000
        </div>
    </div> --}}

    <div class="row m-0">
        <div class="col-md-12">
            <table class="table table-bordered" id="income-statement-tbl">
                {{-- <thead>
                    <tr>
                        <th>Account Title </th>
                        <th>Debit </th>
                        <th>Credit </th>
                        <th>Total </th>
                    </tr>
                </thead> --}}
                <tbody>
                    <tr>
                        <td>    
                            <ul style="padding-left:0;">
                                <li ng-repeat="is in income_statements" class="aheads">
                                    <div  class="row">
                                        <div class="col-md-6"><span class="child-level font-weight-bold" ng-class="getLevel(is.AccountLevel, is.OrderNo)"><u class="[[ is.AccountLevel == 5?'remove-underline':'';]] [[is.OrderNo == 0?'thicker':'']]">[[is.AccountTitle]]</u> </span></div>
                                        <div class="col-md-2 text-right offset-md-4 [[is.OrderNo == 0?'thicker':'']]" > [[is.Total | currency]] </div>
                                    </div>
                                </li>
                            </ul>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>    
    </div>
</div>

<script type="text/javascript">       
    function toCsv() {
        $("#income-statement-tbl").tableHTMLExport({
            type:'csv',
            filename:'income-statements.csv'
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
