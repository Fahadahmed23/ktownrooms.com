

<div class="card p-3">
    <div class="row">
        {{-- @php
            $hasAdmin = auth()->user()->roles->contains(function ($role, $key) {
                return $role->name == 'Admin';
            });
        @endphp --}}
        {{-- <div class="col-md-12" ng-if="!is_admin">
            <div class="title px-2 border-bottom bg-light py-1">
                <h6 class="mb-0"> <i class="icon-calendar2 mr-1"></i> Hotel Information</h6>    
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="booking_information">
                        
                        <div class="pt-2 px-2 detail">

                            <div class="booking-hotel">
                                <span class="font-weight-bold"> Hotel Name : </span><span> [[user.hotel.HotelName]] </span>
                            </div>

                            <div class="booking-city">
                                <span class="font-weight-bold"> Hotel Address : </span><span>  [[user.hotel.Address]]</span>
                            </div>

                            <div class="booking-total-occupants">
                                <span class="font-weight-bold"> Hotel Description : </span><span> [[user.hotel.Description]]</span>
                            </div>

                            <div class="booking-total-cost">
                                <span class="font-weight-bold"> Hotel Code : </span><span>[[user.hotel.Code]]</span>
                            </div>
                        </div>
                    </div> 
                </div>
            </div>
           
        </div> --}}
        <div class="col-md-3 col-sm-4 " ng-if="is_admin">
            <a href="report?module=Hotels&report=Hotels&title=Hotels Report&_period_=Year">
                <div class="card card-body bg-indigo-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[records.hotelsCount]]</h3>
                            <span class="text-uppercase font-size-xs">Hotels</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="icon-hat icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 " ng-if="!is_admin">
            <a href="report?module=Hotels&report=Hotels&title=Hotels Report&_period_=Year">
                <div class="card card-body bg-indigo-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[user.hotel.HotelName]] - [[user.hotel.Code]]</h3>
                            <h4 class="mb-0">[[user.hotel.Address]]</h4>
                            <h5 class="mb-0">[[user.hotel.Description]]</h5>
                            <span class="text-uppercase font-size-xs">Hotel Information</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="icon-hat icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-md-3 col-sm-4 ">
            <a href="report?module=Bookings&report=Bookings&_period_=Year">
                <div class="card card-body bg-blue-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[records.bookingCount]]</h3>
                            <span class="text-uppercase font-size-xs">Total Bookings</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="icon-price-tag2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    
        <div class=" col-md-3 col-sm-4 ">
            <a href="report?module=Bookings&report=Bookings&_period_=Year&status=Confirmed">
                <div class="card card-body bg-success-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[records.bookingApprovedCount]]</h3>
                            <span class="text-uppercase font-size-xs">Confirmed Bookings</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="icon-price-tags icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    
        <div class=" col-md-3 col-sm-4 ">
            <a href="report?module=Bookings&report=Bookings&_period_=Year&status=Pending">
                <div class="card card-body bg-warning-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[records.bookingPendingCount]]</h3>
                            <span class="text-uppercase font-size-xs">Pending Bookings</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="icon-price-tags2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class=" col-md-3 col-sm-4 ">
            <a href="report?module=Bookings&report=Bookings&title=Cancelled Bookings&_period_=Year&status=Cancelled">
                <div class="card card-body bg-danger-400 has-bg-image" style="min-height: 95px;">
                    <div class="media">
                        <div class="media-body">
                            <h3 class="mb-0">[[records.bookingCancelledCount]]</h3>
                            <span class="text-uppercase font-size-xs">Cancelled Bookings</span>
                        </div>
        
                        <div class="ml-3 align-self-center">
                            <i class="icon-price-tags2 icon-3x opacity-75"></i>
                        </div>
                    </div>
                </div>
            </a>
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