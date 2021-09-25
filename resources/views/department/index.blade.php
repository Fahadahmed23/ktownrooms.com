@extends('layouts.app')

@section('scripts')
    <script src="app/department-controller.js"></script>
@endsection


@section('content')


<div  id="main-content" class="content" ng-controller='departmentCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('department.form')
        @include('department.service_modal')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('department.filter')
        <!-- /left sidebar component -->

        <!-- datatable component -->
        <div class="flex-fill">    
            @include('department.table')
        </div>
        <!-- /datatable component -->

    </div>    
</div>   
     
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>

@endsection