<form id="hotelRoomCategoryForm" class="card-body" name="hotelRoomCategoryForm" >
<div style="" class="card-body mt-3 p-2">
    <div class="row">
        <div ng-repeat="room_category in room_categories track by $index" class="col-md-2 ">
            <div class="card">
                <div class="card-header px-1">
                    <span class="card-title"> 
                        <div class="toggle-checkbox-div-all">
                        <div class="row m-0">
                            <div class="col-md-6">
                                <span class="badge text-white" style="background:[[room_category.Color]];">[[room_category.RoomCategory]]</span>
                            </div>

                            <div class="col-md-6">
                                <md-switch ng-change="hotelRoomCategory(room_category, hrc[$index])" ng-model="hrc[$index].status" ng-true-value="1" ng-false-value="0" style="float: right;" >
                                </md-switch>
                            </div>
                        </div>
                            
                        </div>
                    </span>
                </div>
                <div class="card-body py-0" style="padding: 0 10px !important;">
                    <div class="row pt-0">
                        <div class="col-md-6">
                            <input ng-model="hrc[$index].hotel_id" class="quantity form-control d-none"  name="hotel_id">
                            <div class="mb-2">Occupants:</div> 
                            <div class="categorycounter">
                                <button ng-click="decrementAllowedOccupants(room_category , $index)" type="button" class="btn btn-sm btn-danger"><i class="fa fa-minus"></i></button>
                                <input readonly ng-model="hrc[$index].allowed" ng-value="room_category.AllowedOccupants" class="quantity form-control num2" min="1" name="AllowedOccupants" type="number" aria-invalid="false" style="">
                                <button ng-click="incrementAllowedOccupants(room_category , $index )" type="button" class="btn btn-sm  btn-primary"><i class="fa fa-plus"></i></button> 
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-2">Max Occupants:</div> 
                            <div class="categorycounter">
                                <button ng-click="decrementMaxAllowedOccupants(room_category , $index)" type="button" class="btn btn-sm  btn-danger"><i class="fa fa-minus"></i></button> 
                                <input  readonly ng-model="hrc[$index].max_allowed" ng-value="room_category.MaxAllowedOccupants" class="quantity form-control num2" min="1" name="MaxAllowedOccupants" type="number" aria-invalid="false" style="">
                                <button ng-click="incrementMaxAllowedOccupants(room_category , $index)" type="button" class="btn btn-sm btn-primary"><i class="fa fa-plus"></i></button>
                            </div>
                        </div>

                            <div class="col-md-6 py-2">
                                <span style="display: inline-block; padding-top:12px;">Add. Guest Charges:</span>
                            </div>
                            <div class="col-md-6 pt-2 addi_charges">
                                <span style="font-weight: 800">
                                    <input maxlength="8"  ng-model="hrc[$index].additional_guest_charges" ng-value="room_category.AdditionalGuestCharges" data-type="currency" currency type="text" class="form-control">
                                </span>
                            </div>
                        

                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>
<div class="text-right">
        <button type="button" ng-click="saveHotelRoomCategories()" id="btn-save" class="btn btn-sm bg-success"><i class="icon-floppy-disk mr-1"></i> Save Hotel room Categories</button>
</div>
</form>