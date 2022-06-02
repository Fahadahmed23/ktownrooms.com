@extends('layouts.app-report')

@section('scripts')
    <!-- <script src="app/bookings-controller.js"></script> -->
    <script src="{{ asset_path('app/report-controller.js') }}"></script>
    <script src="app/housekeeping-controller.js"></script>
@endsection


@section('content')


<div class="content" ng-controller='reportCtrl' ng-init='GetKlcReport()'>

    <div class="d-md-flex admin-panel-section align-items-md-start">
        <!-- Left sidebar component -->
        @include('reports_get_klc_report.filter')
        <!-- /left sidebar component -->
        <!-- datatable component -->
        {{-- <div class="flex-fill overflow-auto"> --}}

        <div class="flex-fill overflow-auto">

            @include('reports_get_klc_report.table')

        </div>
        <!-- /datatable component -->

    </div>
</div>


@endsection


