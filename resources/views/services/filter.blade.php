<div class="sidebar sidebar-light bg-transparent sidebar-component border-0 shadow-0 sidebar-expand-md">

    <!-- Sidebar content -->
    <div class="sidebar-content">

        <!-- Filter -->
        <div class="card">
            <div class="card-header bg-transparent header-elements-inline">
                <span class="text-uppercase font-size-sm font-weight-semibold">Filter</span>
                <div class="header-elements">
                    <div class="list-icons">
                        <a href="#" class="" ng-click="hideFilter()"><i class="fa fa-close" style="font-size: 12px;"></i></a>
                        {{-- <a class="list-icons-item" data-action="collapse"></a> --}}
                    </div>
                </div>
            </div>

            <div class="card-body">
                <div class="floating-label"> 
                  <input ng-model="searchName" type="text" class="form-control" placeholder=" ">
                  <span class="highlight"></span>
                  <label>Service Title </label>
                  
                </div>

                <div class="floating-label"> 
                    <input ng-model="searchDeparment" type="text" class="form-control" placeholder=" ">
                    <span class="highlight"></span>
                    <label>Department</label>
                </div>

                <div class="floating-label"> 
                    <input ng-model="searchType" type="text" class="form-control" placeholder=" ">
                    <span class="highlight"></span>
                    <label>Service Type</label>
                </div>
            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->

</div>
