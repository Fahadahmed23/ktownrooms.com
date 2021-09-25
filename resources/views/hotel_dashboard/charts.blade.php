<style>
    .budget-price {
        display: inline-block;
        width: 100%;
        display: flex;
        align-items: center;
        margin-bottom: 3px;
    }

    .budget-price .budget-price-square {
        width: 15px;
        height: 3px;
        background-color: #f9f9f9;
    }

    .budget-price .budget-price-label {
        font-size: 12px;
        font-weight: 600;
        margin-left: 5px;
    }

    .btn-sm .letter-icon {
        height: 1.375rem;
    }

    .letter-icon {
        width: 1rem;
        height: 1.375rem;
        display: block;
    }
</style>

<div class="card p-3">
    <div class="row col-12 p-2">
        <div class="col-4 d-flex">
            <div class="card card-body text-center col-md-12">
                <h6 class="font-weight-semibold mb-0 mt-1">Channel Bookings</h6>
                <canvas id="channelChart" width="400" height="400"></canvas>
            </div>
        </div>
        <div class="col-4 d-flex">
            <div class="card card-body text-center col-md-12">
                <h6 class="font-weight-semibold mb-0 mt-1">All Bookings</h6>
                <canvas id="allBookingChart" width="400" height="400"></canvas>
            </div>
        </div>
        <div class="col-4 d-flex">
            <div class="card gradient-bottom col-md-12">
                <div class="card-header d-flex p-0">
                    <div class="col-md-8">

                        <h4>Top 5 Customers</h4>
                    </div>
                    {{-- <div class="card-header-action dropdown col-md-4 text-right">
                        <a href="#" data-toggle="dropdown" class="btn btn-danger dropdown-toggle">Month</a>
                        <ul class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
                        <li class="dropdown-title">Select Period</li>
                        <li><a href="#" class="dropdown-item">Today</a></li>
                        <li><a href="#" class="dropdown-item">Week</a></li>
                        <li><a href="#" class="dropdown-item active">Month</a></li>
                        <li><a href="#" class="dropdown-item">This Year</a></li>
                        </ul>
                    </div> --}}
                </div>
                <div class="card-body" id="top-5-scroll" tabindex="2"
                    style="min-height: 558px; overflow: hidden; outline: none;">
                    <ul class="list-unstyled list-unstyled-border">
                        <li class="media" ng-repeat="customer in customers">
                            <a href="#" class="btn bg-indigo rounded-pill btn-icon btn-sm mr-2">
                                <span class="letter-icon">[[customer.FirstName.charAt(0)]]</span>
                            </a>
                            {{-- <span class="letter-icon">TK</span> --}}
                            {{-- <img class="mr-3 rounded" width="55"
                                src="../../../../global_assets/images/demo/users/face15.jpg" alt="product"> --}}
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">[[customer.total_bookings]]
                                        Bookings</div>
                                </div>
                                <div class="media-title">[[customer.FirstName]] [[customer.LastName]]
                                    ([[customer.Email]])</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-primary"
                                            data-width="[[customer.progress_percentage]]%"
                                            style="width: [[customer.progress_percentage]]%; min-width:1% !important">
                                        </div>
                                        <div class="budget-price-label">[[customer.progress_bookings]]</div>
                                    </div>
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-danger"
                                            data-width="[[customer.cancel_percentage]]%"
                                            style="width: [[customer.cancel_percentage]]%; min-width:1% !important">
                                        </div>
                                        <div class="budget-price-label">[[customer.cancel_bookings]]</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        {{-- <li class="media">
                            <img class="mr-3 rounded" width="55"
                                src="../../../../global_assets/images/demo/users/face13.jpg" alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">20 Bookings</div>
                                </div>
                                <div class="media-title">Saad Jafri</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-primary" data-width="84%"
                                            style="width: 80%;"></div>
                                        <div class="budget-price-label">16</div>
                                    </div>
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-danger" data-width="60%" style="width: 20%;">
                                        </div>
                                        <div class="budget-price-label">4</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 rounded" width="55"
                                src="../../../../global_assets/images/demo/users/face14.jpg" alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">60 Bookings</div>
                                </div>
                                <div class="media-title">Umer Hasan</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-primary" data-width="34%"
                                            style="width: 100%;"></div>
                                        <div class="budget-price-label">60</div>
                                    </div>
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-danger" data-width="28%" style="width: 1%;">
                                        </div>
                                        <div class="budget-price-label">0</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 rounded" width="55"
                                src="../../../../global_assets/images/demo/users/face15.jpg" alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">28 Sales</div>
                                </div>
                                <div class="media-title">oPhone X Lite</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-primary" data-width="45%"
                                            style="width: 45%;"></div>
                                        <div class="budget-price-label">$13,972</div>
                                    </div>
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-danger" data-width="30%" style="width: 30%;">
                                        </div>
                                        <div class="budget-price-label">$9,660</div>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="media">
                            <img class="mr-3 rounded" width="55"
                                src="../../../../global_assets/images/demo/users/face15.jpg" alt="product">
                            <div class="media-body">
                                <div class="float-right">
                                    <div class="font-weight-600 text-muted text-small">19 Sales</div>
                                </div>
                                <div class="media-title">Old Camera</div>
                                <div class="mt-1">
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-primary" data-width="35%"
                                            style="width: 35%;"></div>
                                        <div class="budget-price-label">$7,391</div>
                                    </div>
                                    <div class="budget-price">
                                        <div class="budget-price-square bg-danger" data-width="28%" style="width: 28%;">
                                        </div>
                                        <div class="budget-price-label">$5,472</div>
                                    </div>
                                </div>
                            </div>
                        </li> --}}
                    </ul>
                </div>
                <div class="card-footer pt-3 d-flex justify-content-center">
                    <div class="budget-price justify-content-center">
                        <div class="budget-price-square bg-primary" data-width="20" style="width: 20px;"></div>
                        <div class="budget-price-label">Completed Booking</div>
                    </div>
                    <div class="budget-price justify-content-center">
                        <div class="budget-price-square bg-danger" data-width="20" style="width: 20px;"></div>
                        <div class="budget-price-label">Cancel Booking</div>
                    </div>
                </div>
            </div>
        </div>

      

    </div>



</div>