
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

                <div ng-show="isSelectHotel" class="floating-label">
                    <div class="floating-label">
                        <md-select ng-hide="" ng-model="filters.hotel_id" placeholder="Hotels">
                            <md-option ng-repeat="h in hotels" ng-value="[[h.id]]">[[h.HotelName]]</md-option>
                        </md-select>
                    </div>
                </div>

                <div ng-show="isSelectDepartment" class="floating-label">
                    <div class="floating-label">
                        <md-select ng-hide="" ng-model="filters.department_id" placeholder="Departments">
                            <md-option ng-repeat="d in departments" ng-value="[[d.id]]">[[d.Department]]</md-option>
                        </md-select>
                    </div>
                </div>
                <div class="floating-label">
                    <input ng-model="filters.service_title" type="text" class="form-control" maxlength="50" placeholder=" ">
                    <span class="highlight"></span>
                    <label>Service Title</label>
                </div>

                <div class="float-right">
                    <button class="btn btn-default" ng-click="filterData(filters, 'clear')" type="reset">Reset</button>
                    <button type="button" class="btn btn-primary" ng-click="filterData(filters)">Filter</button>
                </div>
            </form>



           </div>
       </div>
       <!-- /filter -->
   </div>
   <!-- /sidebar content -->
</div>
