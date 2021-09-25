<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="channelModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header p-2 border-bottom bg-light">
				<h5 class="modal-title">Add Channel</h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="ChannelForm" name="ChannelForm">
				<div class="modal-body">
						<div class="form-group row">	
                                <div class="col-lg-4">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input required name="Channel" ng-model="channel.Channel" type="text" placeholder="Third Party" class="form-control alphabets" maxlength="25">
                                    <div ng-messages="ChannelForm.Channel.$error" ng-if='ChannelForm.Channel.$touched || ChannelForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Channel Title is required</div>
                                    </div>
                                
                                </div>
                                <div class="col-lg-4">
                                    <label class="col-form-label">Is Show Property Level </label>
                                    <md-switch ng-value="1" ng-model="channel.isShowPropertyLevel" ng-true-value="'1'" ng-false-value="0" style="display:block"></md-switch>
                                </div>

                                <div class="col-lg-4">
                                    <label class="col-form-label">Additional Info
                                        <span data-popup="popover" title="" data-trigger="hover" data-html="true"
                                            data-content="If Checked!  Booking Agent Name & phone is required at tme of booking"
                                            data-original-title="">
                                            <i class="fa fa-info-circle"></i>
                                        </span>
                                    </label>
                                    <md-switch ng-value="1" ng-model="channel.additionalInfo" ng-true-value="'1'" ng-false-value="'0'" style="display:block"></md-switch>
                                    
                                </div>
                            
                        </div>
				</div>
				<div class="modal-footer p-2 bg-light">
					 <button type="button" ng-click="saveChannel()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[channel.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>