
<div id="addNewClient" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[client.id?'Update':'Add New']] General Client</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        @include('layouts.form_messages')
        <form name="clientForm" id="clientForm" class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    <i class="icon-city mr-2"></i>
                    General Client Information
                  </legend>
                </div>

                <div class="col-md-3">
                    <label class="col-lg-6 col-form-label">Name<span class="text-danger">*</span></label>
                    <input name="name" maxlength="50"  type="text" class="form-control px-2 alphabets" ng-model="client.name" placeholder="Asad Ali" required>

                    <div ng-messages="clientForm.name.$error" ng-if='clientForm.name.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                     <div class="text-danger" ng-message="required">Name is required</div>
                    </div>
                </div>


                <div class="col-md-3">
                 <label class="col-lg-6 col-form-label">Email <span class="text-danger">*</span></label>
                 <input name="email" maxlength="50"  type="email" class="form-control px-2 email_mask" ng-model="client.email" placeholder="abc01@gmail.com" required>

                 <div ng-messages="clientForm.email.$error" ng-if='clientForm.email.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Email is required</div>
                 </div>

                </div>

                <div class="col-md-3">
                  <label class="col-lg-6 col-form-label">Phone <span class="text-danger">*</span></label>
                  <input name="phone" type="text" class="form-control px-2 phone_us" ng-model="client.phone" placeholder="0336-3636657" required>

                  <div ng-messages="clientForm.phone.$error" ng-if='clientForm.phone.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Phone is required</div>
                   </div>

                </div>

                <div class="col-md-3">
                    <label class="col-lg-6 col-form-label">POC<span class="text-danger">*</span></label>
                    <input name="poc" maxlength="50"  type="text" class="form-control px-2 alphabets" ng-model="client.poc" placeholder="Asad Ali" required>

                    <div ng-messages="clientForm.poc.$error" ng-if='clientForm.poc.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                     <div class="text-danger" ng-message="required">POC is required</div>
                    </div>
                </div>


                <div class="col-md-3">
                    <label class="col-lg-6 col-form-label">Hotel Name<span class="text-danger">*</span></label>

                       <md-select name="hotel_id"  md-no-asterisk class="m-0" ng-model="client.hotel_id" ng-init="GetHotels()" required>
                           <md-option ng-repeat="x in hotallist" ng-value="x.hotel_id">[[x.hotel_name]]</md-option>
                       </md-select>

                      <div ng-messages="clientForm.hotel_id.$error" ng-if='clientForm.hotel_id.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Hotel Name is required</div>
                      </div>
                </div>
                <div class="col-md-3">
                  <label class="col-lg-6 col-form-label">Status <span class="text-danger">*</span></label>
                  <md-switch ng-model="client.status" ng-true-value="1" ng-false-value="0" style="display:block">
                  <span class="">Active</span>
                </md-switch>
                </div>


            </div>
            <div class="text-right mt-2">
              <button  type="button" ng-click="saveClient()" id="btn-save" class="btn btn-sm bg-success">[[client.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>
        </form>


</div>
