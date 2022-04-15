<div id="addCheckoutDiscount" class="mt-2" style='display:none;'>
        <div class="form-group row m-0">
           <form ng-submit="saveCheckoutDiscount()"></form>
            <strong class="col-form-label col-md-6 pl-0">Checkout Discount</strong>
            <input ng-change="getCheckoutDiscount(Invoice.invoice.checkout_discount)" name="checkout_discount" ng-model="Invoice.invoice.checkout_discount" type="text" data-type="currency" currency placeholder="200.00" class="border-0 col-md-6" maxlength="10">
            <textarea ng-show="checkout_discount_remarks" ng-model="Invoice.invoice.checkout_discount_remarks" name="" id="" class="bg-white form-control mt-1" placeholder="Please enter remarks!"></textarea>
        </div>
</div>
