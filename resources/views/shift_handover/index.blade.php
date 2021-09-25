@extends('layouts.app')

@section('scripts')
    <script src="app/shifthandover-controller.js"></script>
@endsection

@section('content')


<div id="main-content" class="content" ng-controller='shifthandoverCtrl' ng-init='init()'>
    <form name="shiftHandoverForm" id="shiftHandoverForm">
    <div class="m-auto">
        @include('shift_handover.main')
    </div>

	
    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        <!-- /left sidebar component -->
        <div class="flex-fill overflow-auto">
			@include('shift_handover.shift_handover_sheet')
        </div>        
			
			
    </div>
    </form>
	
</div>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection