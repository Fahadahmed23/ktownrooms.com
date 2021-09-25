
<div id="vendorFormSec" class="card admin-form-section" style="display:none;">
	<div class="card-header header-elements-inline">
		<h5 class="card-title ng-binding">Create Vendor</h5>
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
				<div class="col-md-12">
					<fieldset>
							<div class="form-group row">		
								<div class="col-md-12">
									<label class="col-form-label font-w-500 txt-unln">1. Add Profile information:</label>
								</div>

								<div class="col-lg-6">
									<label class="col-form-label">Name <span class="required">*</span></label>
									<input name="name" ng-model="vendor.Name" type="text" placeholder="John" class="form-control alphabets" aria-invalid="true" required>
									<div ng-messages="myForm.name.$error" ng-if="myForm.name.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Name is required</div>
									</div>
								</div>
								<div class="col-lg-6">
									<label class="col-form-label">Address <span class="required">*</span></label>
									<textarea name="address" ng-model="vendor.Address" class="form-control px-2" rows="1" placeholder="Address" required></textarea>

									{{-- <input name="address" ng-model="vendor.address" type="text" placeholder="Doe" class="form-control alphabets" aria-invalid="true" required> --}}
									<div ng-messages="myForm.address.$error" ng-if="myForm.address.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Address is required</div>
									</div>
								</div>

								<div class="col-lg-6">
									<label class="col-form-label">Email <span class="required">*</span></label>
									<input name="email" ng-model="vendor.Email" type="email" placeholder="email@example.com" class="form-control" aria-invalid="true" required>
									<div ng-messages="myForm.email.$error" ng-if="myForm.email.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Email is required</div>
										<div class="text-danger" ng-message="email">Please enter a valid email (e.g., abc@def.com)</div>
									</div>
                                </div>
                                <div class="col-lg-6">
                                        <label class="col-form-label">Phone <span class="required">*</span></label>
										<input name="phone_no" pattern="03[\d]{2}-[\d]{7}" ng-model="vendor.Phone" type="text" placeholder="0300-1234567" class="form-control phone_us" aria-invalid="true" required>
										<div ng-messages="myForm.phone_no.$error" ng-if="myForm.phone_no.$touched || myForm.$submitted">
											<div class="text-danger" ng-message="required">Phone Number is requried</div>
											<div class="text-danger" ng-message="pattern">Please enter valid Phone Number (e.g., 0323-8228708)</div>
										</div>
								</div>
							</div>
					</fieldset>
				</div>
			</div>
			<div class="text-right">
				<button ng-click="saveVendor()" type="button" class="btn btn-success "><i class="icon-floppy-disk mr-2"></i> [[formType=='save'?'Add':'Update']] Vendor </button>
				<button type="button" ng-click="hideCreate()" class="btn btn-danger"><i class="icon-close2 mr-2"></i> Cancel</button>
			</div>
		</form>
		<form action="saveProfilePicture" method="post" enctype="multipart/form-data" id="logo-form" onsubmit="return false;"></form>

	</div>
	
</div>