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
                        <input ng-model="searchAttribute.Name" type="text" class="form-control" maxlength="50" placeholder=" " ng-model-options="{ debounce: 500 }" ng-change="searchFilter(searchAttribute)">
                        <span class="highlight"></span>
                        <label>Name </label>
                    </div>

                    <div class="floating-label"> 
                        <input ng-model="searchAttribute.Email" type="text" class="form-control" maxlength="50" placeholder=" " ng-model-options="{ debounce: 500 }" ng-change="searchFilter(searchAttribute)">
                        <span class="highlight"></span>
                        <label>Email </label>
                    </div>

                    <div class="floating-label"> 
                        <input ng-model="searchAttribute.Phone" type="text" class="form-control phone_us" maxlength="15" placeholder=" " ng-model-options="{ debounce: 500 }" ng-change="searchFilter(searchAttribute)">
                        <span class="highlight"></span>
                        <label>Phone No. </label>
                    </div>

                    {{-- <div class="float-right">
                        <button type="reset" ng-click="resetFilters()" class="btn btn-default">Reset</button>
                        <button type="button" ng-click="getVendors()" class="btn btn-primary">Filter</button>
                    </div> --}}
                </form>
            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->
</div>