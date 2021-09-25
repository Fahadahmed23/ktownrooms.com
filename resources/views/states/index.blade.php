@extends('layouts.app')

@section('scripts')
    <script src="app/states-controller.js"></script>
@endsection

@section('content')


<div class="content" ng-controller='statesCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('states.form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('states.filter')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title"><span><a href="#" class="sidebar-control sidebar-component-toggle legitRipple mr-2">
									 <i id="icon-shift" class="icon-drag-right"></i> 
								</a></span>States</h5>
						<div class="header-elements">
							<div class="list-icons">
								<button type="button" class="btn btn-sm btn-primary " ng-click="createState()"><i class="mr-1 icon-plus22"></i>Add New State</button>
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getStates()"></a>
			
							</div>
						</div>
					</div>
					@include('states.table')
				</div>
        </div>        
			
			
    </div>        
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection