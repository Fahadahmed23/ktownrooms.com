
<div id="mappingFormSec" class="card admin-form-section" style="display:none;">
	<div class="card-header header-elements-inline">
		<h5 class="card-title ng-binding">Create Booking Mapping</h5>
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
									<label class="col-form-label">Client <span class="required">*</span></label>
									<md-select md-no-asterisk required name="client" id="client"  aria-invalid="true" class="m-0" ng-model="mapping.client">  
										<md-option value=" " selected>Select your Client</md-option>  
										<md-option value="Ktown"> Ktown</md-option>  
								   </md-select> 
									<div ng-messages="myForm.client.$error" ng-if="myForm.client.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Client is required</div>
									</div>
								</div>
								<div class="col-lg-6">
									<label class="col-form-label">Type <span class="required">*</span></label>
									<md-select md-no-asterisk asterisk required name="type" id="type"  aria-invalid="true" class="m-0" ng-model="mapping.type" ng-change="getDestination()">  
										<md-option value=" " selected="true">Select your Type</md-option>  
										<md-option value="hotel"> Hotel</md-option>  
										<md-option value="roomcategory"> Room Category</md-option>  
								   </md-select> 
									<div ng-messages="myForm.type.$error" ng-if="myForm.type.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Type is required</div>
									</div>
								</div>
								<div class="col-lg-6">
									<label class="col-form-label">Source <span class="required">*</span></label>
									<input ng-model="mapping.source" required name="source" id="source" type="text" placeholder="Enter your source" class="form-control" aria-invalid="true">
									<div ng-messages="myForm.source.$error" ng-if="myForm.source.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Source is required</div>
									</div>
								</div>
								<div class="col-lg-6" id="des-div" style="display: none">
									<label class="col-form-label">Destination <span class="required">*</span></label>
									
								   	<md-select md-no-asterisk required aria-invalid="true" name="destination" id="destination" class="m-0" ng-model="mapping.destination" placeholder="Select your destination" required>
										<md-option ng-repeat="destination in destinations" ng-value="destination.id">[[destination.name]]</md-option>
									</md-select>
									<div ng-messages="myForm.destination.$error" ng-if="myForm.destination.$touched || myForm.$submitted">
										<div class="text-danger" ng-message="required">Destination is required</div>
									</div>
								</div>
								
							</div>
					</fieldset>
				</div>
			</div>
			<div class="text-right">
				<button ng-click="saveBookingMapping()" type="button" class="btn btn-success "><i class="icon-floppy-disk mr-2"></i> [[formType=='save'?'Add':'Update']] Mapping </button>
				<button type="button" ng-click="hideCreate()" class="btn btn-danger"><i class="icon-close2 mr-2"></i> Cancel</button>
			</div>
		</form>
		<form action="saveProfilePicture" method="post" enctype="multipart/form-data" id="logo-form" onsubmit="return false;"></form>

	</div>
	
</div>