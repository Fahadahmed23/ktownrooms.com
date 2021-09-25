@extends('layouts.app')

@section('scripts')
    <script src="app/permission-controller.js" ></script>
@endsection

@section('content')
     <!-- Page content -->
    <div class="page-content" ng-controller="permissionCtrl" ng-init="getPermissions()">

        <!-- Main sidebar -->

        <!-- Main content -->
        <div class="content-wrapper">

            <!-- Page header -->
            <!--/page header-->

            <!-- Content area -->
            <div class="content">
                
                 @include('permission.permission-form')

                <!-- Inner container -->
                <div class="d-md-flex admin-panel-section align-items-md-start">

                    <!-- Left sidebar component -->
                  
                    <!-- /left sidebar component -->

                    <!-- Right content -->
                    @include('permission.permission-table')
                    <!-- /right content -->

                </div>
                <!-- /inner container -->

            </div>
            <!-- /content area -->


            <!-- /main content -->
            <script>
                $('.sidebar-control').on('click', function() {

                    $('#icon-shift').toggleClass('icon-drag-right icon-drag-left'); //Adds 'a', removes 'b' and vice versa
                });

          
                
            </script>
        </div>
    </div>
@endsection
