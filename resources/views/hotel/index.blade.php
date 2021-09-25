@extends('layouts.app')

@section('scripts')
    <script src="app/hotel-controller.js"></script>
@endsection

@section('content')

<div id="main-content" class="content" ng-controller='hotelCtrl' ng-init='init()'>
    <div class="m-auto">
        @permission('can-add-hotel')
        @include('hotel.countsboxes')
        @include('hotel.form')
        @include('hotel.hotel_contacts_form')
        @endpermission
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
         <!-- Left sidebar component -->
         @include('hotel.filter')
         <!-- /left sidebar component -->
        <div class="flex-fill">
            <div class="row">
                <div class="col-lg-12">
                    @permission('can-view-hotel')
                    @include('hotel.hotel_table')
                    @endpermission
                </div>
            </div>
        </div> 
    </div>   
</div>        

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection