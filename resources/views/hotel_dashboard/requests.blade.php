<div class="card p-3">
    <div class="row">

        <div class="col-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Discount Requests</h6>
                    <div class="header-elements">
                        <span class="badge badge-primary badge-pill">
                            <a href="/discountrequests" class="text-white ml-auto"> View
                                all</a>
                        </span>
                    </div>
                </div>
    
                <div class="card-body">
    
                    <ul class="media-list">
                        <li class="media" ng-repeat="(key, discount_request) in discount_requests">
                            <div class="mr-3">
                                <a href="#"
                                    class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">[[key+1]]
                                </a>
                            </div>
    
                            <div class="media-body">
                                [[discount_request.requester.name]] has requested discount for <strong>Booking #</strong>
                                [[discount_request.booking.booking_no]] & <strong> Customer
                                </strong>[[discount_request.booking.invoice.customer_first_name]]
                                [[discount_request.booking.invoice.customer_last_name]] on
                                [[discount_request.created_at | date]] <span class="font-weight-semibold">for amount</span>
                                <span class="font-weight-semibold text-danger">[[discount_request.requested_amount
                                    |currency]]</span>
                                and previous allowed amount is <span
                                    class="font-weight-semibold text-danger">[[discount_request.allowed_discount
                                    |currency]]</span>
                                {{-- <div class="text-muted">2 hours ago</div> --}}
                            </div>
    
                            {{-- <div class="ml-3 align-self-center">
                                <a href="#" class="list-icons-item"><i class="icon-more"></i></a>
                            </div> --}}
                        </li>
    
                    </ul>
                </div>
            </div>
            
        </div>
        <div class="col-6 d-flex">
            <div class="card flex-fill">
                <div class="card-header header-elements-inline">
                    <h6 class="card-title">Service Requests</h6>
                    <div class="header-elements">
                        {{-- <label class="custom-control custom-switch custom-control-inline custom-control-right">
                                                    <input type="checkbox" class="custom-control-input" id="realtime" checked="">
                                                    <span class="custom-control-label">Realtime</span>
                                                </label> --}}
                        <span class="badge badge-primary badge-pill">
                            <a href="/hotel_booking_services" class="text-white ml-auto"> View
                                all</a>
                        </span>
                    </div>
                </div>
    
                <div class="card-body">
    
                    <ul class="media-list">
                        <li class="media" ng-repeat="(key, bs) in hotelbookingservices">
                            <div class="mr-3">
                                <a href="#"
                                    class="btn bg-transparent border-indigo text-indigo rounded-pill border-2 btn-icon">[[key+1]]</a>
                            </div>
    
                            <div class="media-body">
                                Booking # [[bs.BookingNo]] <span class="font-weight-semibold">requested for
                                    [[bs.service_name]]</span> service, <span
                                    class="font-weight-semibold text-danger">[[bs.service_charges | currency]]</span>
                                charges
                                <div class="text-muted">Serving for [[bs.serving_time]]</div>
                            </div>
    
                            {{-- <div class="ml-3 align-self-center">
                                <a href="#" class="list-icons-item"><i class="icon-more"></i></a>
                            </div> --}}
                        </li>
    
                    </ul>
                </div>
            </div>
            
        </div>
    </div>


</div>