@extends('layouts.app')

@section('scripts')
    <script src="app/incomestatement-controller.js"></script>
	<script src="{{ asset_path('global_assets/js/plugins/ui/dragula.min.js') }}"></script>
	<script src="{{ asset_path('assets/js/report-columns.js') }}"></script>
	<script src="{{ asset_path('assets/js/tableHTMLExport.js') }}"></script>
@endsection

@section('content')

<div id="main-content" class="content" ng-controller='incomeStatementCtrl' ng-init='init()'>
    <div class="m-auto">
		@include('income_statement.search')
    </div>

	
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
				<div class="card">
                
					<div class="card-header header-elements-inline">
						<h5 class="card-title">Income Statement
							{{-- <span>
								<a href="#" class="" ng-click="showFilter()">
								<i id="" class="icon-search4 " style="font-size: 12px;"></i> 
						   		</a>
							</span> --}}
						</h5>
						<div class="header-elements">
							<div class="list-icons">
								<a class="list-icons-item" data-action="collapse"></a>
								<a class="list-icons-item" data-action="reload" ng-click="getLedger()"></a>
			
							</div>
						</div>
					</div>
					@include('income_statement.record')
				</div>
        </div>        
			
			
    </div>
	
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection