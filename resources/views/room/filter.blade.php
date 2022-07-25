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
                  <input ng-model="filters.hotel" type="text" class="form-control" placeholder=" ">
                  <span class="highlight"></span>
                  <label>Hotel</label>
                </div>

                <div class="floating-label">
                  <md-select ng-model="filters.room_category_id" placeholder="Room Category" multiple>
                      <md-option ng-repeat="rc in roomcategories" ng-value="[[rc.id]]">[[rc.RoomCategory]]</md-option>
                  </md-select>
                </div>

                <div class="floating-label">
                  <md-select ng-model="filters.room_type_id" placeholder="Room Type" multiple>
                      <md-option ng-repeat="rt in roomtypes" ng-value="[[rt.id]]">[[rt.RoomType]]</md-option>
                  </md-select>
                </div>

                <div class="floating-label">
                  <input ng-model="filters.room_title" type="text" class="form-control" placeholder=" ">
                  <span class="highlight"></span>
                  <label>Room Title</label>
                </div>

                <div class="float-right">
                  <button type="button" class="btn btn-primary float-right" ng-click="filter_rooms(filters)">Filter</button>
                </div>

                {{-- <div class="floating-label">
                    <input ng-model="searchRoom" type="text" class="form-control" placeholder=" ">
                    <span class="highlight"></span>
                    <label>Room</label>
                </div> --}}


                  {{-- <div class="floating-label">
                    <input ng-model="searchType" type="text" class="form-control" placeholder=" ">
                    <span class="highlight"></span>
                    <label>Type </label>
                  </div>

                  <div class="floating-label">
                    <input ng-model="searchCategory" type="text" class="form-control" placeholder=" ">
                    <span class="highlight"></span>
                    <label>Room Category </label>
                  </div> --}}

            </div>
        </div>
        <!-- /filter -->

    </div>
    <!-- /sidebar content -->

</div>
