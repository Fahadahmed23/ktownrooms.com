<div id="ANR-filter" class="ANR-filter">


    <!--Searching FIlters-->
    <div class="card">
        <div class="card-header header-elements-inline bg-light">
            <h5 class="card-title">Search Income Statement</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body mt-3">
            <form name="incomeStatementForm" action="javascript:void(0)" style="display:flex; width:100%" class="row" confirm-on-exit>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Select <span class="font-weight-semibold">Level</span><span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-md-4">
                            <md-select ng-change="changeLevel()" md-no-asterisk  name="level_no" class="m-0" ng-model="income_statement.level_no" placeholder="Select a Level" required>
                                <md-option ng-repeat="level in levels" ng-value="level.level_no">[[level.name]]</md-option>
                            </md-select>
                            <div ng-messages="incomeStatementForm.level_no.$error" ng-if='incomeStatementForm.level_no.$touched || incomeStatementForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Level is required</div>
                            </div>
                        </div>
                    </div>        
                </div> 

                <div class="col-md-12 mt-2" ng-show="is_admin">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Hotel </label>
                        </div>
                        <div class="col-md-4">
                            <md-select md-no-asterisk  name="hotel_id" class="m-0" ng-model="income_statement.hotel_id" placeholder="Select a Hotel " multiple>
                                <md-select-header>
                                    <input ng-model="search_hotels"  class="_md-text w-100 border px-3 py-2" placeholder="Search Hotels"  onkeydown="event.stopPropagation()">
                                </md-select-header>
                                <md-option ng-repeat="hotel in hotels | filter:search_hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                                <md-button class="border-top" layout-fill value="all" ng-click="selectAllHotels()">Select All</md-button>
                            </md-select>
                         
                        </div>
                    </div>        
                </div>
                <div class="col-md-12 mt-2">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Fiscal <span class="font-weight-semibold">Year</span><span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-md-4">
                            <md-select md-no-asterisk  name="fiscal_year" class="m-0" ng-model="income_statement.fiscal_year" placeholder="Select a Fiscal Year " required>
                                <md-option ng-repeat="fy in fiscal_years" ng-value="fy.id">[[fy.title]]</md-option>
                            </md-select>
                            <div ng-messages="incomeStatementForm.fiscal_year.$error" ng-if='incomeStatementForm.fiscal_year.$touched || incomeStatementForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Fiscal Year is required</div>
                            </div>
                        </div>
                    </div>        
                </div>
                <div class="col-md-12 mt-2">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Start <span class="font-weight-semibold">Date</span></label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input  type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="income_statement.start_date" id="startdate" class=" form-control pickadate startdate" >
                            </div>
                        </div>
                    </div>        
                </div>


                <div class="col-md-12 mt-2">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">End <span class="font-weight-semibold">Date</span></label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input type="text" name="end_date" placeholder="MM/DD/YYYY" ng-model="income_statement.end_date" id="enddate" class=" form-control pickadate enddate">
                            </div>
                        </div>
                    </div>        
                </div>





                <div class="text-right mt-3 col-md-8">
                    <button ng-click="incomeStatement()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-paperplane mr-1"></i>Generate Income Statement</button>
                    
                </div>
            </form>
            
        </div>
    </div>

    <script>
        $.extend($.fn.pickadate.defaults, {
            // formatSubmit: 'yyyy-mm-dd',
            format: 'mm/dd/yyyy',
            // hiddenName: true,
            // hiddenSuffix: '_submit'
        })
    </script>
    <!--/Searching Filters-->
</div>