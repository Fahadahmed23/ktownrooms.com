@extends('layouts.app')
@section('title')
Reports
@endsection
<style>
    table {
        width: 100%;
    }

    .tab-content a {
        color: black;
    }
    .md-select-menu-container {
        z-index: 9999 !important;
    }

    md-backdrop.md-select-backdrop {
        z-index:8000 !important;
    }
    .sortable{
        white-space: nowrap; 
        width: 70%; 
        overflow: hidden;
        text-overflow: ellipsis; 
    }
</style>

@section('scripts')
<script src="{{ asset_path('app/report-controller.js') }}"></script>
@endsection

@section('content')
<!-- Page content -->
<div class="page-content" ng-controller="reportCtrl" ng-init="getSavedReports()">

    <!-- Main sidebar -->

    <!-- Main content -->
    <div class="content-wrapper">

        <!-- Page header -->
        @include('report.header')
        <!--/page header-->

        <!-- Content area -->
        <div class="content">

            {{-- <div class="card card-body col-md-4 m-auto">
                <div class="receipt zig-zag-top">
                    <div class="col-12"><label class="d-block font-weight-semibold">Receipt</label></div>
                    <table class="table receipt-content" style="">
                        <tbody><!-- ngIf: !selectedUser --><tr ng-if="!selectedUser" class="ng-scope">
                                <td>Adults</td>
                                <td class="ng-binding">0 x $20</td>
                                <td class="ng-binding">$0 </td>
                            </tr><!-- end ngIf: !selectedUser -->
                            <!-- ngIf: !selectedUser --><tr ng-if="!selectedUser" class="ng-scope">
                                <td>Children</td>
                                <td class="ng-binding">0 x $10</td>
                                <td class="ng-binding">$0 </td>
                            </tr><!-- end ngIf: !selectedUser -->
                            <!-- ngIf: selectedUser.memberships.length > 0 -->
                            <!-- ngIf: selectedUser.memberships.length > 0 -->
                            <!-- ngIf: selectedUser.memberships.length > 0 -->
                            <!-- ngIf: selectedUser.memberships.length > 0 -->
                            <tr>
                                <td>Discount</td>
                                <td></td>
                                <td class="ng-binding">$0 </td>
                            </tr>
                            <tr>
                                <td>UnderAge (Free)</td>
                                <td class="ng-binding">0</td>
                                <td>$0</td>
                            </tr>
                            <!-- ngIf: !selectedUser --><tr ng-if="!selectedUser" class="ng-scope">
                                <td>Automobies</td>
                                <td class="ng-binding">0 x $3</td>
                                <td class="ng-binding">$0 </td>
                            </tr><!-- end ngIf: !selectedUser -->
                            <!-- ngIf: selectedUser.memberships.length > 0 -->
                            <!-- ngIf: selectedUser.memberships.length > 0 -->    

                            <tr>
                                <td>Convenience charges</td>
                                <td class="ng-binding">5 /person</td>
                                <td class="ng-binding">$ </td>
                            </tr>

                            <tr>
                                <td>Payment processing charges</td>
                                <td class="ng-binding">2%</td>
                                <td class="ng-binding">$ </td>
                            </tr>        
                           
                            <tr class="font-weight-bold">
                                <td>Grand Total</td>
                                <td></td>
                                <td class="ng-binding">$0 </td>
                            </tr>
                        </tbody>
                    </table>
                    <table class="table h-receipt">
                        <tbody><tr class="font-weight-bold G-total" style="display: none;">
                                <td>Grand Total</td>
                                <td class="text-center ng-binding">$0 </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div> --}}

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h6 class="card-title">All Reports</h6>
                        <!-- <div class="header-elements">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                        <a class="list-icons-item" data-action="reload"></a>
                                        <a class="list-icons-item" data-action="remove"></a>
                                    </div>
                                </div> -->
                    </div>

                    <div class="card-body">
                        {{-- [[modules]] --}}
                        <div style="display: inline-flex; width: 100%;" class="justify-content-lg-between">
                            <ul class="nav nav-pills flex-column mr-lg-3 wmin-lg-250 mb-lg-0">

                                <li ng-cloak ng-repeat="module in modules" class="nav-item">
                                    <a href="#[[module.name]]" ng-click="activeModule(module.name)" ng-class="{ active: module.name == (currentModule ? currentModule : 'Bookings ') }" class="nav-link display-5" data-toggle="tab">
                                        <i class="icon-file-presentation mr-2"></i>
                                        [[module.name]]
                                    </a>
                                </li>
                                <li ng-if="myReports.length > 0" class="nav-item">
                                    <a href="#my-reports" ng-click="activeModule('My Reports')" class="nav-link" data-toggle="tab">
                                        <i class="icon-file-presentation mr-2"></i>
                                        My Reports
                                    </a>
                                </li>

                            </ul>

                            <div style="width: 100%;" class="tab-content">
                                <div ng-cloak ng-repeat="module in modules" ng-class="module.name == (currentModule ? currentModule : 'Bookings') ? ['show','active'] : '' " class="tab-pane fade" id="[[module.name]]">
                                    <div class="row" >
                                        
                                        {{-- [[module.reports.name]] --}}
                                        <div ng-cloak ng-repeat="report in module.reports" class="col-md-4" ng-if="report.name">
                                            <div class="card" > 
                                                <div class="card-header header-elements-inline p-2">
                                                    <h5 class="card-title sortable text-uppercase " ng-click="loadDynamicReport(report.report)" style="cursor: pointer">
                                                        <a data-popup="tooltip" data-original-title="[[report.name]]" data-trigger="hover" class="current-div1">
                                                            [[report.name]]
                                                        </a>
                                                    </h5>
                                                    <div class="list-icons">
                                                        <a ng-hide="report.created_by == 0" ng-click="moveReport(report.report)" data-popup="tooltip" data-original-title="Move Report" data-trigger="hover" class="current-div1 list-icons-item mr-2"><i class="icon-move"></i></a>
                                                        <a ng-hide="report.created_by == 0" ng-click="editSharedReport(report.report)" data-popup="tooltip" data-original-title="Edit Shared Report" data-trigger="hover" class="current-div1 list-icons-item mr-2"><i class="icon-pencil6"></i></a>
                                                        <a ng-hide="report.created_by == 0" ng-click="deleteSharedReport(report.report)" data-popup="tooltip" data-original-title="Delete Shared Report" data-trigger="hover" class="current-div1 list-icons-item mr-2"><i class="icon-trash"></i></a>
                                                    </div>

                                                </div>
                                                <div class="card-body">

                                                    <a>
                                                        {{-- <a href="criteria?module=[[module.name]]&report=[[report.name]]"></a> --}}
                                                        <!--<legend class="font-weight-semibold">[[report.name]]</legend>-->
                                                        <p>[[report.description]]</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                </div>

                                <div ng-if="myReports.length > 0" class="tab-pane fade" id="my-reports">
                                    <div class="row">

                                        <div ng-cloak ng-repeat="report in myReports" class="col-md-6">
                                            <div class="card"  >
                                                <div class="card-header header-elements-inline">
                                                    {{-- <legend class="font-weight-semibold">[[report.name]]</legend> --}}
                                                    <h5 class="card-title sortable" ng-click="loadConfigAndRunReport(report,true)" style="cursor: pointer">
                                                        <a data-popup="tooltip" data-original-title="[[report.name]]" data-trigger="hover" class="current-div1">
                                                            [[report.name]]
                                                        </a>
                                                    </h5>
                                                    <div class="list-icons">
                                                        <a ng-click="openShareModal(report)" data-popup="tooltip" data-original-title="Share Report" data-trigger="hover" class="current-div1 list-icons-item mr-2"><i class="icon-share2"></i></a>
                                                        <a ng-click="editReport(report)" data-popup="tooltip" data-original-title="Edit Report" data-trigger="hover" class="current-div1 list-icons-item mr-2"><i class="icon-pencil6"></i></a>
                                                        <a ng-click="deleteReport(report)" data-popup="tooltip" data-original-title="Delete Report" data-trigger="hover" class="current-div1 list-icons-item mr-2"><i class="icon-trash"></i></a>
                                                    </div>
                                                </div>
                                                <div class="card-body">
                                                    
                                                    <a >
                                                        <p>[[report.description]]</p>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>


                                    </div>


                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- /content area -->


        <!-- /main content -->

    </div>
    <div id="shareReport" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title">[[shareReportForm.edit ? 'Edit' : 'Share']] [[shareReportForm.module_report ? 'module' : '']] Report</h5>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              {{-- <form ng-submit="shareReportConfig()"> --}}

                 <div class="modal-body filters">
                    <div class="form-group row">
                       <div class="col-lg-12">
                          <label class="col-form-label">Report Name <span class="required">*</span></label>
                          <input ng-model="shareReportForm.name" type="text" class="form-control">
                       </div>
                       <div class="col-lg-12">
                          <label class="col-form-label">Description</label>
                          <textarea ng-model="shareReportForm.description" class="form-control"></textarea>
                       </div>
                       {{-- <div class="col-lg-12" >
                        <label class="col-form-label">For me <span class="required">*</span></label>
                        <md-switch class="" ng-model="shareReportForm.for_me"> 
                        </md-switch>
                        </div>  --}}
                       {{-- [[getModules]] --}}
                        <div class="col-lg-12" ng-if="!shareReportForm.edit">
                            <label class="col-form-label">Select Module <span class="required">*</span></label>
                            <md-select class="form-control" ng-model="shareReportForm.module_id" placeholder="Select your Module"> 
                                <md-option ng-repeat="module in modules" value="[[module.id]]">[[module.name]]</md-option>
                            </md-select>
                        </div> 
                        <div class="col-lg-12" ng-if="!shareReportForm.edit">
                            <label class="col-form-label">Share with all <span class="required">*</span></label>
                            <md-switch class="" ng-model="shareReportForm.shareWith"> 
                            </md-switch>
                        </div> 
                        <div class="col-lg-12" ng-hide="shareReportForm.shareWith" ng-if="!shareReportForm.edit">
                            <label class="col-form-label">Select Role <span class="required">*</span></label>
                            <md-select class="form-control" multiple ng-model="shareReportForm.role_ids" placeholder="Select your Role"> 
                                <md-option ng-repeat="role in roles" value="[[role.id]]">[[role.name]]</md-option>
                            </md-select>
                        </div> 
                    </div>

                 </div>

                 <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-if="!shareReportForm.edit" ng-click="shareReportConfig()">Save</button>
                    <button type="button" class="btn btn-primary" ng-if="shareReportForm.edit" ng-click="editReportConfig()">Update</button>
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                 </div>
              {{-- </form> --}}
           </div>
        </div>
    </div>

    <div id="moveReport" class="modal fade" tabindex="-1">
        <div class="modal-dialog modal-md">
           <div class="modal-content">
              <div class="modal-header">
                 <h5 class="modal-title">Move Report</h5>
                 <button type="button" class="close" data-dismiss="modal">&times;</button>
              </div>
              {{-- <form ng-submit="shareReportConfig()"> --}}

                 <div class="modal-body filters">
                    <div class="form-group row">
                       {{-- [[getModules]] --}}
                        <div class="col-lg-12">
                            <label class="col-form-label">Select Module <span class="required">*</span></label>
                            <md-select class="form-control" ng-model="moveReportForm.module_id" placeholder="Select your Module"> 
                                <md-option ng-repeat="module in modules" value="[[module.id]]">[[module.name]]</md-option>
                            </md-select>
                        </div> 
                    </div>

                 </div>

                 <div class="modal-footer">
                    <button type="button" class="btn btn-primary" ng-click="moveReportConfig()">Save</button>
                    <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                 </div>
              {{-- </form> --}}
           </div>
        </div>
    </div>
</div>
@endsection

@section('inlineJS')

@endsection