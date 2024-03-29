
<style>

.slect_printerDD {
    border-left: 2px solid #ea863b;
    margin: 5px auto;
    border-bottom: 1px solid #00000017;
    text-align: left;
    width: 300px;
    background: #eeeeee;
    padding: 15px;
    float: right;
    border-radius: 0 0 5px 5px;
    
}
.slect_printerDD label {
    width: 50%;
    float: left;
}

.slect_printerDD select {
    cursor: pointer;
    border: none;
    width: 50%;
    padding: 5px 0px;
    border-radius: 5px;
    border: 1px solid #0000002e;
}
#for_portable  {
    width:200px;
    font-size: 12px;
}
#for_portable table {
    border-collapse: collapse;
    font-size: 12px;
    max-width: 100%;
}
#for_portable .footernote{
font-size: 10px !important;
}

    table {
        border-collapse: collapse;
        font-size: 14px;
    }
    
    .ticket {
        margin: 0 auto;
        width: 300px;
        padding: 10px 15px;
        max-width: 300px;
        background: #eee;
    }
    .centered-content {
    color: #000;
    }
    .pos-sale-ticket img {
    width: 90%;
    }
    #compname {
        font-weight: bold;
        font-size: 17px;
        text-transform: uppercase;
    }
    
    .pos-content {
        padding: 15px;
    }
    
    table.receipt-orderlines {
        text-align: left;
        width: 100%;
    }
    
    table.receipt-total {
        text-align: left;
        width: 100%;
    }
    
    .pos-right-align {
        text-align: right;
    }
    .pos-left-align {
        text-align: left;
    }
    .pos-center-align {
    text-align: center;
    }
    
    div#receiptButtons {
        text-align: right;
        display: block;
    }
    #actionbtnformodal{
        display: none;
    }


    /* css for invoice list */
    
    .invoice_detail_sec {
    height: 100vh;
    float: left;
    border-right: 2px solid #ea863b;
    margin: 5px auto;
    border-bottom: 1px solid #00000017;
    text-align: left;
    width: 300px;
    overflow: auto;
    background: #eeeeee;
    border-radius: 0px 0px 5px 5px;
    }
    .inv_heading h4{
        margin:0;
    }
    .inv_heading {
    border-bottom: 1px solid #dedada;
    padding: 10px 0;
    margin-bottom: 10px;
    }
    .inv-detail strong {
    width: 50%;
    float: left;
    font-size: 13px;
    }
    .inv-detail span {
    width: 50%;
    float: left;
    font-size: 13px;
    }
    .invoice_detail_sec .row {
        padding: 0 12px;
    }
    ul.invoice-list-ul {
        list-style: none;
        padding: 0;
        margin: 0;
    }
    .invoice-list-ul li {
    background: #fff;
    cursor: pointer;
    padding: 5px 10px;
    border-radius: 5px;
    margin-bottom: 14px;
    border: 1px solid #dedada;
    }
    .invoice-list-ul li.active {
    border: 2px dashed #ea863b;
    background: #fff;
    margin-top: 10px;
    }
    .inv-detail {
    display: inline-block;
    width: 100%;
    }
    .iner-div {
    width: 100%;
    float: left;
    }
    .invoice-row {
        /* max-height: 200px; */
        overflow: auto;
    }
    .iner-div.text-right {
    text-align: right;
    margin: 5px 0 0 0;
    }
    .iner-div.text-right button {
    font-size: 10px;
    }
    .iner-div.text-right button i {
    margin-left: 5px;
    }
    .text-right{
        text-align: right;
    }
    .text-center{
        text-align: center;
    }
    .invoice_detail_table{
        margin-bottom: 20px;
    }

    @media print {
        #receiptButtons,
        #receiptButtons * {
            display: none !important;
        }

        .ticket{
            position: absolute;
            top: 0;
            left: 0;
        }
        .slect_printerDD {
            display: none;
        }
        .invoice_detail_sec{
            display: none;
        }


    }
</style>
<div class="invoice_detail_sec">
    {{-- <div class="row">
        <div class="inv_heading">
            <h4>Main </h4>
        </div>
    </div> --}}
    <div class="row invoice-row">

        <ul id="invoice_btns_ul" class="invoice-list-ul">
            <li class="inv_btn [[!invoice_detail?'active':'']]" style="margin-top: 20px;" ng-click="showMainReceipt()">
                <div class="inv-detail">
                    <div class="iner-div"><strong>Main Receipt</strong></div>
                    <div class="iner-div"><strong>Booking No: </strong> <span>[[Invoice.booking_no]]</span></div>
                </div>
            </li>
            <div class="inv_heading">
            <h4>Invoices</h4>
            </div>
            <li class="inv_btn [[inv.invoice_no==invoice_detail.invoice_no?'active':'']]" data-inv="[[inv.invoice_no]]" ng-repeat="inv in invoice_details" ng-click="getInvoiceDetailReceipt(inv)">
                <div class="inv-detail">
                    <div class="iner-div"><strong>Receipt No:</strong> <span>[[inv.invoice_no]]</span></div>
                    <div class="iner-div"> <strong>Type: </strong> <span>[[inv.type | camelCase]]</span> </div>
                    <div class="iner-div"><strong>Booking No: </strong> <span>[[inv.booking_no]]</span></div>
                    {{-- <div class="iner-div text-right"><button ng-click="getInvoiceDetailReceipt(inv)">Get Receipt <i class="fa fa-receipt" aria-hidden="true"></i></button></div> --}}
                </div>
            </li>
        </ul>
    </div>
</div>



<div class="slect_printerDD">
    <label for="">Select your page size:</label>
    <select name="type" id="type">
        <option name="blackcopper" value="blackcopper" data-toggle="tooltip" data-placement="top" title="This size is use for 'BlackCopper Printer'">80mm</option>
        <option name="portable" value="portable" data-toggle="tooltip" data-placement="top" title="This size is use for 'Portable Printer'">58mm</option>
    </select>
</div>
<div class="ticket" id="for_blackcopper">
    <div class="centered-content">
        <div id="receiptButtons">
            <button ng-click="printBookingReceipt()" id="btnPrint" type="button" class="btn btn-xs btn-info"><i class="fa fa-print"></i></button>
        </div>
        <div id='actionbtnformodal' class="button text-right print" ng-hide="inPrint">
            <button id="redirectReceiptPage" ng-click="hideBookingReceipt(); bookingReceiptRedirect(Invoice.id)" class="btn btn-warning"  data-placement="top" data-popup="popover" data-trigger="hover" data-html="true"
            data-content="Printable Invoices"><i class="icon-printer2"></i></button>
            <button ng-click="hideBookingReceipt(); showPartialPay(Invoice.id)" class="btn btn-info" data-placement="top" data-popup="popover" data-trigger="hover" data-html="true"
            data-content="Add Payment"><i class="icon-cash2"></i></button>
            <button ng-show="old_status == 'CheckedIn'" ng-click="checkoutFromReceipt()" type="button" class="checkout_btn btn btn-xs btn-warning" data-placement="top" data-popup="popover" data-trigger="hover" data-html="true"
            data-content="Checkout"><i class="fa fa-sign-out-alt"></i></button>
            <button ng-click="hideBookingReceipt()" class="btn btn-xs btn-danger" data-placement="top" data-popup="popover" data-trigger="hover" data-html="true"
            data-content="Cancel"><i class="fa fa-close"></i></button>
        </div>
        <div class="pos-receipt-container">
                <div ng-show="Invoice.invoice.is_corporate == '0' && Invoice.invoice.net_total > Invoice.invoice.payment_amount && 1==2">
                    @include('bookings.partial_payment_form')
                    <button type="button" ng-click="checkoutFromReceipt()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i>Pay and Checkout</button>
                </div>
                <div class="pos-sale-ticket">
                    <img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="ktown Rooms & Homes">
                    <br>
                    <br>
                    <br><span class="boldre">Booking # </span><span class="ordernum">[[Invoice.booking_no]]</span>
                    <br>
                    <span class="boldre">Date &amp; Time: </span>[[current_timestamp]]
                    <br>
                    <span class="boldre">Customer: </span>[[Invoice.customer.FirstName+' '+Invoice.customer.LastName]]<br>
                    <div ng-if="invoice_detail.type == 'service'" class="boldre">Room: [[Invoice.rooms[0].room_title]] (Room# [[Invoice.rooms[0].RoomNumber]])</div>
                    <span ng-if="invoice_detail.invoice_no" class="boldre">Receipt No: </span>[[invoice_detail.invoice_no]]<br>
                    
                    <br>
                    <br>

                    <table ng-show="invoice_detail" class="receipt-orderlines invoice_detail_table">
                        <thead>
                            <tr>
                                <th ng-if="invoice_detail.type == 'payment'">Payment</th>
                                <th ng-if="invoice_detail.type == 'service'">Service</th>
                                <th>Type</th>
                                <th ng-if="invoice_detail.quantity">Quantity</th>
                                <th ng-if="invoice_detail.rate" class="text-right" >Rate</th>
                                <th ng-if="invoice_detail.type == 'payment'">Total</th>
                                <th ng-if="invoice_detail.type == 'refund'|| invoice_detail.type == 'early checkin' || invoice_detail.type == 'late checkout'">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td ng-if="invoice_detail.type == 'payment'">Payment Received</td>
                                <td ng-if="invoice_detail.type == 'service'" >[[invoice_detail.title]]</td>
                                <td>[[invoice_detail.type | camelCase]]</td>
                                <td ng-if="invoice_detail.quantity" class="text-center">[[invoice_detail.quantity]]</td>
                                <td ng-if="invoice_detail.rate" class="text-right" >[[invoice_detail.rate | currency]]</td>
                                <td ng-if="invoice_detail.type == 'payment'">[[invoice_detail.amount | currency]]</td>
                                <td ng-if="invoice_detail.type == 'refund'|| invoice_detail.type == 'early checkin' || invoice_detail.type == 'late checkout'">[[invoice_detail.amount | currency]]</td>
                            </tr>
                        </tbody>
                    </table>
                    
                    <table ng-show="invoice_detail.type == 'service'" class="receipt-orderlines">
                        <th>Total</th>
                        <td class="text-right">[[invoice_detail.amount | currency]]</td>
                    </table>


                    <table ng-hide="invoice_detail" class="receipt-orderlines">
                        
                                <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Rate</th>
                                        <th class="pos-right-align">Night(s)</th>
                                        <th class="pos-right-align">Amount</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <tr ng-repeat="room in Invoice.rooms">
                                            <td>[[room.room_title]] (Room# [[room.RoomNumber]])</td>
                                            <td>[[room.pivot.room_charges_onbooking | currency]]</td>
                                            <td class="pos-center-align"> [[Invoice.invoice.nights]]</td>
                                            <td class="pos-center-align">[[Invoice.invoice.nights * room.pivot.room_charges_onbooking | currency]]</td>
                                        </tr>
                                    </tbody>
                    </table>
                                            <br>
                    <table ng-hide="invoice_detail" class="receipt-orderlines" ng-if="Invoice.services.length > 0">
                                              
                                                <thead>
                                                    <tr>
                                                        <th>Services</th>
                                                        <th class="pos-right-align">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="service in Invoice.services">
                                                        <td>[[service.excludes]] [[service.service_name]] @ [[service.service_charges | currency]]</td>
                                                        <td class="pos-right-align">[[service.amount | currency]]</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="pos-right-align">Total:</th>
                                                        <th class="pos-right-align">[[Invoice.service_total | currency]]</th>
                                                    </tr>
                                                </tfoot>
                    </table>
                                            <br>
                    <table ng-hide="invoice_detail" class="receipt-total">
                                            <tbody>
                                                <tr ng-show="show_discount && Invoice.invoice.discount_amount > 0">
                                                    <td>Discount:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.discount_amount | currency]]</td>
                                                </tr>
                                                
                                                <tr ng-show="Invoice.invoice.early_checkin_charges > 0">
                                                    <td>Early Checkin Charges:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.early_checkin_charges | currency]]</td>
                                                </tr>

                                                <tr ng-show="Invoice.invoice.late_checkout_charges > 0">
                                                    <td>Late Checkout Charges:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.late_checkout_charges | currency]]</td>
                                                </tr>

                                                <tr ng-if="Invoice.invoice.tax_rate_id > 0">
                                                    <td>Tax: <small>([[Invoice.invoice.tax_name]]: [[Invoice.invoice.tax_rate]] %)</small></td>
                                                    <td class="pos-right-align">[[Invoice.invoice.tax_charges | currency]]</td>
                                                </tr>
                                                    
                                                {{-- <tr ng-if="Invoice.invoice.net_total > Invoice.invoice.payment_amount"> --}}
                                                <tr ng-if="Invoice.invoice.payment_amount > 0">
                                                    <td>Payment Received:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.payment_amount | currency]]</td>
                                                </tr>
                                                
                                                <tr ng-if="Invoice.invoice.net_total > Invoice.invoice.payment_amount && !Invoice.invoice.refund">
                                                    <td>Balance Payable:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.net_total - Invoice.invoice.payment_amount | currency]]</td>
                                                </tr>

                                                <tr ng-if="Invoice.invoice.refund">
                                                    <td>Balance Refundable:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.refund | currency]]</td>
                                                </tr>
                                                
                                                <tr class="emph">
                                                    <td><span class="boldre">Total:</span></td>
                                                    <td class="pos-right-align"><span class="boldre">[[Invoice.invoice.net_total | currency]]</span></td>
                                                </tr>
                                            </tbody>
                    </table>

                            <br>
                            <br>
                            <hr><span class="boldre">User: </span>[[user.name]]
                            <hr>
                            <div class="thnote" style="font-size: 14px;">Thankyou for choosing Ktown Rooms & Homes </div>
                            <hr><span style="font-size: 12px;">Powered by Manhattan Datanet INC.</span>
                </div>
        </div>
    </div>
</div>

<div class="ticket" id="for_portable" style="display: none;">
    <div class="centered-content">
        <div id="receiptButtons">
            <button ng-click="printBookingReceipt()" id="btnPrint" type="button" class="btn btn-xs btn-info"><i class="fa fa-print"></i></button>
        </div>
        <div id='actionbtnformodal' class="button text-right print" ng-hide="inPrint">
            <button ng-show="old_status == 'CheckedIn'" ng-click="checkoutFromReceipt()" type="button" class="checkout_btn btn btn-xs btn-warning" data-placement="top" data-popup="popover" data-trigger="hover" data-html="true"
            data-content="Checkout"><i class="fa fa-sign-out-alt"></i></button>
            <button ng-click="hideBookingReceipt()" class="btn btn-xs btn-danger" data-placement="top" data-popup="popover" data-trigger="hover" data-html="true"
            data-content="Cancel"><i class="fa fa-close"></i></button>
        </div>
        <div class="pos-receipt-container">
                <div ng-show="Invoice.invoice.is_corporate == '0' && Invoice.invoice.net_total > Invoice.invoice.payment_amount && 1==2">
                    @include('bookings.partial_payment_form')
                    <button type="button" ng-click="checkoutFromReceipt()" class="btn btn-success"><i class=" mr-2 icon-floppy-disk mr-2"></i>Pay and Checkout</button>
                </div>
                <div class="pos-sale-ticket">
                    <img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="ktown Rooms & Homes">
                    <br>
                    <br>
                    <br><span class="boldre">Bookig # </span><span class="ordernum">[[Invoice.booking_no]]</span>
                    <br>
                    <span class="boldre">Date &amp; Time: </span>[[current_timestamp]]
                    <br>
                    <span class="boldre">Customer: </span>[[Invoice.customer.FirstName+' '+Invoice.customer.LastName]]
                    <br>
                    <div ng-if="invoice_detail.type == 'service'" class="boldre">Room: [[Invoice.rooms[0].room_title]] (Room# [[Invoice.rooms[0].RoomNumber]])</div>
                    <span ng-if="invoice_detail.invoice_no" class="boldre">Receipt No: </span>[[invoice_detail.invoice_no]]<br>
                    <br>


                    <table ng-show="invoice_detail" class="receipt-orderlines invoice_detail_table">
                        <thead>
                            <tr>
                                <th ng-if="invoice_detail.type == 'payment'">Payment</th>
                                <th ng-if="invoice_detail.type == 'service'">Service</th>
                                <th>Type</th>
                                <th ng-if="invoice_detail.quantity">Quantity</th>
                                <th ng-if="invoice_detail.rate" class="text-right" >Rate</th>
                                <th ng-if="invoice_detail.type == 'payment'">Total</th>
                                <th ng-if="invoice_detail.type == 'refund'|| invoice_detail.type == 'early checkin' || invoice_detail.type == 'late checkout'">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td ng-if="invoice_detail.type == 'payment'">Payment Received</td>
                                <td ng-if="invoice_detail.type == 'service'" >[[invoice_detail.title]]</td>
                                <td>[[invoice_detail.type | camelCase]]</td>
                                <td ng-if="invoice_detail.quantity" class="text-center">[[invoice_detail.quantity]]</td>
                                <td ng-if="invoice_detail.rate" class="text-right" >[[invoice_detail.rate | currency]]</td>
                                <td ng-if="invoice_detail.type == 'payment'">[[invoice_detail.amount | currency]]</td>
                                <td ng-if="invoice_detail.type == 'refund'|| invoice_detail.type == 'early checkin' || invoice_detail.type == 'late checkout'">[[invoice_detail.amount | currency]]</td>


                            </tr>
                        </tbody>
                    </table>
                    
                    <table ng-show="invoice_detail.type == 'service'" class="receipt-orderlines">
                        <th>Total</th>
                        <td class="text-right">[[invoice_detail.amount | currency]]</td>
                    </table>



                    <table ng-hide="invoice_detail" class="receipt-orderlines">
                                <thead>
                                    <tr>
                                        <th>Room</th>
                                        <th>Rate</th>
                                        <th class="pos-right-align">Night(s)</th>
                                        <th class="pos-right-align">Amount</th>
                                    </tr>
                                </thead>
                                    <tbody>
                                        <tr ng-repeat="room in Invoice.rooms">
                                            <td>[[room.room_title]] (Room# [[room.RoomNumber]])</td>
                                            <td>[[room.pivot.room_charges_onbooking | currency]]</td>
                                            <td class="pos-center-align"> [[Invoice.invoice.nights]]</td>
                                            <td class="pos-center-align">[[Invoice.invoice.nights * room.pivot.room_charges_onbooking | currency]]</td>
                                        </tr>
                                    </tbody>
                    </table>
                                            <br>
                    <table ng-hide="invoice_detail" class="receipt-orderlines" ng-if="Invoice.services.length > 0">
                                             
                                                <thead>
                                                    <tr>
                                                        <th>Services</th>
                                                        <th class="pos-right-align">Amount</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr ng-repeat="service in Invoice.services">
                                                        <td>[[service.excludes]] [[service.service_name]] @ [[service.service_charges | currency]]</td>
                                                        <td class="pos-right-align">[[service.amount | currency]]</td>
                                                    </tr>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th class="pos-right-align">Total:</th>
                                                        <th class="pos-right-align">[[Invoice.service_total | currency]]</th>
                                                    </tr>
                                                </tfoot>
                    </table>
                                            <br>
                    <table ng-hide="invoice_detail" class="receipt-total">
                                            <tbody>
                                                <tr ng-show="show_discount && Invoice.invoice.discount_amount > 0">
                                                    <td>Discount:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.discount_amount | currency]]</td>
                                                </tr>
                                                
                                                <tr ng-if="Invoice.invoice.tax_rate_id > 0">
                                                    <td>Tax: <small>([[Invoice.invoice.tax_name]]: [[Invoice.invoice.tax_rate]] %)</small></td>
                                                    <td class="pos-right-align">[[Invoice.invoice.tax_charges | currency]]</td>
                                                </tr>
                                                    
                                                {{-- <tr ng-if="Invoice.invoice.net_total > Invoice.invoice.payment_amount"> --}}
                                                <tr ng-if="Invoice.invoice.payment_amount > 0">
                                                    <td>Payment Received:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.payment_amount | currency]]</td>
                                                </tr>
                                                
                                                <tr ng-if="Invoice.invoice.net_total > Invoice.invoice.payment_amount">
                                                    <td>Balance Payable:</td>
                                                    <td class="pos-right-align">[[Invoice.invoice.net_total - Invoice.invoice.payment_amount | currency]]</td>
                                                </tr>
                                                
                                                <tr class="emph">
                                                    <td><span class="boldre">Total:</span></td>
                                                    <td class="pos-right-align"><span class="boldre">[[Invoice.invoice.net_total | currency]]</span></td>
                                                </tr>
                                            </tbody>
                    </table>
                            <br>
                            <br>
                            <hr><span class="boldre">User: </span>[[user.name]]
                            <hr>
                            <div class="thnote footernote" style="font-size: 14px;">Thankyou for choosing Ktown Rooms & Homes </div>
                            <hr><span  class="footernote" style="font-size: 12px;">Software Developed by Manhattan Datanet INC.</span>
                </div>
        </div>
    </div>
</div>


<script>

    $('#type').change(function(){
        if($('#type').val() == 'portable') {
            $('#for_portable').show(); 
            $('#for_blackcopper').hide(); 
        }else if($('#type').val() == 'blackcopper'){
            $('#for_portable').hide(); 
            $('#for_blackcopper').show(); 
        }
    });

</script>