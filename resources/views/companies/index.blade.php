@extends('layouts.app')

@section('scripts')
    <script src="app/companies-controller.js"></script>
@endsection

@section('content')


<div class="content" ng-controller='companiesCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('companies.form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('companies.filter')
        <!-- /left sidebar component -->
        <div class="flex-fill">
			@include('companies.table')
        </div>        
			
			
    </div>  
</div>      
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection