<div class="card">
    <!-- <div class="card-header header-elements-inline">
        <h5 class="card-title">Edit Search Criteria&nbsp;
            <a href="" class="list-icons-item flex-fill" data-popup="tooltip" data-container="body" data-html="true" data-original-title="<b>Step#1: </b>Choose the column name to be filtered</br><b>Step#2: </b>Select the operator(e.g. Equal to) according to column</br><b>Step#3: </b>Entered the value to be searched</br><b>Note:</b>There is AND operator in between the column criteria and OR operator is performed between two search groups.</br>" aria-describedby="tooltip696410">
                <i class="icon-help top-0"></i></a>
        </h5>
    </div> -->
    <div class="card-body">
        <div ng-cloak ng-repeat="searchGroup in searchGroups track by $index" class="filters">
            <div style="border: 1px dotted;padding: 10px;" class="dotted-border">
                <label style="display: block;" class="col-form-label f-w-500">Selection Set [[$index+1]] &nbsp;
                    <a style="color: black;" href=""><i ng-click="addColumnCriteria($index)" data-trigger="hover" class="current-div1 icon-plus3 top-0" data-toggle="tooltip" data-popup="tooltip" data-container="body" data-html="true" data-original-title="Add Column Criteria"></i></a>
                    <a style="color: black;" href="javascript:void(0)"><i style="float: right;color:red;"  ng-click="removeSearchGrp($index)" class="current-div1 icon-cross top-0" data-trigger="hover" data-popup="tooltip" data-container="body" data-html="true" data-original-title="Clear Group"></i></a>
                </label>
                <br ng-if="searchGroup.length!=0">
                <div style="display: flex; align-items: center" ng-cloak ng-repeat="colCriteria in searchGroup" class="form-group row">
                    <div class="col-lg-5">
                        <md-select aria-label="column" placeholder="Select a column to be filtered" ng-if="colCriteria" ng-change="check(colCriteria)" ng-model-options="{trackBy: '$value.alias'}" ng-model="colCriteria.column">
                            <md-option ng-cloak ng-if="col.type != 'custom'" ng-value="col" ng-repeat="col in columns">[[ col.alias ]]</md-option>
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
                        <select ng-if="colCriteria.column.type == 'date'" ng-model="colCriteria.operator" ng-change="refreshDate(colCriteria);" placeholder="Select an operator" class="form-control">
                            <option value="" selected="true" disabled="true">Select an operator</option>
                            <option value=">">Greater than</option>
                            <option value="<">Less than</option>
                            <option value=">=">Greater than Equals</option>
                            <option value="<=">Less than Equals</option>
                            <option value="=">Equals</option>
                            <option value="==">Timespan</option>
                        </select>
                        <select ng-if="colCriteria.column.type == 'time'" ng-model="colCriteria.operator" placeholder="Select an operator" class="form-control">
                            <option value="" selected="true" disabled="true">Select an operator</option>
                            <option value=">">Greater than</option>
                            <option value="<">Less than</option>
                            <option value="=">Equals</option>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <input ng-cloak placeholder="Type [[colCriteria.column.alias]] value to be filtered" ng-if="colCriteria.column.type != 'enum'  && colCriteria.column.type != 'date'" id="colInput" type="[[ (colCriteria.column.type == 'number' || colCriteria.column.type == 'float' || colCriteria.column.type == 'amount' || colCriteria.column.type == 'int' ) ? 'number' : 'text' ]]" ng-model="colCriteria.value" class="form-control  [[ colCriteria.column.type == 'time' ? 'pickatime' : '' ]]">
                        <input ng-cloak placeholder="Click to filter date for [[colCriteria.column.alias]]" ng-if="colCriteria.column.type == 'date' && colCriteria.operator != '=='" id="colInput" type="text" ng-model="colCriteria.value" class="form-control pickadatereport">
                        <md-select ng-cloak placeholder="Select timespan" class="timespan_value" ng-if="colCriteria.column.type == 'date' && colCriteria.operator == '=='" ng-model="colCriteria.value">
                            <md-option value="yesterday">Yesterday</md-option>
                            <md-option value="today">Today</md-option>
                            <md-option value="tomorrow">Tomorrow</md-option>
                            <md-option value="this week">This Week</md-option>
                            <md-option value="this month">This Month</md-option>
                            <md-option value="this quarter">This Quarter</md-option>
                            <md-option value="this calendar year">This Calendar Year</md-option>
                            <md-option value="last week">Last Week</md-option>
                            <md-option value="last month">Last Month</md-option>
                            <md-option value="last 3 months">Last 3 Months</md-option>
                            <md-option value="last 6 months">Last 6 Months</md-option>
                            <md-option value="last year (12 months)">Last Year (12 Months)</md-option>
                            <md-option value="previous year today">Previous Year Today</md-option>
                            <md-option value="previous year this week">Previous Year This Week</md-option>
                            <md-option value="previous year this month">Previous Year This Month</md-option>
                            <md-option value="previous year this quarter">Previous Year This Quarter</md-option>
                            <md-option value="previous year last 3 months">Previous Year Last 3 Months</md-option>
                            <md-option value="previous year last 6 months">Previous Year Last 6 Months</md-option>
                            <md-option value="previous calendar year">Previous Calendar Year</md-option>
                            {{-- <md-option value="previous year (12 months)">Previous Year (12 Months)</md-option> --}}
                            {{-- Next Year Timespan --}}
                            <md-option value="next week">Next Week</md-option>
                            <md-option value="next month">Next Month</md-option>
                            <md-option value="next quarter">Next Quarter</md-option>
                            <md-option value="next 3 months">Next 3 Months</md-option>
                            <md-option value="next 6 months">Next 6 Months</md-option>
                            <md-option value="next year (12 months)">Next Year (12 Months)</md-option>
                            <md-option value="next year today">Next Year Today</md-option>
                            <md-option value="next year this week">Next Year This Week</md-option>
                            <md-option value="next year this month">Next Year This Month</md-option>
                            <md-option value="next year this quarter">Next Year This Quarter</md-option>
                            <md-option value="next year last 3 months">Next Year Last 3 Months</md-option>
                            <md-option value="next year last 6 months">Next Year Last 6 Months</md-option>
                            <md-option value="next calendar year">Next Calendar Year</md-option>
                        </md-select>
                        <md-select placeholder="Select [[colCriteria.column.alias]]" ng-if="colCriteria.column.type == 'enum'" ng-model="colCriteria.value">
                            <md-option ng-value="val" ng-repeat="val in colCriteria.column.enumArr">[[ val ]]</md-option>
                        </md-select>
                    </div>
                    <div class="col-lg-1">
                        <a style="color: black;" href="javascript:void(0)" ng-click="removeSearchCriteria($index,$parent.$index)">
                            <i  class="icon-cross current-div1 mr-2" data-trigger="hover" data-popup="tooltip" data-container="body" data-original-title="Remove Criteria"></i>
                        </a>
                    </div>
                    <span class="and-span" ng-if="!$last">AND</span>
                </div>
                <!-- <button ng-click="addColumnCriteria($index)" type="button" class="btn btn-primary">Add Column Criteria</button>
            <button ng-if="searchGroup.length!=0" ng-click="removeSearchGrp($index)" type="button" class="btn btn-primary">Clear Group [[$index+1]]</button> -->
                <br>
            </div>
            <span class="or-span" ng-if="!$last">OR</span>
        </div>

        <div class="row">
            <div class="col-md-12 text-center">
                <a style="color: black;" href="javascript:void(0)">
                    <i ng-click="addSearchGroup()" class="current-div1 icon-plus3 top-0" data-trigger="hover" data-popup="tooltip" data-container="body" data-original-title="Add Search Group"></i>
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <!-- <button ng-click="addSearchGroup()" type="button" class="btn btn-primary">Add Search Group</button> -->
                <!-- <button type="button" class="btn btn-primary" ng-click="resetSearchGroup()">Reset Criteria</button> -->
                <!-- <button type="button" class="btn btn-primary" ng-click="loadCriteria()">Accept Criteria</button> -->
            </div>
        </div>
    </div>
</div>