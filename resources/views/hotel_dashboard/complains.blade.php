<div class="card p-3">
    <div class="row">

        <div class="card col-12">
            <div class="card-header header-elements-sm-inline">
                <h6 class="card-title">Complains</h6>
                {{-- <div class="header-elements">
                    <a class="text-body daterange-ranges font-weight-semibold cursor-pointer dropdown-toggle">
                        <i class="icon-calendar3 mr-2"></i>
                        <span>July 11 - August 9</span>
                    </a>
                </div> --}}
            </div>

            <div class="card-body d-lg-flex align-items-lg-center justify-content-lg-between flex-lg-wrap">
                <div class="d-flex align-items-center mb-3 mb-lg-0">
                    <a href="#" class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">
                        <i class="icon-alarm-add"></i>
                    </a>
                    <div class="ml-3">
                        <h5 class="font-weight-semibold mb-0">[[records.complain_count]]</h5>
                        <span class="text-muted">Total complains</span>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3 mb-lg-0">
                    <a href="#" class="btn bg-transparent border-primary text-primary rounded-pill border-2 btn-icon">
                        <i class="icon-circle-small"></i>
                    </a>
                    <div class="ml-3">
                        <h5 class="font-weight-semibold mb-0">[[records.open_complain_count]]</h5>
                        <span class="text-muted">Open complains</span>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3 mb-lg-0">
                    <a href="#" class="btn bg-transparent border-success text-success rounded-pill border-2 btn-icon">
                        <i class="icon-checkmark3"></i>
                    </a>
                    <div class="ml-3">
                        <h5 class="font-weight-semibold mb-0">[[records.resolved_complain_count]]</h5>
                        <span class="text-muted">Resolved complains</span>
                    </div>
                </div>

                <div class="d-flex align-items-center mb-3 mb-lg-0">
                    <a href="#" class="btn bg-transparent border-danger text-danger rounded-pill border-2 btn-icon">
                        <i class="icon-cross3"></i>
                    </a>
                    <div class="ml-3">
                        <h5 class="font-weight-semibold mb-0">[[records.closed_complain_count]]</h5>
                        <span class="text-muted">Closed complains</span>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table text-nowrap">
                    <thead>
                        <tr>
                            <th style="width: 50px">Due</th>
                            <th style="width: 300px;">User</th>
                            <th>Complain</th>
                            {{-- <th>Action</th> --}}
                            {{-- <th class="text-center" style="width: 20px;"><i class="icon-arrow-down12"></i></th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        <tr class="table-active table-border-double">
                            <td colspan="2">Today's Open complains</td>
                            <td class="text-right">
                                <span class="badge badge-primary badge-pill">
                                    <a href="/complains" class="text-white ml-auto">
                                        View all</a>
                                </span>
                            </td>
                        </tr>

                        <tr ng-repeat="open_complain in open_complains">
                            <td class="text-center">
                                <h6 class="mb-0">[[open_complain.CalculateHoursAgo]]</h6>
                                <div class="font-size-sm text-muted line-height-1">Hours</div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{-- <div class="mr-3">
                                        <a href="#" class="btn btn-teal rounded-pill btn-icon btn-sm">
                                            <span class="letter-icon">A</span>
                                        </a>
                                    </div> --}}
                                    <div>
                                        <span
                                            class="text-body font-weight-semibold letter-icon-title">[[open_complain.customer.FirstName]]
                                            [[open_complain.customer.LastName]]</span>
                                        <div class="text-muted font-size-sm"><span
                                                class="badge badge-mark border-primary mr-1"></span> Open</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="font-weight-semibold">[#[[open_complain.complain_code]]]
                                    [[open_complain.subject]]
                                </div>
                                <span class="text-muted">[[open_complain.message]]</span>
                            </td>
                            {{-- <td class="text-center">
                                <div class="list-icons">
                                    <div class="dropdown">
                                        <a href="#" class="list-icons-item" data-toggle="dropdown"><i
                                                class="icon-menu7"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                            <a href="#" class="dropdown-item"><i class="icon-undo"></i> Quick reply</a>
                                            <a href="#" class="dropdown-item"><i class="icon-history"></i> Full
                                                history</a>
                                            <div class="dropdown-divider"></div>
                                            <a href="#" class="dropdown-item"><i
                                                    class="icon-checkmark3 text-success"></i> Resolve issue</a>
                                            <a href="#" class="dropdown-item"><i class="icon-cross2 text-danger"></i>
                                                Close issue</a>
                                        </div>
                                    </div>
                                </div>
                            </td> --}}
                        </tr>
                        <tr ng-if="open_complains.length == 0">
                            <td colspan="3">No complains for today</td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <div class="row d-none">
        <div ng-repeat="service in records.services" class="col-md-3">
            <div class="mb-3">
                <h3><i class="[[service.IconPath]]" style="font-size:18px;"></i> [[service.Service]]<span></span></h3>
                <div class="row row-tile no-gutters">
                    <div class="col-6 ">
                        <button type="button" class="btn bg-success-400 btn-block btn-float m-0 legitRipple">
                            {{-- <i class="[[service.IconPath]]"></i> --}}
                            <i class="icon-cup2 icon-2x"></i>
                            <span class="text-light">Total Tasks</span>
                            <h2>150</h2>
                        </button>
                    </div>

                    <div class="col-6">
                        <button type="button" class="btn bg-white btn-block btn-float m-0 legitRipple">
                            <i class="icon-hour-glass3 text-pink-400 icon-2x"></i>
                            <span>Pending Tasks</span>
                            <h2>15</h2>
                        </button>
                    </div>
                </div>
            </div>
        </div>

    </div>


</div>