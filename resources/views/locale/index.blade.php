@extends('layouts.app')

@section('scripts')
    <script src="app/locale-controller.js"></script>
@endsection

@section('content')

<div class="content" ng-controller='localeCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('locale.country_form')
        @include('locale.state_form')
        @include('locale.city_form')
        @include('locale.hotelcategory_form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <div class="flex-fill">
            @include('locale.cards')
            {{-- <div class="row">
                <div class="col-lg-4">@include('locale.countries_table')</div>
                <div class="col-lg-4">@include('locale.states_table')</div>
                <div class="col-lg-4">@include('locale.cities_table')</div>
            </div> --}}
        </div> 
    </div>   
</div>        

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

@endsection