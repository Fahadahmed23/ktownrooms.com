@extends('layouts.app')

@section('scripts')
    <script src="app/bookings-controller.js"></script>
@endsection

@section('content')

<div class="content" ng-controller='bookingsCtrl' ng-init='loadRoomDashboard()'>
    <div class="m-auto">
        @include('room_dashboard.search')
        @include('room_dashboard.rooms')
    </div>
</div>        

@endsection