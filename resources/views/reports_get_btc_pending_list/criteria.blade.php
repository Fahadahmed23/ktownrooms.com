@extends('layouts.app')
@php
$link = Request::fullUrl();
$parsedUrl = parse_url($link);
parse_str($parsedUrl['query'], $parsedQuery);
$title = ucfirst(isset($parsedQuery['title']) ? $parsedQuery['title'] : $parsedQuery['report']);
@endphp
@section('title')
{{ $title }} Criteria
@endsection
@section('CSSLibraries')
<style>
   table {
      width: 100%;
   }

   .md-select-menu-container {
      z-index: 9999999;
   }

   md-backdrop.md-select-backdrop {
      z-index: 999999;
   }

   .and-span {
      text-align: center;
      width: 100%;
      font-weight: bold;
      margin-top: 15px;
   }

   .or-span {
      width: 100%;
      display: inline-block;
      text-align: center;
      font-weight: bold;
      margin-top: 15px;
   }

   .f-w-500 {
      font-weight: 500;
   }

   .stepper {
      margin-bottom: .65rem;
      display: flex;
      padding: 0;
      width: 100%;
      list-style: none;
      position: relative;
   }

   .stepper::before {
      position: absolute;
      top: 0;
      left: 0;
      height: 100%;
      content: "";
      width: calc(100% - 20px);
      background: #e7e7e7;
   }

   .stepper__item {
      flex: 100%;
      padding: 20px 20px 20px 40px;
      background: repeating-linear-gradient(-65deg, #fff, #fff 20px, #fcfcfc 20px, #fcfcfc 40px);
      -webkit-clip-path: polygon(20px 50%, 0% 0%, calc(100% - 20px) 0%, 100% 50%, calc(100% - 20px) 100%, 0% 100%);
   }

   .stepper__item.current {
      background: #fff;
      /* font-weight: bold; */
   }

   .stepper__item.complete {
      /* background: repeating-linear-gradient(-65deg, #fcfcfc, #fcfcfc 20px, #f4faf7 20px, #f4faf7 40px); */
   }

   .stepper__item:first-child {
      padding: 20px;
      -webkit-clip-path: polygon(0% 0%, calc(100% - 20px) 0%, 100% 50%, calc(100% - 20px) 100%, 0% 100%);
   }

   .stepper__item:last-child {
      -webkit-clip-path: polygon(20px 50%, 0% 0%, 100% 0%, 100% 100%, 0% 100%);
   }
</style>

@endsection


@section('scripts')
<script src="{{ asset_path('app/reports-controller.js') }}"></script>
<script src="{{ asset_path('global_assets/js/plugins/ui/dragula.min.js') }}"></script>
<script src="{{ asset_path('assets/js/report-columns.js') }}"></script>
@endsection

@section('content')
<!-- Page content -->
<div class="page-content" ng-controller="reportsCtrl" ng-init="init()">

   <!-- Main sidebar -->

   <!-- Main content -->
   <div class="content-wrapper">

      <!-- Page header -->
      @include('reports_get_guest_detail.header')
      <!--/page header-->
      <!-- Content area -->
      <div class="content">
         <ul class="stepper">
            <li class="stepper__item complete"><b>Step 1(Optional)</b>
               <span style="margin-left: 10px;">Select filter,columns and groups to be displayed</span>
            </li>
            <li class="stepper__item current"><b>Step 2</b>
               <span style="margin-left: 10px;">Preview the report output </span>
            </li>
            <li class="stepper__item"><b>Step 3</b>
               <span style="margin-left: 10px;">Click on Run</span>
            </li>
         </ul>
         <div class="card admin-form-section">
            <div class="card-header header-elements-inline">
               <h5 class="card-title"> <a style="color: black;" href="javascript:void(0)"> <i ng-click="goBack()" class="icon-arrow-left7"></i> </a> &nbsp;&nbsp;[[params.title?params.title:params.report]] Report</h5>
               <!-- <div class="header-elements">
                  <div class="list-icons">
                     <a class="list-icons-item" data-action="collapse"></a>
                     <a class="list-icons-item d-block" data-action="remove"></a>
                  </div>
               </div> -->
            </div>
            <div class="card-body">
               <div class="nav-tabs-responsive bg-light border-top">
                  <ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
                     <li class="nav-item"><a id="a1" href="#search-criteria" class="nav-link active" data-toggle="tab"><i class="icon-search4 mr-2"></i> Filter</a></li>
                     <li class="nav-item"><a id="a2" href="#display-columns" class="nav-link" data-toggle="tab"><i class="icon-table2 mr-2"></i>Columns</a></li>
                     <li class="nav-item"><a id="a3" href="#group-columns" class="nav-link" data-toggle="tab"><i class="icon-make-group mr-2"></i> Groups</a></li>
                     <li class="nav-item"><a id="a4" href="#preview" class="nav-link" data-toggle="tab" ng-click="refresh()"><i class="icon-eye mr-2"></i> Preview</a></li>
                  </ul>
               </div>

               <div class="tab-content">
                  <div class="tab-pane fade show active" id="search-criteria">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="card">
                              <div class="card-header header-elements-inline">
                                 <h5 class="card-title">Filter Criteria&nbsp;
                                    <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-toggle="tab" data-popup="tooltip" data-container="body" data-html="true" data-original-title="<b>Step#1: </b>Choose the column name to be filtered</br><b>Step#2: </b>Select the operator(e.g. Equal to) according to column</br><b>Step#3: </b>Entered the value to be searched</br><b>Note:</b>There is AND operator in between the column criteria and OR operator is performed between two search groups.</br>" aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a>
                                    <!-- <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="Search criteria allows user to filter the reporting data" aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a> -->
                                 </h5>
                                 <div class="header-elements">
                                    <div class="list-icons">
                                       <a class="list-icons-item" data-action="collapse"></a>
                                       <!-- <a class="list-icons-item d-block" data-action="remove"></a> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="card-body">
                                 @include('reports_get_btc_pending_list.edit-criteria-tab-modal')
                                 <!-- <p ng-if="searchGroups[0][0].column == null">No Criteria selected</p>
                           <p ng-if="searchGroups[0][0].column != null">This report will display following search criteria</p>
                           <ul ng-if="searchGroups[0][0].column != null">
                              <div ng-cloak ng-repeat="searchGroup in searchGroups">
                                 <li ng-cloak ng-repeat="searchCriteria in searchGroup">[[searchCriteria.column.alias]] [[searchCriteria.operator]] [[searchCriteria.value]] <span ng-if="!$last">AND</span></li>
                                 <span ng-if="!$last">OR</span>
                              </div>
                           </ul> -->
                              </div>
                              <!-- <div class="card-footer">
                           <div class="text-left">
                              <button type="button" class="btn btn-primary legitRipple" data-toggle="modal" data-target="#EditCriteria">Edit Criteria</button>
                              <button type="button" class="btn btn-primary" ng-click="resetSearchGroup()">Reset Criteria</button>
                              <!-- <button ng-click="getselectedcolumns()"  type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditColumns">Edit Colums</button>
                           </div>
                        </div> -->
                           </div>
                        </div>

                     </div>
                  </div>
                  <div class="tab-pane fade" id="display-columns">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="card">
                              <div class="card-header header-elements-inline">
                                 <h5 class="card-title">Display Columns&nbsp;
                                    <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="The columns displayed in 'Selected Columns' will be displayed in report. To add/remove columns Simply drag n drop columns from 'Available Columns' card and to sort columns drag in desired order in 'Selected Columns'" aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a>
                                    <!-- <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="These following column will be displayed in same order when the report will be generated" aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a> -->
                                 </h5>
                                 <div class="header-elements">
                                    <div class="list-icons">
                                       <a class="list-icons-item" data-action="collapse"></a>
                                       <!-- <a class="list-icons-item d-block" data-action="remove"></a> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="card-body">
                                 @include('reports_get_btc_pending_list.edit-tab-columns-modal')
                                 <!-- <p>This report will display the following columns</p>
                                 <ul>
                                    <li ng-cloak ng-repeat="col in selectedColumns">
                                       <span name="[[col.Alias]]" for="[[col.Alias]]" ng-click="availablecolumnclick(col.Alias,true)">[[col.Aggregation.length>0 ? col.Aggregation + "(" + col.Alias + ")" : col.Alias]]</span>
                                       <input class="form-control" style="display:none;width:40%;" value="[[col.Alias]]" type="text" name="[[col.Alias]]" ng-blur="availablecolumnclick(col.Alias,false)">
                                    </li>
                                 </ul> -->
                              </div>
                              <!-- <div class="card-footer">
                                 <div class="text-left">
                                    <button ng-click="getSelectedColumns()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditColumns">Edit Columns</button>
                                    <button ng-click="getSelectedColumnsForAggregate()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditColumnsAggregate">Edit Aggregates&nbsp;
                                       <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="Aggregation i.e. sum,average,minimum,maximum etc can be applied on provided column" aria-describedby="tooltip696410">
                                          <i class="icon-help top-0"></i>
                                       </a></button>
                                    <button ng-click="resetColumns()" type="button" class="btn btn-primary">Reset Columns&nbsp;
                                       <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="Click reset to set columns to default" aria-describedby="tooltip696410">
                                          <i class="icon-help top-0"></i>
                                       </a></button>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="tab-pane fade" id="group-columns">
                     <div class="row">
                        <div class="col-md-12">
                           <div class="card">
                              <div class="card-header header-elements-inline">
                                 <h5 class="card-title">Grouped Columns&nbsp;
                                    <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="The Columns displayed in 'Grouped Columns' will be grouped when report is executed. To add/remove columns Simply drag n drop columns from 'Ungrouped Columns' card" aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a>
                                    <!-- <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="The GROUPED Columns groups rows that have the same values into summary rows, like 'find the number of customers in each country'. The GROUP BY statement is often used with aggregate functions (COUNT, MAX, MIN, SUM, AVG) to group the result-set by one or more columns." aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a> -->
                                 </h5>
                                 <div class="header-elements">
                                    <div class="list-icons">
                                       <a class="list-icons-item" data-action="collapse"></a>
                                       <!-- <a class="list-icons-item d-block" data-action="remove"></a> -->
                                    </div>
                                 </div>
                              </div>
                              <div class="card-body">
                                 @include('reports_get_guest_detail.edit-tab-grouped-columns-modal')
                                 <!-- <p>This report will group the following columns</p>
                                 <ul>
                                    <li ng-cloak ng-repeat="col in groupedColumns">
                                       <span name="[[col.Alias]]" for="[[col.Alias]]" ng-click="availablecolumnclick(col.Alias,true)">[[col.Alias]]</span>
                                       <span name="[[col.Alias]]1" for="[[col.Alias]]" ng-click1="availablecolumnclick(col.Alias,true)">[[col.Alias]]</span>
                                    </li>
                                 </ul> -->
                              </div>
                              <!-- <div class="card-footer">
                                 <div class="text-left">
                                    <button ng-click="getGroupedColumns()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditGroupedColumns">Edit Columns</button>
                                    <button ng-click="resetGrpColumns()" type="button" class="btn btn-primary">Reset Grouped Columns</button>
                                 </div>
                              </div> -->
                           </div>
                        </div>
                     </div>
                  </div>

                  <div class="tab-pane fade" id="preview">
                     <div style="margin-top: 15px;;" class="row">
                        <div class="col-md-6">
                           <div class="card">
                              <div class="card-header header-elements-inline">
                                 <h5 class="card-title">Filter Criteria&nbsp;
                                    <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="Search criteria allows user to filter the reporting data" aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a>
                                 </h5>
                                 <div class="header-elements">
                                    <div class="list-icons">
                                       <a class="list-icons-item" data-action="collapse"></a>
                                       <!-- <a class="list-icons-item d-block" data-action="remove"></a> -->
                                    </div>
                                 </div>
                              </div>
                              <div style="height: 180px; overflow-y: auto;" class="card-body">
                                 <p ng-if="searchGroups[0][0].column == null">No Criteria selected</p>
                                 <p ng-if="searchGroups[0][0].column != null">This report will display following filter criteria</p>
                                 <ul ng-if="searchGroups[0][0].column != null">
                                    <div ng-cloak ng-repeat="searchGroup in searchGroups">
                                       <li ng-cloak ng-repeat="searchCriteria in searchGroup">[[searchCriteria.column.alias]] [[searchCriteria.operator]] [[searchCriteria.value]] <span ng-if="!$last">AND</span></li>
                                       <span ng-if="!$last">OR</span>
                                    </div>
                                 </ul>
                              </div>
                              <div class="card-footer">
                                 <div class="text-left">
                                    <button type="button" class="btn btn-outline bg-slate-600 text-slate-600 border-slate" ng-click="goToFilter()"><i class="mr-1 icon-pencil6"></i> Edit Criteria</button>
                                 </div>
                              </div>
                           </div>

                           <div class="card">
                              <div class="card-header header-elements-inline">
                                 <h5 class="card-title">Grouped Columns&nbsp;
                                    <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="The GROUPED Columns groups rows that have the same values into summary rows, like 'find the number of customers in each country'. The GROUP BY statement is often used with aggregate functions (COUNT, MAX, MIN, SUM, AVG) to group the result-set by one or more columns." aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                 </h5>
                                 <div class="header-elements">
                                    <div class="list-icons">
                                       <a class="list-icons-item" data-action="collapse"></a>
                                       <!-- <a class="list-icons-item d-block" data-action="remove"></a> -->
                                    </div>
                                 </div>
                              </div>
                              <div style="height: 180px; overflow-y: auto;" class="card-body">
                                 <p>This report will group the following columns</p>
                                 <ul>
                                    <li ng-cloak ng-repeat="col in groupedColumnsP">
                                       <!-- <span name="[[col.Alias]]" for="[[col.Alias]]" ng-click="availablecolumnclick(col.Alias,true)">[[col.Alias]]</span> -->
                                       <span name="[[col.Alias]]1" for="[[col.Alias]]" ng-click1="availablecolumnclick(col.Alias,true)">[[col.Alias]]</span>
                                    </li>
                                 </ul>
                              </div>
                              <div class="card-footer">
                                 <div class="text-left">
                                    <button type="button" class="btn btn-outline bg-slate-600 text-slate-600 border-slate" ng-click="goToGroup()"><i class="mr-1 icon-pencil6"></i> Edit Groups</button>

                                    <!-- <button ng-click="resetGrpColumns()" type="button" class="btn btn-primary">Reset Grouped Columns</button> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="col-md-6">
                           <div class="card">
                              <div class="card-header header-elements-inline">
                                 <h5 class="card-title">Display Columns&nbsp;
                                    <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="These following column will be displayed in same order when the report will be generated" aria-describedby="tooltip696410">
                                       <i class="icon-help top-0"></i>
                                    </a>
                                 </h5>
                                 <div class="header-elements">
                                    <div class="list-icons">
                                       <a class="list-icons-item" data-action="collapse"></a>
                                       <!-- <a class="list-icons-item d-block" data-action="remove"></a> -->
                                    </div>
                                 </div>
                              </div>
                              <div style="height: 515px;overflow-y:auto;" class="card-body">
                                 <p>This report will display the following columns</p>
                                 <ul>
                                    <li ng-cloak ng-repeat="col in selectedColumnsP">
                                       <span name="[[col.Alias]]" for="[[col.Alias]]" ng-click="availablecolumnclick(col.Alias,true)">[[col.Aggregation.length>0 ? col.Aggregation + "(" + col.Alias + ")" : col.Alias]]</span>
                                       <input class="form-control" style="display:none;width:40%;" value="[[col.Alias]]" type="text" name="[[col.Alias]]" ng-blur="availablecolumnclick(col.Alias,false)">
                                    </li>
                                 </ul>
                              </div>
                              <div class="card-footer">
                                 <div class="text-left">
                                    <button type="button" class="btn btn-outline bg-slate-600 text-slate-600 border-slate" ng-click="goToColumn()"><i class="mr-1 icon-pencil6"></i> Edit Columns</button>


                                    <button type="button" class="btn btn-outline bg-slate-600 text-slate-600 border-slate" ng-click="getSelectedColumnsForAggregate()" data-toggle="modal" data-target="#EditColumnsAggregate">
                                       <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="Aggregation i.e. sum,average,minimum,maximum etc can be applied on provided column" aria-describedby="tooltip696410">
                                          <i class="mr-1 icon-help"></i>Edit Aggregates
                                       </a></button>


                                    <!-- <button ng-click="getSelectedColumnsForAggregate()" type="button" class="btn btn-primary" data-toggle="modal" data-target="#EditColumnsAggregate">Edit Aggregates&nbsp;
                                       <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="Aggregation i.e. sum,average,minimum,maximum etc can be applied on provided column" aria-describedby="tooltip696410">
                                          <i class="icon-help top-0"></i>
                                       </a></button> -->
                                    <!-- <button ng-click="resetColumns()" type="button" class="btn btn-primary">Reset Columns&nbsp;
                                 <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="Click reset to set columns to default" aria-describedby="tooltip696410">
                                    <i class="icon-help top-0"></i>
                                 </a></button> -->
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-md-6">

                        </div>
                     </div>
                  </div>
               </div>




               <div class="text-right">
                  <!-- <button type="button" ng-click="goBack()" class="btn btn-primary">Back <i class="icon-backspace2 ml-2"></i></button> -->
                  <button type="button" ng-click="resetReport()" class="btn btn-outline-danger"><i class="mr-1 icon-reset"></i> Reset </button>
                  <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#SaveReport"><i class="mr-1 icon-floppy-disk"></i> Save</button>



                  <!-- <button type="button" ng-click="saveReportConfig()" class="btn btn-primary">Save Report Configuration <i class="icon-floppy-disk ml-2"></i></button> -->
                  <!-- <a href="report[[urlParams]]"><button type="button" class="btn btn-primary"><i class="icon-paperplane"></i> Run </button></a> -->
                  <button type="button" ng-click="run(urlParams)" class="btn btn-primary"><i class="mr-1 icon-paperplane"></i> Run </button>
               </div>
            </div>
         </div>



         @include('reports_get_btc_pending_list.edit-columns-modal')
         @include('reports_get_btc_pending_list.edit-grouped-columns-modal')
         @include('reports_get_btc_pending_list.edit-aggregate-modal')


         <div id="SaveReport" class="modal fade" tabindex="-1">
            <div class="modal-dialog modal-md">
               <div class="modal-content">
                  <div class="modal-header">
                     <h5 class="modal-title">Save Report Configuration</h5>
                     <button type="button" class="close" data-dismiss="modal">&times;</button>
                  </div>
                  <form ng-submit="saveReportConfig()">

                     <div class="modal-body filters">
                        <div class="form-group row">
                           <div class="col-lg-12">
                              <label class="col-form-label">Report Name</label>
                              <input ng-model="saveReportForm.name" type="text" class="form-control">
                           </div>
                           <div class="col-lg-12">
                              <label class="col-form-label">Description</label>
                              <textarea ng-model="saveReportForm.description" class="form-control"></textarea>
                           </div>
                           <!--   <div class="col-lg-12">
                                                <label class="col-form-label">Cusom report type</label>
                                                   <select class="form-control">
                                                       <option>Choose a custom repot type</option>
                                                   </select>
                                            </div> -->
                           <!-- <div class="col-lg-12">
                                                <label class="col-form-label">Make this available to </label>
                                                   <select class="form-control">
                                                       <option>Just me</option>
                                                   </select>
                                            </div> -->
                        </div>

                     </div>

                     <div class="modal-footer">
                        <button type="submit" class="btn btn-outline bg-slate-600 text-slate-600 border-slate">Save</button>
                        <button type="button" class="btn btn-outline bg-slate-600 text-slate-600 border-slate" data-dismiss="modal">Close</button>
                     </div>
                  </form>
               </div>
            </div>
         </div>


         <!-- /content area -->


         <!-- /main content -->

      </div>
   </div>
</div>
@endsection

@section('inlineJS')
<script>
   $(document).ready(function() {
      $('.clickMe').click(function() {
         "use strict";
         $(this).hide();
         $('#' + $(this).attr('for')).val($(this).text()).toggleClass("form-control").show().focus();
      });

      $('.blur').blur(function() {
         "use strict";
         $(this).hide().toggleClass("form-control");
         var myid = (this).id;
         $('span[for=' + myid + ']').text($(this).val()).show();
      });
   })
</script>
@endsection
