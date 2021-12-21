<fieldset>
    <div class="form-group row" ng-hide="paymentCleared">
        <div class="col-md-6">
            <label class="col-form-label">Payment Type</label>
            <md-select md-no-asterisk ng-required="is_partial==1" name="partial_payment_type" class="m-0" ng-model="partial_payment_typ" ng-change="changePaymentTyp()" placeholder="Cash">
                <md-option ng-repeat="paymenttype in paymenttypes" ng-value="paymenttype">[[paymenttype.PaymentMode]]</md-option>
            </md-select>

            <div ng-messages="myForm.partial_payment_type.$error" ng-if="myForm.partial_payment_type.$touched || myForm.$submitted">
                <div class="text-danger" ng-message="required">Payment Type is required</div>
            </div>
        </div>

        <div class="col-lg-6">
            <label class="col-form-label">Payment Amount</label>
            <input ng-required="is_partial==1 || formType=='view'" name="partial_payment" ng-model="partial_payment" type="text" data-type="currency" currency placeholder="200.00" class="form-control" maxlength="10" ng-disabled="checkout_in_process">

            <div ng-messages="myForm.partial_payment.$error" ng-if="myForm.partial_payment.$touched || myForm.$submitted">
                <div class="text-danger" ng-message="required">Payment amount is required</div>
            </div>
        </div>

        <div class="col-lg-6 ppCheque" style='display:none'>
            <label class="col-form-label">Cheque #</label>
            <input ng-required="partial_payment_typ.id==2 && is_partial == 1" name="partial_payment_cheque" ng-model="partial_payment_cheque" type="text"  placeholder="93222257" class="form-control cheque" maxlength="8">
            <div ng-messages="myForm.partial_payment_cheque.$error" ng-if="myForm.partial_payment_cheque.$touched || myForm.$submitted">
                <div class="text-danger" ng-message="required">Cheque # is required</div>
            </div>
        </div>
    </div>
    <div class="form-group row" ng-show="paymentCleared">
        <div class="col-md-12">
            <h5>All payment has been cleared</h5>
        </div>
    </div>

</fieldset>
