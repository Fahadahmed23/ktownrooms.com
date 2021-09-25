<style>
  .mb-3 .col-3 {
    border-bottom: 1px solid#ddd;
    border-right: 1px solid #ddd;
    padding: 15px 25px;
}
</style>
<div id="addNewRoom" class="card" style="display: ">
    <div class="card-header bg-white header-elements-inline">
		  <h5 class="card-title" style="text-transform:capitalize;">[[room.id?'Update':'Add New']] Room</h5>
      <div class="header-elements">
        <div class="list-icons">
                  <a class="list-icons-item" data-action="collapse"></a>
          <a class="list-icons-item new-rec-close" ng-click="revert()"><i class="icon-cross2"></i></a>
        </div>
      </div>
	  </div>
        @include('layouts.form_messages')
        <form id="roomForm" class="card-body" name="roomForm" method="POST">

                <div class="col-md-3"> 
                  <label class="col-lg-6 col-form-label">Hotel</label>
                  <md-select name="hotel_id" class="m-0" ng-model="room.hotel_id" placeholder="Select a Hotel" required>
                    <md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                  </md-select>
                </div> 

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Room Title</label>
                 <input id="room_title" name="room_title" ng-minlength="5" ng-maxlength="15"  type="text" class="form-control px-2" ng-model="room.room_title" placeholder="Enter Room title" required>
                </div>           

                <div class="col-md-3">
                 
                 <label class="col-lg-6 col-form-label">Room Type</label>
                    <md-select name="roomtype_id" class="m-0" ng-model="room.room_type_id" placeholder="Select a Room Type" required>
                      <md-option ng-repeat="roomtype in roomtypes" ng-value="roomtype.id">[[roomtype.RoomType]]</md-option>
                    </md-select>
                </div>

                <div class="col-md-3">
                 <label class="col-lg-6 col-form-label">Room Category</label>
                 <md-select name="roomcategory_id" class="m-0" ng-model="room.room_category_id" placeholder="Select Room Category" required>
                  <md-option ng-repeat="roomcategory in roomcategories" ng-value="roomcategory.id">[[roomcategory.RoomCategory]]</md-option>
                 </md-select>
                </div>
                
               
            </div>
           
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Room Number</label>
                 <input id="roomNumber" name="roomNumber" type="text" ng-minlength="1" ng-maxlength="5" class="form-control px-2" ng-model="room.RoomNumber" placeholder="Enter Room" required>
                
                </div>

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Floor No</label>
                 <input id="floorNo" name="floorNo" type="text" ng-minlength="1" ng-maxlength="50" class="form-control px-2" ng-model="room.FloorNo" placeholder="Enter Floor" required>
                </div>
                
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Room Charges</label>
                 <input id="roomCharges" name="roomCharges" type="text" ng-minlength="1" ng-maxlength="50" class="form-control px-2" ng-model="room.RoomCharges" placeholder="Enter Room Charges" required>
                </div>

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Tax Rate</label>
                 <md-select name="tax_rate_id" class="m-0" ng-model="room.tax_rate_id" placeholder="Select your Tax Rate" required>
                  <md-option ng-repeat="taxrate in taxrates" ng-value="taxrate.id">[[taxrate.Tax]]</md-option>
                 </md-select>
                </div>                
            </div>

            {{-- <div class="form-group">
              <div class="mb-3">
                <h5 style="padding: 10px 0; margin: 20px 10px;">Room Facilities</h5>
                <div class="row">
                    <div ng-repeat="facility in facilities" class="col-3">
                              <i class="[[facility.IconPath]]"></i>
                              <div class="form-check form-check-inline form-check-right">

                                <md-checkbox style="display:block" value="facility.id" ng-checked="room.facility.indexOf(facility.id) > -1"
                                  ng-click="checkFacility(facility.id)">
                                  [[role.name]]
                                </md-checkbox>

                                <md-checkbox style="display:block" value="facility.id" ng-checked="room.facility.indexOf(facility.id) > -1"
                                  ng-click="checkFacility(facility.id)">
                                  [[facility.Facility]]
                                </md-checkbox>
                              </div>
                    </div>


                </div>
              </div>
            </div>   --}}

            <div class="text-right">
              <button  type="submit" id="btn-save" ng-click="saveRoom()" class="btn btn-sm bg-success">[[room.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>

                {{-- <div class="mb-3">
	              	<h5>Room Facilities</h5>
									<div class="row row-tile no-gutters">
										<div  class="col-12">
										
											
												<div class="form-check form-check-inline form-check-right">
													<label class="form-check-label">
														
                          <md-checkbox style="display:block" ng-repeat="facility in facilities" ng-value="facility.id" 
                          ng-checked="facility.indexOf(facility.id) > -1">
														[[facility.Facility]]

                            <img src="/image_uploads/[[facility.IconPath]]" width="100px" height="100px">
													</md-checkbox>
                            

                          </label>
												</div>
									
										</div>
									</div>
								</div> --}}
        </form>
</div>

