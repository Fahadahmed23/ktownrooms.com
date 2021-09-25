<div class="sidebar sidebar-light bg-transparent sidebar-component  border-0 shadow-0 sidebar-expand-md">

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
                <div class="floating-label"> 
                  <input ng-model="searchPO_num" type="text" maxlength="50" class="form-control" placeholder=" " ng-model-options="{ debounce: 500 }">
                  <span class="highlight"></span>
                  <label>Purchase Order #</label> 
                </div>


                <div class="floating-label"> 
                    <input ng-model="searchHotel" type="text" maxlength="50" class="form-control alphabets" placeholder=" " ng-model-options="{ debounce: 500 }">
                    <span class="highlight"></span>
                    <label>Hotel</label> 
                </div>

            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->

</div>
