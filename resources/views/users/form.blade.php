
<div id="userFormSec" class="card admin-form-section" style="display:none;">
	<div class="card-header header-elements-inline">
		<h5 class="card-title ng-binding">Create User</h5>
		<div class="header-elements">
			<div class="list-icons">
				<a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="hideCreate()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>

	<div class="card-body">
		@include('layouts.form_messages')
        <form class="" confirm-on-exit name="myForm" method="POST" >
			<div class="row">
				<div class="col-md-6">
					<fieldset>
							<div class="form-group row">		
								<div class="col-md-12">
									<label class="col-form-label font-w-500 txt-unln">1. Add Profile information:</label>
								</div>
								<div class="col-lg-12">
									<div class="row">
										<label class="col-lg-3 col-form-label">Profile Picture</label>
										<div class="col-lg-3">
											<div class="wrapper prof-wrap">
												<img id="preview" class="output_image" ng-src="[[ user.picture!=null ? user.picture : 'https://pwcenter.org/sites/default/files/default_images/default_profile.png' ]]">
												<div class="custom-file">
													<input name="logo" type="file" class="custom-file-input logo" form="logo-form">
													<label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
												</div>
											</div>
										</div>
										<div class="col-lg-6">
											<div class="btns-div">
												<button ng-hide="user.picture" name="user" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
												<button ng-show="user.picture" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture('user')"><i class="icon-cancel-circle2"></i> Remove</button>
											</div>
										</div>
									</div>
								</div>

								<div class="col-lg-6">
									<label class="col-form-label">First Name <span class="required">*</span></label>
									<input name="first_name" ng-model="user.first_name" type="text" placeholder="John" class="form-control alphabets" aria-invalid="true" required>
									<div ng-messages="myForm.first_name.$error" ng-if="myForm.first_name.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">First Name is required</div>
									</div>
								</div>
								<div class="col-lg-6">
									<label class="col-form-label">Last Name <span class="required">*</span></label>
									<input name="last_name" ng-model="user.last_name" type="text" placeholder="Doe" class="form-control alphabets" aria-invalid="true" required>
									<div ng-messages="myForm.last_name.$error" ng-if="myForm.last_name.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Last Name is required</div>
									</div>
								</div>

								<div class="col-lg-6">
									<label class="col-form-label">Email <span class="required">*</span></label>
									<input name="email" ng-model="user.email" type="email" placeholder="email@example.com" class="form-control" aria-invalid="true" required>
									<div ng-messages="myForm.email.$error" ng-if="myForm.email.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Email is required</div>
										<div class="text-danger" ng-message="email">Please enter a valid email (e.g., abc@def.com)</div>
									</div>
                                </div>
                                <div class="col-lg-6">
                                        <label class="col-form-label">Phone <span class="required">*</span></label>
										<input name="phone_no" pattern="03[\d]{2}-[\d]{7}" ng-model="user.phone_no" type="text" placeholder="0300-1234567" class="form-control phone_us" aria-invalid="true" required>
										<div ng-messages="myForm.phone_no.$error" ng-if="myForm.phone_no.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Phone Number is requried</div>
											<div class="text-danger" ng-message="pattern">Please enter valid Phone Number (e.g., 0323-8228708)</div>
										</div>
								</div>
							</div>
					</fieldset>
				</div>
				<div class="col-md-6">
					<fieldset>
							<div class="form-group row">
							
								<div class="col-lg-6">
									<label class="col-lg-6 col-form-label">Role <span class="text-danger">*</span></label>
									<md-select ng-change="changeRole()" name="user_role" md-no-asterisk required class="m-0" ng-model="user.roles[0]" placeholder="Select your Role">
										<md-option ng-repeat="role in roles" ng-value="role.id">[[role.display_name]]</md-option>
									</md-select>
									<div ng-messages="myForm.user_role.$error" ng-if="myForm.user_role.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Role is required</div>
									</div>
								</div>
								<div class="col-lg-6">
										<label class="col-lg-6 col-form-label">City <span class="text-danger">*</span></label>
									


										<md-select name="city" md-no-asterisk required class="m-0" ng-model="user.city_id" placeholder="Select your city">
											<md-option ng-repeat="city in cities" ng-value="city.id">[[city.CityName]]</md-option>
										</md-select>
										<div ng-messages="myForm.city.$error" ng-if="myForm.city.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">City is required</div>
										</div>
								</div>
								
								<div class="col-lg-6">
										<label class="col-lg-6 col-form-label">Hotel <span class="text-danger">*</span></label>
										<md-select  ng-if="multiple_hotels == '1'" multiple name="hotel" md-no-asterisk required class="m-0" ng-model="user.hotel_id" placeholder="Select your hotel">
											<md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
										</md-select>

										<md-select  ng-if="multiple_hotels == '0'"  name="hotel" md-no-asterisk required class="m-0" ng-model="user.hotel_id" placeholder="Select your hotel">
											<md-option ng-repeat="hotel in hotels | filter: {city_id:user.city_id}" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
										</md-select>

										<div ng-messages="myForm.hotel.$error" ng-if="myForm.hotel.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Hotel is required</div>
										</div>
								</div>

								<div class="col-lg-3">
									<label class="col-lg-6 col-form-label">Department </label>
									<md-select ng-disabled="user.all_department == '1'" name="department" md-no-asterisk class="m-0" ng-model="user.department_id" placeholder="[[user.all_department=='1'?'All Departments':'Select Department']]">
										<md-option ng-repeat="department in departments" ng-value="department.id">[[department.Department]]</md-option>
									</md-select>
								</div>
								<div class="col-lg-3 mt-3">
									<md-switch ng-true-value="'1'" ng-false-value="'0'" ng-model="user.all_department" style="display:inline">All Department</md-switch>
								</div>

								{{-- <div class="col-lg-6">
									<label class="col-lg-6 col-form-label">Role <span class="text-danger">*</span></label>
									<md-select ng-change="changeRole()" name="user_role" md-no-asterisk required class="m-0" ng-model="user.roles[0]" placeholder="Select your Role">
										<md-option ng-repeat="role in roles" ng-value="role.id">[[role.display_name]]</md-option>
									</md-select>
									<div ng-messages="myForm.user_role.$error" ng-if="myForm.user_role.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Role is required</div>
									</div>
								</div>	 --}}
								<div class="col-lg-6" ng-if="discount_priviledge == '1'">
									<label class="col-lg-6 col-form-label">Maximum Discount Allowed <span class="text-danger">*</span></label>
									<input data-type="currency" currency class="form-control" ng-model="user.max_allowed_discount" name="discount" ng-required="discount_priviledge == '1'">
									<div ng-messages="myForm.discount.$error" ng-if="myForm.discount.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Maximum Allowed Discount is required</div>
									</div>
								</div>	
								<!-- <div class="col-lg-6">
									<label class="col-lg-6 col-form-label">Designation</label>
									<md-select name="designation" md-no-asterisk required class="m-0" ng-model="user.designation_id" placeholder="Select your Designation">
										<md-option ng-repeat="designation in designations" ng-value="designation.id">[[designation.DesignationName]]</md-option>
									</md-select>
									<div ng-messages="myForm.designation.$error" ng-if="myForm.designation.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Designation is required</div>
									</div>
								</div>	 --> 
							</div>

							<div class="row form-group">
								<div class="col-md-12 mt-3">
									<!-- Address list -->
									<div class="card">
										<div class="card-header header-elements-inline">
											<h5 class="card-title">Addresses</h5>
											<div class="header-elements">
												<div class="list-icons">
													<a class="list-icons-item" ng-click="addAddress()"><i class="icon-plus2"></i></a>
													<a class="list-icons-item" data-action="collapse"></a>
												</div>
											</div>
										</div>
		
										<div class="card-body mx-2" style="">
												<ul id="mediaList" class="media-list">
													<div ng-repeat="address in user.addresses" class="PAddress">
														<li class="media m-0">
															<div class="media-body">
																<div class="media-title font-weight-semibold">[[address.type]] <span ng-if="address.primary == true" class="badge badge-info"><a>primary</a><span></div>
																<span class="text-muted">[[address.address]],[[address.city.CityName]],[[address.state.StateName]],[[address.zip]]</span>
															</div>
				
															<div class="align-self-center ml-3">
																<div class="list-icons list-icons-extended">
																	<a href="" class="list-icons-item" ng-click="editAddress(address)" title="Edit Address"><i class="icon-pencil6"></i></a>
																	<a href="" class="list-icons-item" data-popup="tooltip" title="" ng-click="removeAddress(address)" data-trigger="hover" data-original-title="Remove"><i class="icon-cross2"></i></a>
																</div>
															</div>
														</li>
													 </div>
												
												</ul>
										</div>
									</div>
									<!-- /Address list -->
								</div>
								<div class="col-md-6">

									<!-- <div id="style4" class="form-group scrollbar">
											<div class="card">
												<div class="card-header">
													<h6 class="card-title">Roles</h6>
												</div>
												<div style="height: 100px;overflow-y:auto;" class="card-body rolescheckbox">
													<md-checkbox style="display:block" ng-repeat="role in roles" value="role.id" ng-checked="user.roles.indexOf(role.id) > -1"
														ng-click="checkRole(role.id)">
														[[role.name]]
													</md-checkbox>
												</div>
											</div>
										
									</div> -->

									
									{{-- <div class="card">
										<div class="card-header header-elements-inline">
											<h5 class="card-title">Roles</h5>
										</div>

										<div style="height:200px;overflow-y:auto;" class="card-body">
											<ul class="media-list">
												<li ng-repeat="role in roles" class="media">
													<input type="checkbox" value="role.id" ng-checked="user.roles.indexOf(role.id) > -1"
													ng-click="checkRole(role.id)">
													<label style="padding-left: 5px">[[role.name]]</label>
												</li>
											</ul>
										</div>
									</div> --}}
								</div>
							
		
								<!-- ngIf: isMember || isDonor -->
							</div>


							
					</fieldset>
				</div>

				<div class="col-md-12">
					<fieldset>
						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<label class="col-form-label">Do You Have Experience?
									</label>
									<md-radio-group ng-change="changeExp()" ng-model="expType" type="text" layout="row">
										<md-radio-button ng-value="'Yes'" aria-label="Yes">
											Yes
										</md-radio-button>
										<md-radio-button ng-value="'No'" aria-label="No">
											No
										</md-radio-button>
									</md-radio-group>
								</div>
							</div>
							<div class="row my-4 experience" style="display: none;">	
									<div class="col-md-2 experience" style="display: none;">
										<label>How much Experience <span class="text-danger">*</span></label>
										<input ng-required="expType=='Yes'" name="noy" type="text" ng-model="user.experiences[0].no_of_years" class="form-control" placeholder="No. of years">
										<div ng-messages="myForm.noy.$error" ng-if="myForm.noy.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Experience is required</div>
										</div>
									</div>

									<div class="col-md-2 experience" style="display: none;">
										<label>Organization Name <span class="text-danger">*</span></label>
										<input ng-required="expType=='Yes'" name="organization_name" type="text" ng-model="user.experiences[0].organization_name" class="form-control" placeholder="Organization name">
										<div ng-messages="myForm.organization_name.$error" ng-if="myForm.organization_name.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Organization Name is required</div>
										</div>
									</div>

									<div class="col-md-2 experience" style="display: none;">
										<label>Your Role <span class="text-danger">*</span></label>
										<input ng-required="expType=='Yes'" name='role' type="text" ng-model="user.experiences[0].role" class="form-control" placeholder="Enter your role">
										<div ng-messages="myForm.role.$error" ng-if="myForm.role.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Role is required</div>
										</div>
									</div>
							</div>
						</div>


						<div class="form-group">
							<div class="row">
								<div class="col-lg-6">
									<label class="col-form-label">Reference
									</label>
									<md-radio-group ng-change="changeRef()" ng-model="refType" type="text" layout="row">
										<md-radio-button ng-value="'Yes'" aria-label="Yes">
											Yes
										</md-radio-button>
										<md-radio-button ng-value="'No'" aria-label="No">
											No
										</md-radio-button>
									</md-radio-group>
								</div>
							</div>
							<div class="row my-4">	
									<div class="col-md-2 reference" style="display: none;">
										<label class="col-form-label">Reference Name <span class="required">*</span></label>
										<input name="reference_name" ng-required="refType=='Yes'" ng-model="user.reference_name" type="text" class="form-control">
										<div ng-messages="myForm.reference_name.$error" ng-if="myForm.reference_name.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Reference Name is required</div>
										</div>
									</div>

									<div class="col-md-2 reference" style="display: none;">
										<label class="col-form-label">Department <span class="required">*</span></label>
										<input name="reference_department" ng-required="refType=='Yes'" ng-model="user.reference_department" type="text" class="form-control">
										<div ng-messages="myForm.reference_department.$error" ng-if="myForm.reference_department.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Department is required</div>
										</div>
									</div>

									<div class="col-md-2 reference" style="display: none;">
										<label class="col-form-label">Designation <span class="required">*</span></label>
										<input name="reference_designation" ng-required="refType=='Yes'" ng-model="user.reference_designation" type="text" class="form-control">
										<div ng-messages="myForm.reference_designation.$error" ng-if="myForm.reference_designation.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Designation is required</div>
										</div>
									</div>
							</div>
						</div>
						
					<fieldset>
				</div>
			</div>
			<div class="text-right">
				<button ng-click="saveUser()" type="button" class="btn btn-success "><i class="icon-floppy-disk mr-2"></i> [[formType=='save'?'Add':'Update']] User </button>
				<button type="button" ng-click="hideCreate()" class="btn btn-danger"><i class="icon-close2 mr-2"></i> Cancel</button>
			</div>
		</form>
		<form action="saveProfilePicture" method="post" enctype="multipart/form-data" id="logo-form" onsubmit="return false;"></form>

	</div>
	
</div>