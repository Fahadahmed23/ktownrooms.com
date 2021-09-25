@extends('layouts.app')

@section ('scripts') 
    <script src="app/complains-controller.js"></script>
@endsection

@section ('content')
<div class="content" ng-controller='complainsCtrl' ng-init='init()'>
    <div class="m-auto">
        @include ('bookings.invoice')
        @include ('complains.filter')
        @include ('complains.list')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        
    </div>
</div>

@endsection