
<style>
    .md-select-menu-container,
   md-backdrop {
       z-index: 999999 !important;
   }
</style>
<div class="sidebar sidebar-light bg-transparent sidebar-component  border-0 shadow-0 sidebar-expand-md">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Filter -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
                <div class="header-elements">
                    <div class="list-icons">
                        {{-- <a class="list-icons-item" data-action="collapse"></a> --}}
                        <a href="#" class="" ng-click="hideFilter()"><i class="fa fa-close" style="font-size: 12px;"></i></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
                    <div class="floating-label">
                        <md-select ng-model="filters.account_type_id" placeholder="Account Type" multiple>
                            <md-option ng-repeat="at in account_types" ng-value="[[at.id]]">[[at.title]]</md-option>
                        </md-select>
                    </div>

                    <div class="floating-label">
                        <md-select ng-model="filters.account_level_id" placeholder="Account Level" multiple>
                            <md-option ng-repeat="al in account_levels" ng-value="[[al.id]]">[[al.name]]</md-option>
                        </md-select>
                    </div>
                    <div class="floating-label">
                        <input ng-model="filters.title" type="text" class="form-control" maxlength="50" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Account Title </label>
                    </div>
                    <div class="floating-label">
                        <input ng-model="filters.account_gl_code" type="text" class="form-control gl_code" maxlength="50" placeholder=" ">
                        <span class="highlight"></span>
                        <label>Account Gl Code </label>
                    </div>
                    <div class="float-right">
                        <button type="button" class="btn btn-primary float-right" ng-click="filterData(filters)">Filter</button>
                    </div>
            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->

</div>
