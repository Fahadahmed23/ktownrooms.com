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
  <div id="addNewAutoPosting" class="card" style="display:none;">
      <div class="card-header bg-white header-elements-inline">
            <h5 class="card-title" style="text-transform:capitalize;">[[auto_posting.id?'Update':'Add New']] Auto Posting</h5>
        <div class="header-elements">
          <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
            <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
          </div>
        </div>
        </div>
          {{-- @include('layouts.form_messages') --}}
          <form name="autoPostingForm" id="autoPostingForm" class="card-body" >
            <div class="row">

                <div class="col-md-6">
                    <fieldset class="py-2 px-2">
                      <legend class="font-weight-semibold text-uppercase font-size-sm mb-0 bg-light p-2">
                        <i class="icon-grid7 mr-2"></i>
                        Auto Posting Basic Information
                        <a href="#" class="float-right text-default collapsed" data-toggle="collapse" data-target="#demo2" aria-expanded="false">
                          <i class="icon-circle-down2"></i>
                        </a>
                      </legend>
        
                      <div class="collapse show" id="demo2" style="">
                        <div class="row">

                          <div class="col-md-3">
                            <div class="form-group py-2">
                              <label class="col-form-label">Posting Type</label>
                              <md-select required ng-change="getpostingTyp(posting_type.auto_posting_type_id)" name="auto_posting_type_id" class="m-0" ng-model="posting_type.auto_posting_type_id" placeholder="Select Posting type" >
                                <md-option ng-repeat="apt in auto_posting_types" ng-value="apt.id" >[[apt.title]]</md-option>
                              </md-select>
                              <div ng-messages="autoPostingForm.auto_posting_type_id.$error" ng-if="autoPostingForm.auto_posting_type_id.$touched || autoPostingForm.$submitted">
                                <div class="text-danger" ng-message="required">Posting type is required</div>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-12">
                            <table class="table table-user table-striped hover display datatable-basic table-bordered">
                              <thead>
                                <tr>
                                  <th>Account Type</th>
                                  <th>Account Head</th>
                                  <th ng-hide="true">Level</th>
                                  <th>Debit</th>
                                  <th>Credit</th>
                                  <th></th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr ng-repeat="a in auto_postings_arr track by $index">
                                  <td>[[a.account_type_name]]</td>
                                  <td>[[a.account_gl_name]] ([[a.account_gl_code]])</td>
                                  <td  ng-hide="true" >[[a.account_level]]</td>
                                  <td class="text-success text-right">[[a.is_dr=='1'?'Debit':'']]</td>
                                  <td class="text-danger text-right">[[a.is_cr=='1'?'Credit':'']]</td>
                                  <td><i ng-click="removeRecord($index , ap)" class="btn btn-danger fa fa-minus"></i></td>
                                </tr>
                                <tr>
                                  <td>
                                    <md-select name="account_type_id" class="m-0" ng-model="auto_posting_ar.account_type_id" placeholder="Select Account Type" >
                                      <md-select-header>
                                        <input ng-model="search_account_types"  class="_md-text w-100 border px-3 py-2" placeholder="Search Account Type"  onkeydown="event.stopPropagation()">
                                      </md-select-header>
                                      <md-option ng-repeat="at in account_types |filter:search_account_types" ng-value="at.id" >[[at.title]]</md-option>
                                    </md-select>
                                  </td>
                                  <td>
                                    <md-select ng-change="getGl(auto_posting_ar.account_gl_id)" name="account_gl_id" class="m-0" ng-model="auto_posting_ar.account_gl_id" placeholder="Select Account head" >
                                      <md-select-header>
                                        <input ng-model="search_account_heads"  class="_md-text w-100 border px-3 py-2" placeholder="Search Account Head"  onkeydown="event.stopPropagation()">
                                      </md-select-header>
                                      <md-option ng-repeat="ah in account_heads | filter: {account_type_id:auto_posting_ar.account_type_id, title:search_account_heads } | orderBy:'title'" ng-value="ah.id" >[[ah.title]] ([[ah.account_gl_code]])</md-option>
                                    </md-select>
                                  </td>

                                  <td  ng-hide="true">
                                    <input disabled type="text" name="account_level" ng-value="" ng-model="auto_posting_ar.account_level" class="form-control px-2" >
                                  </td>

                                  <td>
                                    <md-switch ng-disabled="auto_posting_ar.is_cr == '1'" ng-model="auto_posting_ar.is_dr" ng-true-value="1" ng-false-value="0" style="display:block"></md-switch>
                                  </td>

                                  <td>
                                    <md-switch ng-disabled="auto_posting_ar.is_dr == '1'" ng-value="1" ng-model="auto_posting_ar.is_cr" ng-true-value="1" ng-false-value="0" style="display:block"></md-switch>
                                  </td>
                                  
                                  <td>
                                  <button  class="vd_push_btn btn btn-info" ng-click="pushAutoPosting(auto_posting_ar)"><i class="fa fa-plus"></i> </button> 
                                  </td>
                                  
                                </tr>
                              </tbody>
                            </table>
                          </div>
                          
                        </div>
                      </div>
                    </fieldset>
                  </div>
              {{-- <div class="col-md-6">
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
                        <div class="col-md-6"> 
                          <div class="form-group">
                            <label class="col-lg-6 col-form-label">Voucher Type</label>
                            <md-select asterisk name="voucher_type_id" class="m-0" ng-model="voucher.voucher_type_id" ng-change="getVoucherType(voucher.voucher_type_id)" placeholder="Select a Voucher Type" required>
                              <md-option ng-repeat="v in voucher_types" ng-value="v.id">[[v.title]]</md-option>
                            </md-select>
                            <div ng-messages="voucherForm.PurchaseOrderId.$error" ng-if='voucherForm.PurchaseOrderId.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                              <div class="text-danger" ng-message="required">Voucher Type is required</div>
                            </div>
                          </div>
    
                        </div> 
                        <div class="col-md-6">  
  
                          <div class="form-group">
                            <label class="col-lg-6 col-form-label">Fiscal Years</label>
                            <md-select ng-change="getFiscalyear(voucher.fiscal_year_master_id)" asterisk name="fiscal_year_master_id" class="m-0" ng-model="voucher.fiscal_year_master_id" placeholder="Select a Fiscal Year" required>
                              <md-option ng-repeat="fy in fiscal_years" ng-value="fy.id">[[fy.title]]</md-option>
                            </md-select>
                            <div ng-messages="voucherForm.fiscal_year_master_id.$error" ng-if='voucherForm.fiscal_year_master_id.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                              <div class="text-danger" ng-message="required">Fiscal Year is required</div>
                            </div>
                          </div>
                        </div>
                      </div>
    
                      <div class="row m-0 p-2 bg-light">
                        <div class="col-md-6"> 
                          <div class="form-group">
                            <input type="hidden" name="voucher" ng-model="voucher.voucher_no" class="form-control" readonly placeholder="">
                            <label class="col-lg-6 col-form-label">Date<span class="required">*</span></label>
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input ng-change="getVoucherDate()"  type="text" name="voucher_date" placeholder="MM/DD/YYYY" ng-model="voucher.date" id="voucher_date" class="form-control pickadate voucher_date" required>
                            </div>
                            <div ng-messages="voucherForm.voucher_date.$error" ng-if='voucherForm.voucher_date.$touched || voucherForm.$submitted' ng-cloak style="color:#e9322d;">
                              <div class="text-danger" ng-message="required">Voucher Date is required</div>
                            </div>
                          </div>
    
                        </div> 
                        <div class="col-md-6">  
                          <div class="form-group">
                            <label class="col-lg-6 col-form-label">Description</label>
                            <textarea ng-model="voucher.description" name="description" class="form-control" placeholder="Please enter description here.."></textarea>
                          </div>
                        </div>
                      </div>
    
                    </div>
                  </fieldset>
                </div>
              </div> --}}
    
              
            </div>
  
  
             
              <div class="text-right mt-2">
                <button  type="button" ng-click="saveAutoPosting()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> [[auto_posting.id?'Update':'Save']]</button>
              </div>
          </form>
  
          
  </div>
  
  