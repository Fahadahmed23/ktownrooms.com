<style>
     .md-select-menu-container,
    md-backdrop {
        z-index: 999999 !important;
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
                    <div class="floating-label">

                        <md-select ng-disabled="user.name == 'Frontdesk' " md-no-asterisk  aria-invalid="true" class="m-0" ng-model="filter.hotel_id" placeholder="Regent Plaza">
                            <md-option ng-repeat="h in hotels" ng-value="h.id">[[h.HotelName]]</md-option>
                        </md-select>
                        <span class="highlight"></span>

                    </div>

                    <div class="float-right">
                        <button class="btn btn-primary float-right" ng-click="filterBookingServices(filter)">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /filter -->
    </div>
    <!-- /sidebar content -->
</div>