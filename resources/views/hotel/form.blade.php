<style>
/* category box */
.categorycounter button {
    /* background: #00bcd4; */
    float: left;
    width: 15%;
    padding: 0 0px !important;
    color: #fff;
}
.categorycounter input {
   /* width: 50%;*/
    width: 70%;
    float: left;
    height: 22px;
    text-align: center;
}

.addi_charges input{
    margin-top: 5px;
    padding: 5px;
    /*width: 80%;*/
    width:100%;
    height: 25px;
    border: 1px solid rgb(158 158 158) !important
}


/* Chrome, Safari, Edge, Opera */
.categorycounter input::-webkit-outer-spin-button,
.categorycounter input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
.categorycounter input[type=number] {
  -moz-appearance: textfield;
}


/* category box */

   img#preview {
    width: 100%;
    height: auto;
    border: 1px solid #a6a7a8;
    border-radius: 0;
    }
    .wrapper.prof-wrap .custom-file{
        height: 100%;
    }
    .wrapper.prof-wrap .custom-file .logo{
        height: 100%;
    }
.hotelroomcategorysec{
    height: 276px;
    overflow-y: auto;
}

.hotelroomcategorysec::-webkit-scrollbar {
  width: 0px;
}

.hotelroomcategorysec::-webkit-scrollbar-track {
  background: #dddddd;
}

.hotelroomcategorysec::-webkit-scrollbar-thumb {
    background-color: #757575;
    border-radius: 20px;
    border: 3px solid #757575;
}
.gl-info-sec {
    border: 1px dashed #66bb6a59;
}
.hotel-gl-list li {
    list-style: none;
}
/* li.aheads {
    padding: 15px 0;
    margin: 0px 0;
    border-bottom:  1px dashed #eee;
} */
.hotel-gl-list {
    max-height: 200px;
    overflow: auto;
}
.lvl-1 {
    border-top: 1px dashed #66bb6a;
    margin-top: 10px;
    padding-top: 10px;
}
.lvl-1:first-child {
    border: none;
    padding: 0;
    margin: 0;
}
</style>
<div id="addNewHotel" class="card" style="display: none">
    <div class="card-header bg-white header-elements-inline">
		<h5 class="card-title" style="text-transform:capitalize;">[[hotel.id?'Update':'Add New']] Hotel</h5>
		<div class="header-elements">
			<div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
				<a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
			</div>
		</div>
	</div>


    <div ng-if="formType == 'edit'" class="p-2">
        <div class="row">
            <div  class="col-md-4 ">
                <a href="http://localhost:8000/nrooms" target="_blank">
                    <div class="card card-body bg-blue-400 has-bg-image" style="min-height: 95px;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">[[hotel.RoomCount]]</h3>
                                <span class="text-uppercase font-size-xs">Total Rooms</span>
                            </div>
            
                            <div class="ml-3 align-self-center">
                                <i class="icon-city icon-3x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        
             <div class="col-md-4">
                 <a href="http://localhost:8000/bookings" target="_blank">
                    <div class="card card-body bg-success-400 has-bg-image" style="min-height: 95px;">
                        <div class="media">
                            <div class="media-body">
                                <h3 class="mb-0">[[hotel.BookingCount]]</h3>
                                <span class="text-uppercase font-size-xs">Total Bookings</span>
                            </div>
            
                            <div class="ml-3 align-self-center">
                                <i class="far fa-calendar-check fa-4x opacity-75"></i>
                            </div>
                        </div>
                    </div>
                 </a>
            </div>
    
    
            <div class="col-md-4">
                   <div class="card card-body bg-indigo-400 has-bg-image" style="min-height: 95px;">
                       <div class="media">
                           <div class="media-body">
                               <h3 class="mb-0">[[hotel.BookingRevenueSum |currency ]]</h3>
                               <span class="text-uppercase font-size-xs">Total Revenue</span>
                           </div>
           
                           <div class="ml-3 align-self-center">
                            <i class="far fa-money-bill-alt fa-4x opacity-75"></i>
                           </div>
                       </div>
                   </div>
           </div>
        </div>
    </div>


        @include('layouts.form_messages')
        <ul class="nav nav-tabs nav-tabs-bottom flex-nowrap mb-0 hotel-navs-tabs">

            @permission('can-add-hotel')
                <li class="nav-item active show"><a id="basic-info-btn" href="#basic_info" class="nav-link active show" data-toggle="tab"><i class="icon-stack-check mr-2 text-success"></i>Basic Info</a></li>
            @endpermission

            @permission('can-add-update-hotel-room-categories')
                <li ng-if="hotel_id" class="nav-item"><a id="categories-btn" ng-click="addHotelRoomCategories()" href="#hotel_room_categories" class="nav-link" data-toggle="tab"><i class="icon-crown mr-2 text-warning"></i>Hotel Room Categories</a></li>
            @endpermission


            @permission('can-add-update-hotel-contacts')
                <li ng-if="hotel_id"class="nav-item"><a id="contact-info-btn"  ng-click="showHotelContacts()" href="#hotel_contacts" class="nav-link" data-toggle="tab"><i class="icon-collaboration mr-2 text-pink"></i>Hotel Contacts</a></li>
            @endpermission


            @permission('can-add-update-hotel-accounts-mapping')
                <li ng-if="hotel_id" class="nav-item"><a id="account-info-btn" ng-click="getGlAccounts()"  href="#account_info" class="nav-link" data-toggle="tab"><i class="icon-wallet mr-2 text-teal"></i>Account Info</a></li>
            @endpermission


            @permission('can-add-update-hotel-checkin-checkout-rules')
                <li ng-if="hotel_id" class="nav-item"><a id="cin-cout-btn" ng-click="setDefaultRules()" href="#check_in_check_out_rules" class="nav-link " data-toggle="tab"><i class="icon-watch mr-2 text-info"></i>Checkin CheckOut Rules</a></li>
            @endpermission

            @permission('can-add-update-hotel-sms-configuration')
                <li ng-if="hotel_id" class="nav-item"><a id="default-msg-btn"  ng-click="getSmsConfiguration()" href="#default_msgs" class="nav-link " data-toggle="tab"><i class="icon-envelop4 mr-2 text-warning"></i>Sms Configuration</a></li>
            @endpermission


        </ul>
        <div class="tab-content hotel-tabs">
            @permission('can-add-hotel')
                <div class="tab-pane fade show active" id="basic_info">
                    @include('hotel.basic_info')
                </div>
            @endpermission

            @permission('can-add-update-hotel-room-categories')

                <div class="tab-pane fade" id="hotel_room_categories">
                    @include('hotel.hotel_room_categories')
                </div>
            @endpermission

            @permission('can-add-update-hotel-contacts')

                <div class="tab-pane fade" id="hotel_contacts">
                    @include('hotel.hotel_contacts')
                </div>
            @endpermission

            @permission('can-add-update-hotel-accounts-mapping')
                <div class="tab-pane fade" id="account_info">
                    @include('hotel.account_info')
                </div>
            @endpermission

            @permission('can-add-update-hotel-checkin-checkout-rules')
                <div class="tab-pane fade" id="check_in_check_out_rules">
                    @include('hotel.cin_cout')
                </div>
            @endpermission


            @permission('can-add-update-hotel-sms-configuration')
                <div class="tab-pane fade" id="default_msgs">
                    @include('hotel.sms_configuration')
                </div>
            @endpermission
           
        </div>
   
</div>

<script>
    


    
// $(".pickadate").pickadate({
//     min: true
//         });

        $.extend($.fn.pickadate.defaults, {
            // min:true,
            // formatSubmit: 'yyyy-mm-dd',
            format: 'mm/dd/yyyy',
            // hiddenName: true,
            // hiddenSuffix: '_submit',
        })
</script>

