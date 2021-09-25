@extends('layouts.app')

@section('scripts')
    <script src="app/bookingservices-controller.js"></script>
@endsection

@section('content')


<div class="content" ng-controller='bookingservicesCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('booking_services/main')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">   
        <div class="flex-fill">
        </div>        
    </div>  
</div>      
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection