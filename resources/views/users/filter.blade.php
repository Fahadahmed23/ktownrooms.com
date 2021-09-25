<style>
    .md-select-menu-container,
   md-backdrop {
       z-index: 999999 !important;
   }
</style>
<div id="filterFrm" style="display:none" class="sidebar sidebar-light bg-transparent border-0 shadow-0 sidebar-expand-md">
    <!-- Sidebar content -->
    <div class="sidebar-content">
        <!-- Filter -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                        <a class="list-icons-item" ng-click="hideFilter()"><i class="fa fa-close" style="font-size: 12px;"></i></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                <form name="filterForm">
                    <div class="floating-label"> 
                        <input ng-model="searchName" type="text" class="form-control" maxlength="50" placeholder=" ">
                        <span class="highlight"></span>
                        <label>User Name </label>
                    </div>

                    <div class="floating-label"> 
                        <input ng-model="searchEmail" type="text" class="form-control" maxlength="50" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Email </label>
                    </div>

                    <div class="floating-label"> 
                        <input ng-model="searchPhone" type="text" class="form-control phone_us" maxlength="15" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Phone No. </label>
                    </div>

                    <div class="my-3">
                        <label>Select Hotel</label>
                        <md-select  md-no-asterisk  aria-invalid="true" class="m-0" ng-model="searchHotel" placeholder="Regent Plaza">
                            <md-option ng-repeat="h in hotels" ng-value="h.id">[[h.HotelName]]</md-option>
                        </md-select>
                    </div>

                    <div class="float-right">
                        <button type="reset" ng-click="resetFilters()" class="btn btn-default">Reset</button>
                        <button type="button" ng-click="getUsers()" class="btn btn-primary">Filter</button>
                    </div>
                </form>
            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->
</div>