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
    padding: 5px 10px !IMPORTANT;
}
textarea.form-control {
    height: 33px;
}
</style>
<div id="addNewVoucher" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[voucher.id?'Update':'Add New']] Voucher</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        {{-- @include('layouts.form_messages') --}}
        <form name="voucherForm" id="voucherForm" class="card-body" enctype="multipart/form-data" >
          <div class="row">
            <div class="col-md-6">
              <div class="py-2 px-2">
                <fieldset>
                  <legend class="font-weight-semibold text-uppercase font-size-sm">
                    <i class="icon-city mr-2"></i>
                    Voucher Basic information
                    <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo1" aria-expanded="false">
                      <i class="icon-circle-down2"></i>
                    </a>
                  </legend>
                  <div class="collapse show" id="demo1" style="">
                    <div class="row row m-0 p-2 bg-light">
                      <div ng-if="voucher.voucher_no" class="col-md-12" style="margin-bottom: 20px;">
                        <div class="voucher_number-div">
                          <label class="col-form-label">Voucher #</label>
                          <h4 class="text-success">[[voucher.voucher_no]]</h4>
                        </div>
                      </div>
                      <div class="[[voucher.is_configured=='1'?'col-md-4':'col-md-6']]"> 
                        <div class="form-group">
                          <label class="col-lg-6 col-form-label">Hotels</label>
                          <md-select ng-disabled="field_disabled || hotels.length == 1 " asterisk name="hotel_id" class="m-0" ng-model="voucher.hotel_id" placeholder="Select Hotel" required>
                            <md-option  ng-repeat="h in hotels" ng-value="h.id">[[h.HotelName]]</md-option>
                          </md-select>
                          <div ng-messages="voucherForm.hotel_id.$error" ng-if='voucherForm.hotel_id.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Hotel is required</div>
                          </div>
                        </div>
  
                      </div> 
                      <div class="[[voucher.is_configured=='1'?'col-md-4':'col-md-6']]"> 
                        <div class="form-group">
                          <label class="col-lg-6 col-form-label">Voucher Type</label>
                          <md-select ng-disabled="field_disabled" asterisk name="voucher_type_id" class="m-0" ng-model="voucher.voucher_type_id" ng-change="getVoucherType(voucher.voucher_type_id)" placeholder="Select a Voucher Type" required>
                            <md-option ng-repeat="v in voucher_types|filter: {title:'!Auto Posting'} " ng-value="v.id">[[v.title]]</md-option>
                          </md-select>
                          <div ng-messages="voucherForm.voucher_type_id.$error" ng-if='voucherForm.voucher_type_id.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Voucher Type is required</div>
                          </div>
                        </div>
                      </div> 
                      <div ng-show="voucher.is_configured=='1'" class="col-md-4">
                        <div class="form-group">
                          <label class="col-lg-6 col-form-label">Amount</label>
                          <input ng-required="voucher.is_configured=='1'" type="text" currency data-type="currency" name="is_configured_amount" ng-model="voucher.is_configured_amount" class="form-control" placeholder="100" maxlength="6">
                          <div ng-messages="voucherForm.is_configured_amount.$error" ng-if='voucherForm.is_configured_amount.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Amount is required</div>
                          </div>
                        </div>  
                      </div>
                    </div>
  
                    <div class="row m-0 p-2 bg-light">
                      <div class="col-md-4">  

                        <div class="form-group">
                          <label class="col-lg-6 col-form-label">Fiscal Years</label>
                          <md-select ng-disabled="field_disabled" ng-change="getFiscalyear(voucher.fiscal_year_master_id)" asterisk name="fiscal_year_master_id" class="m-0" ng-model="voucher.fiscal_year_master_id" placeholder="Select a Fiscal Year" required>
                            <md-option ng-repeat="fy in fiscal_years" ng-value="fy.id">[[fy.title]]</md-option>
                          </md-select>
                          <div ng-messages="voucherForm.fiscal_year_master_id.$error" ng-if='voucherForm.fiscal_year_master_id.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Fiscal Year is required</div>
                          </div>
                        </div>
                      </div>
                      <div class="col-md-4"> 
                        <div class="form-group">
                          <input type="hidden" name="voucher" ng-model="voucher.voucher_no" class="form-control" readonly placeholder="">
                          <label class="col-lg-6 col-form-label">Date<span class="required">*</span></label>
                          <div class="input-group">
                              <span class="input-group-prepend">
                                  <span class="input-group-text"><i class="icon-calendar"></i></span>
                              </span>
                              <input ng-disabled="field_disabled" ng-change="getVoucherDate()"  type="text" name="voucher_date" placeholder="MM/DD/YYYY" ng-model="voucher.date" id="voucher_date" class="form-control pickadate voucher_date" required>
                          </div>
                          <div ng-messages="voucherForm.voucher_date.$error" ng-if='voucherForm.voucher_date.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                            <div class="text-danger" ng-message="required">Voucher Date is required</div>
                          </div>
                        </div>
  
                      </div> 
                      <div class="col-md-4">  
                        <div class="form-group">
                          <label class="col-lg-6 col-form-label">Description</label>
                          <textarea ng-disabled="field_disabled" ng-model="voucher.description" name="description" class="form-control" placeholder="Please enter description here.."></textarea>
                        </div>
                      </div>
                    </div>
  
                  </div>
                </fieldset>
              </div>
            </div>
  
            <div ng-show="voucher.is_configured=='0'" class="col-md-6">
              <fieldset class="py-2 px-2">
                <legend class="font-weight-semibold text-uppercase font-size-sm mb-0 bg-light p-2">
                  <i class="icon-grid7 mr-2"></i>
                  Voucher Details
                  <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo2" aria-expanded="false">
                    <i class="icon-circle-down2"></i>
                  </a>
                </legend>
  
                <div class="collapse" id="demo2" style="">
                  <div class="row">
                    <div class="col-md-12">
                      <table class="table table-user table-striped hover display datatable-basic table-bordered">
                        <thead>
                          <tr>
                            <th>Account Type</th>
                            <th>Account Head</th>
                            <th>Narration</th>
                            <th>Debit</th>
                            <th>Credit</th>
                            <th ng-hide="field_disabled"></th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="vd in voucher_details track by $index">
                            <td>[[vd.account_type_name]]</td>
                            <td>[[vd.AccountHeadName]] ([[vd.AccountHeadCode]])</td>
                            <td>[[vd.narration]]</td>
                            <td class="text-success text-right">[[vd.dr_amount |currency]]</td>
                            <td class="text-danger text-right">[[vd.cr_amount |currency]]</td>
                            <td ng-hide="field_disabled"><i ng-click="removeVoucherDetail($index , vd)" class="btn btn-danger fa fa-minus"></i></td>
                          </tr>
                          <tr ng-hide="field_disabled">
                            <td>
                              <md-select name="account_type_id" class="m-0" ng-model="voucher_detail.account_type_id" placeholder="Select Account Type">
                                <md-select-header>
                                  <input ng-model="search_account_types"  class="_md-text w-100 border px-3 py-2" placeholder="Search Account Type"  onkeydown="event.stopPropagation()">
                                </md-select-header>
                                <md-option ng-repeat="at in account_types |filter:search_account_types |orderBy:'title' track by $index" ng-value="at.id" >[[at.title]]</md-option>
                              </md-select>

                              {{-- <div ng-messages="voucherForm['account_type_id_' + $index].$error" ng-if="voucherForm['account_type_id_' + $index].$touched || voucherForm.$submitted" ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Account type required</div>
                              </div> --}}
                                
                              
                            </td>
                            <td>
                              <md-select ng-change="getAccountHead(voucher_detail.account_gl_id)"  name="account_gl_id" class="m-0" ng-model="voucher_detail.account_gl_id" placeholder="Select Account head" >
                                <md-select-header>
                                  <input ng-model="search_account_heads"  class="_md-text w-100 border px-3 py-2" placeholder="Search Account Head"  onkeydown="event.stopPropagation()">
                                </md-select-header>
                                <md-option ng-repeat="ah in account_heads | filter:{account_type_id:voucher_detail.account_type_id,title:search_account_heads } | orderBy:'title'" ng-value="ah.id" >[[ah.title]] ([[ah.account_gl_code]])</md-option>
                              </md-select>

                              
                            </td>
                            <td>
                              <textarea name="narration" ng-model="voucher_detail.narration" class="form-control px-2" placeholder="narration"></textarea>
                            </td>
                            <td>
                              <input ng-change="getDebitVal(voucher_detail.dr_amount)" type="text" currency data-type="currency" name="dr_amount" ng-model="voucher_detail.dr_amount" class="form-control debit-input px-2" placeholder="100" maxlength="9">
                            </td>
                            <td>
                              <input ng-change="getCreditVal(voucher_detail.cr_amount)" type="text" currency data-type="currency" name="cr_amount" ng-model="voucher_detail.cr_amount" class="form-control credit-input px-2" placeholder="100"  maxlength="9">
                            </td>
                            <td>
                              <button class="vd_push_btn btn btn-info" ng-click="pushVoucherDetail(voucher_detail)"><i class="fa fa-plus"></i> </button> 
                            </td>
                            
                          </tr>
                        </tbody>
                        <tfoot>
                          <tr class="text-right">
                            <th colspan="4">
                              Total Debit: [[dr_total | currency]]
                            </th>
                            <th colspan="2">Total Credit: [[cr_total  | currency]]</th>
                          </tr>
                        </tfoot>
                        
                      </table>
                    </div>
                    
                  </div>
                </div>
              </fieldset>
            </div>
          </div>


           
            <div ng-hide="field_disabled" class="text-right mt-2">
              <button  type="button" ng-click="saveVoucher()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[voucher.id?'Update':'Save']]</button>
            </div>
        </form>

        
</div>

