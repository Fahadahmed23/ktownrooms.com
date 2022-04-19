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
                Expense Report 
                    <span><a href="#" class="" ng-click="showFilter()">
                        <i id="" class="icon-search4 " style="font-size: 12px;"></i> 
                   </a></span>
            </h5>
        </div>

        <table id="examplefahad" datatable="ng" dt-options="dtOptions" class="table table-striped hover display dataTable datatable-basic receivable-report-table">

        <!-- <table id="examplefahad" datatable="ng" dt-options="vm.dtOptions" ng-cloak class="table table-striped hover display dataTable datatable-basic receivable-report-table">-->
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Date</th>
                    <th scope="col">Expense Details</th>
                    <th scope="col">Expense Amount</th>
                    <th scope="col" style="visibility: hidden;">Date</th>
                    <th scope="col" style="visibility: hidden;">Expense Details</th>
           
                </tr>
            </thead>
                <tbody data-link="row" class="rowlink">
                    <tr class="col-lg-12 unread" ng-repeat="a in getexpenses" ng-cloak>
                        <th scope="row">[[$index +1]]</th>
                        <td>[[a.created_at]]</td>
                        <td>[[a.description]]</td>
                        <td>[[a.cr_amount]]</td>
                        <td style="visibility: hidden;">[[a.created_at]]</td>
                        <td style="visibility: hidden;">[[a.description]]</td>
                    </tr>
                </tbody>
            </table>
            
       
 
    </div>
</div>


