<div class="row m-0">
    <div class="checkIn-col col-md-6">
        @include('hotel.check_in')
    </div>
    <div class="checkOut-col col-md-6">
        @include('hotel.check_out')
    </div>
    
    <div class="col-md-12 text-right p-2">
        <button class="btn btn-success" ng-click="saveCheckInCheckOutRules()">Add CheckIn & CheckOut Rules</button>
    </div>

</div>