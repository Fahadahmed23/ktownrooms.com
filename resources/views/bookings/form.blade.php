<style>
.scrolbx::-webkit-scrollbar-thumb {
      background: #9a9a9a;  
}
.scrolbx::-webkit-scrollbar {
    width: 3px;
}
.scrolbx::-webkit-scrollbar-thumb:hover {
    background: #c1c1c1;
}
.customerfindbtn{
    cursor: pointer;
}
.rooms-form-table td, .rooms-form-table th{
    padding: 5px !important;
}
.maping-status-list li {
    margin: 24px 0 0 0 !important;
    list-style: none;
}
.maping-status-list li i {
    font-size: 24px;
}
.maping-status-list li i:after {
    content: '';
    border-left: 2px dashed #ccc;;
    position: relative;
    left: -14px;
    top: 24px;
    font-size: 24px;
}
.maping-status-list li:first-child {
    margin-top: 0 !important;
}
.maping-status-list li:last-child i:after {
    display: none;
}
/* .title.px-2.border-bottom.bg-grey.py-1 {
    background: #8e8e8e;
} */

</style>
<div  class="bookingForm card reservation-information" style="display:none;">
    <div class="card-header bg-white header-elements-inline">
        <h6 class="card-title" ng-if="!nBooking.is_third_party"><i ng-click="formType=='create'?addRooms():hideSearch()" class="fa fa-angle-left mr-2"></i>Booking <span ng-if="formType=='edit'"> ([[nBooking.booking_no]]) </span><span ng-class="getStatusClass(nBooking.status)" class="badge ml-2"> [[nBooking.status]]</span></h6>
        <h6 class="card-title" ng-if="nBooking.is_third_party"><i ng-click="formType=='create'?addRooms():hideSearch()" class="fa fa-angle-left mr-2"></i>Booking <span ng-if="formType=='edit'"> ([[nBooking.booking_third_party.booking_no]]) </span><span ng-class="getStatusClass(nBooking.status)" class="badge ml-2"> [[nBooking.status]]</span></h6>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
                <a ng-show="lockdown" class="list-icons-item" data-action="reload" ng-click="editBooking(nBooking.id)"></a>
                <a class="list-icons-item" ng-click="user.is_frontdesk?loadFrontdesk():hideBookForm()"><i class="icon-cross2"></i></a>
            </div>
        </div>
    </div>

    <div class="card-body">

        {{-- <div class="card"> --}}
            <div ng-if="nBooking.is_third_party" class="pt-0 mx-2">
                <div class="card pt-0">
                    <div class="row m-0"> 
                        <div class="col-md-8">
                            <div class="row">
                                <div class="col-md-3">
                                    <div class="customer_information">
                                        <div class="title px-2 border-bottom bg-light py-1">
                                            <h6 class="mb-0"> <i class="icon-user mr-1"></i> Customer Information</h6>    
                                        </div>
                                        <div class="p-2 detail">
                                            <div class="customer-name">
                                                <span class="font-weight-bold">Name: </span><span>[[nBooking.booking_third_party.first_name]] [[nBooking.booking_third_party.last_name]]</span>
                                            </div>
                                            <div class="customer-phone">
                                                <span class="font-weight-bold">Phone: </span><span>[[nBooking.booking_third_party.phone]]</span>
                                            </div>    
                                            <div class="customer-email">
                                                <span class="font-weight-bold">Email: </span><span>[[nBooking.booking_third_party.email]]</span>
                                            </div>
                                        </div>
                                    </div> 
                                </div>
                                <div class="col-md-9">
                                    <div class="title px-2 border-bottom bg-light py-1">
                                        <h6 class="mb-0"> <i class="icon-calendar2 mr-1"></i> Third Party Booking Information</h6>    
                                    </div>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="booking_information">
                                                
                                                <div class="pt-2 px-2 detail">
                                                    <div class="booking-number">
                                                        <span class="font-weight-bold"> Booking #: </span><span>[[nBooking.booking_third_party.booking_no]]</span><span ng-class="getStatusClass(nBooking.status)" class="badge ml-2"> [[nBooking.status]]</span>
                                                    </div>
                
                                                    <div class="booking-hotel">
                                                        <span class="font-weight-bold"> Hotel : </span><span>[[nBooking.booking_third_party.hotel_name]] </span>
                                                    </div>

                                                    <div class="booking-city">
                                                        <span class="font-weight-bold"> City : </span><span>[[nBooking.booking_third_party.city]] </span>
                                                    </div>

                                                    <div class="booking-total-occupants">
                                                        <span class="font-weight-bold"> Total Occupants : </span><span>[[nBooking.booking_third_party.no_occupants]] </span>
                                                    </div>
                
                                                    <div class="booking-total-cost">
                                                        <span class="font-weight-bold"> Total Amount : </span><span>[[nBooking.booking_third_party.total_cost | currency]] </span>
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                        <div class="col-md-4">
                                            <div class="booking_information">
                                                <div class=" pt-2 px-2 detail">
                                                    <div class="booking-channel">
                                                        <span class="font-weight-bold"> Channel : </span><span>[[nBooking.channel]] </span>
                                                    </div>
                                                    <div class="checkin-date">
                                                        <span class="font-weight-bold">Booking Date: </span><span>[[nBooking.booking_third_party.booking_date | date]]</span>
                                                    </div> 
        
                                                    <div class="checkin-date">
                                                        <span class="font-weight-bold">Check-In: </span><span>[[nBooking.booking_third_party.booking_from | date]]</span>
                                                    </div>    
                                                    <div class="checkout-date">
                                                        <span class="font-weight-bold">Check-Out: </span><span>[[nBooking.booking_third_party.booking_to  |date]]</span>
                                                    </div>
                                                    <div class="payment-mode">	
                                                        <span class="font-weight-bold">Pay With: </span><span>[[nBooking.booking_third_party.payment_mode ]]</span>	
                                                    </div>	
                                                    <div class="payment-status">	
                                                        <span class="font-weight-bold">Payment Status: </span><span>[[nBooking.booking_third_party.payment_status ? 'PAID' : 'UNPAID']]</span>	
                                                    </div>
                                                </div>
                                            </div> 
                                        </div>
                                    </div>
                                   
                                </div>
                                <div class="col-md-12">
                                    <div class="title px-2 border-bottom bg-light py-1">
                                        <h6 class="mb-0"><i class="icon-city mr-1"></i> Rooms Information</h6>    
                                    </div>
        
                                    <div class="row m-0 py-2">
                                        <div class="col-md-4" ng-repeat="detail in nBooking.booking_third_party.details">
                                            <div class="card border-left-3 border-left-warning">
                                                <div class="card-body">
                                                    {{-- <div class="media">
                                                        <div class="mr-3 align-self-center">
                                                            <i class="icon-city icon-3x opacity-75"></i>
                                                        </div>
                                                        <div class="media-body text-right">
                                                            <span class="text-uppercase font-size-xs badge badge-warning text-white">[[detail.room_type_name?detail.room_type_name:'Room Deluxe']]</span>
                                                        </div>
                                                    </div> --}}
                                                    <div class="row py-1">
                                                        <div class="col-md-6">
                                                            <div class="font-size-xs">Occupants: [[detail.occupants]]</div>
                                                            <div class="font-size-xs">Charges: [[detail.selling_price | currency]] / Night</div>
                                                        </div>

                                                        <div class="col-md-6 text-right">
                                                            <span class="text-uppercase font-size-xs badge badge-warning text-white">[[detail.room_type_name?detail.room_type_name:'Room Deluxe']]</span>
                                                        </div>
                                                        
                                                    </div>
                                                </div>
                                            </div>
                                        </div>  
                                    </div>
        
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="title px-2 border-bottom bg-light py-1">
                                <h6 class="mb-0">Mapping Status</h6>    
                            </div>
                            <div class="maping-information maping-status-list">
                                    <ul class="pl-2 pt-2">
                                        <li class="my-1" ng-repeat="mapping_status in nBooking.booking_third_party.mapping_statuses">
                                            <i class="icon-[[mapping_status.status ? 'checkmark' : 'cancel']]-circle2 [[mapping_status.status ? 'text-success' : 'text-danger']]" ></i>
                                            [[mapping_status.booking_mapping_type]]
                                        </li>
                                    </ul>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        {{-- </div> --}}
        



        <div class="row p-2 d-none" ng-if="nBooking.is_third_party">
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-info-300 header-elements-inline">
                        <h5 class="card-title">Third Party Detail(s)</h5>
                        <div class="header-elements">
                            <div class="list-icons">

                                <span ng-if="formType=='create'">
                                <a class="list-icons-item rm-add" ng-click="addRooms()"><i class="icon-plus22 mr-2"></i>Rooms</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 scrolbx" style="height: 185px;overflow: auto;">
                        <div class="table-responsive">
                            <table class="table rooms-form-table">
                                <thead>
                                    <tr>
                                        <th>No of Rooms</th>
                                        <th>Selling Price </th>
                                        <th>Cost of Rooms</th>
                                        <th>Occupants</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="detail in nBooking.booking_third_party.details" >
                                       
                                        <td>[[detail.no_of_rooms]]</td>
                                        <td>[[detail.selling_price]]</td>
                                        <td>[[detail.cost_of_rooms]]</td>
                                        <td>[[detail.occupants]]</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
           


            <div  class="col-md-3">
                <div class="card">
                    <div class="card-header bg-info-300 header-elements-inline">
                        <h5 class="card-title">Mapping Status</h5>
                    </div>
                    <div class="card-body" style="height: 185px; overflow-y: scroll;">
                        <div class="input-group" >
                            <ul style="list-style: none">
                                <li ng-repeat="mapping_status in nBooking.booking_third_party.mapping_statuses">
                                    <span><i class="icon-[[mapping_status.status ? 'checkmark' : 'cancel']]-circle2"></i></span> [[mapping_status.booking_mapping_type]]</li>
                            </ul>
                            {{-- <label for="" class="col-md-12">[[mapping_status.status]] <span class="">[[mapping_status.booking_mapping_type]]</span></label> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row p-2">
            <div class="" ng-class="getRoomsClass()">
                <div class="card">
                    <div class="card-header bg-info-300 header-elements-inline">
                        <h5 class="card-title">Room(s)</h5>
                        <div class="header-elements">
                            <div class="list-icons">

                                <span ng-if="formType=='create'">
                                <a class="list-icons-item rm-add" ng-click="addRooms()"><i class="icon-plus22 mr-2"></i>Rooms</a>
                                </span>
                                <span ng-if="formType=='edit' && nBooking.is_third_party">
                                <a class="list-icons-item rm-add" ng-click="allocateRooms()"><i class="icon-plus22 mr-2"></i>Rooms</a>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 scrolbx" style="height: 185px;overflow: auto;">
                        <div class="table-responsive">
                            <table class="table rooms-form-table">
                                <thead>
                                    <tr>
                                        <th>Rooms</th>
                                        <th>Category</th>
                                        {{-- <th>Room Rate (exc tax)</th> --}}
                                        <th> Room Rate</th>
                                        <th>Occupants</th>
                                        <th>Additional Guest Charges</th>
                                        <th ng-show="formType=='create'">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr ng-repeat="nBook in nBooking.rooms" >
                                        <td>[[nBook.room_title]] (Room# [[nBook.RoomNumber]])
                                            <!-- popup -->
                                            <span data-popup="popover" title="[[nBook.room_title]] (Room# [[nBook.RoomNumber]])" data-trigger="hover" data-html="true"
                                            data-content="Allowed Occupants: [[nBook.hotel_room_category.allowed]]
                                            <br>Maximum Allowed Occupants: [[nBook.hotel_room_category.max_allowed]]
                                            <br>Additional Guest Rate: [[nBook.hotel_room_category.additional_guest_charges]]"
                                            data-original-title="Popover title"><i class="fa fa-info-circle"></i></span>                                   
                                        </td>
                                        <td>[[nBook.hotel_room_category.CategoryName]]</td>
                                        {{-- <td>[[nBook.RoomCharges | currency]]</td> --}}
                                        <td><input ng-disabled="formType=='edit' || nBook.is_third_party" ng-change="changeRoomCharges()" ng-model="nBook.room_charges_onbooking" class="form-control" data-type="currency" currency type="text"></td>
                                        <td>
                                            <div class="def-number-input number-input safari_only" style="width: 80px;">
                                                {{-- <button ng-show="formType=='create'" ng-disabled="lockdown" ng-click="decrementRoomOccupants(nBook)" class="minus p-2"></button> --}}
                                                <button ng-disabled="lockdown" ng-click="decrementRoomOccupants(nBook)" class="minus p-2"></button>
                                                <input ng-model="nBook.occupants" class="quantity form-control" min="1" type="number" disabled>
                                                <button ng-disabled="lockdown" ng-click="incrementRoomOccupants(nBook)" class="plus p-2"></button>
                                                {{-- <button ng-show="formType=='create'" ng-disabled="lockdown" ng-click="incrementRoomOccupants(nBook)" class="plus p-2"></button> --}}
                                            </div>
                                        </td>
                                        <td>[[nBook.hotel_room_category.additional_guest_charges | currency]]</td>
                                        <td><a ng-show="formType=='create'" href="javascript:void(0)" ng-click="deleteRoom(nBook)" ><i class="fa fa-close text-danger"></i></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div ng-if="required_occupants > 1" class=" col-md-3">
                <div class="card">
                    <div class="card-header bg-info-300 header-elements-inline">
                        <h5 class="card-title">Occupants</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <span>
                                <a class="list-icons-item rm-add" ng-click="showOccupantsModal()"><i class="icon-plus22 mr-2"></i>Add</a>
                                </span>   
                            </div>
                        </div>
                    </div>
                    <div class="card-body m-0 scrolbx" style="height: 185px; overflow-y: scroll;">
                        <ul id="mediaList" class="media-list" style="">
                            <div class="">
                                <!-- <span ng-if="nBooking.booking_occupants.length == 0"><a href="javascript:void(0)" ng-click="showOccupantsModal()" class="text-muted"> Please Add occupants</a></span> -->
                                <li ng-hide="nBooking.customer.CNIC && nOccupant.CNIC==nBooking.customer.CNIC && formType=='edit'" ng-repeat="nOccupant in nBooking.booking_occupants" class="media m-0 py-2" style="border-bottom: 1px solid #00000014;">
                                    <div class="media-body">
                                        <div class="media-title font-weight-semibold">[[nOccupant.FirstName]] [[nOccupant.LastName]]<span ng-if="nBooking.customer.CNIC && nOccupant.CNIC==nBooking.customer.CNIC" class="badge badge-info ml-2">primary</span></div>
                                        <div class="text-muted" ng-if="nOccupant.CNIC && nOccupant.CNIC.length > 0">CNIC# [[nOccupant.CNIC]]</div>
                                        <div class="text-muted" ng-if="nOccupant.Passport && nOccupant.Passport.length > 0">Passport# [[nOccupant.Passport]]</div>
                                    </div>
                                    
                                    <a ng-show="formType=='create'" href="" class="list-icons-item" ng-click="showOccupantsModalEdit(nOccupant, true);" title="Edit Occupant"><i class="icon-pencil6"></i></a>
                                    <a ng-show="formType=='create'" href="" class="list-icons-item px-3" data-popup="tooltip" title="" ng-click="removeOccupant(nOccupant);" data-trigger="hover" data-original-title="Remove"><i class="icon-cross2"></i></a>
                                </li>
                            </div>
                        
                        </ul>
                    </div>
                </div>
            </div>


            <div  class=" col-md-3">
                <div class="card">
                    <div class="card-header bg-info-300 header-elements-inline">
                        <h5 class="card-title">Stays</h5>
                        <div class="header-elements">
                            <div class="list-icons">
                                <a value="[[nBooking.booking_no || nBooking.status=='CheckedIn']]" ng-hide="nBooking.booking_no && nBooking.status=='CheckedIn'" class="list-icons-item rm-add" ng-click="showStayModal()"><i class="icon-pencil5 mr-2"></i></a>
                                
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" style="height: 185px; overflow-y: scroll;">
                        <div class="input-group">
                            <label for="" class="col-md-12">Night's: <span class="">[[nights]]</span></label>
                            
                        </div>

                        <div class="input-group">
                            <label for="" class="col-md-12">Check-In: <span class="">[[sdTemp | date]]</span></label>
                        </div>

                        <div class="input-group">
                            <label for="" class="col-md-12">Check-Out: <span class="">[[edTemp | date]]</span></label>
                        </div>
                    </div>
                    {{-- <div class="card-body mx-2 scrolbx" style="height: 185px; overflow-y: scroll;">
                        <ul id="mediaList" class="media-list" style="">
                            <div class="">
                                    <li class="media m-0 py-2" > 
                                    <div class="media-body mt-2">
                                        <div class="media-title font-weight-semibold d-flex">
                                            <label class="col-md-3">Night(s):</label>
                                            <div class="def-number-input number-input safari_only" style="margin-left: 12px; margin-top: -10px;">
                                                <button ng-click="decrementNights()" class="minus p-2"></button>
                                                <input readonly="" ng-model="nights" class="nights form-control ng-pristine ng-valid ng-valid-min ng-not-empty ng-touched" min="1" name="nights" type="number" aria-invalid="false" style="">
                                                <button ng-click="incrementNights()" class="plus p-2"></button>
                                            </div>
                                        </div>
                                        <div ng-hide="(nBooking.status=='Pending' || nBooking.status=='Confirmed') && formType=='edit'" class="media-title font-weight-semibold">Check-In : <span>[[nBooking.start_date | date]]</span></div>
                                        <div ng-show="(nBooking.status=='Pending' || nBooking.status=='Confirmed') && formType=='edit'" class="media-title font-weight-semibold">
                                            <label class="col-form-label col-md-3">Check-In :</label>
                                                <div class="input-group" style="border: 1px solid #eee;">
                                                    <input ng-change="changeCheckInDate()" type="text" name="start_date" placeholder="MM/DD/YYYY" ng-model="start_date" id="startdate" class="form-control pickadate" required>
                                                    <span class="" style=" margin: 0;border-left: 1px solid #eee;">
                                                        <span class="btn btn-info " style="padding: 0;"> check availibilty <i ng-click="checkRoomsAvailability" class="icon-redo2"></i>
                                                       
                                                        </span>
                                                    </span>
                                                </div>
                                        </div>
                                        <div class="media-title font-weight-semibold mt-2">
                                           <label class="col-md-3">Checkout:</label> 
                                            <div class="col-md-12">[[nBooking.end_date | date]]</div>
                                        </div>
                                    </div>
                                </li>
                            </div>
                        
                        </ul>   
                    </div> --}}
                </div>
            </div>
        </div>
        <div class="row p-2">
            <form id ="bookingForm" action="javascript:void(0)" class="donorform px-2 py-2" name="myForm" confirm-on-exit style="width: 100%">
                <div class="row">

                    <div class="col-md-3">
                        <div class="card p-3 customerinfofieldset">
                            <fieldset class="">
                                @include('layouts.form_messages')
                                <legend class="font-weight-semibold"> <i class="icon-vcard mr-2"></i> Customer Information</legend>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">First Name <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input aria-invalid="true" required type="text" ng-model="nBooking.customer.FirstName" name="FirstName" placeholder="Enter First Name" value="" class="form-control alphabets" maxlength="20" >
                                        <div ng-messages="myForm.FirstName.$error" ng-if="myForm.FirstName.$touched || myForm.$submitted">
                                            <div class="text-danger" ng-message="required">First Name is required</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">         
                                    <label class="col-md-4 col-form-label">Last Name <span class="text-danger" ng-if="nBooking.status == 'CheckedIn'">*</span></label>
                                    <div class="col-md-8">
                                        <input aria-invalid="true" ng-required="nBooking.status == 'CheckedIn'" type="text" ng-model="nBooking.customer.LastName" name="LastName" placeholder="Enter Last Name" value="" class="form-control alphabets" maxlength="20">
                                        <div ng-messages="myForm.LastName.$error" ng-if="myForm.LastName.$touched || myForm.$submitted">
                                            <div class="text-danger" ng-message="required">Last Name is required</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">  
                                    <label class="col-md-4 col-form-label">Email <span class="text-danger" ng-if="nBooking.status == 'CheckedIn'">*</span></label>
                                    <div class="col-md-8">

                                        <div class="input-group" style="">
                                            {{-- <input ng-change="checkCustAvl('e')" ng-required="nBooking.status == 'CheckedIn'" type="email" ng-model="nBooking.customer.Email" name="Email" placeholder="Email" value="" class="form-control email_mask" maxlength="50" style="background: none;"> --}}
                                            <input ng-required="nBooking.status == 'CheckedIn'" type="email" ng-model="nBooking.customer.Email" name="Email" placeholder="Email" value="" class="form-control email_mask" maxlength="50" style="background: none;">                                           
                                            <span class="" style="margin: 0;">
                                                <span ng-click="checkCustAvl('e')" class="customerfindbtn btn " style="padding: 0; background:#eee;" data-placement="top" data-popup="popover" title="Find Customer by Email" data-trigger="hover" data-html="true"
                                                data-content="Please enter valid email address & click on the search icon." data-original-title="Popover title"><i class="icon-search4"></i>
                                                </span>
                                            </span>
                                        </div>

                                        {{-- <input ng-change="checkCustAvl('e')" ng-required="nBooking.status == 'CheckedIn'" type="email" ng-model="nBooking.customer.Email" name="Email" placeholder="Email" value="" class="form-control email_mask" maxlength="50"> --}}
                                        <div ng-messages="myForm.Email.$error" ng-if="myForm.Email.$touched || myForm.$submitted">
                                            <div class="text-danger" ng-message="required">Email is required</div>
                                            <div class="text-danger" ng-message="email">Please enter a valid email address</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">Phone <span class="text-danger">*</span></label>
                                    <div class="col-md-8">
                                        <input aria-invalid="true" required type="tel" ng-model="nBooking.customer.Phone" name="Phone"  value="" id="phone_int" class="form-control phone_int">
                                        <div ng-messages="myForm.Phone.$error" ng-if="myForm.Phone.$touched || myForm.$submitted">
                                                <div class="text-danger" ng-message="required">Phone is required</div>
                                                {{-- <div class="text-danger" ng-message="pattern">Please enter Phone in correct format (e.g., 0323-8228708)</div> --}}
                                        </div>
                                    </div>
                                     <!--hidden feild for country abr-->
                                     <input  type="hidden" value="" ng-model="nBooking.customer.iso">
                                     <!--hidden feild for country abr-->
                                </div>

                                <div class="form-group row">
                                    <label class="col-md-4 col-form-label">[[nBooking.customer.is_cnic == '0'?'Passport':'Cnic']] # <span class="text-danger" ng-if="nBooking.status == 'CheckedIn'">*</span></label>
                                    <div class="col-md-8">
                                        <div class="input-group" style="">
                                            {{-- <input ng-change="checkCustAvl('c')" aria-invalid="true" pattern="[\d]{5}-[\d]{7}-[\d]{1}" ng-required="nBooking.status == 'CheckedIn'" type="text" ng-model="nBooking.customer.CNIC" name="CNIC" placeholder="42101-099099-152" value="" class="form-control cnic" > --}}
                                            <input aria-invalid="true" ng-pattern="cnicPattern(nBooking.customer.is_cnic)" ng-class="getcustomer(nBooking.customer.is_cnic)" ng-required="nBooking.status == 'CheckedIn'" type="text" ng-model="nBooking.customer.CNIC" name="CNIC" placeholder="[[nBooking.customer.is_cnic == '0'?'PK123456789':'42201-6562366-3']]" value="" class="form-control" style="background:none;">
                                            <span class="" style=" margin: 0">
                                                <span ng-click="checkCustAvl('c')" class="customerfindbtn btn" style="padding: 0; background:#eee;" data-placement="top" data-popup="popover" title="Find Customer by CNIC" data-trigger="hover" data-html="true"
                                                data-content="Please enter valid cnic & click on the search icon." data-original-title="Popover title"><i class="icon-search4"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <div ng-messages="myForm.CNIC.$error" ng-if="myForm.CNIC.$touched || myForm.$submitted">
                                            <div class="text-danger" ng-message="required">[[nBooking.customer.is_cnic == '0'?'Passport':'Cnic']] # is required</div>
                                            <div class="text-danger" ng-message="pattern">Please enter [[nBooking.customer.is_cnic == '0'?'Passport':'Cnic']] in correct format (e.g., [[nBooking.customer.is_cnic == '0'?'PK123456789':'42201-6562366-3']])</div>
                                        </div>
                                    </div>
                                
                                    <!--IsForeigner check-->
                                    <div class="col-md-12 mt-1">
                                        <md-switch ng-model="nBooking.customer.is_cnic" ng-true-value="1" ng-false-value="0" style="display:block;float:right">
                                        Is Cnic?</md-switch>
                                    </div>

                                    <!--Nationality fields-->
                                    <label class="col-md-4 col-form-label">Nationality</label>
                                    <div class="col-md-8">
                                        <md-select name="nationality" md-no-asterisk required class="m-0" ng-model="nBooking.customer.nationality" placeholder="Pakistani ">
                                            <md-option ng-repeat="nationality in nationalities" ng-value="nationality">[[nationality]]</md-option>
                                        </md-select>
                                        {{-- <input aria-invalid="true" type="text" ng-model="nBooking.customer.nationality" name="nationality" placeholder="Pakistani" maxlength="50" value="" class="form-control alphabets"> --}}
                                    </div>
                                </div>
                            
                            </fieldset>
                        </div>
                        @include('bookings.customer_card')
                    </div>

                    <div class="col-md-7">
                        <div class="card p-3">
                            <fieldset>
                                <legend class="font-weight-semibold"> <i class="icon-price-tag2 mr-2"></i> Booking Information</legend>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Status <span class="text-danger">*</span></label>
                                            <div class="col-md-8">
                                                <md-select ng-change="calculateTotalAmount()" name="booking_status" md-no-asterisk required class="m-0" ng-model="nBooking.status" placeholder=" " ng-disabled="status_disabled && toStatus!='inTransition'">
                                                    <md-option ng-repeat="status in statuses" ng-value="status">[[status]]</md-option>
                                                </md-select>
                                                <div ng-messages="myForm.booking_status.$error" ng-if="myForm.booking_status.$touched || myForm.$submitted">
                                                    <div class="text-danger" ng-message="required">Status is required</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row" ng-hide="nBooking.is_cental_booking">           
                                            <label class="col-md-4 col-form-label">Channel </label>
                                            <div class="col-md-8">
                                                <md-select ng-change="getBookingChannel(nBooking.channel)"  name="booking_channel" md-no-asterisk ng-required class="m-0" ng-model="nBooking.channel" placeholder=" " >
                                                    <md-option ng-repeat="channel in channels" ng-value="channel.Channel">[[channel.Channel]]</md-option>
                                                </md-select>
                                                <div ng-messages="myForm.booking_channel.$error" ng-if="myForm.booking_channel.$touched || myForm.$submitted">
                                                    <div class="text-danger" ng-message="required">Channel is required</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div ng-if="additionalInfo" class="form-group row m-0 pb-2">          
                                            <legend class="font-weight-semibold  col-md-12  p-2 mb-1"> <i class="icon-vcard mr-2"></i> Agent Information</legend> 
                                            <label class="col-md-4 col-form-label">Agent Name</label>
                                            <div class="col-md-8">
                                                <input aria-invalid="true" required type="text" ng-model="nBooking.agent.name" name="name" placeholder="Enter Name" value="" class="form-control alphabets" maxlength="20" >
                                                <div ng-messages="myForm.name.$error" ng-if="myForm.name.$touched || myForm.$submitted">
                                                    <div class="text-danger" ng-message="required">Agent Name is required</div>
                                                </div>
                                            </div>

                                            <label class="col-md-4 col-form-label">Agent Phone</label>
                                            <div class="col-md-8">
                                                <input aria-invalid="true" required type="text" ng-model="nBooking.agent.phone" name="name" placeholder="03363231562" value="" class="form-control phone_us">
                                                <div ng-messages="myForm.name.$error" ng-if="myForm.name.$touched || myForm.$submitted">
                                                    <div class="text-danger" ng-message="required">Phone no. is required</div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row"> 
                                            <label class="col-md-4 col-form-label">Corporate Booking</label>
                                                <div class="col-md-1 mt-1">
                                                    <md-switch ng-model="nBooking.invoice.is_corporate" ng-true-value="1" ng-false-value="0" style="display:block"></md-switch>
                                                </div>
                                            <label class="col-md-2 col-form-label text-right" ng-show="nBooking.invoice.is_corporate == '1'">Client Name </label>
                                            <div class="col-lg-5" ng-show="nBooking.invoice.is_corporate == '1'">
                                                <input ng-disabled="formType=='edit' && nBooking.invoice.corporate_client_id" class="form-control alphabets" name="corporate_client" ng-required="nBooking.invoice.is_corporate=='1'" ng-model="nBooking.invoice.corporate_client_name">
                                                <!-- <md-select name="corporate_client" md-no-asterisk ng-required="nBooking.invoice.is_corporate=='1'" class="m-0" ng-model="nBooking.invoice.corporate_client_id" placeholder=" " >
                                                    <md-option ng-repeat="client in clients" ng-value="client.id">[[client.FullName]]</md-option>
                                                </md-select> -->
                                                <div ng-messages="myForm.corporate_client.$error">
                                                    <div class="text-danger" ng-message="required">Please enter Client Name</div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Purpose of stay:</label>
                                            <div class="col-lg-8">
                                                <input ng-model="nBooking.purpose_of_stay" type="text" name="" placeholder="Touring" value="" class="form-control alphabets" maxlength="100">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Special Request:</label>
                                            <div class="col-lg-8">
                                                <input ng-model="nBooking.special_request" type="text" name="" placeholder="Special Request" value="" class="form-control alphabets" maxlength="100">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Origin</label>
                                            <div class="col-lg-8">
                                                <input ng-model="nBooking.origin" type="text" name="" placeholder="Origin" value="" class="form-control alphabets" maxlength="100">
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Additional Comments</label>
                                            <div class="col-lg-8">
                                                <textarea class="form-control" name="additional_comments" ng-model="nBooking.additional_comments" placeholder="Any additional comments"></textarea>
                                            </div>
                                        </div>



                                    </div> 

                                    <div class="col-md-6">
                                        <div class="form-group row">
                                            <label class="col-md-4 col-form-label">Discount Type</label>
                                            <div class="col-md-8 mt-2">
                                                <md-radio-group ng-model="nBooking.invoice.per_night" ng-change="calculateTotalAmount()" type="text" layout="row" ng-disabled="discount_disabled">
                                                    <md-radio-button class="pernight_discount"  ng-value="1" aria-label="Per Night" ng-true-value="1" ng-false-value="0" data-placement="top" data-popup="popover" title="Per Night Discount" data-trigger="hover" data-html="true"
                                                    data-content="Apply Per Night Discount" data-original-title="Popover title">
                                                        Per Night
                                                    </md-radio-button>
                                                    <md-radio-button  class="flat_discount"  ng-value="0" aria-label="Flat" ng-true-value="1" ng-false-value="0" data-placement="top" data-popup="popover" title="Flat Discount" data-trigger="hover" data-html="true"
                                                    data-content="Apply Flat Discount" data-original-title="Popover title">
                                                        Flat
                                                    </md-radio-button>
                                                </md-radio-group>
                                            </div>
                                            {{-- <div class="col-md-5" ng-show="nBooking.invoice.per_night == 1">
                                                <input ng-change="calculateTotalAmount()" ng-disabled="discount_disabled" data-type="currency" length="5" currency  ng-model="nBooking.invoice.discount_per_night" type="text" name="" placeholder="24,500.00" Value="PKR 20,000" class="form-control">
                                            </div> --}}

                                        </div>

                                        <div class="form-group row">
                                            <label class="col-lg-4 col-form-label">Discount:</label>
                                            <div class="col-lg-8">
                                                <input id="discount_amount" ng-disabled="discount_disabled||lockdown" ng-class="getDiscountClass(nBooking.invoice.discount_amount)" ng-change="calculateTotalAmount()" data-type="currency" length="5" currency ng-model="discount_amount" type="text" name="" placeholder="1,000" value="" class="form-control">
                                            
                                                <span ng-show="nBooking.discount_request.status=='Approved'||nBooking.discount_request.status=='Declined'" class="badge badge-[[nBooking.discount_request.status=='Approved'?'success':'danger']]" id="#danger" style="position: absolute; top: 5px; right: 0;" data-popup="popover" data-trigger="hover" data-html="true"
                                                    data-content="[[nBooking.discount_request.status]] By: [[nBooking.discount_request.supervisor.name]]">[[nBooking.discount_request.status]]</span>
                                            
                                                    <span ng-show="nBooking.discount_request.status=='Pending'" class="badge badge-primary" id="#danger" style="position: absolute; top: 5px; right: 0;">[[nBooking.discount_request.status]]</span>
                                                
                                                <div class="text-info" ng-show="nBooking.invoice.per_night == 1"><span>Your Total Discount for [[nights]] night's ([[discount_amount | currency]] x [[nights]] ) </span>: <span> <b id="perNight_discount"> [[nBooking.invoice.discount_amount |currency ]]</b></span></div>
                                                
                                                <div class="text-danger" ng-show="nBooking.invoice.discount_amount > user_discount_limit">Discount exceeds allowed limit ([[user_discount_limit | currency]])</div>
                                            </div>
                                        </div>

                                        <div class="form-group row" ng-show="discount_amount>0">
                                            <label class="col-lg-4 col-form-label">Reason of discount:</label>
                                            <div class="col-lg-8">
                                                <textarea ng-required="discount_amount>0" type="text" name="discount_reason" class="form-control" ng-model="nBooking.discount_reason"></textarea>
                                                <div ng-messages="myForm.discount_reason.$error" ng-if="myForm.discount_reason.$touched || myForm.$submitted">
                                                    <div class="text-danger" ng-message="required">Discount Reason is required</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row">    
                                            <label class="col-md-4 col-form-label">Sub Total:</label>
                                            <div class="col-md-8">
                                                <input length="5" ng-value="nBooking.invoice.total - nBooking.invoice.discount_amount" type="text" readonly name="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div ng-show="nBooking.invoice.early_checkin_charges > 0" class="form-group row">    
                                            <label class="col-md-4 col-form-label">Early Check-In Charges:</label>
                                            <div class="col-md-8">
                                                <input length="5" ng-value="nBooking.invoice.early_checkin_charges" type="text" readonly name="" placeholder="" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row" ng-if="nBooking.tax_rate_id > 0">
                                            <label class="col-md-4 col-form-label">Tax: ([[nBooking.tax_rate.Tax]] [[nBooking.tax_rate.TaxValue]] %)</label> 
                                            <div class="col-md-8">
                                                <input readonly data-type="currency" length="5" currency type="text" ng-model="nBooking.invoice.tax_charges" placeholder="Tax" class="form-control">
                                            </div>
                                        </div>

                                        <div class="form-group row d-none">
                                            <div class="col-md-12">
                                                <div class="row">
                                                    <div class="col-lg-6">
                                                        <label class="col-form-label">Discount Type
                                                        </label>
                                                        <md-radio-group ng-model="nBooking.invoice.per_night" ng-change="calculateTotalAmount()" type="text" layout="row" ng-disabled="discount_disabled">
                                                            <md-radio-button ng-value="1" aria-label="Per Night" ng-true-value="1" ng-false-value="0">
                                                                Per Night
                                                            </md-radio-button>
                                                            <md-radio-button ng-value="0" aria-label="Flat" ng-true-value="1" ng-false-value="0">
                                                                Flat
                                                            </md-radio-button>
                                                        </md-radio-group>
                                                    </div>
                                                </div>
                                                <div class="row mt-3" ng-show="nBooking.invoice.per_night == 1">
                                                        <label class="col-lg-3 col-form-label">Discount Per Night</label>
                                                        <div class="col-lg-9">
                                                            <input ng-change="calculateTotalAmount()" ng-disabled="discount_disabled" data-type="currency" length="5" currency  ng-model="nBooking.invoice.discount_per_night" type="text" name="" placeholder="24,500.00" Value="PKR 20,000" class="form-control">
                                                        </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group row mt-2">
                                            <label class="col-md-4 col-form-label">Total Amount:</label>
                                            <div class="col-md-8">
                                                <input data-type="currency" length="5" currency  ng-model="nBooking.invoice.net_total" readonly type="text" name="" placeholder="24,500.00" Value="PKR 20,000" class="form-control">
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </fieldset>
                        </div>
                    </div>

                    <div class="col-md-2">
                        <div class="card p-3">
                             <fieldset class="">
                                <legend class="font-weight-semibold"> <i class="icon-cash4 mr-2"></i> Payment Information</legend>
                                <div class="form-group row" ng-hide="formType=='edit'"> 
                                    <label class="col-md-8 col-form-label">Add Payment</label>
                                    <div class="col-md-2 mt-1">
                                        <md-switch ng-disabled="formType=='edit'" ng-model="is_partial" ng-change="changePartialPayment(is_partial)" ng-true-value="1" ng-false-value="0" style="display:block"></md-switch>
                                    </div>
                                </div>
                                <div ng-show="is_partial == '1' && formType != 'edit'">
                                    @include('bookings.partial_payment_form')
                                </div>
                                <div ng-show="formType=='edit'">
                                    <div class="form-group row">
                                        <label class="col-lg-12 col-form-label">Amount Paid: [[nBooking.invoice.payment_amount | currency]]</label>
                                    </div>
                                </div>
                            </fieldset>
                        </div>    

                        <div class="card zig-zag-top card-collapsed" style="background: #f5f5f5 !important;border: none;box-shadow: 0 0;">
                            <div class="card-header bg-white header-elements-inline" style="background: #f5f5f5 !important;">
                                <h6 class="card-title"><i class="icon-clipboard3 mr-2"></i>Invoice Detail</h6>
                                <div class="header-elements pt-0">
                                    <div class="list-icons">
                                        <a class="list-icons-item" data-action="collapse"></a>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body" style="display:none;">
                                @include('bookings.minimal_receipt')
                            </div>
                        </div>

                                <!-- <div class="form-group row">
                                    <label class="col-lg-4 col-form-label">Status</label>
                                    <div class="col-md-5">
                                        <md-radio-group ng-model="nBooking.invoice.paid" type="text" layout="row" ng-disabled="paid_disabled || nBooking.status=='Cancelled' || (lockdown && nBooking.status != 'CheckedIn')">
                                            <md-radio-button ng-value="1" aria-label="Paid">
                                                Paid
                                            </md-radio-button>
                                            <md-radio-button ng-value="0" aria-label="Unpaid" >
                                                Unpaid
                                            </md-radio-button>
                                        </md-radio-group>
                                    </div>
                                        
                                </div>
                                <div class="form-group row" ng-show="nBooking.invoice.paid==1">
                                        <label class="col-lg-4 col-form-label">Payment Type</label>
                                        <div class="col-lg-8">
                                        <md-select ng-disabled="paid_disabled" class="m-0" ng-model="nBooking.payTyp" placeholder="Cash">
                                            <md-option ng-repeat="paymenttype in paymenttypes" ng-value="paymenttype">[[paymenttype.PaymentMode]]</md-option>
                                        </md-select>
                                        </div>
                                </div>
        
                                <div class="form-group row" ng-if="nBooking.invoice.paid==1 && nBooking.payTyp.id==2">
                                    <div class="col-lg-12 chequerow">
                                        <div class="row">
                                            <label class="col-lg-4 col-form-label">Cheque Number <span class="text-danger">*</span></label>
                                            <div class="col-lg-8">
                                                <input aria-invalid="true" ng-required="nBooking.payTyp.id==2" type="text" ng-model="nBooking.cheque_no" name="chequeno" placeholder="93222257" value="" class="form-control cheque" maxlength="8">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                            
                    </div>
                </div>
    
                <div class="text-right">
                    <button type="button" ng-click="user.is_frontdesk?loadFrontdesk():hideBookForm()" class="btn btn-outline-danger bkng-cncl"><i class="icon-close2 mr-1"></i> Close</button>
                    <button class="btn btn-info" ng-show="can_extend" ng-click="adminExtend()"><i class="icon-calendar mr-1"></i> Booking Extend</button>
                    <button ng-show="formType!='create'" type="button" ng-click="viewPOS(nBooking)" class="btn btn-warning"><i class="icon-clipboard3  mr-1"></i>POS Receipt</button> 
                    <button ng-disabled="lockdown" ng-hide="can_checkout" type="button" ng-click="showInvoice(nBooking)" class="btn btn-primary bkng-cnfrm"><i class="icon-paperplane mr-1"></i> [[nBooking.status=='Cancelled'?'Cancel':'Book']]</button>
                    <button ng-if="can_checkout" type="button" ng-click="viewPOS(nBooking, 'checkout')" class="btn btn-primary bkng-cnfrm"><i class="icon-paperplane mr-1"></i> CheckOut</button>
                </div>
            </form>
        </div>
    </div>
</div>
@include('bookings.pos_booking_modal')
