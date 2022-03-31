 <div id="EditColumns" class="modal fade" tabindex="-1">
    <div class="modal-dialog modal-lg">
       <div class="modal-content">
          <div class="modal-header">
             <h5 class="modal-title">Edit Columns&nbsp;
                <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" title="" data-original-title="The columns displayed in 'Selected Columns' will be displayed in report. To add/remove columns Simply drag n drop columns from 'Available Columns' card and to sort columns drag in desired order in 'Selected Columns'" aria-describedby="tooltip696410">
                   <i class="icon-help top-0"></i>
                </a></h5>
             <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>
          <div class="modal-body filters">
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
             <br>
             <div class="modal-footer">
                <button type="button" class="btn btn-primary" ng-click="saveSelectedCols()">Select Columns</button>
                <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Cancel</button>
             </div>
          </div>
       </div>
    </div>
 </div>