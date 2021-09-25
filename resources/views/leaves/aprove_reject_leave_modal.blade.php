<style>
.md-select-menu-container,
    md-backdrop {
        z-index: 999999 !important;
    }
</style>
<div id="AprveRejctModal" class="modal fade" tabindex="-1" data-backdrop="static" data-keyboard="false">
	<div class="modal-dialog modal-sm modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header p-2 border-bottom">
				<h5 class="modal-title">Aprrove or Reject Leave </h5>
				<button type="button" class="close" ng-click="hideApproveRejectModal()">&times;</button>
			</div>
            
            <form name="leaveForm" id="leaveForm">
                <div class="modal-body">
                    <div class="row">
                        <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom px-2 py-1 bg-light mb-2">
                            <i class="icon-user mr-2 text-success"></i>
                            User Information
                        </legend>
                        <div class="col-md-12">
                            <div class="user-details">
                                <div class="u-name">
                                   <span>User Name: </span> <strong>[[leave.user.name]]</strong>
                                </div>
                                <div class="u-department">
                                    <span>Department: </span> <strong>[[leave.user.department.Department]]</strong>
                                </div>

                                <div class="l-type">
                                    <span>Leave Type: </span> <span>[[leave.type]]</span>
                                 </div>


                                 <div class="l-from">
                                    <span>From: </span> <span>[[leave.LeaveRequestFrom ]]</span>
                                 </div>

                                 <div class="l-to">
                                    <span>To: </span> <span>[[leave.LeaveRequestTo]]</span>
                                 </div>

                                 <div class="l-to">
                                    <span>Reason: </span> <span>[[leave.reason]]</span>
                                 </div>

                                 <hr>
                                 <div ng-if="approved" class="last-leave-approved mb-2">
                                    <strong>Last approved leave: </strong> 
                                    <div>
                                        <span>From: </span> <span>[[approved.LeaveRequestFrom]]</span>
                                        <span>To: </span> <span>[[approved.LeaveRequestTo]]</span>
                                    </div>
                                 </div>
                            </div>
                        </div>

                    </div>
                   


                    <div class="row">
                        <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom px-2 py-1 bg-light mb-2 mt-2">
                            <i class="icon-user-check mr-2 text-success"></i>
                            Leave Status
                        </legend>
                    
                        <div class="col-md-12 text-right">
                            <button class="btn btn-success" ng-click="approveRejectLeave(leave.id , 'approved')">Approve <i class="icon-checkmark2 ml-1"></i></button>
                            <button class="btn btn-danger" ng-click="approveRejectLeave(leave.id , 'rejected')">Reject <i class="icon-cross3 ml-1"></i></button>
                        </div>
                        {{-- <div class="col-md-12">
                            <label class="col-form-label">Status<span class="text-danger" >*</span></label>
                                <input type="hidden" ng-value="leave.id" ng-model="leave.id">
                                <md-select ng-change="getLeaveStatus(leave.status)" name="status" md-no-asterisk required class="m-0" ng-model="leave.status" placeholder="Approve or Reject">
                                    <md-option ng-repeat="ls in statuses" ng-value="ls">[[ls]]</md-option>
                                </md-select>
                                <div ng-messages="leaveForm.status.$error" ng-if='leaveForm.status.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                    <div class="text-danger" ng-message="required">please select leave status</div>
                                </div>
                        </div>

                        <div class="col-md-12" ng-if="leave.status == 'rejected'">
                            <label class="col-form-label">Reason<span class="text-danger" >*</span></label>
                            <textarea ng-required="leave.status == 'rejected'" name="rejected_reason" id="" ng-model="leave.rejected_reason" class="form-control"></textarea>
                            <div ng-messages="leaveForm.rejected_reason.$error" ng-if='leaveForm.rejected_reason.$touched || leaveForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Reason is Required</div>
                            </div>
                        </div> --}}
                    </div>    
                </div>
                {{-- <div class="modal-footer">
                    <div class="row">
                        <div class="col-md-12 text-right">
                            <small><button type="button" ng-click="approveRejectLeave()" class="btn btn-success btn-sm mt-3">[[leave.status=='rejected'?'Reject':'Approve']]<i class="icon-redo2 ml-1"></i></button></small>
                        </div>
                    </div>
                </div>   --}}
            </form>    
		</div>
	</div>
</div>