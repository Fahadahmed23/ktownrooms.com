
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
            <form class="mt-4" >
                    <label>Select Department</label>
                    <md-select ng-disabled="!user_is_admin" ng-change="getFilterTasks(filter.department_id)" md-no-asterisk name="department_id" class="m-0" ng-model="filter.department_id" placeholder="Select Department">
                        <md-option ng-repeat="d in departments" ng-value="d.id">[[d.Department]]</md-option>
                    </md-select>
            </form>



           </div>
       </div>
       <!-- /filter -->
   </div>
   <!-- /sidebar content -->
</div>
