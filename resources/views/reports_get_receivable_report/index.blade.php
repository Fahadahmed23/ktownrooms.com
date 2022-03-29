@extends('layouts.app')

@section('scripts')
    <!-- <script src="~/app/reports-controller.js"></script> -->
    <script src="{{ asset_path('app/report-controller.js') }}"></script>

@endsection

@section('content')

{{-- <div class="content" ng-controller='reportsCtrl' ng-init='getSavedReports()'> --}}
    <div class="content" ng-controller='reportCtrl'>
    <div class="content-wrapper">

        @include('reports_get_receivable_report.header')

        <div class="content">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header header-elements-inline">
                        <h4 class="card-title">Receivables</h4>
                    </div>
                    {{-- [[rec1 | json]] --}}
                    <table class="table" ng-init="GetReceivableReport()">
                        <thead>
                          <tr>
                            <th scope="col">#</th>
                            <th scope="col">Date</th>
                            <th scope="col">Room No.</th>
                            <th scope="col">Booking No.</th>
                            <th scope="col">Guest Name</th>
                            <th scope="col">Total Amount</th>
                            <th scope="col">Amount Paid</th>
                            <th scope="col">Out Standing Balance</th>
                            <th scope="col">UserName</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-repeat="a in rec1" class="unread">
                            <th scope="row">[[$index +1]]</th>
                            <td>[[a.checkin_time]]</td>
                            <td>[[a.roomNumber]]</td>
                            <td>[[a.booking_no]]</td>
                            <td>[[a.customer_first_name]] [[a.customer_last_name]]</td>
                            <td>[[a.net_total]]</td>
                            <td>[[a.payment_amount]]</td>
                            <td>[[a.balance_outstanding]]</td>
                            <td>[[a.user_name]]</td>
                            
                          </tr>
                        </tbody>
                      </table>

             
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
