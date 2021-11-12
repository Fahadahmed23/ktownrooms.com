<style>
.mb-3 .col-12 {
    border-bottom: 1px solid#ddd;
    border-right: 1px solid #ddd;
    padding: 15px 25px;
}
.serviceBox {
    padding: 15px !important;
}
.serviceBox i {
    display: inline-block;
    float: left;
    width: 15%;
}
.serviceBox .form-check-right {
    float: left;
    width: 50%;
    margin: 10px 0;
    display: inline-block;
}
.serviceBox .form-group {
    width: 30%;
    float: right;
}
.serviceBox .md-label {
    margin-left: 25px;
}
.servicelistBox{
    width: 100%;
    float: left;
    height: 300px;
    overflow: auto;
}
.servicelistBox::-webkit-scrollbar {
  width: 0px;
}

.servicelistBox::-webkit-scrollbar-track {
  background: #dddddd;
}

.servicelistBox::-webkit-scrollbar-thumb {
    background-color: #757575;
    border-radius: 20px;
    border: 3px solid #757575;
}


.facilityBox {
    padding: 15px !important;
}
/* .facilityBox i {
    display: inline-block;
    float: left;
    width: 15%;
} */
.facilityBox img {
    margin-right: 25px;
    display: inline-block;
    float: left;
}
.facilityBox .form-check-right {
    float: left;
    width: 85%;
    margin: 5px 0;
    display: inline-block;
}
.facilityBox .md-label {
    margin-left: 25px;
}
.facilitylistBox{
    width: 100%;
    float: left;
    height: 300px;
    overflow: auto;
}

.facilitylistBox::-webkit-scrollbar {
  width: 0px;
}

.facilitylistBox::-webkit-scrollbar-track {
  background: #dddddd;
}

.facilitylistBox::-webkit-scrollbar-thumb {
    background-color: #757575;
    border-radius: 20px;
    border: 3px solid #757575;
}
/* .table-image {
  td, th {
    vertical-align: middle;
  }
} */

/* room images */
.roomimgpreview {
    width: 100% !important;
    height: 125px;
    border-radius: 0;

}
.roomimagesupload .custom-file-input {
    opacity: 1;
    height: auto;
    width: 100%;
    padding: 0;
}
.roomimagesupload .custom-file {
    opacity: 1;
    position: relative;
}

/* .roomimagesupload .custom-file-input {
    opacity: 1;
    width: auto;
} */
/* .custom-file {
    position: inherit;
    opacity: 1;
}
input#selectimage {
    opacity: 1;
} */
</style>
<div id="addNewRoom" class="card" style="display:none;">
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
        <form id="roomForm" class="card-body" name="roomForm">
          
          
          <div class="col-lg-6">
            <div class="row">
            <div class="col-md-12">
              <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ">
                <i class="icon-city mr-2"></i>
                Room Thumbnail
              </legend>
            </div>
              
              {{-- <label class="col-lg-3 col-form-label">Room Picture</label> --}}
              <div class="col-lg-3">
                <div class="wrapper prof-wrap">
                  <img id="preview" class="output_image" ng-src="[[ room.thumbnail!=null ? room.thumbnail : 'https://mtbcycletours.com/wp-content/uploads/2019/02/bedroom-512.png' ]]" style="padding:5px;">
                  <div class="custom-file">
                    <input name="logo" type="file" class="custom-file-input logo" form="logo-form">
                    <label id="fileLabel" class="custom-file-label" for="customFile">Choose file</label>
                  </div>
                </div>
              </div>
              <div class="col-lg-6">
                <div class="btns-div">
                  <button ng-hide="room.thumbnail" name="room" class="btn m-b-xs w-auto btn-success upload-logo" type="button"><i class="icon-upload"></i> Upload</button>
                  <button ng-show="room.thumbnail" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearPicture('room')"><i class="icon-cancel-circle2"></i> Remove</button>
                </div>

              </div>

            </div>
          </div>

            <div class="form-group row">
                <div class="col-md-12">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    <i class="icon-city mr-2"></i>
                    Room information
                  </legend>
                </div>

                <div class="col-md-3"> 
                 <label class="col-lg-6 col-form-label">Hotel <span class="text-danger">*</span></label>
                  <md-select md-no-asterisk ng-change="getHotelId(room.hotel_id)" name="hotel_id" class="m-0" ng-model="room.hotel_id" placeholder="Select a Hotel" required>
                    <md-option ng-repeat="hotel in hotels" ng-value="hotel.id">[[hotel.HotelName]]</md-option>
                  </md-select>

                  <div ng-messages="roomForm.hotel_id.$error" ng-if='roomForm.hotel_id.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                    <div class="text-danger" ng-message="required">Hotel is required</div>
                  </div>
                  
                </div> 

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Room Title <span class="text-danger">*</span></label>
                 <input  name="room_title" maxlength="25"  type="text" class="form-control px-2" ng-model="room.room_title" placeholder="Enter Room title" required>
                 
                 <div ng-messages="roomForm.room_title.$error" ng-if='roomForm.room_title.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Room Title is required</div>
                 </div>
                </div>           

                <div class="col-md-3">
                 
                 <label class="col-lg-6 col-form-label">Room Type <span class="text-danger">*</span></label>
                    <md-select  md-no-asterisk name="room_type_id" class="m-0" ng-model="room.room_type_id" placeholder="Select a Room Type" required>
                      <md-option ng-repeat="roomtype in roomtypes" ng-value="roomtype.id">[[roomtype.RoomType]]</md-option>
                    </md-select>

                    <div ng-messages="roomForm.room_type_id.$error" ng-if='roomForm.room_type_id.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                      <div class="text-danger" ng-message="required">Room Type is required</div>
                    </div>


                </div>

                <div class="col-md-3">
                 <label class="col-lg-6 col-form-label">Room Category <span class="text-danger">*</span></label>
                 <md-select  md-no-asterisk name="room_category_id" class="m-0" ng-change="roomcategoryChange()"  ng-model="room.room_category_id" placeholder="Select Room Category" required>
                  <md-option ng-repeat="roomcategory in roomcategories " ng-value="roomcategory.id">[[roomcategory.RoomCategory]]</md-option>
                 </md-select>

                <div ng-messages="roomForm.room_category_id.$error" ng-if='roomForm.room_category_id.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Room Category is required</div>
                </div>

                </div>
               
            </div>
           
            <div class="form-group row">
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Room Number <span class="text-danger">*</span></label>
                 <input id="roomNumber" name="roomNumber" type="text"  class="form-control num3 px-2 " maxlength="15" ng-model="room.RoomNumber" placeholder="Enter Room" required>
                 
                 <div ng-messages="roomForm.roomNumber.$error" ng-if='roomForm.roomNumber.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Room Number is required</div>
                 </div>

                </div>

                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Floor No <span class="text-danger">*</span></label>
                 <input id="floorNo" name="floorNo" type="text"  class="form-control num3 px-2 num3" maxlength="15" ng-model="room.FloorNo" placeholder="Enter Floor" required>
                 
                 <div ng-messages="roomForm.floorNo.$error" ng-if='roomForm.floorNo.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Floor Number is required</div>
                 </div>

                </div>
                
                <div class="col-md-3">        
                 <label class="col-lg-6 col-form-label">Room Charges <span class="text-danger">*</span></label>
                 <input id="roomCharges" data-type="currency" currency name="roomCharges" type="text"  class="form-control px-2" ng-model="room.RoomCharges" maxlength="10" placeholder="Enter Room Charges" required>
                
                 <div ng-messages="roomForm.roomCharges.$error" ng-if='roomForm.roomCharges.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Room Charges is required</div>
                 </div>
                
                </div>

                {{-- <div class="col-md-3">    
                      
                 <label class="col-lg-6 col-form-label">Tax Rate <span class="text-danger">*</span></label>
                 <md-select  md-no-asterisk name="tax_rate_id" class="m-0" ng-model="room.tax_rate_id" placeholder="Select your Tax Rate" required>
                  <md-option ng-repeat="taxrate in taxrates" ng-value="taxrate.id">[[taxrate.Tax]]</md-option>
                 </md-select>

                 <div ng-messages="roomForm.tax_rate_id.$error" ng-if='roomForm.tax_rate_id.$touched || roomForm.$submitted' ng-cloak style="color:#e9322d;">
                  <div class="text-danger" ng-message="required">Room Tax is required</div>
                 </div>

                </div>        --}}
                
                <div class="col-md-12">
                  <legend class="font-weight-semibold text-uppercase font-size-sm border-0 ml-2 mt-3">
                    <i class="icon-city mr-2"></i>
                    Room Availability
                  </legend>
                </div>
                <div class="col-md-2">
                    <md-switch ng-true-value="1" ng-false-value="0" ng-model="room.is_available" style="display:inline"></md-switch>
                </div>
            </div>
            

            <div class="form-group">
              
              <div class="mb-3">
                <div class="row">
                  <div class="col-md-6">
                    <div class="card mt-5">
                      <div class="card-header bg-white header-elements-inline">
                        <h5 class="card-title" style="text-transform:capitalize;">Room Facilities</h5>
                        <div class="header-elements">
                          <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                          </div>
                        </div>
                      </div>
                    <div class="facilitylistBox">
                      <div ng-repeat="facility in facilities" class="col-12 facilityBox" style="float: left">
                        {{-- <i class="[[facility.IconPath]] fa-3x" style=""></i> --}}
                        <img ng-if="facility.Image" width="30px" height="30px" ng-src="[[facility.Image]]">
                        <div class="form-check form-check-inline form-check-right">
                            <md-checkbox style="display:block" ng-value="facility" ng-click="checkFacility(facility)" ng-checked="room.facilities.indexOf(facility.id) > -1">
                            [[facility.Facility]]
                            </md-checkbox>
                            
                        </div>
                      </div>
                    </div>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="card mt-5">
                      <div class="card-header bg-white header-elements-inline">
                        <h5 class="card-title" style="text-transform:capitalize;">Room Services</h5>
                        <div class="header-elements">
                          <div class="list-icons">
                            <a class="list-icons-item" data-action="collapse"></a>
                          </div>
                        </div>
                      </div>
                      <div class="servicelistBox">
                        <div ng-repeat="service in services | filter: {hotel_id:room.hotel_id }" class="col-12 serviceBox" style="float: left">
                          <i class="[[service.IconPath]] fa-3x" style=""></i>
                          <div class="form-check form-check-inline form-check-right">
                              <md-checkbox style="display:block" ng-model="servicetemp[service.id].status" >
                              [[service.Service]]
                              </md-checkbox>
                          </div>
                          {{-- <div class="form-group"> 
                            <label class="mb-0">Count</label> 
                              <input ng-model="servicetemp[service.id].count" placeholder="1" class="servicecount form-control" min="0" name="servicecount" type="number">                       
                          </div> --}}
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

                <div class="card">
                  <div class="card-header bg-white header-elements-inline">
                    <h5 class="card-title" style="text-transform:capitalize;">Room Images</h5>
                    <div class="header-elements">
                      <div class="list-icons">
                        <a class="list-icons-item" data-action="collapse"></a>
                      </div>
                    </div>
                  </div>
                  <div style=" padding: 10px 0">
                    <div class="col-lg-6">
                      
                      <div  class="">
                        <div>
                          <div class="row">
                            <div class="col-lg-6 float-left">
                              
                              <div class="wrapper prof-wrap roomimagesupload">
                                <div class="custom-file">
                                  <input id="selectimage" name="logo" type="file" class="custom-file-input logo form-control" form="images-form">
                                </div> 
                              </div>
                            </div>
                            <div class="col-lg-6 float-left">
                              <div class="btn-div">
                                <button name="room" class="btn m-b-xs w-auto btn-success upload-images" type="button"><i class="icon-upload"></i> Upload </button>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>                  
    
                  <div class="">
                    <div class="">
                      <div class="">
                      <table class="table table-hover ">
                        <thead>
                          <tr class="table-secondary">
                            <th>Room Images</th>
                            <th>Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr ng-if="room.images" ng-repeat="image in room.images">
                            <td class="w-25  py-1">
                              <img ng-src="[[ image.ImagePath!=null ? image.ImagePath : 'https://pwcenter.org/sites/default/files/default_images/default_profile.png' ]]" class="img-fluid img-thumbnail" style="height: 70px;width: 70px;">
                            </td>
                            <td  class="py-1" style="vertical-align: middle;"><button ng-show="image" class="btn m-b-xs w-auto btn-danger" type="button" ng-click="clearRoomImage(image)" style=""><i class="icon-cancel-circle2 mr-2"></i>Remove </button></td>
                          </tr>
                        </tbody>
                      </table>   
                      </div>
                    </div>
                  </div>
                </div>                  


            <div class="text-right mt-2">
              <button  type="button" ng-click="saveRoom()" id="btn-save" class="btn btn-sm bg-success">[[room.id?'Update':'Save']]<i class="icon-floppy-disk ml-1"></i></button>
            </div>
        </form>

        <form action="saveProfilePicture" method="post" enctype="multipart/form-data" id="logo-form" onsubmit="return false;"></form>

        
        <form action="saveImages" method="post" enctype="multipart/form-data" id="images-form" onsubmit="return false;"></form>
</div>

