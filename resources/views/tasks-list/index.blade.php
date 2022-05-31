@extends('layouts.app')

@section('scripts')
    <script src="app/taskmanagement-controller.js"></script>
    <script src="{{ asset_path('global_assets/js/plugins/ui/dragula.min.js') }}"></script>
    <script src="{{ asset_path('assets/js/report-columns.js') }}"></script>
@endsection

@section('content')
<div class="content" ng-controller='taskmanagementCtrl' ng-init='init()'>
    <div class="m-auto">

    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">
         <!-- Left sidebar component -->
         @include('tasks-list.filter')
         <!-- /left sidebar component -->
        <div class="flex-fill">
            @include('tasks-list/main')
        </div>
    </div>
</div>
     {{-- <script src='{{asset('assets/js/require.js')}}'></script> --}}
     {{-- <script src='{{asset('assets/js/angularjs-dragula.js')}}'></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
@endsection
