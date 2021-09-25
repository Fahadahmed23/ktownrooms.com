@extends('layouts.app')

@section('scripts')
    <script src="app/hotelbookingservices-controller.js"></script>
@endsection

@section('content')
<style>
	.noti_icon {
    display: none;
	}
</style>

<div id="main-content" class="content" ng-controller='hotelbookingservicesCtrl' ng-init='init()'>
    <div class="m-auto">
    </div>

	
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('hotel_booking_services.filter')
        <!-- /left sidebar component -->

        <div class="flex-fill overflow-auto">
				<div class="card">
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Hotel Booking Services
							<span>
								<a href="#" class="" ng-click="showFilter()">
								<i id="" class="icon-search4 " style="font-size: 12px;"></i> 
						   		</a>
							</span>
						</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getHotelBookingServices()"></a>
			
							</div>
						</div>
					</div>
					@include('hotel_booking_services.table')
				</div>
        </div>        
			
			
    </div>
	
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection