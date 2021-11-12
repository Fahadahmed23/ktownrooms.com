<style>
.logo.logo-img .defaultimg {
    text-align: justify;
    margin: 0;
}
</style>
<div id="invoiceBox" class="modal fade" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="modal-title">Booking Invoice</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div> -->

            <div class="main" style="width: 100%;margin: 0 auto;padding: 15px 15px;">
                <div class="header" style="width: 100%;float: left;border-bottom: 1px solid #ea863b;">
                    <div class="headerRow" style="width: 100%;float: left;">
                        <div class="headerCol" style="width: 50%;float: left;">
                            <div class="logo logo-img">
                                <div class="defaultimg " ng-if="default_rule_img">
                                    <img src="[[default_rule_img]]" alt="ktown Rooms & Homes">
                                </div>
                                <div class="defaultimg" ng-if="!default_rule_img">
                                    <img style="width:20% !important;" src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="headerCol" style="width: 50%;float: left;">
                            <h4 style="margin: 0;">Head Office</h4>
                            <ul style="padding: 0;list-style: none; margin: 0;">
                                <li> <b> Address :</b> <span> [[default_rule.address?default_rule.address:'73C Jami Commercial Phase VII DHA Karachi']]</span></li>
                                <li><b>Phone :</b><span> [[default_rule.phone?default_rule.phone:'(92)-311-1222418']]</span></li>
                                <li><b>Website:</b> <span><a href="[[default_rule.website]]" target="_blank">[[default_rule.website]] </a></span></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="contnt" style="width: 100%;float: left;">
                    <div class="sectionOne" style="width: 100%;float: left;">
                        <div class="sectionOnecontent" style="width: 50%;padding: 0px;color: #00000091;border-collapse: collapse;float: left;">
                            <div class="box" style="min-height: 175px; border: 1px solid #eee;border-collapse: collapse; padding: 10px 20px;">
                                <h5 style="margin: 0;font-size: 18px;text-decoration: underline;">Booking Detail</h5>
                                <div class="">
        
                                    <ul style=" padding: 0;list-style: none;">
                                        <li ng-if="Invoice.booking_no" style=" margin: 2px 0;"><b> Booking # </b> <span style=" color: #000;">[[Invoice.booking_no]]</span></li>
                                        <li style=" margin: 2px 0;"><b> Hotel Name :</b> <span style=" color: #000;">[[Invoice.rooms[0].hotel.HotelName]]</span></li>
                                        <li style=" margin: 2px 0;"><b> Booking From :</b> <span style=" color: #000;">[[Invoice.start_date | date]]</span></li>
                                        <li style=" margin: 2px 0;"><b> Booking To :</b> <span style=" color: #000;">[[Invoice.end_date | date]]</span></li>
                                        <li style=" margin: 2px 0;"><b> Website :</b> <span style=" color: #000;"> <a href="https://www.ktownrooms.com" target="_blank">www.ktownrooms.com</a>
                                        </span></li>
        
                                    </ul>
                                </div>
                            </div>
        
                        </div>
        
                        <div class="sectionOnecontent" style="width: 50%;padding: 0px;color: #00000091;border-collapse: collapse;float: left;">
                            <div class=" box " style="min-height: 175px; border: 1px solid #eee;border-collapse: collapse; padding: 10px 20px;">
                                <h5 style="margin: 0;font-size: 18px;text-decoration: underline;">Customer Detail</h5>
                                <div class=" ">
        
                                    <ul style=" padding: 0;list-style: none;">
                                        <li style=" margin: 2px 0;"><b> Customer Name :</b> <span style=" color: #000;">[[Invoice.customer.FirstName]] [[Invoice.customer.LastName]]</span></li>
                                        <li style=" margin: 2px 0;"><b> Email :</b> <span style=" color: #000;">[[Invoice.customer.Email]]</span></li>
                                        <li style=" margin: 2px 0;"><b> Phone :</b> <span style=" color: #000;">[[Invoice.customer.Phone]]</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
        
                    <div class="sectionTwo " style=" width: 100%;float: left;">
                        <div class="sectionTwocontent " style="width: 100%;float: left;color: #00000091;">
                            <div class="box " style=" border: 1px solid #eee;border-collapse: collapse;padding: 10px 20px;">
                                <h5 style=" margin: 0;font-size: 18px;text-decoration: underline;">Invoice Detail</h5>
                                <div class=" ">
        
                                    <table style="margin-top: 25px;width: 100%;text-align: left;border-collapse: collapse;">
                                        <thead>
                                            <tr>
                                                <th style="padding: 10px !important;background: #1f2120;color: #fff;">Room Title</th>
                                                <th style="padding: 10px !important;background: #1f2120;color: #fff;">Night(s)</th>
                                                <th style="padding: 10px !important;background: #1f2120;color: #fff;">Services</th>
                                                <th style="padding: 10px !important;background: #1f2120;color: #fff;">Add. Guest</th>
                                                <th style="padding: 10px !important;background: #1f2120;color: #fff;">Total</th>
        
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr ng-repeat="room in Invoice.rooms">
                                                <td style="color: #000;background: #828c9d4f; border: 1px solid #eee; padding: 0 15px;">
                                                    <span class="roomtitle " style=" margin:5px 0 ; display: block;">[[room.room_title]] (Room# [[room.RoomNumber]])</span>
                                                    <span style=" background-color: #4caf50;display: inline-block;padding: 3px;margin-top: 5px;font-size: 12px;border-radius: 2px; color:#fff;" class="roomcategory ">[[room.category.RoomCategory]]</span>
                                                    <span class="  roomAllowedoccupants " style=" display: block; font-size: 13px;    margin: 5px 0; ">Allowed Occupants: [[room.hotel_room_category.allowed]]</span>
                                                    <span class="  roomMaxAllowedoccupants " style=" display: none; font-size: 13px;    margin: 5px 0; ">Max Allowed Occupants: [[room.hotel_room_category.max_allowed]]</span>
                                                </td>
                                                <td style="border: 1px solid #eee; padding: 0 15px;">
                                                    <span class=" nightscount " style="  margin:5px 0 ;display: block; ">[[nights]] Night(s)</span>
                                                    <span class="nightscharges " style=" margin:5px 0 ; display: block; ">[[nights]] x [[room.room_charges_onbooking | currency]]</span>
                                                    <span class="nightscharges " style="  margin:5px 0 ;display: block; ">[[room.room_charges_onbooking * nights | currency]]</span>
                                                </td>
                                                <td style="border: 1px solid #eee; padding: 0 15px">
                                                    <span ng-repeat="service in Invoice.services | filter:{room_id:room.id}" class="services" style="display: block;">[[service.service_name]] x [[service.excludes]]: [[service.amount | currency]]</span>
                                                    <!-- <span class="services" style="display: block;">Service 2</span>
                                                    <span class="services" style="display: block;">Service 3</span> -->
        
                                                    <!-- <span class="serviceprice" style="  margin:5px 0 ;display: block; ">[[service.amount]]</span> -->
                                                </td>
                                                <td style="border: 1px solid #eee; padding: 0 15px;">
                                                    <span class="guestcount " style=" display: block; " ng-if="room.occupants > room.hotel_room_category.allowed">[[room.occupants - room.hotel_room_category.allowed]] Guest(s)</span>
                                                    <span class="guestprice " style=" display: block; " ng-if="room.occupants > room.hotel_room_category.allowed">[[room.occupants - room.hotel_room_category.allowed]] x [[room.hotel_room_category.additional_guest_charges * nights | currency]]</span>
                                                    <span class="guestprice " style=" display: block; " ng-if="room.occupants > room.hotel_room_category.allowed">[[(room.occupants - room.hotel_room_category.allowed) * room.hotel_room_category.additional_guest_charges * nights | currency]]</span>
                                                </td>
                                                <td style="border: 1px solid #eee; padding: 0 15px;">
                                                    [[room.room_charges_onbooking * nights | currency]]
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2 ">
        
                                                </td>
                                                <td colspan="3 " style="border: 1px solid #eee; padding: 0 10px; background: #828c9d4f; color:#000;">
                                                    <div class="total">
                                                        <span ng-if="Invoice.invoice.discount_amount>0 && show_discount" class="discount " style="  margin:5px 0 ;display: block; ">Discount: [[Invoice.invoice.discount_amount | currency]] <span ng-if="Invoice.invoice.per_night == 1">([[ Invoice.invoice.discount_per_night | currency]] / Night)</span></span>
                                                        <span class="subtotal " style="  margin:5px 0 ;display: block; ">Sub Total: [[Invoice.invoice.total - Invoice.invoice.discount_amount | currency]]</span>
                                                        <span ng-if="Invoice.tax_rate_id > 0" class="tax " style="  margin:5px 0 ;display: block; ">Tax ([[tax_rate.Tax]] [[tax_rate.TaxValue]] %): [[Invoice.invoice.tax_charges | currency]]</span>
                                                        <span class="grandtotal " style="  margin:5px 0 ;display: block; ">GRAND TOTAL:<b> [[Invoice.invoice.net_total | currency]]</b></span>
                                                    </div>
                                                </td>
                                            </tr>
        
                                        </tbody>
                                    </table>
                                    {{-- <p style="margin: 0;text-align: right;"><small>*All prices are inclusive of tax</small></p> --}}
                                </div>
                            </div>
        
                        </div>
                    </div>
                </div>
            </div>













            <div class="card-body d-none">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="mb-4">
                            <img src="https://www.ktownrooms.com/resources/assets/web/img/logo.png" class="" alt="" style="width: 250px;">
                             {{-- <ul class="list list-unstyled mb-0">
                                <li>2269 Elba Lane</li>
                                <li>Paris, France</li>
                                <li>888-555-2311</li>
                            </ul> --}}
                        </div>
                    </div>

                    <div class="col-sm-6">
                        <div class="mb-4">
                            <div class="text-sm-right">
                                <h4 ng-if="formType=='edit'" class="text-primary mb-2 mt-md-2">Invoice #[[Invoice.id]]</h4>
                                <ul class="list list-unstyled mb-0">
                                    <li>Booking From: <span class="font-weight-semibold">[[Invoice.start_date | date]]</span></li>
                                    <li>Booking To: <span class="font-weight-semibold">[[Invoice.end_date | date]]</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-md-flex flex-md-wrap">
                    <div class="mb-4 mb-md-2">
                        <span class="text-muted">Invoice To:</span>
                         <ul class="list list-unstyled mb-0">
                            <li><h5 class="mt-2 mb-0 ">[[Invoice.customer.FirstName]] [[Invoice.customer.LastName]]</h5></li>
                            {{-- <li><span class="font-weight-semibold">Normand axis LTD</span></li>
                            <li>3 Goodman Street</li>
                            <li>London E1 8BF</li>
                            <li>United Kingdom</li>
                            <li>888-555-2311</li> --}}
                            <li class="mt-0"><a href="#">[[Invoice.customer.Email]]</a></li>
                            <li class="mt-0" ><a href="#">[[Invoice.customer.Phone]]</a></li>
                        </ul>
                    </div>

                    {{-- <div class="mb-2 ml-auto">
                        <span class="text-muted">Payment Details:</span>
                        <div class="d-flex flex-wrap wmin-md-400" style="background: #00000014;padding: 10px 5px">
                            <ul class="list list-unstyled mb-0">
                                <li><h5 class="my-2">Total Due:</h5></li> --}}
                                {{-- <li>Bank name:</li> --}}
                                {{-- <li>Country:</li>
                                <li>City:</li>
                                <li>Address:</li> --}}
                                {{-- <li>IBAN:</li> --}}
                                {{-- <li>SWIFT code:</li> --}}
                            </ul>

                            {{-- <ul class="list list-unstyled text-right mb-0 ml-auto">
                                <li><h5 class="font-weight-semibold my-2">[[Invoice.invoice.net_total | currency]]</h5></li> --}}
                                {{-- <li><span class="font-weight-semibold">Profit Bank Europe</span></li> --}}
                                {{-- <li>Pakistan</li>
                                <li>Karachi</li>
                                <li>DHA Phase-II</li> --}}
                                {{-- <li><span class="font-weight-semibold">KFH37784028476740</span></li>
                                <li><span class="font-weight-semibold">BPT4E</span></li> --}}
                            {{-- </ul>
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="table-responsive d-none">
                <table class="table table-lg">
                    <thead>
                        <tr>
                            <th>Rooms</th>
                            <th>Category</th>
                            {{-- <th>Charges</th> --}}
                            {{-- <th>Hours</th> --}}
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr ng-repeat="room in Invoice.rooms" >
                            <td class="py-0">
                                <h6 class="mb-0">[[room.room_title]] (Room# [[room.RoomNumber]])</h6>
                                <span class="text-muted">[[room.hotel.HotelName]]</span>
                            </td>
                            <td class="py-0"><span class="badge badge-info ml-auto">[[room.category.CategoryName]]</span></td>
                            {{-- <td class="py-0">[[room.RoomCharges]]</td> --}}
                            {{-- <td class="py-0">5</td> --}}
                            <td class="py-0"><span class="font-weight-semibold">[[room.room_charges_onbooking | currency]]</span></td>
                        </tr>
                        
                    </tbody>
                </table>
            </div>

            <div class="card-body d-none">
                <div class="d-md-flex flex-md-wrap">
                    {{-- <div class="pt-2 mb-3">
                        <h6 class="mb-3">Authorized person</h6>
                        <div class="mb-3">
                            <img src="../../../../global_assets/images/signature.png" width="150" alt="">
                        </div>

                        <ul class="list-unstyled text-muted">
                            <li>Ktown Rooms</li>
                            <li>DHA Phase-II</li>
                            <li>karachi, Pakistan</li>
                            <li>923182128676</li>
                        </ul>
                    </div> --}}

                    <div class="pt-2 mb-3" style="width: 100%">
                        <h6 class="mb-3 px-3">Payment Mode: <small>[[Invoice.payTyp.PaymentMode]]</small><small ng-if="Invoice.payTyp.id==2">[["  (" + Invoice.cheque_no + ")"]]</small></h6>
                        <h6 class="mb-3 px-3">Total due</h6>
                        
                        <div class="table-responsive">
                            
                            <table class="table">
                                <tbody>
                                    <tr>
                                        <th>Subtotal:</th>
                                        <td class="text-right py-0">[[Invoice.invoice.total | currency ]]</td>
                                    </tr>
                                    <tr ng-if="Invoice.promotion.Code">
                                        <th>Promo:[[Invoice.promo.Code]]</th>
                                        <td ng-if="Invoice.promo.IsPercentage==1" class="text-right py-0">[[Invoice.promo.DiscountValue]]<span >%</span></td>
                                        <td ng-if="Invoice.promo.IsPercentage==0" class="text-right py-0">[[Invoice.promo.DiscountValue | currency]]</td>
                                    </tr>
                                    <tr>
                                        <th>Tax: <span class="font-weight-normal">([[tax_rate.Tax]]: [[tax_rate.TaxValue]] %)</span></th>
                                        <td class="text-right py-0">[[Invoice.invoice.tax_charges | currency]]</td>
                                    </tr>
                                    <tr>
                                        <th>Total:</th>
                                        <td class="text-right py-0 text-primary"><h5 class="font-weight-semibold"> [[Invoice.invoice.net_total | currency]]</h5></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-right mt-3">
                            <!-- <button ng-click="saveForm()" type="button" class="btn btn-primary btn-labeled btn-labeled-left"><i class="icon-paperplane"></i> Send invoice</button> -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- <div class="card-footer">
                <span class="text-muted">Thanks for visiting us. This invoice can be paid via Cash,Cheque or Credit Card. Payment is due within 30 days from the date of delivery. Late payment is possible, but with a fee of 10% per month.</span>
            </div> -->

            <div class="modal-footer bg-transparent">
                <button ng-show="channels" type="button" ng-click="closeInvoice()" class="btn btn-outline-danger bkng-cncl"><i class="icon-close2 ml-2"></i> [[inBooking?'Cancel':'Close']]</button>
                <button ng-hide="channels" type="button" data-dismiss="modal" class="btn btn-outline-danger bkng-cncl"><i class="icon-close2 ml-2"></i> [[inBooking?'Cancel':'Close']]</button>
                <button  ng-if="inBooking" ng-click="saveForm()" type="button" class="btn btn-primary btn-labeled btn-labeled-left"><i class="icon-paperplane"></i> Confirm</button>
            </div>
        </div>
    </div>
</div>
<!-- /modal with invoice -->