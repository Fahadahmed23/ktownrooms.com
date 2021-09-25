@extends('layouts.app')

@section('scripts')
    <script src="app/dashboard-controller.js"></script>
@endsection


@section('content')


<div class="content" ng-controller='dashboardCtrl' ng-init='init()'>
    <div class="m-auto">
       @include('dashboard.countboxes')
       @include('dashboard.filter')

       @include('dashboard.charts.cities')
       @include('dashboard.charts.hotels')
       @include('dashboard.charts.rooms')
       {{-- @include('dashboard.searchfilter') --}}
      
      
    </div>
    <div class="d-md-flex admin-panel-section align-items-md-start">


        <!-- datatable component -->
        <div class="flex-fill">    
          
        </div>
        <!-- /datatable component -->

    </div>    
</div>  
</div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://www.gstatic.com/charts/loader.js"></script>

    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>


@endsection