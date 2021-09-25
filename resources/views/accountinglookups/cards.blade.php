
<style>
.icnbx {
    width: 20%;
    float: left;
    text-align: right;
}
.lblbx {
    width: 80%;
    float: left;
}
.frm {
    width: 100%;
    float: left;
}
.frm input.form-control {
    width: 70%;
    float: left;
  
}
.list {
    height: 120px;
    overflow: auto;
    margin-bottom: 15px;
}
.validation-invalid-label {
    float: left;
}
.formactionbtnspan {
    width: 30%;
    float: right;
    text-align: right;
}
.formactionbtnspan button {
    border: none;
    padding: 10px;
}
</style>
<div class="cardsmain card p-3">
    <div class="row">
        <div class="col-md-3">
            <!-- Account Types -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Account Types</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[account_types.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="account_type in account_types" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="icon-radio-checked mr-2 fa-1x"></i>[[account_type.title]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteAccountType(account_type)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editAccountType(account_type)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addAccountType()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Account Type</strong>
                    </a>
                </div>
            </div>
            <!-- /Account Types -->
        </div>

        <div class="col-md-3">
            <!-- Account Sub Types -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Account Sub Types</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[account_sub_types.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="acc_sub_type in account_sub_types" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="icon-radio-checked mr-2 fa-1x"></i>[[acc_sub_type.title]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteAccountSubType(acc_sub_type)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editAccountSubType(acc_sub_type)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addAccountSubType()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Account Sub Type</strong>
                    </a>
                </div>
            </div>
            <!-- /Account Types -->
        </div>




        <div class="col-md-3">
            <!-- Voucher Types -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Voucher Types</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[voucher_types.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="voucher_type in voucher_types" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="icon-radio-checked mr-2 fa-1x"></i>[[voucher_type.title]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteVoucherType(voucher_type)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editVoucherType(voucher_type)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addVoucherType()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Voucher Type</strong>
                    </a>
                </div>
            </div>
            <!-- /Voucher Type -->
        </div>

        <div class="col-md-3">
            <!-- Account Level -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Account Levels</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[account_levels.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="account_level in account_levels" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="icon-radio-checked mr-2 fa-1x"></i>[[account_level.name]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteAccountLevel(account_level)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editAccountLevel(account_level)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addAccountLevel()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Account Level</strong>
                    </a>
                </div>
            </div>
            <!-- / Account Level -->
        </div>


        <div class="col-md-3">
            <!-- Account Sales Tax -->
            <div class="card">
                <div class="card-header bg-transparent header-elements-inline">
                    <span class="card-title font-weight-semibold">Account Sales Taxes</span>
                    <div class="header-elements">
                        <span class="badge bg-info badge-pill">[[account_sales_taxes.length]]</span>
                        <a class="list-icons-item ml-1" data-action="collapse"></a>
                    </div>
                </div>

                <div class="list-group list-group-flush">
                    <div class="list">
                        <a ng-repeat="account_sales_tax in account_sales_taxes" class="list-group-item list-group-item-action legitRipple">
                            <div class="lblbx"><i class="icon-radio-checked mr-2 fa-1x"></i>[[account_sales_tax.title]]</div>
                            <div class="icnbx">
                            <span  ng-click="deleteAccountSalesTax(account_sales_tax)" class="badge bg-danger icn"><i class="fa fa-trash" style="color: white"></i></span>
                            <span  ng-click="editAccountSalesTax(account_sales_tax)" class="badge bg-success icn"><i class="fa fa-pencil" style="color: white"></i></span>
                            </div>
                        </a>
                    </div>    
                    <a class="list-group-item list-group-item-action legitRipple" ng-click="addAccountSalesTax()">
                        <i class="fa fa-plus mr-3"></i>
                        <strong>Add Account Sales tax</strong>
                    </a>
                </div>
            </div>
            <!-- /Account Sales tax -->
        </div>

    </div>
</div>


