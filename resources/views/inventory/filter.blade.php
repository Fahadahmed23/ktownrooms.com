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
                  <input ng-model="searchAttribute.Title" type="text" maxlength="50" class="form-control" placeholder=" " ng-model-options="{ debounce: 500 }" ng-change="searchFilter(searchAttribute)">
                  <span class="highlight"></span>
                  <label>Item Name</label> 
                </div>


                <div class="floating-label"> 
                    <input ng-model="searchAttribute.Hotel" type="text" maxlength="50" class="form-control" placeholder=" " ng-model-options="{ debounce: 500 }" ng-change="searchFilter(searchAttribute)">
                    <span class="highlight"></span>
                    <label>Hotel</label> 
                </div>

                <div class="floating-label"> 
                  <input ng-model="searchAttribute.Rate" type="text" maxlength="50" class="form-control" placeholder=" " ng-model-options="{ debounce: 500 }" ng-change="searchFilter(searchAttribute)">
                  <span class="highlight"></span>
                  <label>Rate</label> 
                </div>

                <div class="floating-label"> 
                  <input ng-model="searchAttribute.Description" type="text" class="form-control" placeholder=" " ng-model-options="{ debounce: 500 }" ng-change="searchFilter(searchAttribute)">
                  <span class="highlight"></span>
                  <label>Description</label> 
                </div>


                

            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->

</div>
