<style>
.minimal-receipt .kt-logo img {
    width: 50%;
}
.room-detail table{
    font-size:12px;
    width: 100%;
}
.booking-detail {
    margin: 10px 0 5px 0;
    padding: 0 0 10px 0;
    border-bottom: 1px dashed #c1c1c1;
}
.booking-detail label{
    margin: 0;
}
.room-detail {
    border-bottom: 1px dashed #c1c1c1;
    margin-top: 10px;
    padding: 0 0 10px 0;
}
.charges-detail{
    margin-top: 10px;
    padding: 0 0 10px 0;
}
.charges-detail table{
    font-size:12px;
    width: 100%;
}
</style>
<div class="minimal-receipt">
    <div class="kt-logo">
        <img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="ktown Rooms & Homes">
    </div>
    <div class="booking-detail col-md-12">
        <div class="customer">
            <label>Customer: <span>[[nBooking.customer.FirstName]] [[nBooking.customer.LastName]]</span></label>
        </div>
        <div class="CheckIn">
            <label>Check-In: <span class="">[[start_date | date]]</span></label>
        </div>
        <div class="CheckIn">
            <label>Check-Out: <span class="">[[end_date | date]]</span></label>
        </div>
    </div>
    <div class="room-detail table-resposive col-md- d-none">
        <table>
            <thead>
                <tr>
                    <th>Room</th>
                    <th>Rate</th>
                    <th>Night's</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr ng-repeat="nBook in nBooking.rooms">
                    <td>[[nBook.room_title]]</td>
                    <td>[[nBook.room_charges_onbooking | currency]]</td>
                    <td class="text-center">[[nights]]</td>
                    <td>[[nBook.room_charges_onbooking*nights | currency]]</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="charges-detail col-md-12">
        <table>
            <tbody>
                <tr>
                    <th>Discount</th>
                    <td class="text-right">[[nBooking.invoice.discount_amount |currency]]</td>
                </tr>    
                <tr>
                    <th>Tax ([[nBooking.tax_rate.Tax]] [[nBooking.tax_rate.TaxValue]] %)</th>
                    <td class="text-right">[[nBooking.invoice.tax_charges |currency]]</td>
                </tr>    
                <tr>
                    <th>Paid Before</th>
                    <td class="text-right">[[nBooking.invoice.payment_amount | currency]]</td>
                </tr>
                <tr>
                    <th>Balance</th>
                    <td class="text-right">[[nBooking.invoice.net_total - nBooking.invoice.payment_amount | currency]]</td>
                </tr>
                <tr>
                    <th>Total</th>
                    <td class="text-right">[[nBooking.invoice.net_total |currency]]</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>