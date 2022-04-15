
<div id="addNewCustomer" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[customer.id?'Update':'Add New']] Customer</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        @include('layouts.form_messages')
        <form name="customerForm" id="customerForm" class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    <i class="icon-user-plus mr-2"></i>
                    Customer Information
                  </legend>
                </div>

                {{-- <div class="col-md-6 customer_stats" ng-if="customer.id">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    <i class="icon-pie-chart3 mr-2"></i>
                    Customer Booking Status
                  </legend>
                </div> --}}
            </div> 

            <div class="row">
              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-md-6">        
                    <label class="col-lg-6 col-form-label">First Name<span class="text-danger">*</span></label>
                    <input name="FirstName" maxlength="50"  type="text" class="form-control px-2 alphabets" ng-model="customer.FirstName" placeholder="Asad" required>
                    
                    <div ng-messages="customerForm.FirstName.$error" ng-if='customerForm.FirstName.$touched || customerForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">First Name is required</div>
                    </div>
                  </div>

                  <div class="col-md-6">        
                    <label class="col-lg-6 col-form-label">Last Name<span class="text-danger">*</span></label>
                    <input name="LastName" maxlength="50"  type="text" class="form-control px-2 alphabets" ng-model="customer.LastName" placeholder="Asad" required>
                    
                    <div ng-messages="customerForm.LastName.$error" ng-if='customerForm.LastName.$touched || customerForm.$submitted' ng-cloak style="color:#e9322d;">
                      <div class="text-danger" ng-message="required">Last Name is required</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label class="col-lg-6 col-form-label">Email  <span class="text-danger">*</span></label>
                    <input name="Email" maxlength="50"  type="email" class="form-control px-2 email_mask" ng-model="customer.Email" placeholder="abc01@gmail.com" required>
                    
                    <div ng-messages="customerForm.Email.$error" ng-if='customerForm.Email.$touched || customerForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Email is required</div>
                    </div>
                  
                  </div>
    
                  <div class="col-md-4">
                    <label class="col-lg-6 col-form-label">Phone <span class="text-danger">*</span></label>
                    <input aria-invalid="true" name="Phone" type="tel" class="form-control phone_int" id="phone_int" ng-model="customer.Phone" placeholder="" value=""  required>
                    
                    <div ng-messages="customerForm.Phone.$error" ng-if='customerForm.Phone.$touched || customerForm.$submitted' ng-cloak style="color:#e9322d;">
                      <div class="text-danger" ng-message="required">Phone is required</div>
                    </div>
                  </div>

                  <div class="col-md-4">
                    <label class="col-lg-6 col-form-label">[[customer.is_cnic == '0'?'Passport':'CNIC']] #</label>
                    <input aria-invalid="true" ng-class="getcustomer(customer.is_cnic)" type="text" ng-model="customer.CNIC" name="CNIC" placeholder="[[customer.is_cnic == '0'?'PK123456789':'42201-6562366-3']]" value="" class="form-control">

                      <div ng-messages="customerForm.customer.$error" ng-if='customerForm.customer.$touched || customerForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">[[customer.is_cnic == '0'?'Passport':'Cnic']] # is required</div>
                      </div>
                      <md-switch ng-model="customer.is_cnic" ng-true-value="1" ng-false-value="0" style="display:block;float:right">
                      Is CNIC?</md-switch>
                  </div>

                  <div class="col-md-4">
                    <label class="col-lg-6 col-form-label">Nationality <span class="text-danger">*</span></label>
                        <md-select name="nationality" md-no-asterisk required class="m-0" ng-model="customer.nationality" placeholder="Pakistani ">
                            <md-option ng-repeat="nationality in nationalities" ng-value="nationality">[[nationality]]</md-option>
                        </md-select>

                        <div ng-messages="customerForm.nationality.$error" ng-if='customerForm.nationality.$touched || customerForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Nationality is required</div>
                      </div>
                  </div>

                  <div class="col-md-4">
                    <label class="col-lg-6 col-form-label">Status <span class="text-danger">*</span></label>
                    <md-switch ng-model="customer.IsActive" ng-true-value="1" ng-false-value="0" style="display:block" >
                    <span class="">Active</span>
                    </md-switch>
                  </div>
                </div>  
              </div> 

              <div class="col-md-6 row customer_stats" style="display:none;">
                <div class="col-md-4">       
                  <div class="card card-body bg-success has-bg-image" style="min-height: 95px;">
                      <div class="media">
                          <div class="media-body">
                              <h3 class="mb-0 ng-binding">[[customer.ConfirmedBookingsCount]]</h3>
                              <span class="text-uppercase font-size-xs">Total Confirmed Booking</span>
                          </div>
                          <div class="ml-3 align-self-center">
                              <i class="icon-clipboard2 icon-3x opacity-75"></i>
                          </div>
                      </div>
                  </div>
                </div>

                <div class="col-md-4">       
                  <div class="card card-body bg-info has-bg-image" style="min-height: 95px;">
                      <div class="media">
                          <div class="media-body">
                              <h3 class="mb-0 ng-binding">[[customer.Revenue |currency]]</h3>
                              <span class="text-uppercase font-size-xs">Total Reveue of Bookings </span>
                          </div>
                          <div class="ml-3 align-self-center">
                              <i class="icon-cash3 icon-3x opacity-75"></i>
                          </div>
                      </div>
                  </div>
                </div>


                <div class="col-md-4">       
                  <div class="card card-body bg-danger has-bg-image" style="min-height: 95px;">
                      <div class="media">
                          <div class="media-body">
                              <h3 class="mb-0 ng-binding">[[customer.CancelledBookingsCount]]</h3>
                              <span class="text-uppercase font-size-xs">Total Cancelled Bookings</span>
                          </div>
                          <div class="ml-3 align-self-center">
                              <i class="icon-close2 icon-3x opacity-75"></i>
                          </div>
                      </div>
                  </div>
                </div>

              </div>
            </div>
            




            <div class="text-right mt-2">
              <button ng-if="customer.id" type="button" ng-click="blackListCustomer(customer)" id="btn-save" class="btn btn-sm bg-danger">Black List Customer<i class="fa fa-skull-crossbones ml-1"></i></button>
              <button  type="button" ng-click="saveCustomer()" id="btn-save" class="btn btn-sm bg-success">[[customer.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>
        </form>

        
</div>

