<div class="card">
    <div class="card-header bg-white header-elements-inline">
        <h5 class="card-title"><i class="icon-cog mr-2"></i>Default Settings</h5>
        <div class="header-elements">
            <div class="list-icons">
            </div>
        </div>
    </div>

    <div class="card-body">


        <form name="myForm">

            @include('layouts.form_messages')

            <div class="row">

                <div class="col-md-10">
                    <fieldset>


                        <div class="form-group row">
                            <div class="col-md-6">
                                <div class="row form-group">
                                    <div class="col-md-12">
                                        <label class="col-form-label font-w-500 txt-unln">1. Contact Information:</label>
                                    </div>



                                    <div class="col-md-6">
                                        <label class="col-form-label">Title</label>
                                        <input required name="title" type="text" ng-model="defaultSettingsForm.name" class="form-control">

                                        <div ng-messages="myForm.title.$error" ng-if='myForm.title.$touched || myForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Title is required</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 form-group row">
                                        <label class="col-lg-12 col-form-label">Logo</label>
                                        <div class="col-lg-6">
                                            <div class="wrapper prof-wrap">
                                                <img style="border-radius:0px;object-fit: contain;" id="preview" class="output_image" src="[[ defaultSettingsForm.picture!=null ? defaultSettingsForm.picture : 'https://pesmcopt.com/admin-media/images/default-logo.png' ]]">
                                                <div class="custom-file">
                                                    <input name="logo" type="file" class="custom-file-input logo member" form="logo-form">
                                                    <label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="btns-div">
                                                <button ng-show="!defaultSettingsForm.picture" name="member" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
                                                <button ng-show="defaultSettingsForm.picture" id="remove-logo" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture('logo')"><i class="icon-cancel-circle2"></i> Remove</button>
                                            </div>
                                        </div>
                                    </div>
 
                                    <div class="col-md-6">
                                        <label class="col-form-label">Email</label>
                                        <input required type="email" name="email" ng-model="defaultSettingsForm.email" class="form-control">
                                        <div ng-messages="myForm.email.$error" ng-if='myForm.email.$touched || myForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Email is required</div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">Phone</label>
                                        <input required name="phone" type="text" ng-model="defaultSettingsForm.phone" class="form-control phone_us">
                                        <div ng-messages="myForm.phone.$error" ng-if='myForm.phone.$touched || myForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Phone is required</div>
                                        </div>
                                    </div> 

                                    <div class="col-md-6">
                                        <label class="col-form-label">Address</label>
                                        <input required name="address" type="text" ng-model="defaultSettingsForm.address" class="form-control">

                                        <div ng-messages="myForm.address.$error" ng-if='myForm.address.$touched || myForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Address is required</div>
                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">Website</label>
                                        <input required name="website" type="text" ng-model="defaultSettingsForm.website" class="form-control">

                                        <div  ng-messages="myForm.website.$error" ng-if='myForm.website.$touched || myForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Website is required</div>
                                        </div>
                                    </div> 
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="col-form-label font-w-500 txt-unln">
                                            2. Default Operating Hours:
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">CheckIn Time</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-alarm"></i></span>
                                            </span>
                                            <input onchange="disableEndTime()" id="opening-time" ng-model="defaultSettingsForm.checkin_time" type="text" class="form-control pickatime" placeholder="Opening Time">

                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">CheckOut Time</label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-alarm"></i></span>
                                            </span>
                                            <input ng-model="defaultSettingsForm.checkout_time" type="text" class="form-control pickatime-disabled" placeholder="Closing Time">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <label class="col-form-label font-w-500 txt-unln">
                                            3. Sms Setup:
                                            {{-- <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="Set default visit fee of museum here" aria-describedby="tooltip696410">
                                                <i class="icon-help top-0"></i>
                                            </a> --}} 
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">Confirm Message</label>
                                        <div class="input-group">
                                            <div id="summernote_confirm" class="confirm"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">Cancel Message</label>
                                        <div class="input-group"> 
                                            <div id="summernote_cancel" class="cancel" ></div>
                                            {{-- <textarea class="form-control border-textarea" ng-model="defaultSettingsForm.cancel_message" id="cancel_message"></textarea> --}}
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">Amendment Message</label>
                                        <div class="input-group"> 
                                            <div id="summernote_amendment" class="amendment"></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-md-4">
                                        <label class="col-form-label">CheckIn Message</label>
                                        <div class="input-group"> 
                                            <div id="summernote_checkin" class="checkin"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">CheckOut Message</label>
                                        <div class="input-group"> 
                                            <div id="summernote_checkout" class="checkout"></div>
                                        </div>
                                    </div> 

                                </div>
                            </div>
  
                        </div>

                     
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 ">
                                        <label class="col-form-label font-w-500 txt-unln">
                                            3. Reminder Sms Setup:
                                            {{-- <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="Set default visit fee of museum here" aria-describedby="tooltip696410">
                                                <i class="icon-help top-0"></i>
                                            </a> --}} 
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="col-form-label">Reminder Message</label>
                                        <div class="input-group">
                                            <div id="summernote_reminder" class="reminder"></div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="col-form-label">Remind Before <small>(in days)</small></label>
                                        <input name="reminder_before" type="text" ng-model="defaultSettingsForm.reminder_before" placeholder="1" class="form-control num3">

                                        <div  ng-messages="myForm.reminder_before.$error" ng-if='myForm.reminder_before.$touched || myForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Reminder Before is required</div>
                                        </div>
                                    </div> 
                                    
                                </div>
                                    
                            </div>
  
                        </div>


                    </fieldset>
                </div>
                <div class="col-md-2">
                    <fieldset>
                        <legend class="font-weight-semibold"><i class="icon-link2 mr-2"></i> Keys Setup</legend>
                        <span ng-if="defaultSettingsKey.key_exist" style="float: right;" ng-click="editKeys()"> <i class="icon-pencil5 mr-2"></i> </span>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <div class="row form-group"> 

                                    <div class="col-md-12">
                                        <label class="col-form-label">Client Key</label>
                                        <input type="text" ng-model="defaultSettingsKey.client_key" class="form-control">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="col-form-label">Secret Key</label>
                                        <input type="text" ng-model="defaultSettingsKey.secret_key" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="form-group row" ng-if="!defaultSettingsKey.key_exist">
                            <div class="col-md-12">
                                <div class="text-right">
                                    <button type="button" ng-click="saveDefaultKeys()" class="btn btn-dark">Add Keys <i class="icon-floppy-disk ml-2"></i></button>
                                </div>
                            </div>
                        </div>
                    </fieldset>
                </div>

                

            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="text-right">
                        <button type="button" ng-click="saveDefaultSetting()" class="btn btn-primary">Save <i class="icon-floppy-disk ml-2"></i></button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Insert Token Template -->
<div class="modal fade" id="InsertTokenModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-sm" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Insert Token</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
            <input type="hidden" name="module" id="module" value="">
			<div class="modal-body" id="ListOfTokens">
				<p>Click on the token to insert it</p>
				{{-- <input type="text" id="tokenSearcher" placeholder="Search tokens (start typing)" class="form-control"> --}}
				<ul id="tokenList"> 
					<li><a href="javascript:return;" ng-click="insertToken('<<name>>')">Default Title</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<email>>')">Default Email</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<phone>>')">Default Phone</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<checkin_time>>')">CheckIn Time</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<checkeout_time>>')">CheckOut Time</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<hotel_name>>')">Hotel Name</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<hotel_code>>')">Hotel Code</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<hotel_latitude>>')">Hotel Latitude</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<hotel_longitude>>')">Hotel Longitude</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<customer_name>>')">Customer Name</a></li>
					<li><a href="javascript:return;" ng-click="insertToken('<<booking_no>>')">Booking No</a></li>
					<li class="portal_link"><a href="javascript:return;" ng-click="insertToken('<<portal_link>>')">Portal Link</a></li> 
				</ul>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
    

</script>
