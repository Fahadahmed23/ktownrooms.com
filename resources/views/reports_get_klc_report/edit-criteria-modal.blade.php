<div id="EditCriteria" class="modal fade" tabindex="-1">
   <div class="modal-dialog modal-md">
      <div class="modal-content">
         <div class="modal-header">
            <h5 class="modal-title">Edit Search Criteria&nbsp;
               <a href="" class="current-div1 list-icons-item flex-fill" data-trigger="hover" data-popup="tooltip" data-container="body" data-html="true" data-original-title="<b>Step#1: </b>Choose the column name to be filtered</br><b>Step#2: </b>Select the operator(e.g. Equal to) according to column</br><b>Step#3: </b>Entered the value to be searched</br><b>Note:</b>There is AND operator in between the column criteria and OR operator is performed between two search groups.</br>" aria-describedby="tooltip696410">
                  <i class="icon-help top-0"></i></a>
            </h5>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
         </div>
         {{-- <div class="modal-body" style="max-height: 500px;overflow-y:auto;"> --}}
         <div class="modal-body">
         <div ng-cloak ng-repeat="searchGroup in searchGroups track by $index" class="filters">
            <label class="col-form-label f-w-500">Search Group [[$index+1]]</label><br ng-if="searchGroup.length!=0">
            <div style="display: flex; align-items: center" ng-cloak ng-repeat="colCriteria in searchGroup" class="form-group row">
               <div class="col-lg-5">
                  <md-select aria-label="column" ng-if="colCriteria" ng-change="check(colCriteria)" ng-model-options="{trackBy: '$value.alias'}" ng-model="colCriteria.column" >
                     <md-option ng-cloak ng-if="col.type != 'custom'" ng-value="col" ng-repeat="col in columns" >[[ col.alias ]]</md-option>
                  </md-select>
                 
               </div>
               <div class="col-lg-3">
                  <select ng-if="colCriteria.column.type == 'string'" placeholder="Select an operator" ng-model="colCriteria.operator" class="form-control">
                     <option value="" selected="true" disabled="true">Select an operator</option>
                     <option value="=">Equals</option>
                     <option value="<>">Not Equals</option>
                     <option value="contains">Contains</option>
                  </select>
                  <select ng-if="colCriteria.column.type == 'enum'" placeholder="Select an operator" ng-model="colCriteria.operator" class="form-control">
                     <option value="" selected="true" disabled="true">Select an operator</option>
                     <option value="=">Equals</option>
                     <option value="<>">Not Equals</option>
                  </select>
                  <select ng-if="colCriteria.column.type == 'number' || colCriteria.column.type == 'float' || colCriteria.column.type == 'amount' || colCriteria.column.type == 'int'" placeholder="Select an operator" ng-model="colCriteria.operator" class="form-control">
                     <option value="" selected="true" disabled="true">Select an operator</option>
                     <option value=">">Greater than</option>
                     <option value="<">Less than</option>
                     <option value="=">Equals</option>
                  </select>
                  <select ng-if="colCriteria.column.type == 'date'"  ng-model="colCriteria.operator" placeholder="Select an operator" class="form-control">
                     <option value="" selected="true" disabled="true">Select an operator</option>
                     <option value=">">Greater than</option>
                     <option value="<">Less than</option>
                     <option value="=">Equals</option>
                     <option value="==">Timespan</option>
                  </select>
                  <select ng-if="colCriteria.column.type == 'time'"  ng-model="colCriteria.operator" placeholder="Select an operator" class="form-control">
                     <option value="" selected="true" disabled="true">Select an operator</option>
                     <option value=">">Greater than</option>
                     <option value="<">Less than</option>
                     <option value="=">Equals</option>
                  </select>
               </div>
               <div class="col-lg-3">
                  <input ng-if="colCriteria.column.type != 'enum'  && colCriteria.column.type != 'date'" id="colInput" type="[[ (colCriteria.column.type == 'number' || colCriteria.column.type == 'float' || colCriteria.column.type == 'amount') ? 'number' : 'text' ]]" ng-model="colCriteria.value" class="form-control  [[ colCriteria.column.type == 'time' ? 'pickatime' : '' ]]">
                  <input ng-if="colCriteria.column.type == 'date' && colCriteria.operator != '=='" id="colInput" type="text" ng-model="colCriteria.value" class="form-control pickadate">
                  <md-select class="timespan_value" ng-if="colCriteria.column.type == 'date' && colCriteria.operator == '=='" ng-model="colCriteria.value">
                     <md-option value="today">Today</md-option>
                     <md-option value="this week">This Week</md-option>
                     <md-option value="this month">This Month</md-option>
                     <md-option value="this quarter">This Quarter</md-option>
                     <md-option value="last 3 months">Last 3 Months</md-option>
                     <md-option value="last 6 months">Last 6 Months</md-option>
                     <md-option value="this calendar year">This Calendar Year</md-option>
                     <md-option value="last year (12 months)">Last Year (12 Months)</md-option>
                     <md-option value="previous year today">Previous Year Today</md-option>
                     <md-option value="previous year this week">Previous Year This Week</md-option>
                     <md-option value="previous year this month">Previous Year This Month</md-option>
                     <md-option value="previous year this quarter">Previous Year This Quarter</md-option>
                     <md-option value="previous year last 3 months">Previous Year Last 3 Months</md-option>
                     <md-option value="previous year last 6 months">Previous Year Last 6 Months</md-option>
                     <md-option value="previous calendar year">Previous Calendar Year</md-option>
                     <md-option value="previous year (12 months)">Previous Year (12 Months)</md-option>
                     
                  </md-select>
                  <md-select ng-if="colCriteria.column.type == 'enum'" ng-model="colCriteria.value">
                     <md-option ng-value="val" ng-repeat="val in colCriteria.column.enumArr">[[ val ]]</md-option>
                  </md-select>
               </div>
               <div class="col-lg-1">
               <a class="current-div1 list-icons-item mr-2" title="Remove Criteria" ng-click="removeSearchCriteria($index,$parent.$index)">
                  <i class="icon-cross"></i>
               </a>
               </div>
               
               <span class="and-span" ng-if="!$last">AND</span>
            </div>
            <button ng-click="addColumnCriteria($index)" type="button" class="btn btn-primary">Add Column Criteria</button>
            <button ng-if="searchGroup.length!=0" ng-click="removeSearchGrp($index)" type="button" class="btn btn-primary">Clear Group [[$index+1]]</button><br>
            
            <span class="or-span" ng-if="!$last">OR</span>
         </div>
           
         <!-- <div style="padding: 1.25rem;" class="text-left">

            
         </div> -->
         </div>
         <div class="modal-footer">
            <button ng-click="addSearchGroup()" type="button" class="btn btn-primary">Add Search Group</button>
            <button type="button" class="btn btn-primary" ng-click="resetSearchGroup()">Reset Criteria</button>
            <button type="button" class="btn btn-primary" ng-click="loadCriteria()">Load Criteria</button>
         </div>
      </div>
   </div>
</div>