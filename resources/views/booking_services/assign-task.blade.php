<div id="assignTaskForm" class="col-md-4 pr-0 float-left task-assigning" style="display: none;">
    <div class="card">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Task Assigning</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="reload"></a>
                </div>
            </div>
        </div>

        <div class="card-body">
            <p class="mb-2"><strong>Room: [[assigntask.room_title]]</strong></p>
            <div class="row">         
            <form id="taskForm" class="row m-0" name="taskForm" >
                <div class="col-md-6 mt-4">
                    <label>Select Service</label>
                    <md-select required md-no-asterisk name="service_id" ng-model="task.service_id" class="m-0" placeholder="Select Service">
                        <md-option ng-repeat="service in assigntask.services" ng-value="service.id">[[service.Service]]</md-option>
                        <md-option value="Other">Other</md-option>
                    </md-select>

                    <div ng-messages="taskForm.service_id.$error" ng-if='taskForm.service_id.$touched || taskForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Service is required</div>
                    </div>
                </div>
                <div class="col-md-6 mt-4" ng-if="task.service_id == 'Other'">
                    <label>Other Service</label>
                    <input required type="text" name="other_service" class="form-control alphabets" maxlength="50" ng-model="task.other_service"  placeholder="Other">

                    <div ng-messages="taskForm.other_service.$error" ng-if='taskForm.other_service.$touched || taskForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Other Service is required</div>
                    </div>
                </div>

                <div class="col-md-12 mt-4">
                    <label class="col-form-label">Description </label>
                    <textarea required name="description" maxlength="255" ng-model="task.description" class="form-control" cols="30" rows="5" style="border: 1px solid #e0e0e0 !important;"></textarea>
                
                    <div ng-messages="taskForm.description.$error" ng-if='taskForm.description.$touched || taskForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Description is required</div>
                    </div>
                </div>

                <div class="col-md-6 my-3">
                    <label class="col-form-label">Job Performing Time</label>
                    <input required type="text" name="performing_time" class="form-control alphabets timepicker" maxlength="50" ng-model="task.performing_time"  placeholder="">
                    
                    <div ng-messages="taskForm.performing_time.$error" ng-if='taskForm.performing_time.$touched || taskForm.$submitted' ng-cloak style="color:#e9322d;">
                        <div class="text-danger" ng-message="required">Performing Time is required</div>
                    </div>
                </div>


                <div class=" col-md-12 text-right">
                    <button ng-click="hideassignTask()" id="cancel" type="button" class="btn btn-outline-danger cancel-task-asign legitRipple">Cancel <i class="icon-cross ml-2"></i></button>
                    <button type="button" ng-click="saveTask()" class="btn btn-primary UPD-rec legitRipple">Save Task <i class="icon-paperplane ml-2"></i></button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<script>
$('.timepicker').pickatime({
  formatSubmit: 'HH:i',
  hiddenName: true
})
</script>