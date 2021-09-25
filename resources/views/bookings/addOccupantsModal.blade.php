<style type="text/css">
    .md-select-menu-container,
    md-backdrop {
        z-index: 999999 !important;
    }
    .bulk_occupant-card{
        background: #eee;
        font-family: monospace;
        border-radius: 3px;
        min-height: 75px;
    }
</style>
<div id="addOccupant" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Occupant(s)</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
			<form id="ocupantform" name="occupant_form">
				<div class="modal-body">
					<fieldset>
						<div class="form-group row">		                         
                            <div class="col-lg-3">
                                <label class="col-form-label">First Name <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="occupantFirstName" required  ng-model="bookOccupant.FirstName" type="text" placeholder="Asad Ali" class="form-control alphabets" maxlength="10">
                                <div ng-messages="occupant_form.occupantFirstName.$error" ng-if="occupant_form.occupantFirstName.$touched || occupant_form.$submitted">
                                    <div class="text-danger" ng-message="required">First Name is required</div>
                                </div>
                            </div>
                            <div class="col-lg-3">   
                                <label class="col-form-label">Last Name <span class="text-danger">*</span></label>
                                <input aria-invalid="true" name="occupantLastName" required ng-model="bookOccupant.LastName" type="text" placeholder="Khan" class="form-control alphabets" maxlength="10">
                                <div ng-messages="occupant_form.occupantLastName.$error" ng-if="occupant_form.occupantLastName.$touched || occupant_form.$submitted">
                                    <div class="text-danger" ng-message="required">Last Name is required</div>
                                </div>
                            </div>

                            <div class="col-lg-2" ng-if="bookOccupant.Over18 == '1'" >
                                <label class="col-form-label">Verification
                                </label>
                                <md-select ng-change="changeDocTyp(bookOccupant.d_typ)" md-no-asterisk required aria-invalid="true" name="d_typ" class="m-0" ng-model="bookOccupant.d_typ" placeholder="CNIC">
                                    <md-option ng-repeat="d_typ in document_type" ng-value="d_typ.id">[[d_typ.name]]</md-option>
                                </md-select>
                            </div>
                            
                            <div class="col-lg-2 CNIC_required" style="display: none" >
                                <label class="col-form-label">CNIC # <span class="text-danger">*</span></label>
                                <div class="form-group form-group-feedback form-group-feedback-right">
                                    <input ng-required="bookOccupant.Over18 == 1 && bookOccupant.d_typ == 1" ng-keydown="$event.keyCode === 13 && occupant_form.occupantCNIC.$valid && findOccupant()" aria-invalid="true" name="occupantCNIC"  ng-model="bookOccupant.CNIC" type="text" placeholder="42101-099099-152" class="form-control cnic" pattern="[\d]{5}-[\d]{7}-[\d]{1}">
                                    <div class="form-control-feedback form-control-feedback-lg">
                                            <i class="icon-enter5 text-grey-300" style="cursor:pointer;"></i>
                                    </div>
                                    <div ng-messages="occupant_form.occupantCNIC.$error" ng-if="occupant_form.occupantCNIC.$touched || occupant_form.$submitted">
                                        <div class="text-danger" ng-message="required">CNIC is required</div>
                                        <div class="text-danger" ng-message="pattern">CNIC is not valid (e.g., 42201-6562366-3)</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 Passport_required" style="display: none">
                                <label class="col-form-label">Passport <span class="text-danger">*</span></label>
                                <div class="form-group form-group-feedback form-group-feedback-right">
                                    <input ng-required="bookOccupant.Over18 == 1 && bookOccupant.d_typ == 2" aria-invalid="true" name="occupantPassport"  ng-model="bookOccupant.Passport" type="text" placeholder="PK123456789" class="form-control alpha_numeric" maxlength="11">
                                    <div ng-messages="occupant_form.occupantPassport.$error" ng-if="occupant_form.occupantPassport.$touched || occupant_form.$submitted">
                                        <div class="text-danger" ng-message="required">Passport# is required</div>
                                        {{-- <div class="text-danger" ng-message="pattern">Passport# is not valid (e.g., PK123456789)</div> --}}
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2">   
                                <label class="col-lg-6 col-form-label">Over 18</label>
                                <md-switch ng-change="changeOver18()" ng-model="bookOccupant.Over18" ng-true-value="1" ng-false-value="0" style="display:block"></md-switch>
                            </div>
                        </div>
                    </fieldset>  
                     
                    <div class="card mt-4">
                        <div class="row m-0">
                            <div class="col-md-12 mt-2" ng-show="bulk_edit_occupants">
                                <h4>Occupants</h4>
                            </div>
                            <div class="col-md-4" ng-repeat="occupant in nBooking.booking_occupants" ng-show="bulk_edit_occupants">
                                <div class="card bulk_occupant-card">
                                    <div class="card-body">
                                        <div class="occupant-basic">
                                            <h3 class="mb-0">[[occupant.FirstName]] [[occupant.LastName]]
                                            <span class="float-right mt-2" style="font-size: 13px"> 
                                                <small>
                                                    <a class="list-icons-item" title="Edit Occupant" ng-click="showOccupantsModalEdit(occupant, false)"><i class="icon-pencil6"></i></a>
                                                    <a class="list-icons-item" title="Remove Occupant" ng-click="removeOccupant(occupant)"><i class="icon-cross2"></i></a>
                                                </small>
                                                </span>
                                            </h3>
                                        </div>
                                        <div class="col-md-12 px-0">
                                            <div class="occupant-cnic" ng-if="occupant.CNIC && occupant.CNIC.length > 0">
                                                <span class="mb-0"><strong>CNIC:</strong>[[occupant.CNIC]]</span>
                                            </div>
                                            <div class="occupant-cnic" ng-if="occupant.Passport && occupant.Passport.length > 0">
                                                <span class="mb-0"><strong>Passport:</strong>[[occupant.Passport]]</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> 
                        </div>
                    </div>

                       
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="showOccupants()" class="btn btn-success"><i class=" icon-floppy-disk mr-2"></i>[[!bulk_edit_occupants && occu_form_type=='edit'?'Update':'Confirm']]</button>
                     <button type="button" ng-click="addMoreOccupants()" class="btn btn-info"><i class="icon-plus22 mr-2"></i>Add</button>
                </div>
            </form>
		</div>
	</div>
</div>