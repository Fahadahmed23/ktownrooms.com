
<div id="addNewPartner" class="card" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[room.id?'Update':'Add New']] Partner</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        @include('layouts.form_messages')
        <form name="partnerForm" id="partnerForm" class="card-body">
            <div class="form-group row">
                <div class="col-md-12">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    <i class="icon-city mr-2"></i>
                    Partner information
                  </legend>
                </div>

                <div class="col-md-3"> 
                 <label class="col-lg-6 col-form-label">Hotel Title<span class="text-danger">*</span></label>
                  
                 <input name="HotelName" maxlength="50"  type="text" class="form-control px-2 alpha_numeric " ng-model="partner.HotelName" placeholder="Regent Plaza" required>

                  <div ng-messages="partnerForm.HotelName.$error" ng-if='partnerForm.HotelName.$touched || partnerForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Hotel Title is required</div>
                  </div>
                </div> 

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Name<span class="text-danger">*</span></label>
                 <input name="FullName" maxlength="50"  type="text" class="form-control px-2 alphabets" ng-model="partner.FullName" placeholder="Asad Ali" required>
                 
                 <div ng-messages="partnerForm.FullName.$error" ng-if='partnerForm.FullName.$touched || partnerForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Name is required</div>
                 </div>
                </div>  
                         
                <div class="col-md-3">
                 <label class="col-lg-6 col-form-label">Email <span class="text-danger">*</span></label>
                 <input name="EmailAddress" maxlength="50"  type="email" class="form-control px-2 email_mask" ng-model="partner.EmailAddress" placeholder="abc01@gmail.com" required>
                 
                 <div ng-messages="partnerForm.EmailAddress.$error" ng-if='partnerForm.EmailAddress.$touched || partnerForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Email is required</div>
                 </div>
                
                </div>

                <div class="col-md-3">
                  <label class="col-lg-6 col-form-label">Phone <span class="text-danger">*</span></label>
                  <input name="ContactNo" type="text" class="form-control px-2 phone_us" ng-model="partner.ContactNo" placeholder="0336-3636657" required>
                  
                  <div ng-messages="partnerForm.ContactNo.$error" ng-if='partnerForm.ContactNo.$touched || partnerForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Phone is required</div>
                   </div>
                
                </div>

                <div class="col-md-3 mt-3">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    Status
                  </legend>
                  <md-switch ng-model="partner.Status" ng-true-value="1" ng-false-value="0" style="display:block" >
                  <span class="">Active</span>
                </md-switch>
                </div>

                
            </div>
            <div class="text-right mt-2">
              <button  type="button" ng-click="savePartner()" id="btn-save" class="btn btn-sm bg-success">[[partner.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>
        </form>

        
</div>

