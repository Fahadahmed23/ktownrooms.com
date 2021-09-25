<div id="ANR-filter" class="ANR-filter">


    <!--Searching FIlters-->
    <div class="card">
        <div class="card-header header-elements-inline bg-light">
            <h5 class="card-title">Search Trial Balance</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body mt-3">
            <form name="trailBalanceForm" action="javascript:void(0)" style="display:flex; width:100%" class="row" confirm-on-exit>
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Select <span class="font-weight-semibold">Level</span><span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-md-4">
                            <md-select ng-change="changeLevel()" md-no-asterisk  name="level_no" class="m-0" ng-model="trial_balance.level_no" placeholder="Select a Level" required>
                                <md-option ng-repeat="level in levels" ng-value="level.level_no">[[level.name]]</md-option>
                            </md-select>
                            <div ng-messages="trailBalanceForm.level_no.$error" ng-if='trailBalanceForm.level_no.$touched || trailBalanceForm.$submitted' ng-cloak style="color:#e9322d;">
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
                            <md-select md-no-asterisk  name="hotel_id" class="m-0" ng-model="trial_balance.hotel_id" placeholder="Select a Hotel ">
                                <md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                            </md-select>
                            {{-- <div ng-messages="trailBalanceForm.hotel_id.$error" ng-if='trailBalanceForm.hotel_id.$touched || trailBalanceForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Hotel is requiured</div>
                            </div> --}}
                        </div>
                    </div>        
                </div>
                <div class="col-md-12 mt-2">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Fiscal <span class="font-weight-semibold">Year</span><span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-md-4">
                            <md-select ng-change="getFiscalYear()" md-no-asterisk  name="fiscal_year" class="m-0" ng-model="trial_balance.fiscal_year" placeholder="Select a Fiscal Year " required>
                                <md-option ng-repeat="fy in fiscal_years" ng-value="fy.id">[[fy.title]]</md-option>
                            </md-select>
                            <div ng-messages="trailBalanceForm.fiscal_year.$error" ng-if='trailBalanceForm.fiscal_year.$touched || trailBalanceForm.$submitted' ng-cloak style="color:#e9322d;">
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
                                <input ng-change="changeStartDate()"   type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="trial_balance.start_date" id="startdate" class=" form-control pickadate startdate" >
                            </div>
                            {{-- <div ng-messages="trailBalanceForm.start_date.$error" ng-if='trailBalanceForm.start_date.$touched || trailBalanceForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Start Date is required</div>
                            </div> --}}
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
                                <input ng-change="changeEndDate()" type="text" name="end_date" placeholder="MM/DD/YYYY" ng-model="trial_balance.end_date" id="enddate" class=" form-control pickadate enddate">
                            </div>
                            {{-- <div ng-messages="trailBalanceForm.end_date.$error" ng-if='trailBalanceForm.end_date.$touched || trailBalanceForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">End Date is required</div>
                            </div> --}}
                        </div>
                    </div>        
                </div>



                <div class="text-right mt-3 col-md-8">
                    <button ng-click="TrialBalanceSheet()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-cog mr-1"></i>Generate Trial Balance</button>
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