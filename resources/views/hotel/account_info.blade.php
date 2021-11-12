<div class="row m-0 mt-2 p-2 gl-account-div">
    <div class="col-md-6">
        <div class="gl-info-sec p-2">
            <div class="hotel-title d-flex">
                <legend class="font-weight-semibold text-uppercase font-size-sm border-bottom p-2 mb-0 bg-light"><i class="icon-cash mr-2"></i>
                    [[hotel.HotelName]] GL Accounts:
                    <span class="float-right">
                        <md-checkbox ng-checked="selectAll" ng-value="" ng-model="is_checked" ng-change="selectAllAccounts()"> Select All</md-checkbox>
                    </span>
                </legend>
            </div>
            <div class="hotel-gl-list py-2">
                <ul class="p-0">
                    <li ng-repeat="gl in hotel_gl_accounts" class="aheads [[ gl.account_level_id == '1'?'lvl-1':'']]" >
                        <span ng-class="getLevel(gl.account_level_id)">
                            <md-checkbox ng-model="hotel.hotel_accounts[gl.id]" ng-checked="[[gl.is_active == '1']]" aria-checked="[[gl.is_active == '1' ? true : false]]" ng-value="[[gl.is_active]]"></md-checkbox>
                            [[gl.title]] ( [[gl.account_gl_code]])
                        </span>
                    </li>
                </ul>
            </div>
            <div class="text-right text-right mt-3">
                <button type="button" ng-click="saveHotelGlAccountMapping()" id="btn-save" class="btn btn-sm bg-success ng-binding legitRipple"><i class="icon-floppy-disk mr-1"></i> Update Accounts</button>
            </div>
        </div>
    </div>
</div>