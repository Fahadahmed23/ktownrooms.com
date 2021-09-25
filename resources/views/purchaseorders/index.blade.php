@extends('layouts.app')

@section('scripts')
    <script src="app/purchaseorder-controller.js"></script>
@endsection

@section('content')


<div id="main-content" class="content" ng-controller='purchaseorderCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('purchaseorders.form')
		@include('purchaseorders.po_detail_modal')
    </div>

	
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('purchaseorders.filter')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Purchase Orders
							<span>
								<a href="#" class="" ng-click="showFilter()">
								<i id="" class="icon-search4 " style="font-size: 12px;"></i> 
						   		</a>
							</span>
						</h5>
						<div class="header-elements">
							<div class="list-icons">
								<button type="button" class="btn btn-sm btn-primary " ng-click="createPurchaseOrder()">New Purchase Order <i class="ml-1 icon-plus22"></i></button>
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" ng-click="init()" data-action="reload" ng-click="getPuchaseOrders()"></a>
			
							</div>
						</div>
					</div>
					@include('purchaseorders.table')
				</div>
        </div>        
			
			
    </div>
	
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection