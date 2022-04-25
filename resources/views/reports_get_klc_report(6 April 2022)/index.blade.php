@extends('layouts.app')

@section('scripts')
    <!-- <script src="~/app/reports-controller.js"></script> -->
    <script src="{{ asset_path('app/report-controller.js') }}"></script>
@endsection

@section('content')

{{-- <div class="content" ng-controller='reportsCtrl' ng-init='getSavedReports()'> --}}
    <div class="content" ng-controller='reportCtrl'>
    <div class="content-wrapper">

        @include('reports_get_klc_report.header')

        <div class="content">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h4 class="card-title">KLC</h4>
                    </div>
                    {{-- [[getklc | json]] --}}
                    <table class="table" ng-init="GetKlcReprot()">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Guest Name</th>
                            <th scope="col">CheckIn</th>
                            <th scope="col">CheckOut</th>
                            <th scope="col">Room #</th>
                            <th scope="col">Room Rent</th>
                            <th scope="col">Nights</th>
                            <th scope="col">Total Other Amenities  (Room Services, Miscelaneous )</th>
                            <th scope="col">Total Room Revenue</th>
                            <th scope="col">Total Amount(All expenses + room rent)</th>
                            <th scope="col">Total Amount Received</th>
                            <th scope="col">Amount Balance  (I - J) </th>
                            <!--<th scope="col">KTOWN Booking Comission</th>
                            <th scope="col">KTOWN Software Fees</th> -->
                            <th scope="col">User Name</th>

                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="k in getklc" class="unread">
                                <th scope="row">[[$index +1]]</th>
                                <td>[[k.BookingFrom]]</td>
                                <td>
                                    [[k.customer_first_name]] [[k.customer_last_name]]
                                </td>
                                <td>[[k.checkin_time]]</td>
                                <td>[[k.checkout_time]]</td>
                                <td>[[k.roomnumber]]</td>
                                <td>[[k.roomscharges]]</td>
                                <td>[[k.nights]]</td>
                                <td>[[k.total_other_amenities]]</td>
                                <td>[[k.total_room_revenue]]</td>
                                <td>[[k.total_amount]]</td>
                                <td>[[k.total_amount_received]]</td>
                                <td>[[k.amount_balance]]</td>
                                <td>[[k.user_name]]</td>
                          </tr>
                        </tbody>
                      </table>

                    <div class="card-body">
                        {{-- [[modules]] --}}
                        <div style="display: inline-flex; width: 100%;" class="justify-content-lg-between">
                            <ul class="nav nav-pills flex-column mr-lg-3 wmin-lg-250 mb-lg-0">

                                <li ng-cloak ng-repeat="module in modules" class="nav-item">
                                    <a href="#[[module.name]]" ng-click="activeModule(module.name)" ng-class="{ active: module.name == (currentModule ? currentModule : 'Bookings')} " class="nav-link" data-toggle="tab">
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
                                                <div class="card-header header-elements-inline">
                                                    <h5 class="card-title sortable " ng-click="loadDynamicReport(report.report)" style="cursor: pointer">
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
                                                    <h5 class="card-title sortable" ng-click="loadConfigAndRunReport(report)" style="cursor: pointer">
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
                          <label class="col-form-label">Description <span class="required">*</span></label>
                          <textarea ng-model="shareReportForm.description" class="form-control"></textarea>
                       </div>
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