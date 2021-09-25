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
            <div class="input-group fl-r">
                <span class="input-group-prepend">
                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                </span>
                <input ng-model="moveDate" type="text" placeholder="Select Date" class="form-control pickadate mr-2">
                <button class="btn btn-sm btn-primary" ng-click="jumpTo(moveDate)">Jump To</button>
            </div>

            <form class="mt-4">
                    <label>Select User</label>
                    <md-select ng-change="getAllLeaves()" md-no-asterisk  aria-invalid="true" class="m-0" ng-model="user_id" placeholder="Admin">
                        <md-option ng-repeat="u in users" ng-value="u.id">[[u.name]]</md-option>
                    </md-select>

                    <div class="float-right mt-2">
                        <button class="btn btn-warning  float-right" ng-click="clearFilter()" type="button">Reset <i class="icon-reload-alt ml-1"></i> </button>
                    </div>
            </form>



           </div>
       </div>
       <!-- /filter -->
   </div>
   <!-- /sidebar content -->
</div>
