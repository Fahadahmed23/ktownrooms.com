<div id="smsModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2 border-bottom">
				<h5 class="modal-title">Send message to [[fBooking.customer.FirstName]] [[fBooking.customer.LastName]]</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>
            <form id="sendMessageForm" name="sendMessageForm">
                    <div class="modal-body p-2">
                        <div class="form-group row">         
                            <label class="col-md-12 col-form-label"><span><b>Booking</b>:</span> 
                                <span><b>[[sms.booking_no]]</b> 
                                {{-- <i ng-click="getPortallink(fBooking.booking_code);" class="icon-unlink2 ml-1 cursor-pointer text-info" data-popup="popover" title="" data-trigger="hover" data-html="true" data-content="Copy Customer Portal Link" data-original-title=""></i> --}}
                                </span>
                            </label>
                        </div>
                        <div class="form-group row">         
                            <label class="col-md-3 col-form-label"><b>Phone</b>:</label>
                            <div class="col-md-9">
                                <div class="mt-2 customer_num_label">[[sms.customer_num]] <span ng-click="editNumCustomer()"  class="float-right cursor-pointer "><i class="icon-pencil mt-1" style="font-size: 12px"></i></span></div>
                                <input required type="tel" maxlength="12" name="customer_num" ng-model="sms.customer_num"  class="form-control customer_num_input phone_us" style="display: none;">        
                                <div ng-messages="sendMessageForm.customer_num.$error" ng-if='sendMessageForm.customer_num.$touched || sendMessageForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Phone no is required</div>
                                </div>                    
                            </div>
                        </div>

                        <div class="form-group row">         
                            <label class="col-md-3 col-form-label"><b>Message</b>:</label>
                            <div class="col-md-9">
                                <textarea required type="text" name="message" ng-model="sms.message"  class="" style="width:100%;border:1px solid #ddd;"></textarea>
                                <div ng-messages="sendMessageForm.message.$error" ng-if='sendMessageForm.message.$touched || sendMessageForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">Message is required</div>
                                </div>
                            </div>
                        </div>
                                    
                                            
                    </div>
                    <div class="modal-footer p-2 border-top text-right">
                            <small><button ng-click="sendSmS(sms)" class="btn btn-success btn-sm"> <i class="mi-send"></i> Send Sms to [[fBooking.customer.FirstName]] [[fBooking.customer.LastName]]</button></small>
                    </div>
            </form>
		</div>
	</div>
</div>
