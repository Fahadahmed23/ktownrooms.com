@extends('layouts.app-first-login')

@section('title')
Change Password
@endsection
@section('JSLibraries')
<script src="{{ asset_path('app/profile-controller.js') }}"></script>
@endsection

@section('CSSLibraries')
<style type="text/css">
    .output_image {
        width: 150px;
        height: 150px;
        border: 1px solid lightgrey;
        float: left;
        border-radius: 50%;
    }
    .invalid-box {
    border-color: red;
    }
    .valid-box {
        border-color: green !important;
    }
</style>

@endsection

@section('content')

<!-- Page content -->
<div class="page-content" ng-controller="profileCtrl" ng-init="init()">

    <!-- Main sidebar -->

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        {{-- @include('profile.header') --}}
        <!--/page header-->

        <!-- Content area -->
        <div class="content d-flex justify-content-center align-items-center">
            {{-- @include('profile.form') --}}
             <!-- Change Password form -->
            {{-- <form class="form-horizontal" ng-submit="changePassword(true)"> --}}
                <div class="card mb-0" style="width: 500px;">
                     <div class="card-body">
                         <div class="text-center mb-3">
                             <i class="icon-reading icon-2x text-slate-300 border-slate-300 border-3 rounded-round p-3 mb-3 mt-1"></i>
                             <h5 class="mb-0">Change Your Password</h5>
                             <span class="d-block text-muted">Before using complete system</span>
                         </div>
 
                         @include('layouts.form_messages')
 
                         {{-- <div class="form-group form-group-feedback form-group-feedback-left">
                             <input class="form-control" id="old_password" placeholder="Old Password" ng-model="cred.old_password" type="password" >
                             <div class="form-control-feedback">
                             <i class="icon-user text-muted"></i>
                             </div>
                         </div> --}}
 
                         <div class="form-group form-group-feedback form-group-feedback-left">
                             <input class="form-control" placeholder="New Password" id="password" ng-model="cred.password" type="password" value="">
                             <div class="form-control-feedback">
                             <i class="icon-lock2 text-muted"></i>
                             </div>
                         </div>
                        {{-- <input type="hidden" ng-model="cred.redirectToHome" ng-value="cred.redirectToHome"> --}}
                         <div class="form-group form-group-feedback form-group-feedback-left">
                             <input class="form-control" placeholder="Confirm Password" id="password_confirmation" ng-model="cred.password_confirmation" type="password" value="">
                             <div class="form-control-feedback">
                             <i class="icon-lock2 text-muted"></i>
                             </div>
                         </div>
                         <div class="form-group">
                            <button type="button" ng-click="changePassword(true)" class="btn btn-primary btn-block"><i class="icon-rotate-cw3 ml-2"></i> Change Password</button>
                         </div>
                     </div>
                 </div>
            {{-- </form> --}}
             <!-- /Change Password form -->
 
        </div>
        <!-- /content area -->


        <!-- /main content -->

    </div>
</div>
@endsection
