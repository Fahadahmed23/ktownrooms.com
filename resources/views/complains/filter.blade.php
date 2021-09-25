<div class="navbar navbar-expand-lg navbar-light navbar-component rounded">
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
                <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown" aria-expanded="false">
                    <i class="icon-sort-time-asc mr-2"></i>
                    Date: [[dateText]]
                </a>

                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" ng-click="filterByDate('')">Show all</a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0)" ng-repeat="date in dates" class="dropdown-item" ng-click="filterByDate(date)">[[date.text]]</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown">
                    <i class="icon-sort-amount-desc mr-2"></i>
                    Status: [[statusName]]
                </a>

                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" ng-click="filterByStatus('')">Show all</a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0)" ng-repeat="status in complain_statuses" class="dropdown-item" ng-click="filterByStatus(status)">[[status.ComplainStatus]]</a>
                </div>
            </li>

            <li class="nav-item dropdown">
                <a href="#" class="navbar-nav-link dropdown-toggle legitRipple" data-toggle="dropdown">
                    <i class="icon-sort-numeric-asc mr-2"></i>
                    Priority: [[priorityName]]
                </a>

                <div class="dropdown-menu">
                    <a href="#" class="dropdown-item" ng-click="filterByPriority('')">Show all</a>
                    <div class="dropdown-divider"></div>
                    <a href="javascript:void(0)" ng-repeat="priority in priorities" class="dropdown-item" ng-click="filterByPriority(priority)">[[priority.TaskPriority]]</a>
                </div>
            </li>
        </ul>

        <span class="navbar-text mr-3 ml-lg-auto">
            Sorting:
        </span>

        <ul class="navbar-nav flex-wrap">
            <li class="nav-item">
                <a href="javascript:void(0)" class="navbar-nav-link active legitRipple" ng-click="sortByDate('asc')">
                    <i class="icon-sort-alpha-asc"></i>
                    <span class="d-lg-none ml-2">Ascending</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="javascript:void(0)" class="navbar-nav-link legitRipple" ng-click="sortByDate('desc')">
                    <i class="icon-sort-alpha-desc"></i>
                    <span class="d-lg-none ml-2">Descending</span>
                </a>
            </li>
        </ul>
    </div>
</div>