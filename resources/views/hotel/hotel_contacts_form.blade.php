<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div  id="contact_form" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Contact</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form name="contactForm" id="v_contact" class="" confirm-on-exit>
				<div class="modal-body">
                    @include('layouts.form_messages')
					<fieldset>
						<div class="form-group row">	
                            <div class="col-lg-4">
                                <label class="col-form-label">Contact Person <span class="text-danger">*</span></label>
                                <input placeholder="Asad Ali" type="text" name="ContactPerson" class="form-control alphabets" ng-model="contact.ContactPerson" required>
                                
                                <div ng-messages="contactForm.ContactPerson.$error" ng-if='contactForm.ContactPerson.$touched || contactForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Contact Person is required</div>
                                </div>
                            
                            </div>                
                            <div class="col-lg-4">
                                <label class="col-form-label">Contact type <span class="text-danger">*</span></label>
                                <md-select md-no-asterisk required placeholder="Select a Contact Type" name="contact_type" class="m-0" ng-model="contact.contact_type_id">
                                    <md-option ng-repeat="contact_type in contact_types" ng-value="contact_type.id">[[contact_type.ContactType]]</md-option>
                                </md-select>
                        

                                <div ng-messages="contactForm.contact_type.$error" ng-if='contactForm.contact_type.$touched || contactForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Contact Type is required</div>
                                </div>
                            </div>

                            <div class="col-lg-4" ng-if="contact.contact_type_id == 1">
                                <label class="col-form-label">Email <span class="text-danger">*</span></label>
                                <input name="value" required type="text" ng-model="contact.Value" ng-class="getMaskingClass()"  class="form-control email_mask" placeholder="abc001@test.com">
                                
                                <div ng-messages="contactForm.value.$error" ng-if='contactForm.value.$touched || contactForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required"> Email is required</div>
                                </div>
                            
                            </div>


                            <div class="col-lg-4" ng-if="contact.contact_type_id == 2">
                                <label class="col-form-label">Phone <span class="text-danger">*</span></label>
                                <input name="value" required type="text" ng-model="contact.Value" ng-class="getMaskingClass()"  class="form-control phone_us" placeholder="0336-3636395">
                                
                                <div ng-messages="contactForm.value.$error" ng-if='contactForm.value.$touched || contactForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required"> Phone is required</div>
                                </div>
                            
                            </div>


                            <div class="col-lg-4" ng-if="contact.contact_type_id == 3">
                                <label class="col-form-label">Fax <span class="text-danger">*</span></label>
                                <input name="value" required type="text" ng-model="contact.Value" ng-class="getMaskingClass()" class="form-control phone_us" placeholder="0336-3636395">
                                
                                <div ng-messages="contactForm.value.$error" ng-if='contactForm.value.$touched || contactForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required"> Fax is required</div>
                                </div>
                            
                            </div>

                        </div>
                    
                    </fieldset>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="pushContact()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i>Add Contact</button>
                </div>
            </form>
		</div>
	</div>
</div>