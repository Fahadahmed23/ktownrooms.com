@extends('layouts.app')

@section('scripts')
    <script src="app/categoryfacilities-controller.js"></script>
@endsection

@section('content')


<div class="content" ng-controller='categoryfacilitiesCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('categoryfacilities.form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('categoryfacilities.filter')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title"><span><a href="#" class="sidebar-control sidebar-component-toggle legitRipple mr-2">
									 <i id="icon-shift" class="icon-drag-right"></i> 
								</a></span>CategoryFacilities</h5>
						<div class="header-elements">
							<div class="list-icons">
								<button type="button" class="btn btn-sm btn-primary " ng-click="createCategoryFacility()"><i class="mr-1 icon-plus22"></i>Add New category facility</button>
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getCategoryFacilities()"></a>
			
							</div>
						</div>
					</div>
					@include('categoryfacilities.table')
				</div>
        </div>        
			
			
    </div>        
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection