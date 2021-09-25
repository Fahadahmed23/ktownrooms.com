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
    .pl-20{
        padding-left: 20px;
    }
    .pl-40{
        padding-left: 40px;
    }
    .pl-60{
        padding-left: 60px;
    }
    </style>
    <div class="row m-0">
        <div class="col-md-12 text-right">
            {{-- <a href="{{ route('pdfview',['download'=>'pdf']) }}" class="btn btn-success">Genrate Pdf</a> --}}
            <a ng-click="download_pdf()" class="btn btn-success" style="color: white" ng-if="balance_sheets.length > 0"><i class="fa fa-file mr-1"></i> Genrate Pdf</a>
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
                                <ul>
                                    <li ng-repeat="bs in balance_sheets" class="aheads">
                                        <div class="row" style="background: [[bs.OrderNo == 0 ? '#3f51b5': 'none']]; color: [[bs.OrderNo == 0 ? '#fff': '#000']]">
                                            <div ng-if="bs.AccountLevel != 1" class="col-md-6"><span class="font-italic child-level font-weight-bold" ng-class="getLevel(bs.AccountLevel)"><u class="[[ bs.AccountLevel == 5?'remove-underline':'']]">[[bs.AccountTitle]]</u> </span></div>
                                            
                                            <div class="col-md-2 text-right" ng-if="bs.OrderNo == 0"></div>
                                            <div class="col-md-2 text-right" ng-if="bs.OrderNo == 0"></div>
                                            <div class="col-md-2 text-right" ng-if="bs.OrderNo == 0"></div>
    
                                            <div class="col-md-2 text-right" ng-if="bs.OrderNo == 1"> <strong>Debit</strong> </div>
                                            <div class="col-md-2 text-right" ng-if="bs.OrderNo == 1"> <strong>Credit</strong></div>
                                            <div class="col-md-2 text-right" ng-if="bs.OrderNo == 1"> <strong>Total</strong></div>
    
                                            <div class="col-md-2 text-right" ng-if="bs.AccountLevel == 5"> [[bs.Debit | currency]] </div>
                                            <div class="col-md-2 text-right" ng-if="bs.AccountLevel == 5"> [[bs.Credit | currency]] </div>
                                            <div class="col-md-2 text-right offset-md-4" ng-if="bs.AccountLevel != 5 && (bs.OrderNo != 0 && bs.OrderNo != 1) && bs.AccountTitle != 'Total Equity'"> [[bs.Net | currency]] </div>
                                            <div class="col-md-2 text-right offset-md-4" ng-if="bs.AccountLevel != 5 && (bs.OrderNo != 0 && bs.OrderNo != 1) && bs.AccountTitle == 'Total Equity'"> [[total_equity | currency]] </div>
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
