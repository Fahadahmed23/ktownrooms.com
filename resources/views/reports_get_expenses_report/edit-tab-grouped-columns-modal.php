<div class="card">
    <!-- <div class="card-header header-elements-inline">
        <h5 class="card-title">Edit Grouped Columns&nbsp;
            <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" title="" data-original-title="The Columns displayed in 'Grouped Columns' will be grouped when report is executed. To add/remove columns Simply drag n drop columns from 'Ungrouped Columns' card" aria-describedby="tooltip696410">
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
                        <h6 class="font-weight-semibold mb-0">Ungrouped Columns</h6>
                     </div>
                     <div id="available" class="dropdown-menu dropdown-menu-sortable-grouped" style="display: block; position: static; width: 100%; margin-top: 0; float: none;">
                        <!--<div class="dropdown-header text-uppercase">Menu header</div>-->
                        <div id="[[col]]" ng-cloak ng-repeat="col in originalGroupedColumns" class="dropdown-item">
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
                        <h6 class="font-weight-semibold mb-0">Grouped Columns</h6>
                     </div>
                     <div id="selected" class="dropdown-menu dropdown-menu-sortable-grouped" style="display: block; position: static; width: 100%; margin-top: 0; float: none;">
                        <!--<div class="dropdown-header text-uppercase">Menu header</div>-->
                        <div id="[[col]]" ng-cloak ng-repeat="col in groupedColumns" class="dropdown-item">
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