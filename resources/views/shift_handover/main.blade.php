<style>
    .form-group .input-group input {
        background: none;
    }
    span.input-group-prepend {
        margin: 0.25rem;
    }
    span.input-group-text {
        padding: 4px;
    }
    .voucher_number-div {
        background: #ffffff;
        border-radius: 5px;
        padding: 0 10px;
        border: 1px dashed #b4b3b3;
        text-align: center;
    }
    .voucher_number-div h4 {
        display: inline-block;
        margin: 0;
        font-weight: 600;
    }
    .voucher_number-div label {
        padding: 0;
    }
    table textarea.form-control {
        height: 33px;
    }
    table td ,table th {
        padding: 5px 10px !important;
    }
    textarea.form-control {
        height: 33px;
    }
    </style>
    <div id="shiftHandOver" class="card" style="display:none;">
                    <div class="row">
                        <div class="col-md-6 mx-auto">
                            <fieldset class="py-2 px-2">
                                <legend class="font-weight-semibold text-uppercase font-size-sm mb-0 bg-light p-2">
                                <i class="icon-grid7 mr-2"></i>
                                Select Account Heads
                                <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo2" aria-expanded="false">
                                    <i class="icon-circle-down2"></i>
                                </a>
                                </legend>
                
                                <div class="collapse show" id="demo2" style="">
                                    <div class="row m-0">
                                        <div class="col-md-12">
                                            <div class="row iner-row my-1 p-1 bg-light">
                                                <div class="col-md-8 text-right"><strong for="">Opening Balance:</strong></div>
                                                <div class="col-md-4 text-right"><strong>[[user_opening_balance | currency]]</strong></div>
                                            </div>

                                            <div class="row iner-row my-1 p-1 bg-light">
                                                <div class="col-md-4 py-2">
                                                    <strong for=""class="mb-0">Cash Receive Today</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <md-select  ng-change="getGl(shift_handover.received_account_gl_id, 'received', 0,0)" name="received_account_gl_id" class="m-0" ng-model="shift_handover.received_account_gl_id" placeholder="Select Account Head" >
                                                        <md-option ng-repeat="ah in account_heads" ng-value="ah.id" >[[ah.title]] ([[ah.account_gl_code]])</md-option>
                                                    </md-select>
                                                    <div ng-messages="shiftHandoverForm.received_account_gl_id.$error" ng-if='shiftHandoverForm.received_account_gl_id.$touched || shiftHandoverForm.$submitted' ng-cloak style="color:#e9322d;">
                                                        <div class="text-danger" ng-message="required">Select Received Account Head</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-right py-2">
                                                    <strong>[[shift_handover.cash_received_today | currency]]</strong>
                                                </div>
                                            </div>
                                            <div class="row iner-row my-1 p-2 bg-light">
                                                <div class="col-md-4 py-2">
                                                    <strong for="" class="mb-0">Cash Paid Today</strong>
                                                </div>
                                                <div class="col-md-4">
                                                    <md-select  ng-change="getGl(shift_handover.paid_account_gl_id , 'paid', shift_handover.cash_received_today , user_opening_balance)" name="paid_account_gl_id" class="m-0" ng-model="shift_handover.paid_account_gl_id" placeholder="Select Account Head" >
                                                        <md-option ng-repeat="ah in account_heads" ng-value="ah.id" >[[ah.title]] ([[ah.account_gl_code]])</md-option>
                                                    </md-select>
                                                    <div ng-messages="shiftHandoverForm.paid_account_gl_id.$error" ng-if='shiftHandoverForm.paid_account_gl_id.$touched || shiftHandoverForm.$submitted' ng-cloak style="color:#e9322d;">
                                                        <div class="text-danger" ng-message="required">Select Paid Account Head</div>
                                                    </div>
                                                </div>
                                                <div class="col-md-4 text-right py-2">
                                                    <strong>[[shift_handover.cash_paid_today | currency]]</strong>
                                                </div>
                                            </div>

                                        <div id="available_balance" class="row iner-row my-1 p-2 bg-light" style="display: none;">
                                                <div class="col-md-8 py-2 text-right">
                                                    <strong for="" class="mb-0">Available Balance:</strong>
                                                </div>
                                                <div class="col-md-4 py-2 text-right">
                                                    <strong>[[shift_handover.cash_available | currency]]</strong>
                                                </div>
                                                
                                                <div class="col-md-12 py-3 px-0 border-top text-right">
                                                    <button  type="button" ng-click="showshiftHandOverSheet()" id="btn-save" class="btn btn-sm bg-warning"><i class="icon-clipboard3 mr-1"></i> Generate Receipt</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>    
            
    </div>
    
    