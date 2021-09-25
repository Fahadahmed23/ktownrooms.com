@extends('layouts.app')

@section ('scripts') 
    <script src="app/discount-requests-controller.js"></script>
@endsection

@section ('content')
<div class="content" ng-controller='discountrequestsCtrl' ng-init='init()'>
    <div class="m-auto">
        @include ('bookings.invoice')
        @include ('discount_requests.filter')
        @include ('discount_requests.list')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        
    </div>
</div>

@endsection