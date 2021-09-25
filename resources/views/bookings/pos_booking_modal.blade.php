<style>
.pos {
    width: auto !important;
    background: #eee !important;
    margin: 0 !important;
}
#btnPrint{
    display: none !important;
}
.ticket{
    max-width: 100% !important;
    margin:0 !important;
    width: auto !important;
}
.pos-sale-ticket img {
    width: 60% !important;
}

#receiptButtons 
{
    display: none !important;
}
.slect_printerDD{
    display: none;
}
#actionbtnformodal
{
    display: block !important;
}

.invoice_detail_sec {
    display: none;
}

</style>
<!--POS Card-->
<div id="printThis">
    <div id="posDetail" class="modal" tabindex="-1" >
        <div class="modal-dialog modal-sm  modal-dialog-centered">
            <div class="modal-content">
                @include('bookings.receipt_booking_angular')
            </div>
        </div>
    </div>
</div>
<!--/POS Card-->

<div>
    <div id="modalPayment" class="modal" tabindex="-1" >
        <div class="modal-dialog modal-xs  modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Checkout</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div ng-show="Invoice.invoice.is_corporate == '0' && Invoice.invoice.net_total > Invoice.invoice.payment_amount">
                        <p>Please collect [[Invoice.invoice.net_total - Invoice.invoice.payment_amount | currency]] from '[[Invoice.invoice.customer_first_name]] [[Invoice.invoice.customer_last_name]]'</p>
                        <div ng-show="!user.is_frontdesk">
                            <p>Mark as bad debt</p> <md-switch ng-model="bed_dead" ng-true-value="1" ng-false-value="0"></md-switch>
                        </div>
                        <div ng-show="user.is_frontdesk || bed_dead == 0">
                            @include('bookings.partial_payment_form')
                        </div>
                    </div>
                </div>
                <!-- pay without checkout -->
                <div class="modal-footer">
                    <button ng-hide="bed_dead == 1" type="button" ng-click="checkoutCallback()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i>Pay and Checkout</button>
                    <div ng-show="Invoice.invoice.net_total <= Invoice.invoice.payment_amount || bed_dead == 1 || Invoice.invoice.is_corporate == 1">
                        <button type="button" ng-click="checkoutCallback()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i>Checkout</button>
                    </div>
                </div>
                    
            </div>
        </div>
    </div>
</div>