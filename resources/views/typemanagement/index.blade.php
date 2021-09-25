@extends('layouts.app')

@section('scripts')
    <script src="app/typemanagement-controller.js"></script>
@endsection


@section('content')


<div class="content" ng-controller='typemanagementCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('typemanagement.taxrateModal')
        @include('typemanagement.channelModal')
        {{-- @include('typemanagement.service_modal') --}} 
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">

        <!-- datatable component -->
        <div class="flex-fill">    
            @include('typemanagement.cards')
        </div>
        <!-- /datatable component -->

    </div>    
</div>        
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

@endsection