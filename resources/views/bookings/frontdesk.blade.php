@extends('layouts.app')

@section('scripts')
    <script src="app/bookings-controller.js"></script>
    <script src="app/housekeeping-controller.js"></script>
@endsection

@section('content')

<div class="content" ng-controller='bookingsCtrl' ng-init='loadFrontdesk()'>
    <div class="m-auto">
        @include('hotel_dashboard.welcome_message')
        @include('bookings.search')
        @include('bookings.frontdesk_rooms')
        @include('bookings.form')
        @include('bookings.stays_modal')
        {{-- @include('bookings.customer_modal') --}}
        @include('bookings.invoice')
        @include('bookings.show_customer_list')
        @include('bookings.addOccupantsModal')
        @include('bookings.room_transfer_modal')
    </div>
</div>

<div ng-controller="housekeepingCtrl">
    @include('housekeeping.services')
</div>

@endsection
