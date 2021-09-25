<div id="taskDetail" class="col-md-4 pr-0 float-left task-info" style="display: none;">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h5 class="card-title">Task Details</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a ng-click="hidetaskDetail()" class="list-icons-item info-close"><i class="icon-cross ml-2"></i></a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <p class="mb-2"><strong>Room: [[taskdetail.room_title]]</strong></p>
                        <p class="mb-2"><strong>Department: </strong> <span class="ml-3">[[taskdetail.department]]</span></p>
                        <div class="list-group list-group-flush">
                            <p href="#" class="list-group-item list-group-item-action legitRipple">
                                <span class="font-weight-semibold mr-2">Service Title: </span>
                                [[taskdetail.service]]<span ng-class="getTaskStatus(taskdetail.status)" class="badge text-uppercase ml-auto">[[taskdetail.status]]</span>
                            </p>
                        </div>
                        <p class="font-weight-bold">Description:</p>
                        <p>[[taskdetail.description]]</p>
                    </div>
                </div>
</div>