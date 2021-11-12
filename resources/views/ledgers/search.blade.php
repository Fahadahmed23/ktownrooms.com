<div id="ANR-filter" class="ANR-filter">


    <!--Searching FIlters-->
    <div class="card">
        <div class="card-header header-elements-inline bg-light">
            <h5 class="card-title">Search General Ledger</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item" data-action="collapse"></a>
                </div>
            </div>
        </div>

        <div class="card-body mt-3">
            <form name="ledgerForm" action="javascript:void(0)" style="display:flex; width:100%" class="row" confirm-on-exit>
                <div class="col-md-12 mt-2" ng-show="is_admin">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Hotel </label>
                        </div>
                        <div class="col-md-4">
                            <md-select md-no-asterisk  name="hotel_id" class="m-0" ng-model="ledger.hotel_id" placeholder="Select a Hotel ">
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
                            <label class="mt-2">Fiscal <span class="font-weight-semibold">Year</span></label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                {{-- <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span> --}}
                                <input readonly type="text" name="fiscal_year" placeholder="YYYY-yy" ng-model="ledger.fiscal_year" id="" class=" form-control" >
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
                            <label class="mt-2">Start <span class="font-weight-semibold">Date</span></label>
                        </div>
                        <div class="col-md-4">
                            <div class="input-group">
                                <span class="input-group-prepend">
                                    <span class="input-group-text"><i class="icon-calendar"></i></span>
                                </span>
                                <input ng-change="changeStartDate()"   type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="ledger.start_date" id="startdate" class=" form-control pickadate startdate" >
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
                                <input ng-change="changeEndDate()" type="text" name="end_date" placeholder="MM/DD/YYYY" ng-model="ledger.end_date" id="enddate" class=" form-control pickadate enddate">
                            </div>
                            {{-- <div ng-messages="trailBalanceForm.end_date.$error" ng-if='trailBalanceForm.end_date.$touched || trailBalanceForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">End Date is required</div>
                            </div> --}}
                        </div>
                    </div>        
                </div>

                <div class="col-md-12 mt-2">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Status <span class="text-danger"> * </span></label>
                        </div>
                        <div class="col-md-4" style="margin-top: 10px">
                            <md-radio-group ng-model="ledger.status" aria-labelledby="status" layout="row">
                                <md-radio-button value="approved">Approved</md-radio-button>
                                <md-radio-button value="posted">Posted</md-radio-button>
                            </md-radio-group>
                        </div>
                    </div>        
                </div>

                <div class="col-md-12 mt-2" ng-show="is_admin">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Account Gl's</label>
                        </div>
                        <div class="col-md-4">
                            <md-select md-no-asterisk ng-change="checkAccGl()" name="account_gls" class="m-0" ng-model="ledger.selected_ids" placeholder="Select Account Gls" multiple>
                                <md-button layout-fill value="all" class="select" ng-click="selectAllGls()">[[keyword]]</md-button>
                                <md-button layout-fill value="all" class="deselect" style="display: none;" ng-click="deselectAllGls()">[[keyword]]</md-button>
                                <md-option ng-repeat="agl in account_gls track by $index" ng-value="agl.id">[[agl.title]] - ([[agl.account_gl_code]])</md-option>
                            </md-select>
                            {{-- <div ng-messages="trailBalanceForm.hotel_id.$error" ng-if='trailBalanceForm.hotel_id.$touched || trailBalanceForm.$submitted' ng-cloak style="color:#e9322d;">
                                <div class="text-danger" ng-message="required">Hotel is requiured</div>
                            </div> --}}
                        </div>
                    </div>        
                </div>
                
                
                {{-- <div class="col-md-12 mt-2">
                    <div class="row">
                        <div class="col-md-3 offset-3" >
                    
                            <!-- Default items sorting -->
                            <div class="card card-body border-top-1 border-top-warning">
                                <div class="text-center">
                                    <h6 class="font-weight-semibold mb-0">Unselected</h6>
                                </div>
                    
                                <div id="1" class="dropdown-menu dropdown-menu-sortable" style="display: block; position: static; width: 100%; margin-top: 0; float: none; height:200px; overflow:auto">
                    
                                    <div id="[[account_gl]]" ng-repeat="account_gl in account_gls | filter : {'is_active' : '1'}" href="#" class="dropdown-item my-1 task-container">
                                        <div class="col-md-8">
                                            <strong class="d-block">[[account_gl.title]] - <span class="text-grey">([[account_gl.account_gl_code]])</span> </strong>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /default items sorting -->
                    
                        </div>
                    
                        <div class="col-md-3" >
                    
                            <!-- Submenu -->
                            <div class="card card-body border-top-1 border-top-info">
                                <div class="text-center">
                                    <h6 class="mb-0 font-weight-semibold">Selected</h6>
                                </div>
                                
                    
                                <div id="0" class="dropdown-menu dropdown-menu-sortable" style="display: block; position: relative; width: 100%; margin-top: 0; float: none; height:200px; overflow:auto">
                                    <div id="[[account_gl]]" ng-repeat="account_gl in account_gls | filter : {'is_active' : '0'}" href="#" class="dropdown-item my-1 task-container">
                                        <div class="col-md-8">
                                            <strong class="d-block">[[account_gl.title]] - <span class="text-grey">([[account_gl.account_gl_code]])</span> </strong>
                                        </div>
                                    </div>
                                
                                </div>
                            </div>
                            <!-- /submenu -->
                    
                        </div>
                    
                    </div>
                </div> --}}





                {{-- <div class="col-md-12 mt-2">
                    <div class="row">
                        <div class="col-md-4 text-right">
                            <label class="mt-2">Account GL <span class="text-danger"> * </span></label>
                        </div>
                        
                        <div class="col-md-4">
                            <span class="multiselect-native-select">
                                <select class="form-control multiselect" ng-value="ledger.account_gl_id" ng-model="ledger.account_gl_id"  multiple="multiple" data-fouc="">
                                    
                                    <option ng-repeat="account_gl in account_gls" value="[[account_gl.id]]">[[account_gl.title]] - [[account_gl.account_gl_code]]</option>

                                </select>
                            </span>
                        </div>
                    </div>        
                </div> --}}


                <div class="text-right mt-3 col-md-8">
                    <button ng-click="general_ledger()" type="button" class="btn bg-success srch-rooms legitRipple"><i class="icon-paperplane mr-1"></i>Generate Ledger</button>
                    
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