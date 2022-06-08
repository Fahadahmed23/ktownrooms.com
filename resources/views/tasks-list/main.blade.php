<style>
    .fc-widget-content .fc-scroller {height: auto !important;}
    .booking_detail {line-height: 13px;font-size: 13px;}
    .fc-right button {float: right;}
    .cursorShow{cursor: default;}
    </style>

    <div id="bookings-table" class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
        <div class="card bookingTable">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">
                    Miscellaneous Amount
                        <!--<span>
                            <a href="#" class="" ng-click="showFilter()">
                                <i id="" class="icon-search4 " style="font-size: 12px;"></i>
                            </a>
                        </span> -->
                </h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                       <!-- <a class="list-icons-item" data-action="reload" ng-click="init()"></a> -->

                    </div>
                </div>
            </div>

            <div class="table table-responsive dataTables_wrapper">
                <table ng-cloak class="table table-striped hover display dataTable datatable-basic">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Amount</th>
                            <th>Is Btc</th>
                            <th>BTC Status</th>
                        </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink">

                        <tr class="col-lg-12 unread" ng-repeat="d in miscellaneous_amounts" ng-cloak>
                            <td>[[d.name]]</td>
                            <td>[[d.amount]]</td>
                            <td>[[d.is_complementary]]</td>
                            <td>
                                <md-switch ng-true-value="1" ng-false-value="0" ng-model="d.is_complementary" style="display:inline;" tabindex="0" type="checkbox" role="checkbox" class="ng-pristine ng-untouched ng-valid ng-empty" aria-checked="false" aria-invalid="false" ng-click="updateMiscellaneous(d.id,d.is_complementary,Invoice)">
                                </md-switch>
                                
                                <a ng-click="deleteMiscellaneous(d,d.id,d.name,Invoice)" class="list-icons-item text-danger delete" data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash" aria-hidden="true"></i></a>

                            
                            </td>
                        </tr>
                        
                
                    </tbody>
                </table>
                <dir-pagination-controls pagination-id="bookingPagination" on-page-change="pageChanged(newPageNumber)" direction-links="true" boundary-links="true"></dir-pagination-controls>
            </div>

            

        </div>
    </div>

    <div id="bookings-table" class="col-12 col-md-12 col-sm-12 left-tour-bar float-left p-0">
        <div class="card bookingTable">
            <div class="card-header header-elements-inline">
                <h5 class="card-title">
                    Services Amount
                        <!--<span>
                            <a href="#" class="" ng-click="showFilter()">
                                <i id="" class="icon-search4 " style="font-size: 12px;"></i>
                            </a>
                        </span> -->
                </h5>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                       <!-- <a class="list-icons-item" data-action="reload" ng-click="init()"></a> -->

                    </div>
                </div>
            </div>

            <div class="table table-responsive dataTables_wrapper">
                <table ng-cloak class="table table-striped hover display dataTable datatable-basic">
                    <thead>
                        <tr>
                            <th>Service Name</th>
                            <th>Service Charges</th>
                            <th>Is Btc</th>
                            <th>BTC Status</th>
                        </tr>
                    </thead>
                    <tbody data-link="row" class="rowlink">
                        <tr class="col-lg-12 unread" ng-repeat="service in Invoice.services" ng-cloak>
                            <td>[[service.service_name]]</td>
                            <td>[[service.service_charges]]</td>
                            <td>[[service.is_btc]]</td>
                            <td>
                                <md-switch ng-true-value="1" ng-false-value="0" ng-model="service.is_btc" style="display:inline;" tabindex="0" type="checkbox" role="checkbox" class="ng-pristine ng-untouched ng-valid ng-empty" aria-checked="false" aria-invalid="false" ng-click="updateService(service.service_name,service.is_btc,service)">
                                </md-switch>
                                
                                <a ng-click="deleteMiscellaneous(d,d.id,d.name,Invoice)" class="list-icons-item text-danger delete" data-popup="tooltip" title="Delete" data-trigger="hover"><i class="fas fa-trash" aria-hidden="true"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
                <dir-pagination-controls pagination-id="bookingPagination" on-page-change="pageChanged(newPageNumber)" direction-links="true" boundary-links="true"></dir-pagination-controls>
            </div>

            

        </div>
    </div>

    
