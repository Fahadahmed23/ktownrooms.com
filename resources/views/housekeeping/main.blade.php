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
}
</style>
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
            <div class="row">
                <div class="col-md-8">
                    <h5  class="card-title mb-0 customerName pl-0">[[greetMessage]], [[booking.customer.FirstName]] [[booking.customer.LastName]]</h5>
                </div>
            </div>
            <h6 class="card-subtitle mt-2 mb-0 text-dark">Thanks For Booking In Ktown Room </h6>

            <div class="card-body">
                <p class="card-text">Your Booking Details:</p>
                <ul style="list-style: none;padding: 0;">
                    <li> <b>Booking #</b>  <span>[[booking.booking_no]]</span></li>
                    <li> <b>Booking Date :</b>  <span>[[booking.BookingDate | date ]]</span></li>
                    <li> <b>Booking Status :</b>  <span ng-class="bookingStatus(booking.status)" class="badge" >[[booking.status]]</span></li>
                </ul>
            </div>

            @endguest


            <div id="complainFormBtns" class="card-body">
                <div class="row kt-services">
                    <div class="kt-kitchen kt col-md-4 text-white text-center" style="background-image: url(http://localhost:8000/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
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

                    <div class="kt-room kt col-md-4  text-white text-center" style="background-image: url(http://localhost:8000/global_assets/images/backgrounds/panel_bg.png); background-size: contain;">
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

            <div id="serviceFormBtns" class="card-body" style="display: none;">
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

  