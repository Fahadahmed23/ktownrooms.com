<style type="text/css">
    .md-select-menu-container, md-backdrop {
        z-index: 999999 !important;
    }
    .form-control[readonly] {
    border-bottom: 0;}
    span.input-group-text {
    padding: 0;
    }
    .input-group {
    border-bottom: 1px solid #eee;
    }
    span.input-group-prepend {
    margin-right: 0.25rem;
    }
    .form-group .input-group input {
    background:none;
    }


</style>
<div id="fiscalYearModal" class="modal fade" tabindex="-1">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Add Fiscal Year </h5>
				<button type="button" class="close" data-dismiss="modal">&times;</button>
			</div>

            <form id="fiscalYearForm" name="fiscalYearForm">
				<div class="modal-body">
						<div class="form-group row">	
                                                    
                                <div class="col-lg-6">
                                    <label class="col-form-label">Title <span class="text-danger">*</span></label>
                                    <input required name="title" ng-model="fiscalyear.title" type="text" placeholder="Current" class="form-control alphabets" maxlength="25">
                                
                                    <div ng-messages="fiscalYearForm.title.$error" ng-if='fiscalYearForm.title.$touched || fiscalYearForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">Title is required</div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <label class="col-form-label">Status</label>
                                    <md-select name="status" md-no-asterisk required class="m-0" ng-model="fiscalyear.status" placeholder="active">
                                        <md-option ng-repeat="status in statuses" ng-value="status">[[status]]</md-option>
                                    </md-select>
                                </div>

                                <div class="col-md-6 mt-3">
                                        <label class="col-form-label">Start Date <span class="text-danger">*</span></label>
                                        <div class="input-group">
                                            <span class="input-group-prepend">
                                                <span class="input-group-text"><i class="icon-calendar"></i></span>
                                            </span>
                                            <input ng-change="changeStartDate()"   type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="fiscalyear.start_date" id="startdate" class=" form-control pickadate startdate" required>
                                        </div>
                                        <div ng-messages="fiscalYearForm.start_date.$error" ng-if='fiscalYearForm.start_date.$touched || fiscalYearForm.$submitted' ng-cloak style="color:#e9322d;">
                                            <div class="text-danger" ng-message="required">Start Date is required</div>
                                        </div>
                                </div>

                                <div class="col-md-6 mt-3">
                                    <label class="col-form-label">End Date <span class="text-danger">*</span></label>
                                    <div class="input-group">
                                        <span class="input-group-prepend">
                                            <span class="input-group-text"><i class="icon-calendar"></i></span>
                                        </span>
                                        <input ng-change="changeEndDate()"   type="text" name="end_date" placeholder="MM/DD/YYYY" ng-model="fiscalyear.end_date" id="enddate" class=" form-control pickadate enddate" required>
                                    </div>
                                    <div ng-messages="fiscalYearForm.end_date.$error" ng-if='fiscalYearForm.end_date.$touched || fiscalYearForm.$submitted' ng-cloak style="color:#e9322d;">
                                        <div class="text-danger" ng-message="required">End Date is required</div>
                                    </div>
                                </div>

                                   
                                <div class="col-md-12 mt-3">   
                                    <label class="col-form-label">Description</label>
                                    <textarea name="description" ng-model="fiscalyear.description" class="form-control" placeholder="Enter Description"></textarea>
                                </div>
                            
                        </div>
				</div>
				<div class="modal-footer">
					 <button type="button" ng-click="saveFiscalYear()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i> [[fiscalyear.id?'Update':'Save']]</button>
                </div>
            </form>

		</div>
	</div>
</div>