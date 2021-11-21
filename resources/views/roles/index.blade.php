@extends('layouts.app')

@section('scripts')
    <script src="app/role-controller.js" ></script>
@endsection

@section('content')
<div class="content" ng-controller='roleCtrl' ng-init='getRoles()'>
    <div class="m-auto">
        @include('roles.role-form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('roles.role-filter')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
			<div class="card">
				@include('roles.role-table')
			</div>
        </div>        
    </div> 
</div>
@endsection
