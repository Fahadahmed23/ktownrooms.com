
<div id="addNewClient" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[room.id?'Update':'Add New']] Corporate Client</h5>
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
                    Corporate Client Information
                  </legend>
                </div>


                <div class="col-md-3">
                 <label class="col-lg-6 col-form-label">Name<span class="text-danger">*</span></label>
                 {{-- <input name="FullName" maxlength="50"  type="text" class="form-control px-2 alphabets" ng-model="client.FullName" placeholder="Asad Ali" required> --}}



                 <md-select name="FullName"  md-no-asterisk class="m-0" ng-model="clients.FullName" ng-init="GetHotels()">
                    <md-option ng-repeat="x in clients" ng-value="x">[[x.FullName]]</md-option>
                </md-select>
                <div ng-messages="clientForm.FullName.$error" ng-if='clientForm.FullName.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Name is required</div>
                </div>
                </div>

                <div class="col-md-3">
                 <label class="col-lg-6 col-form-label">Email <span class="text-danger">*</span></label>
                 <input name="EmailAddress" maxlength="50"  type="email" class="form-control px-2 email_mask" ng-model="client.EmailAddress" placeholder="abc01@gmail.com" required>

                 <div ng-messages="clientForm.EmailAddress.$error" ng-if='clientForm.EmailAddress.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Email is required</div>
                 </div>

                </div>

                <div class="col-md-3">
                  <label class="col-lg-6 col-form-label">Phone <span class="text-danger">*</span></label>
                  <input name="ContactNo" type="text" class="form-control px-2 phone_us" ng-model="client.ContactNo" placeholder="0336-3636657" required>

                  <div ng-messages="clientForm.ContactNo.$error" ng-if='clientForm.ContactNo.$touched || clientForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Phone is required</div>
                   </div>

                </div>

                <div class="col-md-3">
                  <label class="col-lg-6 col-form-label">Status <span class="text-danger">*</span></label>
                  <md-switch ng-model="client.Status" ng-true-value="1" ng-false-value="0" style="display:block" >
                  <span class="">Active</span>
                </md-switch>
                </div>


            </div>
            <div class="text-right mt-2">
              <button  type="button" ng-click="saveClient()" id="btn-save" class="btn btn-sm bg-success">[[client.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>
        </form>


</div>

