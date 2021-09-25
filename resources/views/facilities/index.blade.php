@extends('layouts.app')

@section('scripts')
    <script src="app/facilities-controller.js"></script>
@endsection

@section('content')

<div id="main-content" class="content" ng-controller='facilitiesCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('facilities.form')
		{{-- @include('facilities.iconsModal') --}}
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('facilities.filter')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Facilities
							<span><a href="#" class="" ng-click="showFilter()">
								<i id="" class="icon-search4 " style="font-size: 12px;"></i> 
						   </a></span>
						</h5>

						<div class="header-elements">
							<div class="list-icons">
								<button type="button" class="btn btn-sm btn-primary " ng-click="createFacility()"><i class="mr-1 icon-plus22"></i>Add New facility</button>
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getfacilities()"></a>
			
							</div>
						</div>
					</div>
					@include('facilities.table')
				</div>
        </div>        
			
			
    </div> 
	
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection