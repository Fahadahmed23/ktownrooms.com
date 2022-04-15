<style>
    table th, table td {
    border: 1px solid #eee;
    padding: 0 10px;
    /* text-align: center; */
    }
.complains-card::-webkit-scrollbar {
  width: 0px;
}

.complains-card::-webkit-scrollbar-track {
  background: #dddddd;
}
.complains-card::-webkit-scrollbar-thumb {
    background-color: #757575;
    border-radius: 20px;
    border: 3px solid #757575;
}

.customerName {
    font-size: 30px;
}
#mainBox {
    position: absolute;
    top: 20%;
    width: 100%;
    left: 0;
    right: 0;
    margin: 0 auto;
}
.bckbtn{
    cursor: pointer;
}
@media only screen and (max-width: 767px) {
#mainBox {
    position: relative;
}
.row.kt-services .kt {
    padding: 0;
}

}
.cstStyle{
    display: inline-grid !important;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">

<div id="mainBox" class="row">
    <div class=" col-md-8 m-auto">
        <div class="card p-3" style="background: #ffffffd9;">
            @auth
                <div class="row">
                    <div class="card-body">
                        <h5 class="card-text">Booking Details:</h5>
                        <ul style="list-style: none;padding: 0;">
                            <li> <b>Booking #</b>  <span>[[booking.booking_no]]</span></li>
                            <li> <b>Booking Date :</b>  <span>[[booking.BookingDate | date ]]</span></li>
                            <li> <b>Booking Status :</b>  <span ng-class="bookingStatus(booking.status)" class="badge" >[[booking.status]]</span></li>
                        </ul>
                    </div>
                </div>
            @endauth

            @guest
            {{-- <div class="row">
                <div class="col-md-8">
                    <h5  class="card-title mb-0 customerName pl-0">[[greetMessage]], [[booking.customer.FirstName]] [[booking.customer.LastName]]</h5>
                </div>
            </div>
            <h6 class="card-subtitle mt-2 mb-0 text-dark">Thanks For Booking In <b>[[booking.hotel.HotelName]] </b></h6> --}}

            <div class="card border-bottom-0 rounded-0">
                <div class="page-header page-header-dark has-cover mb-0">
                    <div class="page-header-content header-elements-inline">
                        <div class="page-title">
                            <h5>
                                <span class="font-weight-semibold">[[greetMessage]], <span class="text-uppercase">[[booking.customer.FirstName]] [[booking.customer.LastName]]</span></span>
                                <small class="d-block"> <span class="opacity-75">Thanks For Booking In</span> <span><b class="text-white">[[booking.hotel.HotelName]] </b></span></small>
                            </h5>
                        </div>
                    </div>
                </div>
                <ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0">
                    <li class="nav-item active show"><a href="#booking-detail" class="nav-link active show" data-toggle="tab"><i class="icon-stack-check mr-2 text-success"></i>Details</a></li>
                    <li class="nav-item"><a href="#booking-rooms" class="nav-link" data-toggle="tab"><i class="icon-bed2  mr-2 text-danger"></i>Rooms</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane fade active show" id="booking-detail">
                        <div class="row m-0 py-2">
                            <div class="col-md-4">
                                <div class="booking_information">
                                    <div class="pt-2 px-2 detail">
                                        <div class="booking-number">
                                            <span class="font-weight-bold"> Booking# : </span>
                                            <span>[[booking.booking_no]]</span>
                                            <span ng-class="bookingStatus(booking.status)" class="badge ml-1" >[[booking.status]]</span>
                                        </div>
    
                                        <div class="booking-hotel">
                                            <span class="font-weight-bold"> Hotel : </span><span>[[booking.hotel.HotelName]] </span>
                                        </div>

                                        <div class="booking-total-occupants">
                                            <span class="font-weight-bold"> Total Occupants : </span><span>[[booking.no_occupants]] </span>
                                        </div>
                                        <div class="booking-amount-details">
                                            <div ng-if="booking.invoice.payment_amount > 0">
                                                <span class="font-weight-bold">
                                                    Payment Received:
                                                </span>
                                                 <span>
                                                 [[booking.invoice.payment_amount | currency]]
                                                </span>
                                            </div>
                                            
                                            <div ng-if="booking.invoice.net_total > booking.invoice.payment_amount && !booking.invoice.refund">
                                                <span class="font-weight-bold">
                                                    Balance Payable:
                                                </span>
                                                <span>
                                                    [[booking.invoice.net_total - booking.invoice.payment_amount | currency]]
                                                </span>
                                            </div>

                                            <div ng-if="booking.invoice.refund">
                                                <span class="font-weight-bold">
                                                    Balance Refundable:
                                                </span>
                                                <span>
                                                    [[booking.invoice.refund | currency]]
                                                </span>
                                                 
                                            </div>
                                        </div>

                                        <div class="booking-total-cost">
                                            <span class="font-weight-bold"> Total Amount : </span><span>[[booking.invoice.net_total | currency]] </span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-4">
                                <div class="booking_information">
                                    <div class=" pt-2 px-2 detail">
                                        <div class="booking-channel">
                                            <span class="font-weight-bold"> Channel : </span><span>[[booking.channel]] </span>
                                        </div>
                                        <div class="checkin-date">
                                            <span class="font-weight-bold">Booking Date: </span><span>[[booking.BookingDate | date]]</span>
                                        </div> 

                                        <div class="checkin-date">
                                            <span class="font-weight-bold">Check-In: </span><span>[[checkInTime | date]]</span>
                                        </div>    
                                        <div class="checkout-date">
                                            <span class="font-weight-bold">Expected Check-Out on : </span><span>[[booking.BookingTo  |date]]</span>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                            <div class="col-md-4" ng-if="booking.invoice.net_total > booking.invoice.payment_amount && !booking.invoice.refund">
    							<div class="card-body border-top-primary">
    								<div class="text-center">
    									<h6 class="m-0 font-weight-semibold">Payment</h6>
    									<p class="text-muted mb-3">For online payment of due amount [[booking.invoice.net_total - booking.invoice.payment_amount | currency]] click below</p>
    			                    	<div class="cstStyle">			                    	
                                            <button type="button" ng-click="blinqPayment(booking.id, booking.invoice, 'Credit')" class="btn btn-success rounded-pill"><i class="icon-credit-card mr-2"></i> Pay via Card</button>
                                            <span>OR</span>
                                            <button type="button" ng-click="blinqPayment(booking.id, booking.invoice, 'Account')" class="btn btn-info rounded-pill"><i class="icon-coins mr-2"></i> Pay via Account</button>
                                        </div>
                                        {{-- <button type="button" ng-click="blinqPayment(booking.id, booking.invoice)"  class="btn btn-success rounded-pill"><i class="icon-credit-card mr-2"></i> Pay via Card</button> --}}
    								</div>
    							</div>
    						</div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="booking-rooms">
                        <div class="row m-0 py-2">
                                <div class="col-md-4" ng-repeat="room in booking.rooms">
                                    <div class="card border-left-3 border-left-warning">
                                        <div class="card-body bg-light">
                                            <div class="row py-1">
                                                <div class="col-md-12">
                                                    <div class="font-size-xs">Room: [[room.room_title]] (Room# [[room.RoomNumber]])</div>
                                                    <div class="font-size-xs">Charges: [[room.RoomCharges|currency]]</div>
                                                    <div class="font-size-xs">Category: [[room.RoomCategory]]</div>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>                              
                        </div>
                    </div>
                </div>
            </div>
            @endguest


            <div ng-hide="booking.status != 'CheckedIn'" id="complainFormBtns" class="card-body">
                <div class="row kt-services">
                    <div class="kt-kitchen kt col-md-4 text-white text-center pl-0" style="background-image: url(http://localhost:8000/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
                        <div class="card bg-success ">
                            <div class="card-body text-center">
                                <a ng-click="createComplain()" href="javascript:void(0)" class="text-white">
                                    <i class="fa fa-plus fa-2x border-3 rounded-round p-3 mb-3 mt-1 text-white"></i>
                                    <h5 class="card-title text-white">Complain</h5>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="kt-room kt col-md-4  text-white text-center" style="background-image: url(http://localhost:8000/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
                        <div class="card  bg-info">
                            <div class="card-body text-center"> 
                                <a ng-click="createRequest()" href="javascript:void(0)" class="text-white">
                                    <i class="fas fa-concierge-bell fa-2x border-3 rounded-round p-3 mb-3 mt-1 text-white"></i>
                                    <h5 class="card-title text-white">Request For Service</h5>
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="kt-room kt col-md-4  text-white text-center pr-0" style="background-image: url(http://localhost:8000/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
                       <div class="card  bg-indigo">
                            <div class="card-body text-center"> 
                                <a ng-click="showRequest_Complains()" href="javascript:void(0)" class="text-white">
                                     <i class="fas icon-clipboard3 fa-2x border-3 rounded-round p-3 mb-3 mt-1 text-white"></i>
                                     @auth
                                     <h5 class="card-title text-white">Requested Services & Complains</h5>
                                     @endauth

                                     @guest
                                    <h5 class="card-title text-white">My Requested Services & Complains</h5>
                                     @endguest
                                </a>
                            </div>
                       </div>
                    </div>


                </div>
            </div>

            <div ng-hide="booking.status != 'CheckedIn'" id="serviceFormBtns" class="card-body" style="display: none;">
                <div class="card-header p-0">
                    <h5 class="card-title">
                        Please select your department for service request.
                    </h5>
                </div>
                <div class="row kt-services">
                    @include('housekeeping.departments')
                </div>
                @guest
                <div class="row bck_btn_row" style="display: none;">
                    <div class="col-md-12 mt-3">
                        <span class="legitRipple p-0 bckbtn" ng-click="bckToMain()"> <i class="mi-keyboard-backspace mr-2 mi-2x"> </i>back</span>
                    </div>
                </div>
                @endguest
            </div>
        </div>
    </div>
    
</div>


<form action="https://ipg.blinq.pk/Payment/PaymentProcess.aspx" method="post" style="display:none" id="blinqPayment">
	<input type="hidden" name="client_id" id="client_id" value="ligqexD4gC2oCqR" />
	<input type="hidden" name="payment_via" id="payment_via" />
	<input type="hidden" name="order_id" id="order_id" />
	<input type="hidden" name="paymentcode" id="paymentcode" />
	<input type="hidden" name="encrypted_form_data" id="encrypted_form_data" />
	{{-- <input type="hidden" name="return_url" id="return_url" value="https://partners.ktownrooms.com/order-confirmation" /> --}}
	<input type="hidden" name="return_url" id="return_url"/>
	<button type="submit" id="blinqPay">Pay</button>
</form>

  