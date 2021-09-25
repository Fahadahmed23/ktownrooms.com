<div class="card mt-3">
    <div class="card-header header-elements-inline">
        <h5 class="card-title">Hotel Check In Rule</h5>
        <div class="header-elements">
            <div class="list-icons">
                <a class="list-icons-item" data-action="collapse"></a>
            </div>
        </div>
    </div>
    {{-- <div class="form-group scrollbar">
        <div style="" class="card-body hotelroomcategorysec">
            <div class="row">
                <div ng-repeat="room_category in room_categories" class="col-md-6 ">
                    <div class="card">
                        <div class="card-header px-1">
                            <span class="card-title"> 
                                <div class="toggle-checkbox-div-all">
                                    <md-switch ng-change="hotelRoomCategory(room_category)" ng-model="hotel.hotelroomcategories[room_category.id].status" ng-true-value="1" ng-false-value="0" style="display:block" >
                                        <span class="">[[room_category.RoomCategory]]</span>
                                    </md-switch>
                                </div>
                            </span>
                        </div>
                        <div class="card-body py-0" style="padding: 0 10px !important;">
                            <div class="row pt-0">
                                <div class="col-md-6"><span class="">Occupants:</span> <div class="categorycounter"><button ng-click="decrementAllowedOccupants(room_category)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button><input readonly ng-model="hotel.hotelroomcategories[room_category.id].allowed" ng-value="hotel.hotelroomcategories[room_category.id].allowed?hotel.hotelroomcategories[room_category.id].allowed:room_category.AllowedOccupants" class="quantity form-control num2" min="1" name="AllowedOccupants" type="number" aria-invalid="false" style=""><button ng-click="incrementAllowedOccupants(room_category)" type="button" class="btn btn-sm  btn-primary"><i class="fa fa-plus"></i></button> </div></div>
                                <div class="col-md-6"><span class="">Max Occupants:</span> <div class="categorycounter"><button ng-click="decrementMaxAllowedOccupants(room_category)" type="button" class="btn btn-sm  btn-danger"><i class="fa fa-minus"></i></button> <input  readonly ng-model="hotel.hotelroomcategories[room_category.id].max_allowed" ng-value="hotel.hotelroomcategories[room_category.id].max_allowed?hotel.hotelroomcategories[room_category.id].max_allowed:room_category.MaxAllowedOccupants" class="quantity form-control num2" min="1" name="MaxAllowedOccupants" type="number" aria-invalid="false" style=""><button ng-click="incrementMaxAllowedOccupants(room_category)" type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button></div></div>

                                    <div class="col-md-6 py-2">
                                        <span style="display: inline-block; padding-top:12px;">Add. Guest Charges:</span>
                                    </div>
                                    <div class="col-md-6 pt-2 addi_charges">
                                        <span style="font-weight: 800">
                                        <!-- <ng-form name="subform[[$index]]"> -->
                                            <!-- <input ng-required="checkRequired(hotel.hotelroomcategories[room_category.id].status)" maxlength="5"  ng-model="hotel.hotelroomcategories[room_category.id].additional_guest_charges" ng-value="hotel.hotelroomcategories[room_category.id]?hotel.hotelroomcategories[room_category.id].additional_guest_charges:room_category.AdditionalGuestCharges" data-type="currency" currency type="text" class="form-control" name="AdditionalGuestCharges">
                                            <div ng-messages="subform[[$index]].AdditionalGuestCharges.$error" ng-if='hotelForm.AdditionalGuestCharges.$touched || hotelForm.$submitted || subform[[$index]].AdditionalGuestCharges.$touched' ng-cloak style="color:#e9322d;">
                                                <div class="text-danger" ng-message="required">Additional guest charges are required</div>
                                            </div> -->
                                        <!-- </ng-form> -->
                                        <input maxlength="8"  ng-model="hotel.hotelroomcategories[room_category.id].additional_guest_charges" ng-value="hotel.hotelroomcategories[room_category.id]?hotel.hotelroomcategories[room_category.id].additional_guest_charges:room_category.AdditionalGuestCharges" data-type="currency" currency type="text" class="form-control">
                                            <!-- <div ng-messages="subform[[$index]].AdditionalGuestCharges.$error" ng-if='hotelForm.AdditionalGuestCharges.$touched || hotelForm.$submitted || subform[[$index]].AdditionalGuestCharges.$touched' ng-cloak style="color:#e9322d;">
                                                <div class="text-danger" ng-message="required">Additional guest charges are required</div>
                                            </div> -->
                                        </span>
                                    </div>
                                

                            </div>
                        </div>
                        <div class="card-body" style=" display:none;">
                            <div class="row py-2">
                                <div class="col-md-6 pb-2">
                                    <span>Occupants:</span>
                                    <div class="col-md-10 pl-0">
                                        <div class="def-number-input number-input safari_only">
                                        <button type="button" ng-click="decrementAllowedOccupants(room_category)" class="minus p-2"></button>
                                        <input  ng-model="hotel.hotelroomcategories[room_category.id].allowed" ng-value="hotel.hotelroomcategories[room_category.id].allowed?hotel.hotelroomcategories[room_category.id].allowed:room_category.AllowedOccupants" class="quantity form-control" min="1" name="AllowedOccupants" type="number" aria-invalid="false" style="">
                                        <button type="button" ng-click="incrementAllowedOccupants(room_category)" class="plus p-2"></button>
                                        </div>
                                    </div> 
                                    
                                </div> 


                                <div class="col-md-6 pb-2">
                                    <span>Max Occupants:</span>
                                    <div class="col-md-10 pl-0">
                                    
                                        <div class="def-number-input number-input safari_only">
                                        <button type="button" ng-click="decrementMaxAllowedOccupants(room_category)" class="minus p-2"></button>
                                        <input  ng-model="hotel.hotelroomcategories[room_category.id].max_allowed" ng-value="hotel.hotelroomcategories[room_category.id].max_allowed?hotel.hotelroomcategories[room_category.id].max_allowed:room_category.MaxAllowedOccupants" class="quantity form-control" min="1" name="MaxAllowedOccupants" type="number" aria-invalid="false" style="">
                                        <button type="button" ng-click="incrementMaxAllowedOccupants(room_category)" class="plus p-2"></button>
                                        </div>
                                    </div> 
                                </div> 

                                <div class="col-md-6 pt-2">
                                    <span style="display: inline-block; padding-top:12px;">Add. Guest Charges:</span>
                                </div>
                                <div class="col-md-6 pt-2">
                                    <span style="font-weight: 800">
                                        <input  ng-model="hotel.hotelroomcategories[room_category.id].additional_guest_charges" ng-value="hotel.hotelroomcategories[room_category.id]?hotel.hotelroomcategories[room_category.id].additional_guest_charges:room_category.AdditionalGuestCharges"  type="text" data-type="currency" class="form-control" name="AdditionalGuestCharges">
                                    </span>
                                </div>  
                            </div>


                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div> --}}

    <div class="col-md-12">
        <div class="card-header px-1 d-flex">
            <span class="card-title"> 
                <div class="col-12 pt-2 d-flex">
                    <strong class="col-6 m-auto">Check In Time:</strong>
                    <input ng-model="hotel.check_in_limit"  type="text" class="form-control col-6 pickatime" name="check_in_limit">
                </div> 
                {{-- <strong>Check In Time:</strong>
                <span>[[tConvert(default_rule.checkin_time)]]</span> --}}
            </span>
        </div>
        <fieldset class="py-2 px-2">
        <div class="row">
            <div class="col-md-12">
            <table class="table table-user table-striped hover display datatable-basic table-bordered">
                <thead>
                <tr>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Charges</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <tr ng-repeat="hcin in check_in_rules track by $index">
                    <td>
                        {{-- <input ng-required="true" name="service_start_time" id="service_start_time" placeholder="12:30 AM" readonly type="text" class="form-control px-2 pickatime-startTime pickatime" ng-model="service.service_start_time" placeholder=""> --}}
                        
                        <input type="text" id="cin_start_time" name="cin_start_time" ng-model="hotel.checkin[$index].start_time" class="form-control px-2 pickatime-startTime pickatime" placeholder="12:30 AM" ng-value="'[[hcin.start_time]]'">
                    </td>
                    <td>
                        {{-- [[tConvert(hcin.end_time)]] --}}
                        <input type="text" id="cin_end_time" name="cin_end_time" ng-model="hotel.checkin[$index].end_time" class="form-control px-2 pickatime-endTime pickatime" placeholder="12:30 AM" ng-value="'[[hcin.end_time]]'">

                    </td>
                    <td><input type="text" currency data-type="currency" name="cin_charges" ng-model="hotel.checkin[$index].charges" class="form-control px-2" placeholder="0.00" ng-value="'[[hcin.charges]]'"></td>
                    <td><i data-ng-click="removeCheckInRule($index)" class="btn btn-danger fa fa-minus"></i></td>
                </tr>
                
                </tbody>
            </table>
            </div>
            
        </div>
        </fieldset>
      </div>
</div>