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
                  <input ng-model="searchClient" type="text" maxlength="50" class="form-control alphabets" placeholder=" ">
                  <span class="highlight"></span>
                  <label>Client</label> 
                </div>

                <div class="floating-label"> 
                  <input ng-model="searchEmail" type="text" maxlength="50" class="form-control email_mask" placeholder=" ">
                  <span class="highlight"></span>
                  <label>Email</label> 
                </div>

                <div class="floating-label"> 
                  <input ng-model="searchPhone" type="text" class="form-control phone_us" placeholder=" ">
                  <span class="highlight"></span>
                  <label>Phone</label> 
                </div>


                

            </div>
        </div>
        <!-- /filter -->
        
    </div>
    <!-- /sidebar content -->

</div>
