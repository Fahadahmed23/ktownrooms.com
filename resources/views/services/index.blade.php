@extends('layouts.app')

@section('scripts')
    <script src="app/services-controller.js"></script>
@endsection

@section('content')


<div id="main-content" class="content" ng-controller='servicesCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('services.form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('services.filter')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Services
							<span><a href="#" class="" ng-click="showFilter()">
								<i id="" class="icon-search4 " style="font-size: 12px;"></i> 
						   </a></span>
						</h5>
						<div class="header-elements">
							<div class="list-icons">
								<button type="button" class="btn btn-sm btn-primary " ng-click="createService()"><i class="mr-1 icon-plus22"></i>Add New service</button>
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getServices()"></a>
			
							</div>
						</div>
					</div>
					@include('services.table')
				</div>
        </div>        
			
			
    </div>        
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection