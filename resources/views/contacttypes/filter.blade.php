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
                <div class="floating-label"> 
                    <label>ContactType Name </label>     
                  <input ng-model="filterSearchText" type="text" class="form-control" placeholder=" ">
                  <span class="highlight"></span>
                  
                </div>
                <!-- <button type="button" id="" ng-click="" class="btn btn-sm bg-primary"><i class="icon-search4 mr-2"></i>Search</button>    -->
                <!-- <button class="btn bg-blue btn-block" ng-click="filterMembers(searchMemberAttributes)">
                    <i class=" icon-search4 font-size-base mr-2"></i> Search
                </button>
                <button class="btn bg-blue btn-block" ng-click="filterMembers(searchMemberAttributes = {})">
                        Clear fields
                </button> -->

            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->

</div>
