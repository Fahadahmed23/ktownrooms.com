@extends('layouts.app')

@section('scripts')
    <script src="app/vendor-controller.js"></script>
@endsection

@section('content')
<div id="main-content" class="content" ng-controller='vendorCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('vendors.form')
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('vendors.filter')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Vendors<span><a href="#" class="" ng-click="showFilter()">
                        <i id="" class="icon-search4" style="font-size: 12px;"></i> 
                   </a></span></h5>
						<!-- <span>
							<a href="#" class="sidebar-control sidebar-component-toggle legitRipple mr-2">
								<i id="icon-shift" class="fas fa-search"></i> 
							</a>
						</span> -->
						<div class="header-elements">
							<div class="list-icons">
								<button type="button" class="btn btn-sm btn-primary " ng-click="viewCreate()"><i class="mr-1 icon-plus22"></i>Add New Vendor</button>
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getVendors()"></a>
			
							</div>
						</div>
					</div>
					@permission('can-view-user')
					@include('vendors.table')
					@endpermission
				</div>

        </div>        
	</div>
</div>
@endsection