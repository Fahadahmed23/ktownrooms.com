<div class="navbar navbar-expand-lg navbar-light navbar-component rounded card">
    <div class="text-center d-lg-none w-100">
        <button type="button" class="navbar-toggler dropdown-toggle" data-toggle="collapse" data-target="#navbar-filter">
            <i class="icon-unfold mr-2"></i>
            Filters
        </button>
    </div>

    <div class="navbar-collapse collapse" id="navbar-filter">
        <span class="navbar-text mr-3">
            Filter:
        </span>

        <ul class="navbar-nav flex-wrap">
            <li class="nav-item dropdown">
                <a  ng-click="hotelsChartSec()"  class="navbar-nav-link hotel-rec-view" >
                    <i class="icon-office mr-1"></i>
                    Hotels: <span class="ml-1 text-bold">[[records.hotelsCount]]</span>
                </a>
            </li>

            <li class="nav-item dropdown">
                <a ng-click="roomsChartSec()" class="navbar-nav-link" >
                    <i class="icon-home7 mr-1"></i>
                    Rooms: <span class="ml-1 text-bold">[[records.rooms.length]]</span>
                </a>
            </li>
            
            <li class="nav-item dropdown">
                <a ng-click="citiesChartSec()"  class="navbar-nav-link city-view" >
                    <i class="icon-city mr-1"></i>
                    Cities: <span class="ml-1 text-bold">[[records.citiesCount]]</span>
                </a>
            </li>

            
        </ul>

        {{-- <span class="navbar-text mr-3 ml-lg-auto">
            <ul id="selectcityDD" class="navbar-nav flex-wrap city-slct">
                <li class="nav-item dropdown">
                    <a href="#" class="navbar-nav-link dropdown-toggle" data-toggle="dropdown">
                        <i class="icon-city mr-1"></i>
                    Select City
                    </a>

                    <div class="dropdown-menu">
                        <a href="#" class="dropdown-item city-view">Show all</a>
                        <div class="dropdown-divider"></div>
                        <a href="#" class="dropdown-item" ng-repeat="city in records.cities">[[city.CityName]]</a>
                    </div>
                </li>
            </ul>
        </span>

        <div class="form-group row mb-0">
            <div class="col-lg-10">
                <div class="input-group">
                    <input type="text" class="form-control border-right-0" placeholder="Search">
                    <span class="input-group-append">
                        <button class="btn bg-teal btn-sm" type="button"><i class="icon-search4"></i></button>
                    </span>
                </div>
            </div>
        </div> --}}
    </div>
</div>
<!-- /filter toolbar -->