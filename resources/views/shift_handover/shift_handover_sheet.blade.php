<div id="shiftHandOverSheet" class="card">
    <div class="card-header header-elements-inline border-bottom p-2">
        <h5 class="card-title" style="text-transform:capitalize;">Shift Handover</h5>
         <div class="header-elements">
            <div class="list-icons">
                      <a class="list-icons-item" data-action="collapse"></a>
              <a class="list-icons-item new-rec-close" ng-click="hideshiftHandOverSheet()"><i class="icon-cross2"></i></a>
            </div>
          </div>
    </div>
    <div class="card-body p-2">
        <div class="row ">
            <div class="col-md-8 bg-light">               
                <div class="row pt-2">
                    <div class="col-md-6">
                        <strong> Opening Balance:</strong>
                    </div>
                    <div class="col-md-6 text-right">
                        [[user_opening_balance | currency]]
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <strong> Today's Received Cash:</strong>
                    </div>
                    <div class="col-md-6 text-right">
                        [[shift_handover.cash_received_today | currency]]
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <strong> Today's Paid Cash:</strong>
                    </div>
                    <div class="col-md-6 text-right">
                        [[shift_handover.cash_paid_today | currency]]
                    </div>
                </div>
            
                <div class="row">
                    <div class="col-md-6">
                        <strong> Cash In Drawer:</strong>
                    </div>
                    <div class="col-md-6 text-right">
                        [[shift_handover.cash_available | currency]]
                    </div>
                </div>
            </div>
            <div class="col-md-4 bg-light border-left pt-3">
                <strong for="">Handover to</strong>
                <md-select required  name="hand_over_to" class="m-0" ng-model="shift_handover.hand_over_to" placeholder="Select User" >
                    <md-option ng-repeat="u in users" ng-value="u.id" >[[u.name]]</md-option>
                </md-select>
                <div ng-messages="shiftHandoverForm.hand_over_to.$error" ng-if='shiftHandoverForm.hand_over_to.$touched || shiftHandoverForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Select user to Handover</div>
                </div>
            </div>
        </div>
       
    </div>
    <div class="card-footer p-2 border-top text-right">
        <button  type="button" ng-click="confirmHandover(shift_handover)" class="btn btn-sm bg-success"><i class="icon-clipboard3 mr-1"></i> Handover</button>
    </div>
</div>
