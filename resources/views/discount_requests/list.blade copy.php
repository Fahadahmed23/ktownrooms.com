<div class="row">
    <div class="col-lg-6" dir-paginate="complain in complains | itemsPerPage:perPage" current-page="currentPage" total-items="TotalRecords" pagination-id="complainPagination" ng-cloak>
    <!-- <div class="col-lg-6" ng-cloak ng-repeat="complain in complains"> -->
        <div class="card border-left-3 border-left-danger rounded-left-0">
            <div class="card-body">
                <div class="d-sm-flex align-item-sm-center flex-sm-nowrap">
                    <div>
                        <h6 class="font-weight-semibold">[[complain.customer.FirstName]] [[complain.customer.LastName]]</h6>
                        <ul class="list list-unstyled mb-0">
                            <li>Complain #: <a href="javascript:void(0)">[[complain.id]]</a></li>
                            <!-- <li>Issued on: <span class="font-weight-semibold">2021/01/25</span></li> -->
                        </ul>
                    </div>

                    <div class="text-sm-right mb-0 mt-3 mt-sm-0 ml-auto">
                        <h6 class="font-weight-semibold">[[complain.room.room_title]]</h6>
                        <ul class="list list-unstyled mb-0">
                            <li>Subject: <span class="font-weight-semibold">[[complain.subject]]</span></li>
                            <li class="dropdown">
                                Status: &nbsp;
                                <span class="badge [[complain.status.style_class]] align-top">[[complain.status.ComplainStatus]]</span>
                            </li>
                        </ul>
                    </div>
                </div>
                <p class="mb-0"><strong>Message: </strong>[[complain.message]]</p>
            </div>


            <div class="card-footer d-sm-flex justify-content-sm-between align-items-sm-center">
                <span>
                    <span class="badge badge-mark border-danger mr-2"></span>
                    Due:
                    <span class="font-weight-semibold">[[complain.ResolveTime]]</span>
                </span>

                <ul class="list-inline list-inline-condensed mb-0 mt-2 mt-sm-0">
                    <li class="list-inline-item">
                        <a href="#" class="text-default" data-toggle="modal" data-target="#invoice"><i class="icon-eye8"></i></a>
                    </li>
                    <li class="list-inline-item dropdown">
                        <a href="#" class="text-default dropdown-toggle" data-toggle="dropdown"><i class="icon-menu7"></i>Assign Department</a>

                        <div class="dropdown-menu dropdown-menu-right">
                            <a ng-repeat="department in departments" href="javascript:void(0)" class="dropdown-item"></i>[[department.Department]]</a>
                        </div>
                    </li>
                    <li class="list-inline-item">
                        Priority: &nbsp;
                        <a href="#" class="badge bg-danger-400 align-top dropdown-toggle" data-toggle="dropdown">High</a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a ng-repeat="priority in priorities" href="javascript:void(0)" class="dropdown-item"></i>[[priority.TaskPriority]]</a>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    <!-- </div> -->
    </div>
</div>
<dir-pagination-controls pagination-id="complainPagination" on-page-change="pageChanged(newPageNumber)" direction-links="true" boundary-links="true"></dir-pagination-controls>