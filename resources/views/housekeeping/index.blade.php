@extends('layouts.public_app')

@section('scripts')
    <script src={{url('app/housekeeping-controller.js')}}></script>
@endsection

@section('content')
<style>
.content {
    background-repeat: no-repeat;
    background-size: cover;
    opacity: 1;
    background: url(https://images.unsplash.com/photo-1444201983204-c43cbd584d93?ixid=MXwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHw%3D&ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80),#0000005c !important;
    background-blend-mode: color;
}


</style>
<div class="content" ng-controller='housekeepingCtrl' ng-init="init('{{$code}}')@auth {{';createRequest();user_frontdesk=true'}} @endauth">
    <div class="m-auto">
        @include('housekeeping.main')
        @include('housekeeping.services_complains')

        {{-- complain form --}}
        @include('housekeeping.complain_form')
        {{-- complain form --}}
        
        @include('housekeeping.services')
    </div>
</div>      
@endsection