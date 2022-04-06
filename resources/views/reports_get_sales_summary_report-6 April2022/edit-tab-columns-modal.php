<div class="card">
    <!-- <div class="card-header header-elements-inline">
        <h5 class="card-title">Edit Columns&nbsp;
            <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="The columns displayed in 'Selected Columns' will be displayed in report. To add/remove columns Simply drag n drop columns from 'Available Columns' card and to sort columns drag in desired order in 'Selected Columns'" aria-describedby="tooltip696410">
                <i class="icon-help top-0"></i>
            </a>
        </h5>
    </div> -->
    <div class="card-body filters">
        <div class="row text-center">
            <div class="col-md-6">
                <!-- Default items sorting -->
                <div class="card card-body border-top-1 border-top-info">
                    <div class="text-center">
                        <h6 class="font-weight-semibold mb-0">Avaliable Columns</h6>
                    </div>
                    <div id="available" class="dropdown-menu dropdown-menu-sortable" style="display: block; position: static; width: 100%; margin-top: 0; float: none;">
                        <!--<div class="dropdown-header text-uppercase">Menu header</div>-->
                        <div id="[[col]]" ng-cloak ng-repeat="col in originalColumns" class="dropdown-item">
                            <div class="dropdown-item-childs">
                                <strong>[[ col.Alias ]]</strong>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /default items sorting -->
            </div>
            <div class="col-md-6">
                <!-- Default items sorting -->
                <div class="card card-body border-top-1 border-top-info">
                    <div class="text-center">
                        <h6 class="font-weight-semibold mb-0">Selected Columns</h6>
                    </div>
                    <div id="selected" class="dropdown-menu dropdown-menu-sortable" style="display: block; position: static; width: 100%; margin-top: 0; float: none;">
                        <!--<div class="dropdown-header text-uppercase">Menu header</div>-->
                        <div id="[[col]]" ng-cloak ng-repeat="col in selectedColumns" class="dropdown-item">
                            <div class="dropdown-item-childs">
                                <strong>[[col.Alias]]</strong>
                            </div>
                        </div>

                    </div>
                </div>
                <!-- /default items sorting -->
            </div>
        </div>
    </div>
</div>