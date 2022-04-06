<style>
    .md-select-menu-container.md-active.md-clickable{
        z-index: 1000;
    }

    </style>
<div class="sidebar sidebar-light bg-transparent sidebar-component border-0 shadow-0 sidebar-expand-md" style="none">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Filter -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="#" class="" ng-click="hideFilter()"><i class="fa fa-close" style="font-size: 12px;"></i></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form>

                    <md-select name="hotel"  class="m-0" ng-model="searchReportingAttributes.Hotel" placeholder="Select a Hotel">
                        <md-option ng-repeat="hotel in hotels" ng-value="hotel.hotel_id">[[hotel.hotel_name]]</md-option>
                    </md-select>

                    <div class="floating-label"> 
                        <input ng-model="searchReportingAttributes.booking_no" type="text" class="form-control ng-valid ng-not-empty ng-dirty ng-valid-parse ng-touched" placeholder=" " aria-invalid="false" style="">
                        <span class="highlight"></span>
                        <label>Booking #</label>
                    </div>

                    <div class="floating-label"> 
                        <input ng-model="searchReportingAttributes.cnic" type="text" class="form-control ng-valid ng-not-empty ng-dirty ng-valid-parse ng-touched" placeholder=" " aria-invalid="false" style="">
                        <span class="highlight"></span>
                        <label>Cnic/Passport #</label>
                    </div>

                    <div class="floating-label"> 
                        <input ng-model="searchReportingAttributes.mobile_no" type="text" class="form-control ng-valid ng-not-empty ng-dirty ng-valid-parse ng-touched" placeholder=" " aria-invalid="false" style="">
                        <span class="highlight"></span>
                        <label>Mobile #</label>
                    </div>

                    <div class="float-right">
                        <button class="btn btn-default float-right" ng-click="filterData_invoice_search(searchReportingAttributes, 'clear')"  type="reset">Reset</button>
                        <button class="btn btn-primary float-right" ng-click="filterData_invoice_search(searchReportingAttributes)">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /filter -->
    </div>
    <!-- /sidebar content -->
</div>

