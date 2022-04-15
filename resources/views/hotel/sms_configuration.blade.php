<style>

.border-textarea{
		border: 1px solid #ddd !important;
	}
	.col-form-label-bold{font-weight: 700}
	.font-w-500{font-weight:500}
	.txt-unln{text-decoration:underline}
	 .note-editor{
		width: 100%;
	}
	.note-editing-area{
		margin-top: 20px;
		padding: 5px;
	}
</style>
<div class="row m-0">
        <div class="col-md-12">
            <fieldset>   
                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 bg-light">
                    <span class="float-right">
                    <md-switch ng-change="useDefaultSmsCheck(use_default_messages)" ng-model="use_default_messages" ng-true-value="1" ng-false-value="0" style="float: right;" >
                        Use default messages all
                    </md-switch>
                    </span>
                </legend>

                <div ng-if="use_default_messages == 1" class="row">
                    <div class="col-md-4">
                        <strong>Confirm Message</strong>
                        <textarea readonly class="form-control" style="border:1px solid #eee !important;" ng-model="hotel_sms_config.confirm_message"></textarea>
                    </div>  

                    <div class="col-md-4">
                        <strong>Checkin Message</strong>
                        <textarea readonly class="form-control" style="border:1px solid #eee !important;" ng-model="hotel_sms_config.checkin_message"></textarea>
                    </div>

                    <div class="col-md-4">
                        <strong>Checkout Message</strong>
                        <textarea readonly class="form-control" style="border:1px solid #eee !important;" ng-model="hotel_sms_config.checkout_message"></textarea>
                    </div>
                </div>
                <div ng-if="use_default_messages == 1" class="row my-3">
                    <div class="col-md-4">
                        <strong>Cancelled Message</strong>
                        <textarea  readonly class="form-control" style="border:1px solid #eee !important;" ng-model="hotel_sms_config.cancel_message"></textarea>
                    </div>
                    <div class="col-md-4">
                        <strong>Amendment Message</strong>
                        <textarea readonly class="form-control" style="border:1px solid #eee !important;" ng-model="hotel_sms_config.amendment_message"></textarea>
                    </div>
                </div>   



                <div ng-if="use_default_messages == 0" class="form-group row">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="col-form-label-bold">Confirm Message</label>
                                    <div class="input-group">
                                        <div id="summernote_confirm" class="confirm"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label-bold">Cancel Message</label>
                                    <div class="input-group"> 
                                        <div id="summernote_cancel" class="cancel" ></div>
                                        {{-- <textarea class="form-control border-textarea" ng-model="defaultSettingsForm.cancel_message" id="cancel_message"></textarea> --}}
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label-bold">Amendment Message</label>
                                    <div class="input-group"> 
                                        <div id="summernote_amendment" class="amendment"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-4">
                                    <label class="col-form-label-bold">CheckIn Message</label>
                                    <div class="input-group"> 
                                        <div id="summernote_checkin" class="checkin"></div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="col-form-label-bold">CheckOut Message</label>
                                    <div class="input-group"> 
                                        <div id="summernote_checkout" class="checkout"></div>
                                    </div>
                                </div> 

                            </div>
                        </div>
                </div>
                 
            </fieldset>
        </div>
        <div class="col-md-12 text-right p-2">
            <button class="btn btn-success" ng-click="saveSmsConfiguration()">Save Sms Configuration</button>
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
          
