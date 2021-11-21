<div class="sidebar sidebar-light bg-transparent sidebar-component sidebar-component-left border-0 shadow-0 sidebar-expand-md">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Filter -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                    </div>
                </div>
            </div>

            <div class="card-body">
            <form>
                <div class="floating-label">      
                    <input ng-model="searchRoleAttributes.name" type="text" class="form-control" placeholder=" ">
                    <span class="highlight"></span>
                    <label>Role</label>
                </div>

                <div class="float-right">
                    <button class="btn btn-default" ng-click="filterRoles(searchRoleAttributes={})">Reset</button>
                    <button class="btn btn-primary" ng-click="filterRoles(searchRoleAttributes)">Filter</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>