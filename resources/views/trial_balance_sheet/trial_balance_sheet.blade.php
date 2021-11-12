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
</style>

<div class="row m-0">
    <div class="col-md-12" ng-if="account_heads.length > 0">
        <div class="float-right" >
            <md-switch class="d-inline" ng-change="hideZeroValue(zero_records)" ng-model="zero_records" ng-value="zero_records" ng-true-value="1" ng-false-value="0">
                <span class="">Show Non Zero Value Records</span>
            </md-switch>
            <a ng-click="download_pdf()" class="btn btn-success ml-4" style="color: white" ><i class="fa fa-file mr-1"></i> Genrate Pdf</a>
        </div>
    </div>
</div>
<table class="table table-bordered">
   
    <tbody>
        <tr>
        <td>    
            <ul>
                <li ng-repeat="ah in account_heads" class="aheads">
                    <div  class="row">
                        <div ng-if="ah.AccountLevel == 1" class="col-md-6"><u class="font-weight-bold">[[ah.AccountTitle]] </u></div>
                    <div ng-if="ah.AccountLevel != 1" class="col-md-6"><span class="child-level font-weight-bold" ng-class="getLevel(ah.AccountLevel)"><u class="[[ ah.AccountLevel == trial_balance.level_no?'remove-underline':'']]">[[ah.AccountTitle]]</u> </span></div>
                        <div class="col-md-3 text-right">[[ah.Debit | currency]]</div>
                        <div class="col-md-3 text-right">[[ah.Credit | currency]]</div>
                    </div>
                </li>
                <li>
                    <div class="row total_credit_debit" style="display: none">
                        <div class="col-md-9 text-right"><strong>Total Debit : [[totalDebit|currency]]</strong></div>
                        <div class="col-md-3 text-right"><strong>Total Credit :[[totalCredit|currency]]</strong></div>
                    </div>
                </li>
            </ul>
        </td>
        </tr>
    </tbody>
</table>



{{-- <table class="table table-bordered">
    <tbody>
        <tr>
        <td>
            <ul style="padding: 0;">
                <li> 
                    <ul style="padding-left: 10px;">
                        <li ng-repeat="ah1 in account_heads |filter : {'AccountLevel' : '1'}">
                        <span><u class="font-italic font-weight-bold">[[ah1.AccountTitle]] </u></span>
                            <span class="float-right">[[ah1.Debit | currency]]</span>
                            <ul>
                                <li ng-repeat="ah2 in account_heads |filter : {'AccountLevel' : '2' }" >
                                    <span><u>[[ah2.AccountTitle]] </u></span>
                                    <span class="float-right">[[ah2.Debit | currency]]</span>

                                       <ul>
                                        <li ng-repeat="ah3 in account_heads |filter : {'AccountLevel' : '3'}" >
                                            <span><u>[[ah3.AccountTitle]] </u></span>
                                            <span class="float-right">[[ah3.Debit | currency]]</span>
                                            
                                            <ul>
                                                <li ng-repeat="ah4 in account_heads |filter : {'AccountLevel' : '4'}" >
                                                    <span><u>[[ah4.AccountTitle]]</u></span>
                                                    <span class="float-right">[[ah4.Debit | currency]]</span>
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
