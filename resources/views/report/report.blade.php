@extends('layouts.app')
@php
$link = Request::fullUrl();
$parsedUrl = parse_url($link);
parse_str($parsedUrl['query'], $parsedQuery);
$title = ucfirst(isset($parsedQuery['title']) ? $parsedQuery['title'] : $parsedQuery['report']);
@endphp
@section('title')
{{ $title }} Report
@endsection
<style>
    table {
        width: 100%;
    }

    .tab-content a {
        color: black;
    }

    .input-group-append {
        display: inline-flex;
    }

    .datatable-basic thead .sorting:after {
        content: "";
        margin-top: -.625rem;
        opacity: .5;
    }

    .dataTable thead .sorting:before {
        content: "";
        margin-top: -.125rem;
        opacity: .5;
    }
</style>



@section('scripts')
<script src="{{ asset_path('app/report-controller.js') }}"></script>
<script src="{{ asset_path('assets/js/tableHTMLExport.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.0.10/jspdf.plugin.autotable.min.js"></script>

@endsection

@section('content')
<!-- Page content -->
<div class="page-content" ng-controller="reportCtrl" ng-init="runReport()">
    <!-- Main sidebar -->
    <!-- Main content -->
    <div class="content-wrapper">
        <!-- Page header -->
        @include('report.header')
        <!--/page header-->
        <!-- Content area -->
        <div class="content">
            <div class="card admin-form-section">
                <div class="card-header header-elements-inline">
                    <h5 class="card-title">[[params.title?params.title:params.report]] Report &nbsp; <a href="criteria[[urlParams]]"><button type="button" class="btn btn-outline-danger"><i class="icon-gear"></i> Configure Report</button></a>
                        <button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#SaveReport"><i class="icon-floppy-disk"></i> Save Report Configuration</button>
                    </h5>
                    <div class="input-group-append">
                        <button type="button" class="btn bg-primary legitRipple">Export</button>
                        <button type="button" class="btn btn-light dropdown-toggle legitRipple legitRipple-empty" data-toggle="dropdown" aria-expanded="false"></button>
                        <div class="dropdown-menu dropdown-menu-right" x-placement="bottom-end" style="position: absolute; will-change: transform; top: 0px; left: 0px; transform: translate3d(506px, 38px, 0px);">
                            <a ng-click="exportPdf()" class="dropdown-item"><i class="icon-file-pdf"></i> PDF</a>
                            <a ng-click="toCsv(params.title?params.title:params.report)" class="dropdown-item"><i class="icon-file-excel"></i> Excel</a>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <div class="filter-table">
                        <div class="form-group row">
                            <div class="col-md-10">
                                <div class="text-left">

                                </div>
                            </div>
                           
                        </div>
                    </div>
                    <div class="table table-responsive dataTables_wrapper">
                        <table id="report-tbl" ng-cloak class="table table-striped hover display dataTable datatable-basic">
                            <thead>
                                <tr>
                                    <th ng-cloak ng-repeat="col in reportCols" ng-model="sortColumn[col.Name]" ng-class="sortColumn[col.Name]?sortColumn[col.Name]:'sorting'" ng-click="sort(col,sortColumn[col.Name])">[[col.Alias]]</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr ng-if="reportData.length==0" class="odd">
                                    <td valign="top" colspan="[[reportCols.length]]" class="dataTables_empty">No data available in table</td>
                                </tr>
                                <tr ng-cloak dir-paginate="row in reportData | itemsPerPage:pageSize" current-page="currentPage" pagination-id="mealsPagination" total-items="TotalRecords">
                                    <td ng-cloak ng-repeat="(key,value) in row track by $index" ng-bind-html="renderValue(key, value)">
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <dir-pagination-controls pagination-id="mealsPagination" on-page-change="pageChanged(newPageNumber)" direction-links="true" boundary-links="true"></dir-pagination-controls>
                    </div>
                </div>
            </div>
        </div>

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
                            </div>

                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                            <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /content area -->


    <!-- /main content -->
</div>
@endsection

@section('inlineJS')
<script type="text/javascript">
    function toCsv() {

        $("#report-tbl").tableHTMLExport({
            type: 'csv',
            filename: 'donation.csv'


        });
    }

    function toPdf() {

        $("#report-tbl").tableHTMLExport({
            type: 'pdf',
            filename: 'donation.pdf'


        });
    }
    // $(document).ready(function() {
    //     $('#report-tbl').DataTable({
    //         dom: 'Bfrtip',
    //         buttons: [
    //             {
    //                 extend: 'pdfHtml5',
    //                 orientation: 'landscape',
    //                 pageSize: 'LEGAL'
    //             }
    //         ]
    //     });
    // });
</script>
@endsection