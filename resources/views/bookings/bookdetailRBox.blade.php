<style>
    .history_table {
    width: 100%;
    border-collapse: collapse;
    }

    .history_table td, .history_table th {
    border: 1px solid #dddddd;
    text-align: left;
    padding: 8px;
    }
</style>
<!--right bar content-->
<div class="BookDetailRBox col-lg-4 float-right right-tour-bar pr-lg-0 p-xs-0" style="display:none;">

    <!-- Custom handle -->
    <div class="card tourcard">
        <div class="card-header header-elements-inline">
            <h5 class="card-title">Booking Detail ([[bookingDetail.booking_no]])</h5>
            <div class="header-elements">
                <div class="list-icons">
                    <a class="list-icons-item right-tour-bar-close" ng-click="hideBookDetailRBox()"><i class="icon-cross2"></i></a>
                    <!--<a class="list-icons-item" data-action="reload"></a>
                    -->
                </div>
            </div>
        </div>
        <div class="card-body border-top-0">
            <div class="media">
                <div class="media-body mb-2">
                    <!-- <strong>[[bookingDetail.booking_no]]</strong> -->
                    <ul class="list-inline list-inline-dotted text-muted mb-2">
                        <li class="list-inline-item ng-binding"><strong>Check in: </strong>[[bookingDetail.BookingFrom | date]]</li>
                        <li class="list-inline-item ng-binding"><strong>Check Out: </strong>[[bookingDetail.BookingTo | date]]</li>
                        <li class="list-inline-item ng-binding"><strong>Discount: </strong>[[bookingDetail.invoice.discount_amount | currency]]</li>
                        <li class="list-inline-item ng-binding"><strong>Total: </strong>[[bookingDetail.invoice.net_total | currency ]]</li>
                    </ul>
                </div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Hotel:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.hotel.HotelName]]</div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Full name:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.customer.FirstName]] [[bookingDetail.customer.LastName]]</div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Phone number:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.customer.Phone]]</div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Email:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0"><a href="#">[[bookingDetail.customer.Email]]</a></div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Occupants:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.invoice.num_occupants]]</div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Booking Total:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.invoice.total | currency]]</div>
            </div>

            <!-- <div ng-hide="!bookingDetail.Code">
                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold">Promo Discount: ([[bookingDetail.Code]]) </div>
                    <div class="ml-sm-auto mt-2 mt-sm-0"><span ng-if="bookingDetail.IsPercentage!=1" class="mr-2">Rs. </span>[[bookingDetail.DiscountValue]]<span class="ml-1" ng-if="bookingDetail.IsPercentage==1">%</span></div>
                </div>

                <div class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold">Discount:</div>
                    <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.discount_amount | currency]] </div>
                </div>
            </div> -->

            <div ng-if="bookingDetail.discount_amount > 0" class="d-sm-flex flex-sm-wrap mb-3">
                    <div class="font-weight-semibold">Discount:</div>
                    <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.invoice.discount_amount | currency]] </div>
                </div>

            <div ng-if="bookingDetail.tax_rate_id > 0" class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Tax Amount: ([[bookingDetail.invoice.tax_name]] - [[bookingDetail.invoice.tax_rate]] %)</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.invoice.tax_charges | currency]]</div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Net Total:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.invoice.net_total | currency]]</div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Status:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0"><span class="badge" ng-class="getStatusClass(bookingDetail.status)">[[bookingDetail.status]]</span></div>
            </div>

            <div class="d-sm-flex flex-sm-wrap mb-3">
                <div class="font-weight-semibold">Amount Paid:</div>
                <div class="ml-sm-auto mt-2 mt-sm-0">[[bookingDetail.invoice.payment_amount | currency]]</div>
            </div>

            <div class="text-right my-2" ng-show="bookingDetail.status != 'CheckedOut' && bookingDetail.status != 'Cancelled' && !user.is_supervisor">
                <button ng-click="addPartialPay()" class="btn btn-sm btn-info">Add Payment</button>      
            </div>
        </div>
            <div class="card zig-zag-top" ng-if="bookingDetail.status_history" style="background: #f5f5f5;">
                <div class="card-header header-elements-inline" style="padding: 0 15px !important;">
                    <h6 class="card-title">Status History</h6>
                </div>
                <div class="card-body border-top-0" style="font-family: monospace;">
                    <table class="history_table">
                        <thead>
                            <tr>
                                <td>Status</td>
                                <td>Timestamp</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr ng-repeat="row in bookingDetail.status_history">
                                <td><span>[[row.status]]</span></td>
                                <td>[[row.status_date]]</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

        <div class="card-footer d-flex justify-content-around text-center p-0">
            <a ng-if="bookingDetail.status=='CheckedIn'" href="#" class="list-icons-item flex-fill p-2" ng-click="viewPOS(bookingDetail, 'checkout')" data-popup="tooltip" data-container="body" title="Edit">
                <i class="fa fa-door-closed top-0"></i> Checkout
            </a>

            <a ng-if="bookingDetail.status!='Cancelled' && bookingDetail.status!='CheckedOut'" href="#" class="list-icons-item flex-fill p-2 edit-sec " ng-click="editBooking(bookingDetail.id)" data-popup="tooltip" data-container="body" title="Edit">
                <i class="icon-pencil5 top-0"></i> Edit
            </a>
            <a ng-if="bookingDetail.status!='Cancelled' && bookingDetail.status!='CheckedIn' && bookingDetail.status!='CheckedOut'" href="javascript:void(0)" class="list-icons-item flex-fill p-2 " ng-click="cancelBooking(bookingDetail)" data-popup="tooltip" data-container="body" title="Cancel">
                <i class="icon-undo2 top-0"></i> Cancel
            </a>
            <!-- <a href="javascript:void(0)" class="list-icons-item flex-fill p-2" ng-click="deleteBooking(bookingDetail)" data-popup="tooltip" data-container="body" title="Delete">
                <i class="icon-bin top-0"></i> Delete
            </a> -->
        </div>
    </div>
    <!-- /custom handle -->
</div>
<!--/right bar content-->