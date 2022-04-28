@extends('layouts.app')

@section('scripts')
    <script src="app/corporateclients-controller.js"></script>
@endsection

@section('content')


<div id="main-content" class="content" ng-controller='corporateclientsCtrl' ng-init='init()'>
    <div class="m-auto">
        @include('corporate_clients.form')
    </div>

	
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('corporate_clients.filter')
		@include('corporate_clients.clients_modal')
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Clients
							<span>
								<a href="#" class="" ng-click="showFilter()">
								<i id="" class="icon-search4 " style="font-size: 12px;"></i> 
						   		</a>
							</span>
						</h5>
						<div class="header-elements">
							<div class="list-icons">
								<button type="button" class="btn btn-sm btn-primary " ng-click="createClient()">New Client <i class="ml-1 icon-plus22"></i></button>
								<button type="button" class="btn btn-sm btn-info " ng-click="showImportClientModal()">Import Client <i class="ml-1 icon-file-excel"></i></button>
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getClients()"></a>
			
							</div>
						</div>
					</div>
					@include('corporate_clients.table')
				</div>
        </div>        
			
			
    </div>
	
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection